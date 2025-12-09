<?php
include("../includes/conexao.php");

$cliente = $_POST['cliente_id'];
$profissional = $_POST['profissional_id'];
$servico = $_POST['servico_id'];
$data = $_POST['data'];
$hora = $_POST['hora'];

$agendamento = "$data $hora";

// Regra 1: impedir agendamento no passado
if (strtotime($agendamento) < time()) {
    die("Erro: Não é possível agendar para o passado.");
}

// Regra 2: verificar conflito de horário
$verif = $pdo->prepare("SELECT * FROM agendamentos WHERE data = ? AND hora = ? AND profissional_id = ?");
$verif->execute([$data, $hora, $profissional]);

if ($verif->rowCount() > 0) {
    die("Erro: O profissional já possui agendamento neste horário.");
}

// Inserção
$sql = $pdo->prepare("INSERT INTO agendamentos 
(cliente_id, profissional_id, servico_id, data, hora, status) 
VALUES (?, ?, ?, ?, ?, 'ativo')");

if ($sql->execute([$cliente, $profissional, $servico, $data, $hora])) {
    echo "Agendamento realizado com sucesso!";
} else {
    echo "Erro ao cadastrar agendamento!";
}
