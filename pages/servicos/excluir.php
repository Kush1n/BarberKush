<?php 
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "DELETE FROM servico WHERE id_servico=$id";

$conexao->query($sql);

header("Location: listar.php");
exit;
