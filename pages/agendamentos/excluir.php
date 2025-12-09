<?php
include("../includes/conexao.php");

$id = $_GET['id'];

$check = $pdo->prepare("SELECT status FROM agendamentos WHERE id = ?");
$check->execute([$id]);
$a = $check->fetch();

// Regra: não apagar agendamento finalizado
if ($a['status'] == "finalizado") {
    die("Erro: Não é permitido excluir um agendamento FINALIZADO.");
}

$sql = $pdo->prepare("DELETE FROM agendamentos WHERE id = ?");

if ($sql->execute([$id])) {
    echo "Agendamento excluído.";
} else {
    echo "Erro ao excluir!";
}
