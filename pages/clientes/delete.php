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

$check = $pdo->prepare("SELECT id_agendamento FROM agendamentos WHERE id_cliente = ?");
$check->execute([$id]);

if ($check->rowCount() > 0) {
    die("<div class='alert alert-danger'>Não é possível excluir: cliente possui agendamentos.</div>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!check_csrf($_POST['csrf'])) {
        die("Ação não autorizada.");
    }

    $delete = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = ?");
    $delete->execute([$id]);

    header("Location: http://localhost/BARBERKUSH/pages/clientes/");
    exit;
}
?>

<h2>Excluir Cliente</h2>

<p>Tem certeza que deseja excluir o cliente <strong><?= htmlspecialchars($cliente['nome']) ?></strong>?</p>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
    <button class="btn btn-danger">Excluir</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
