<?php
require_once "../../includes/db.php";
<<<<<<< HEAD
require_once "../../includes/header.php";
require_once "../../includes/token.php";

=======
require_once "../../includes/auth.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
generate_csrf();

$id = $_GET["id"] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM barbeiros WHERE id_barbeiro = ?");
$stmt->execute([$id]);
$barbeiro = $stmt->fetch();

if (!$barbeiro) {
    die("Barbeiro não encontrado.");
}

$check = $pdo->prepare("SELECT id_agendamento FROM agendamentos WHERE id_barbeiro = ?");
$check->execute([$id]);

if ($check->rowCount() > 0) {
    die("<div class='alert alert-danger'>Não é possível excluir: barbeiro possui agendamentos.</div>");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
<<<<<<< HEAD
    if (!check_csrf($_POST['csrf'])) {
        die("Ação não autorizada (CSRF inválido).");
    }

    $del = $pdo->prepare("DELETE FROM barbeiros WHERE id_barbeiro = ?");
    if ($del->execute([$id])) {
        echo '<div class="alert alert-success">Barbeiro excluído com sucesso! Redirecionando...</div>';
        echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
        require_once "../../includes/footer.php";
        exit;
    } else {
        echo '<div class="alert alert-danger">Erro ao excluir barbeiro.</div>';
    }
=======

    if (!check_csrf($_POST['csrf'])) {
        die("Ação não autorizada.");
    }

    $del = $pdo->prepare("DELETE FROM barbeiros WHERE id_barbeiro = ?");
    $del->execute([$id]);

    header("Location: index.php");
    exit;
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
}
?>

<h2>Excluir Barbeiro</h2>

<p>Deseja realmente excluir o barbeiro <strong><?= htmlspecialchars($barbeiro['nome']) ?></strong>?</p>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
    <button class="btn btn-danger">Excluir</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
