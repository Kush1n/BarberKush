<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

generate_csrf();

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM servicos WHERE id_servico = ?");
$stmt->execute([$id]);
$servico = $stmt->fetch();

if (!$servico) {
    die("Serviço não encontrado.");
}

$erro = "";
$sucesso = "";

$nome = $servico['nome'];
$duracao = $servico['duracao_min'];
$preco = $servico['preco'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!check_csrf($_POST['csrf'])) {
        $erro = "Ação não autorizada (CSRF inválido).";
    } else {
        $nome = trim($_POST['nome']);
        $duracao = intval($_POST['duracao_min']);
        $preco = floatval($_POST['preco']);

        if ($duracao <= 0 || $duracao > 30) {
            $erro = "A duração do serviço deve ser no máximo 30 minutos.";
        } else {
            $sql = $pdo->prepare("UPDATE servicos SET nome = ?, duracao_min = ?, preco = ? WHERE id_servico = ?");
            if ($sql->execute([$nome, $duracao, $preco, $id])) {
                $sucesso = "Serviço atualizado com sucesso!";
            } else {
                $erro = "Erro ao atualizar serviço.";
            }
        }
    }
}
?>

<h2>Editar Serviço</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if ($sucesso): ?>
    <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome do Serviço:</label>
    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>" required>

    <label class="mt-2">Duração (minutos, máximo 30):</label>
    <input type="number" name="duracao_min" class="form-control" min="1" max="30" value="<?= htmlspecialchars($duracao) ?>" required>

    <label class="mt-2">Preço:</label>
    <input type="number" step="0.01" name="preco" class="form-control" value="<?= htmlspecialchars($preco) ?>" required>

    <button type="submit" class="btn btn-success mt-3">Atualizar</button>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
