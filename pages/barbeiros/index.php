<?php
require_once "../../includes/db.php";
require_once "../../includes/auth.php";
require_once "../../includes/header.php";

require_login();

$stmt = $pdo->query("SELECT * FROM barbeiros ORDER BY id_barbeiro DESC");
?>

<h2>Barbeiros</h2>

<a class="btn btn-success mb-3" href="create.php">+ Novo Barbeiro</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($b = $stmt->fetch()): ?>
        <tr>
            <td><?= $b['id_barbeiro'] ?></td>
            <td><?= htmlspecialchars($b['nome']) ?></td>
            <td><?= htmlspecialchars($b['cpf']) ?></td>
            <td><?= htmlspecialchars($b['telefone']) ?></td>
            <td>
                <a href="edit.php?id=<?= $b['id_barbeiro'] ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="delete.php?id=<?= $b['id_barbeiro'] ?>" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once "../../includes/footer.php"; ?>
