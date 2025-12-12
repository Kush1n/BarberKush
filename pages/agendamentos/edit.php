<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();

if (!isset($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamento = ?");
$stmt->execute([$id]);
$agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agendamento) {
    die("Agendamento não encontrado.");
}

$clientes = $pdo->query("SELECT id_cliente, nome FROM clientes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$barbeiros = $pdo->query("SELECT id_barbeiro, nome FROM barbeiros WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$servicos = $pdo->query("SELECT id_servico, nome, duracao_min FROM servicos WHERE ativo = 1 ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$hora_inicio = 9;
$hora_fim = 19;
$intervalos = [];
for ($h = $hora_inicio; $h < $hora_fim; $h++) {
    $intervalos[] = sprintf("%02d:00", $h);
    $intervalos[] = sprintf("%02d:30", $h);
}

$data_minima = date('Y-m-d', strtotime('+1 day'));

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $csrf_token = $_POST["csrf"] ?? '';
    if (!check_csrf($csrf_token)) {
        $erro = "Token inválido.";
    } else {
        $cliente_id = $_POST["cliente_id"];
        $barbeiro_id = $_POST["barbeiro_id"];
        $servico_id = $_POST["servico_id"];
        $data = $_POST["data"];
        $hora = $_POST["hora"];

        if (!$cliente_id || !$barbeiro_id || !$servico_id || !$data || !$hora) {
            $erro = "Preencha todos os campos.";
        } elseif ($data < $data_minima) {
            $erro = "Não é possível agendar para hoje ou datas passadas.";
        } elseif (!in_array($hora, $intervalos)) {
            $erro = "Escolha um horário válido entre 09:00 e 19:00 em intervalos de 30 minutos.";
        } else {
            $stmt = $pdo->prepare("SELECT duracao_min FROM servicos WHERE id_servico = ?");
            $stmt->execute([$servico_id]);
            $duracao = $stmt->fetchColumn();

            if (!$duracao) {
                $erro = "Serviço inválido ou sem duração definida.";
            } else {
                $data_hora_inicio = $data . ' ' . $hora;
                $data_hora_fim = date('Y-m-d H:i:s', strtotime("+$duracao minutes", strtotime($data_hora_inicio)));

                $stmt = $pdo->prepare("
                    SELECT COUNT(*) FROM agendamentos
                    WHERE id_barbeiro = ?
                      AND status IN ('pendente','confirmado')
                      AND id_agendamento <> ?
                      AND (
                            (data_inicio < ? AND data_fim > ?) OR
                            (data_inicio < ? AND data_fim > ?)
                          )
                ");
                $stmt->execute([$barbeiro_id, $id, $data_hora_fim, $data_hora_inicio, $data_hora_fim, $data_hora_inicio]);
                if ($stmt->fetchColumn() > 0) {
                    $erro = "O barbeiro já possui agendamento neste horário.";
                }
            }
        }

        if (empty($erro)) {
            $sql = $pdo->prepare("UPDATE agendamentos 
                                  SET id_cliente = ?, id_barbeiro = ?, id_servico = ?, data_inicio = ?, data_fim = ?
                                  WHERE id_agendamento = ?");
            if ($sql->execute([$cliente_id, $barbeiro_id, $servico_id, $data_hora_inicio, $data_hora_fim, $id])) {
                $sucesso = "Agendamento atualizado com sucesso! Redirecionando...";
                echo '<div class="alert alert-success mt-3">' . htmlspecialchars($sucesso) . '</div>';
                echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                require_once "../../includes/footer.php";
                exit;
            } else {
                $erro = "Erro ao atualizar.";
            }
        }
    }
}
?>

<h2>Editar Agendamento</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Cliente:</label>
    <select name="cliente_id" class="form-select" required>
        <?php foreach ($clientes as $c): ?>
            <option value="<?= $c['id_cliente'] ?>" <?= ($c['id_cliente'] == $agendamento['id_cliente']) ? "selected" : "" ?>>
                <?= htmlspecialchars($c['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Barbeiro:</label>
    <select name="barbeiro_id" class="form-select" required>
        <?php foreach ($barbeiros as $b): ?>
            <option value="<?= $b['id_barbeiro'] ?>" <?= ($b['id_barbeiro'] == $agendamento['id_barbeiro']) ? "selected" : "" ?>>
                <?= htmlspecialchars($b['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Serviço:</label>
    <select name="servico_id" class="form-select" required>
        <?php foreach ($servicos as $s): ?>
            <option value="<?= $s['id_servico'] ?>" <?= ($s['id_servico'] == $agendamento['id_servico']) ? "selected" : "" ?>>
                <?= htmlspecialchars($s['nome']) ?> (<?= $s['duracao_min'] ?> min)
            </option>
        <?php endforeach; ?>
    </select>

    <label>Data:</label>
    <input type="date" name="data" class="form-control" required
           value="<?= htmlspecialchars(substr($agendamento['data_inicio'],0,10)) ?>"
           min="<?= $data_minima ?>">

    <label>Hora:</label>
    <select name="hora" class="form-select" required>
        <?php foreach($intervalos as $hora_option): ?>
            <option value="<?= $hora_option ?>" <?= (substr($agendamento['data_inicio'],11,5)==$hora_option) ? "selected" : "" ?>>
                <?= $hora_option ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-success mt-3">Atualizar</button>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
<?php
