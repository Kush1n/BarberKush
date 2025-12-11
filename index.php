<?php
require_once "includes/db.php";
require_once "includes/header.php";
?>
<div class="container mt-4">
    <h1 class="mb-4">Bem-vindo ao BarberKush</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card card-dark h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-2 card-title">Clientes</div>
                    <div class="card-number flex-grow-1 display-6">
                        <?= (int) $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn() ?>
                    </div>
                    <div class="mt-3">
                        <a href="/barberkush/pages/clientes/" class="btn btn-light btn-sm">Ver clientes</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dark h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-2 card-title">Barbeiros</div>
                    <div class="card-number flex-grow-1 display-6">
                        <?= (int) $pdo->query("SELECT COUNT(*) FROM barbeiros WHERE ativo = 1")->fetchColumn() ?>
                    </div>
                    <div class="mt-3">
                        <a href="/barberkush/pages/barbeiros/" class="btn btn-light btn-sm">Ver barbeiros</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dark h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-2 card-title">Serviços</div>
                    <div class="card-number flex-grow-1 display-6">
                        <?= (int) $pdo->query("SELECT COUNT(*) FROM servicos WHERE ativo = 1")->fetchColumn() ?>
                    </div>
                    <div class="mt-3">
                        <a href="/barberkush/pages/servicos/" class="btn btn-light btn-sm">Ver serviços</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-dark h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-2 card-title">Agendamentos</div>
                    <div class="card-number flex-grow-1 display-6">
                        <?= (int) $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE status IN ('pendente','confirmado')")->fetchColumn() ?>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a href="/barberkush/pages/agendamentos/create.php" class="btn btn-light btn-sm">Novo</a>
                        <a href="/barberkush/pages/agendamentos/" class="btn btn-light btn-sm">Ver agendamentos</a>
                    </div>
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
