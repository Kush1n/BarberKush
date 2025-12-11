<?php
require_once "../../includes/db.php";
<<<<<<< HEAD
require_once "../../includes/token.php";
require_once "../../includes/header.php";

=======
require_once "../../includes/auth.php";
require_once "../../includes/token.php";
require_once "../../includes/header.php";

require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
$token = generate_csrf();

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);
$servico = $stmt->fetch();

if (!$servico) {
    die("Serviço não encontrado.");
}

$check = $pdo->prepare("SELECT id_agendamento FROM agendamentos WHERE id_servico = ?");
$check->execute([$id]);

if ($check->rowCount() > 0) {
    die("<div class='alert alert-danger'>Não é possível excluir: serviço vinculado a agendamentos.</div>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< HEAD
    if (!check_csrf($_POST['csrf'])) {
        die("Ação não autorizada (CSRF inválido).");
    }

    $del = $pdo->prepare("DELETE FROM servicos WHERE id_servico = ?");
    if ($del->execute([$id])) {
        echo '<div class="alert alert-success">Serviço excluído com sucesso! Redirecionando...</div>';
        echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
        require_once "../../includes/footer.php";
        exit;
    } else {
        echo '<div class="alert alert-danger">Erro ao excluir serviço.</div>';
    }
=======

    if (!verify_csrf($_POST['csrf'])) {
        die("Ação não autorizada.");
    }

    $del = $pdo->prepare("DELETE FROM servicos WHERE id_servico = ?");
    $del->execute([$id]);

    $_SESSION['msg'] = "Serviço excluído com sucesso!";
    header("Location: index.php");
    exit;
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
}
?>

<h2>Excluir Serviço</h2>

<p>Tem certeza que deseja excluir o serviço <strong><?= htmlspecialchars($servico['nome']) ?></strong>?</p>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <button class="btn btn-danger">Excluir</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
