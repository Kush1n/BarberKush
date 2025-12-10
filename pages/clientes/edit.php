<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";
require_once "../../includes/auth.php";

require_login();

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    die("Cliente não encontrado.");
}

$erro = "";

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
        $erro = "Ação não autorizada.";
    } else {
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $email = trim($_POST['email']);

        if (!validarCPF($cpf)) {
            $erro = "CPF inválido. Digite 11 dígitos válidos.";
        } elseif (empty($telefone) && empty($email)) {
            $erro = "Preencha pelo menos um contato: telefone ou e-mail.";
        } elseif (!empty($telefone) && !validarTelefone($telefone)) {
            $erro = "Telefone inválido. Apenas números, 10 ou 11 dígitos.";
        } else {
            $stmt2 = $pdo->prepare("SELECT id_cliente FROM clientes WHERE cpf = ? AND id_cliente <> ?");
            $stmt2->execute([$cpf, $id]);
            if ($stmt2->rowCount() > 0) {
                $erro = "Este CPF já está cadastrado para outro cliente.";
            } else {
                $sql = $pdo->prepare("UPDATE clientes SET nome=?, cpf=?, telefone=?, email=? WHERE id_cliente=?");
                $sql->execute([$nome, $cpf, $telefone, $email, $id]);

                header("Location: index.php");
                exit;
            }
        }
    }
}
?>

<h2>Editar Cliente</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

    <label class="mt-2">CPF:</label>
    <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cliente['cpf']) ?>" maxlength="11" required>

    <label class="mt-2">Telefone:</label>
    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>" maxlength="11">

    <label class="mt-2">Email:</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">

    <button class="btn btn-success mt-3">Atualizar</button>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
