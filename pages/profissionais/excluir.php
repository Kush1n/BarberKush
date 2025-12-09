<?php 
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "DELETE FROM profissional WHERE id_profissional=$id";

$conexao->query($sql);

header("Location: listar.php");
exit;
