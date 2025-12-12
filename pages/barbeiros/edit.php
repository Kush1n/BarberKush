<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();

$id = $_GET["id"] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM barbeiros WHERE id_barbeiro = ?");
$stmt->execute([$id]);
$barbeiro = $stmt->fetch();

if (!$barbeiro) {
    die("Barbeiro não encontrado.");
}

$erro = "";
$sucesso = "";

function validarCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) $soma += $cpf[$i] * (($t + 1) - $i);
        $d = ((10 * $soma) % 11) % 10;
        if ($cpf[$i] != $d) return false;
    }
    return true;
}

function validarTelefone($telefone) {
    $telefone = preg_replace('/\D/', '', $telefone);
    return (strlen($telefone) >= 10 && strlen($telefone) <= 11) ? $telefone : false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!check_csrf($_POST['csrf'])) {
        $erro = "Ação não autorizada (CSRF inválido).";
    } else {
        $nome = trim($_POST["nome"]);
        $cpf = trim($_POST["cpf"]);
        $telefone = trim($_POST["telefone"]);

        if (empty($nome) || empty($cpf) || empty($telefone)) {
            $erro = "Preencha todos os campos.";
        } elseif (!validarCPF($cpf)) {
            $erro = "CPF inválido. Digite 11 dígitos válidos.";
        } elseif (!validarTelefone($telefone)) {
            $erro = "Telefone inválido. Digite apenas números (10 ou 11 dígitos).";
        } else {
            $verifica = $pdo->prepare("SELECT id_barbeiro FROM barbeiros WHERE cpf = ? AND id_barbeiro != ?");
            $verifica->execute([$cpf, $id]);

            if ($verifica->rowCount() > 0) {
                $erro = "Já existe um barbeiro com este CPF.";
            } else {
                $sql = $pdo->prepare("UPDATE barbeiros SET nome = ?, cpf = ?, telefone = ? WHERE id_barbeiro = ?");
                if ($sql->execute([$nome, $cpf, $telefone, $id])) {
                    $sucesso = "Barbeiro atualizado com sucesso! Redirecionando...";
                    echo '<div class="alert alert-success">' . htmlspecialchars($sucesso) . '</div>';
                    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                    require_once "../../includes/footer.php";
                    exit;
                } else {
                    $erro = "Erro ao atualizar barbeiro.";
                }
            }
        }
    }
}
?>

<h2>Editar Barbeiro</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($barbeiro['nome']) ?>" required>

    <label>CPF:</label>
    <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($barbeiro['cpf']) ?>" maxlength="11" required>

    <label>Telefone:</label>
    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($barbeiro['telefone']) ?>" maxlength="11" required>

    <br>
    <button class="btn btn-primary">Salvar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
