<?php
require_once "../../includes/db.php";
require_once "../../includes/auth.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

require_login();

if (!isset($_GET['id'])) {
    die("ID inválido.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT a.*, c.nome AS cliente, b.nome AS barbeiro, s.nome AS servico 
    FROM agendamentos a
    JOIN clientes c ON a.id_cliente = c.id_cliente
    JOIN barbeiros b ON a.id_barbeiro = b.id_barbeiro
    JOIN servicos s ON a.id_servico = s.id_servico
    WHERE a.id_agendamento = ?
");
$stmt->execute([$id]);
$agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agendamento) {
    die("Agendamento não encontrado.");
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!check_csrf($_POST["token"])) {
        $erro = "Token inválido.";
    } else {
        $del = $pdo->prepare("DELETE FROM agendamentos WHERE id_agendamento = ?");
        if ($del->execute([$id])) {
            header("Location: index.php");
            exit;
        } else {
            $erro = "Erro ao excluir.";
        }
    }
}
?>

<h2>Excluir Agendamento</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<p><strong>Cliente:</strong> <?= htmlspecialchars($agendamento['cliente']) ?></p>
<p><strong>Barbeiro:</strong> <?= htmlspecialchars($agendamento['barbeiro']) ?></p>
<p><strong>Serviço:</strong> <?= htmlspecialchars($agendamento['servico']) ?></p>
<p><strong>Data:</strong> <?= date('d/m/Y', strtotime($agendamento['data_inicio'])) ?></p>
<p><strong>Hora:</strong> <?= date('H:i', strtotime($agendamento['data_inicio'])) ?></p>

<form method="POST">
    <input type="hidden" name="token" value="<?= $_SESSION['csrf_token'] ?>">
    <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
