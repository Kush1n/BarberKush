<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();

$id = $_GET["id"] ?? 0;

/* Busca barbeiro */
$stmt = $pdo->prepare("SELECT * FROM barbeiros WHERE id_barbeiro = ?");
$stmt->execute([$id]);
$barbeiro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barbeiro) {
    echo "<div class='alert alert-danger'>Barbeiro não encontrado.</div>";
    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
    require_once "../../includes/footer.php";
    exit;
}

/* Verifica agendamentos vinculados */
$check = $pdo->prepare("SELECT id_agendamento FROM agendamentos WHERE id_barbeiro = ?");
$check->execute([$id]);

if ($check->rowCount() > 0) {
    echo "<div class='alert alert-danger'>Não é possível excluir: barbeiro possui agendamentos.</div>";
    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2500);</script>';
    require_once "../../includes/footer.php";
    exit;
}

/* Processamento da exclusão */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!check_csrf($_POST['csrf'])) {
        echo "<div class='alert alert-danger'>Ação não autorizada (CSRF inválido).</div>";
        echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2500);</script>';
        require_once "../../includes/footer.php";
        exit;
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
