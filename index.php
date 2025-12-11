<?php 
require_once "includes/db.php";
require_once "includes/header.php"; 
?>

<div class="container mt-4">
    <h1 class="mb-4">Bem-vindo ao BarberKush</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <?php 
                    $total_clientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
                    ?>
                    <p class="card-text display-6"><?= $total_clientes ?></p>
                    <a href="/barberkush/pages/clientes/" class="btn btn-light btn-sm">Ver clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Barbeiros</h5>
                    <?php 
                    $total_barbeiros = $pdo->query("SELECT COUNT(*) FROM barbeiros WHERE ativo = 1")->fetchColumn();
                    ?>
                    <p class="card-text display-6"><?= $total_barbeiros ?></p>
                    <a href="/barberkush/pages/barbeiros/" class="btn btn-light btn-sm">Ver barbeiros</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Serviços</h5>
                    <?php 
                    $total_servicos = $pdo->query("SELECT COUNT(*) FROM servicos WHERE ativo = 1")->fetchColumn();
                    ?>
                    <p class="card-text display-6"><?= $total_servicos ?></p>
                    <a href="/barberkush/pages/servicos/" class="btn btn-light btn-sm">Ver serviços</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h5 class="card-title">Agendamentos</h5>
                    <?php 
                    $total_agendamentos = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE status IN ('pendente','confirmado')")->fetchColumn();
                    ?>
                    <p class="card-text display-6"><?= $total_agendamentos ?></p>
<<<<<<< HEAD
                    <a href="../barberkush/pages/agendamentos/create.php" class="btn btn-light btn-sm">Ver agendamentos</a>
=======
                    <a href="/barberkush/pages/agendamentos/" class="btn btn-light btn-sm">Ver agendamentos</a>
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="alert alert-info">
            <h4 class="alert-heading">Olá</h4>
            <p>Escolha uma opção no menu ou clique nos cards acima para gerenciar clientes, barbeiros, serviços e agendamentos.</p>
        </div>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>