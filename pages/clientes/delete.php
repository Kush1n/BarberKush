<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    echo "<div class='alert alert-danger'>Cliente não encontrado.</div>";
    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
    require_once "../../includes/footer.php";
    exit;
}

$check = $pdo->prepare("SELECT id_agendamento FROM agendamentos WHERE id_cliente = ?");
$check->execute([$id]);

if ($check->rowCount() > 0) {
    echo "<div class='alert alert-danger'>Não é possível excluir: cliente possui agendamentos. Redirecionando...</div>";
    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
    require_once "../../includes/footer.php";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!check_csrf($_POST['csrf'])) {
        die("Ação não autorizada (CSRF inválido).");
    }

    $delete = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = ?");
    if ($delete->execute([$id])) {
        echo '<div class="alert alert-success">Cliente excluído com sucesso! Redirecionando...</div>';
        echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
        require_once "../../includes/footer.php";
        exit;
    } else {
        echo '<div class="alert alert-danger">Erro ao excluir cliente.</div>';
    }
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
