<?php
require_once "../../includes/db.php";
<<<<<<< HEAD
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();
=======
require_once "../../includes/auth.php";
require_once "../../includes/header.php";

require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4

$hora_inicio = 9; 
$hora_fim = 19;   
$erros = [];
<<<<<<< HEAD
$sucesso = "";
=======
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4

$clientes = $pdo->query("SELECT id_cliente, nome FROM clientes")->fetchAll();
$barbeiros = $pdo->query("SELECT id_barbeiro, nome FROM barbeiros WHERE ativo = 1")->fetchAll();
$servicos = $pdo->query("SELECT id_servico, nome, duracao_min FROM servicos WHERE ativo = 1")->fetchAll();

$intervalos = [];
for ($h = $hora_inicio; $h < $hora_fim; $h++) {
    $intervalos[] = sprintf("%02d:00", $h);
    $intervalos[] = sprintf("%02d:30", $h);
}

$data_minima = date('Y-m-d', strtotime('+1 day'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< HEAD
    $csrf_token = $_POST['csrf'] ?? '';
    if (!check_csrf($csrf_token)) {
        $erros[] = "Token inválido.";
    } else {
        $id_cliente = $_POST['id_cliente'] ?? '';
        $id_barbeiro = $_POST['id_barbeiro'] ?? '';
        $id_servico = $_POST['id_servico'] ?? '';
        $data_inicio_input = $_POST['data_inicio'] ?? '';
        $hora_inicio_input = $_POST['hora_inicio'] ?? '';

        if (!$id_cliente || !$id_barbeiro || !$id_servico || !$data_inicio_input || !$hora_inicio_input) {
            $erros[] = "Preencha todos os campos.";
        }

        if ($data_inicio_input < $data_minima) {
            $erros[] = "Não é possível agendar para hoje ou datas anteriores.";
        }

        $stmt = $pdo->prepare("SELECT duracao_min FROM servicos WHERE id_servico = ?");
        $stmt->execute([$id_servico]);
        $duracao = $stmt->fetchColumn();

        if (!$duracao) {
            $erros[] = "Serviço inválido ou sem duração definida.";
        }

        if (empty($erros)) {
            $data_hora_inicio = $data_inicio_input . ' ' . $hora_inicio_input;
            $data_hora_fim = date('Y-m-d H:i:s', strtotime("+$duracao minutes", strtotime($data_hora_inicio)));

            $hora_apontada = (int)date('H', strtotime($data_hora_inicio));
            if ($hora_apontada < $hora_inicio || $hora_apontada >= $hora_fim) {
                $erros[] = "O horário deve estar entre {$hora_inicio}:00 e {$hora_fim}:00.";
            }

            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM agendamentos
                WHERE id_barbeiro = ?
                  AND status IN ('pendente','confirmado')
                  AND (
                        (data_inicio < ? AND data_fim > ?) OR
                        (data_inicio < ? AND data_fim > ?)
                      )
            ");
            $stmt->execute([$id_barbeiro, $data_hora_fim, $data_hora_inicio, $data_hora_fim, $data_hora_inicio]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "O barbeiro já possui agendamento neste horário.";
            }
        }

        if (empty($erros)) {
            $stmt = $pdo->prepare("
                INSERT INTO agendamentos 
                (id_cliente, id_barbeiro, id_servico, data_inicio, data_fim, status, criado_em)
                VALUES (?, ?, ?, ?, ?, 'pendente', NOW())
            ");
            if ($stmt->execute([$id_cliente, $id_barbeiro, $id_servico, $data_hora_inicio, $data_hora_fim])) {
                $sucesso = "Agendamento criado com sucesso! Redirecionando...";
                echo '<div class="alert alert-success mt-3">' . htmlspecialchars($sucesso) . '</div>';
                echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                require_once "../../includes/footer.php";
                exit;
            } else {
                $erros[] = "Erro ao criar agendamento.";
            }
        }
=======
    $id_cliente = $_POST['id_cliente'];
    $id_barbeiro = $_POST['id_barbeiro'];
    $id_servico = $_POST['id_servico'];
    $data_inicio = $_POST['data_inicio'];
    $hora_inicio_input = $_POST['hora_inicio'];

    if ($data_inicio < $data_minima) {
        $erros[] = "Não é possível agendar para hoje ou datas anteriores. Escolha o dia seguinte ou posterior.";
    }

    $stmt = $pdo->prepare("SELECT duracao_min FROM servicos WHERE id_servico = ?");
    $stmt->execute([$id_servico]);
    $duracao = $stmt->fetchColumn();

    if (!$duracao) {
        $erros[] = "Serviço inválido ou sem duração definida.";
    } else {
        $data_hora_inicio = $data_inicio . ' ' . $hora_inicio_input;
        $data_hora_fim = date('Y-m-d H:i:s', strtotime("+$duracao minutes", strtotime($data_hora_inicio)));

        $hora_apontada = (int)date('H', strtotime($data_hora_inicio));
        if ($hora_apontada < $hora_inicio || $hora_apontada >= $hora_fim) {
            $erros[] = "O horário deve estar entre {$hora_inicio}:00 e {$hora_fim}:00.";
        }

        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM agendamentos
            WHERE id_barbeiro = ?
              AND status IN ('pendente','confirmado')
              AND (
                    (data_inicio < ? AND data_fim > ?) OR
                    (data_inicio < ? AND data_fim > ?)
                  )
        ");
        $stmt->execute([$id_barbeiro, $data_hora_fim, $data_hora_inicio, $data_hora_fim, $data_hora_inicio]);
        if ($stmt->fetchColumn() > 0) {
            $erros[] = "O barbeiro já possui agendamento neste horário.";
        }
    }

    if (empty($erros)) {
        $stmt = $pdo->prepare("
            INSERT INTO agendamentos 
            (id_cliente, id_barbeiro, id_servico, data_inicio, data_fim, status, criado_em)
            VALUES (?, ?, ?, ?, ?, 'pendente', NOW())
        ");
        $stmt->execute([$id_cliente, $id_barbeiro, $id_servico, $data_hora_inicio, $data_hora_fim]);
        header("Location: index.php");
        exit;
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
    }
}
?>

<div class="container mt-4">
    <h2>Novo Agendamento</h2>

    <?php if($erros): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($erros as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
<<<<<<< HEAD
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

=======
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
        <div class="mb-3">
            <label>Cliente:</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach($clientes as $c): ?>
                    <option value="<?= $c['id_cliente'] ?>" <?= (isset($_POST['id_cliente']) && $_POST['id_cliente']==$c['id_cliente'])?'selected':'' ?>>
                        <?= htmlspecialchars($c['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Barbeiro:</label>
            <select name="id_barbeiro" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach($barbeiros as $b): ?>
                    <option value="<?= $b['id_barbeiro'] ?>" <?= (isset($_POST['id_barbeiro']) && $_POST['id_barbeiro']==$b['id_barbeiro'])?'selected':'' ?>>
                        <?= htmlspecialchars($b['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Serviço:</label>
            <select name="id_servico" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach($servicos as $s): ?>
                    <option value="<?= $s['id_servico'] ?>" <?= (isset($_POST['id_servico']) && $_POST['id_servico']==$s['id_servico'])?'selected':'' ?>>
                        <?= htmlspecialchars($s['nome']) ?> (<?= $s['duracao_min'] ?> min)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Data:</label>
            <input type="date" name="data_inicio" class="form-control" required
                   value="<?= isset($_POST['data_inicio']) ? $_POST['data_inicio'] : $data_minima ?>"
                   min="<?= $data_minima ?>">
        </div>

        <div class="mb-3">
            <label>Hora:</label>
            <select name="hora_inicio" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach($intervalos as $hora): ?>
                    <option value="<?= $hora ?>" <?= (isset($_POST['hora_inicio']) && $_POST['hora_inicio']==$hora)?'selected':'' ?>>
                        <?= $hora ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Agendar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once "../../includes/footer.php"; ?>
