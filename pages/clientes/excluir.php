<?php 
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "DELETE FROM cliente WHERE id_cliente=$id";

$conexao->query($sql);

header("Location: listar.php");
exit;
