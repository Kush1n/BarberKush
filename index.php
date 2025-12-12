<?php
require_once "includes/db.php";
require_once "includes/header.php";
?>

<style>
    .card-dark {
        background-color: #1f1f1f !important;
        color: #ffffff !important;
        border: 1px solid #333 !important;
        border-radius: 12px;
        transition: 0.3s;
    }

    .card-dark:hover {
        background-color: #272727 !important;
        transform: translateY(-3px);
    }

    .card-dark .card-title {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .card-dark .card-number {
        font-size: 2rem;
        font-weight: bold;
        margin-top: 5px;
        margin-bottom: 10px;
    }

    .card-dark .btn {
        border-color: #fff !important;
        color: #fff !important;
    }

    .card-dark .btn:hover {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>

<div class="container mt-4">

    <h1 class="mb-4 fw-bold">Bem-vindo ao BarberKush</h1>

    <div class="row g-4">

        <!-- CLIENTES -->
        <div class="col-md-3">
            <div class="card card-dark h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Clientes</h5>
                        <?php
                        $total_clientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
                        ?>
                        <p class="card-number"><?= (int)$total_clientes ?></p>
                    </div>

                    <a href="/barberkush/pages/clientes/" class="btn btn-outline-light btn-sm mt-3">
                        Ver clientes
                    </a>
                </div>
            </div>
        </div>

        <!-- BARBEIROS -->
        <div class="col-md-3">
            <div class="card card-dark h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Barbeiros</h5>
                        <?php
                        $total_barbeiros = $pdo->query("SELECT COUNT(*) FROM barbeiros WHERE ativo = 1")->fetchColumn();
                        ?>
                        <p class="card-number"><?= (int)$total_barbeiros ?></p>
                    </div>

                    <a href="/barberkush/pages/barbeiros/" class="btn btn-outline-light btn-sm mt-3">
                        Ver barbeiros
                    </a>
                </div>
            </div>
        </div>

        <!-- SERVIÇOS -->
        <div class="col-md-3">
            <div class="card card-dark h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Serviços</h5>
                        <?php
                        $total_servicos = $pdo->query("SELECT COUNT(*) FROM servicos WHERE ativo = 1")->fetchColumn();
                        ?>
                        <p class="card-number"><?= (int)$total_servicos ?></p>
                    </div>

                    <a href="/barberkush/pages/servicos/" class="btn btn-outline-light btn-sm mt-3">
                        Ver serviços
                    </a>
                </div>
            </div>
        </div>

        <!-- AGENDAMENTOS -->
        <div class="col-md-3">
            <div class="card card-dark h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Agendamentos</h5>

                        <?php
                        $total_agendamentos = $pdo->query("
                            SELECT COUNT(*)
                            FROM agendamentos
                            WHERE status IN ('pendente', 'confirmado')
                        ")->fetchColumn();
                        ?>
                        <p class="card-number"><?= (int)$total_agendamentos ?></p>
                    </div>

                    <div class="d-flex flex-column gap-2 mt-3">
                        <a href="/barberkush/pages/agendamentos/create.php"
                           class="btn btn-outline-warning btn-sm">
                            Novo agendamento
                        </a>

                        <a href="/barberkush/pages/agendamentos/"
                           class="btn btn-outline-light btn-sm">
                            Ver agendamentos
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-5">
        <div class="alert alert-dark border-light">
            <h4 class="alert-heading">Olá</h4>
            <p>
                Escolha uma opção no menu ou clique nos cards acima para gerenciar
                clientes, barbeiros, serviços e agendamentos.
            </p>
        </div>
    </div>

</div>

<?php require_once "includes/footer.php"; ?>
