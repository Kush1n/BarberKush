<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";
<<<<<<< HEAD
=======
require_once "../../includes/auth.php";

require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4

$erro = "";
$sucesso = "";

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
            $sql = $pdo->prepare("INSERT INTO servicos (nome, duracao_min, preco, ativo, criado_em) VALUES (?, ?, ?, 1, NOW())");
            if ($sql->execute([$nome, $duracao, $preco])) {
<<<<<<< HEAD
                $sucesso = "Serviço cadastrado com sucesso! Redirecionando...";
                echo '<div class="alert alert-success">' . htmlspecialchars($sucesso) . '</div>';
                echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                require_once "../../includes/footer.php";
                exit;
=======
                $sucesso = "Serviço cadastrado com sucesso!";
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
            } else {
                $erro = "Erro ao cadastrar serviço.";
            }
        }
    }
}
?>

<h2>Novo Serviço</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<<<<<<< HEAD
<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome do Corte:</label>
=======
<?php if ($sucesso): ?>
    <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome do Serviço:</label>
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
    <input type="text" name="nome" class="form-control" required>

    <label class="mt-2">Duração (minutos, máximo 30):</label>
    <input type="number" name="duracao_min" class="form-control" max="30" required>

    <label class="mt-2">Preço:</label>
    <input type="number" step="0.01" name="preco" class="form-control" required>

    <button class="btn btn-success mt-3">Salvar</button>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
