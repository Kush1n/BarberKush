<?php
require_once "../../includes/db.php";
<<<<<<< HEAD
require_once "../../includes/header.php";

=======
require_once "../../includes/auth.php";
require_once "../../includes/header.php";

require_login();

>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
$horas_antecedencia = 24; 

$agendamentos = $pdo->query("
    SELECT a.id_agendamento, c.nome AS cliente, b.nome AS barbeiro, s.nome AS servico, 
           a.data_inicio, a.data_fim, a.status
    FROM agendamentos a
    JOIN clientes c ON a.id_cliente = c.id_cliente
    JOIN barbeiros b ON a.id_barbeiro = b.id_barbeiro
    JOIN servicos s ON a.id_servico = s.id_servico
    ORDER BY a.data_inicio ASC
")->fetchAll();
?>

<div class="container mt-4">
    <h2>Agendamentos</h2>

    <div class="mb-3">
        <a href="create.php" class="btn btn-success">+ Novo Agendamento</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Barbeiro</th>
                <th>Serviço</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $a): ?>
                <?php
                    $data_inicio_ts = strtotime($a['data_inicio']);
                    $agora = time();
                    $permitir_acao = ($data_inicio_ts - ($horas_antecedencia * 3600)) > $agora;
                ?>
                <tr>
                    <td><?= htmlspecialchars($a['cliente']) ?></td>
                    <td><?= htmlspecialchars($a['barbeiro']) ?></td>
                    <td><?= htmlspecialchars($a['servico']) ?></td>
                    <td><?= date('d/m/Y H:i', $data_inicio_ts) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($a['data_fim'])) ?></td>
                    <td><?= htmlspecialchars($a['status']) ?></td>
                    <td>
                        <?php if ($permitir_acao): ?>
                            <a href="edit.php?id=<?= $a['id_agendamento'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="delete.php?id=<?= $a['id_agendamento'] ?>" class="btn btn-danger btn-sm">Cancelar</a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Editar</button>
                            <button class="btn btn-secondary btn-sm" disabled>Cancelar</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "../../includes/footer.php"; ?>
