<?php
include("../includes/conexao.php");

$id = $_POST['id'];
$valor = $_POST['valor'];
$forma = $_POST['forma_pagamento'];
$status = $_POST['status'];

if ($valor <= 0) {
    die("Erro: Valor inválido.");
}

// Regra: estorno até 24h após o pagamento
$check = $pdo->prepare("SELECT data_pagamento FROM pagamentos WHERE id = ?");
$check->execute([$id]);
$p = $check->fetch();

$tempo_passado = time() - strtotime($p['data_pagamento']);

if ($status == "estornado" && $tempo_passado > 86400) {
    die("Erro: Só é possível estornar até 24 horas após o pagamento.");
}

$sql = $pdo->prepare("
    UPDATE pagamentos 
    SET valor = ?, forma_pagamento = ?, status = ?
    WHERE id = ?
");

if ($sql->execute([$valor, $forma, $status, $id])) {
    echo "Pagamento atualizado!";
} else {
    echo "Erro ao atualizar!";
}
