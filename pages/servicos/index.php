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
?>

<h2>Serviços</h2>
<a href="create.php" class="btn btn-success mb-3">+ Novo Serviço</a>

<?php if (isset($_SESSION['msg'])): ?>
    <div class="alert alert-info"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Serviço</th>
            <th>Preço (R$)</th>
            <th>Duração (min)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = $pdo->query("SELECT * FROM servicos ORDER BY nome ASC");
        while ($s = $sql->fetch()):
        ?>
        <tr>
            <td><?= $s['id_servico'] ?></td>
            <td><?= htmlspecialchars($s['nome']) ?></td>
            <td><?= number_format($s['preco'], 2, ',', '.') ?></td>
            <td><?= $s['duracao'] ?> min</td>
            <td>
                <a href="edit.php?id=<?= $s['id_servico'] ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="delete.php?id=<?= $s['id_servico'] ?>" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>
