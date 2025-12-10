<?php
require_once "../../includes/db.php";
require_once "../../includes/token.php";
require_once "../../includes/header.php";

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

    if (!verify_csrf($_POST['csrf'])) {
        die("Ação não autorizada.");
    }

    $del = $pdo->prepare("DELETE FROM servicos WHERE id_servico = ?");
    $del->execute([$id]);

    $_SESSION['msg'] = "Serviço excluído com sucesso!";
    header("Location: index.php");
    exit;
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
