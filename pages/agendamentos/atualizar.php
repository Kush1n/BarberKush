<?php
include("../includes/conexao.php");

$id = $_POST['id'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$status = $_POST['status'];

$sql = $pdo->prepare("UPDATE agendamentos SET data = ?, hora = ?, status = ? WHERE id = ?");

if ($sql->execute([$data, $hora, $status, $id])) {
    echo "Atualizado com sucesso!";
} else {
    echo "Erro ao atualizar!";
}
