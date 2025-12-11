<?php
require_once "../../includes/db.php";
require_once "../../includes/header.php";

$clientes = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC")->fetchAll();
?>

<h2>Clientes</h2>
<a href="create.php" class="btn btn-success mb-3">+ Novo Cliente</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th><th>Nome</th><th>CPF</th><th>Telefone</th><th>Email</th><th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= $c['id_cliente'] ?></td>
            <td><?= htmlspecialchars($c['nome']) ?></td>
            <td><?= htmlspecialchars($c['cpf']) ?></td>
            <td><?= htmlspecialchars($c['telefone']) ?></td>
            <td><?= htmlspecialchars($c['email']) ?></td>
            <td>
                <a href="edit.php?id=<?= $c['id_cliente'] ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="delete.php?id=<?= $c['id_cliente'] ?>" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>
