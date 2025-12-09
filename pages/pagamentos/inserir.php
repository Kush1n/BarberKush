<?php
include("../includes/conexao.php");

$agendamento_id = $_POST['agendamento_id'];
$valor = $_POST['valor'];
$forma = $_POST['forma_pagamento'];

// Regra 1: valor inválido
if ($valor <= 0) {
    die("Erro: Valor do pagamento deve ser maior que zero.");
}

// Regra 2: agendamento deve estar finalizado
$sql = $pdo->prepare("SELECT status FROM agendamentos WHERE id = ?");
$sql->execute([$agendamento_id]);
$ag = $sql->fetch();

if (!$ag || $ag['status'] != 'finalizado') {
    die("Erro: Só é possível pagar por agendamentos FINALIZADOS.");
}

// Regra 3: impedir pagamento duplicado
$dup = $pdo->prepare("SELECT * FROM pagamentos WHERE agendamento_id = ?");
$dup->execute([$agendamento_id]);

if ($dup->rowCount() > 0) {
    die("Erro: Este agendamento já possui pagamento.");
}

// Inserir pagamento
$sql = $pdo->prepare("
    INSERT INTO pagamentos (agendamento_id, valor, forma_pagamento, data_pagamento, status)
    VALUES (?, ?, ?, NOW(), 'pago')
");

if ($sql->execute([$agendamento_id, $valor, $forma])) {
    echo "Pagamento registrado com sucesso!";
} else {
    echo "Erro ao registrar pagamento!";
}
