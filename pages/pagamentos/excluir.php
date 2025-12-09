<?php
include("../includes/conexao.php");

$id = $_GET['id'];

$sql = $pdo->prepare("DELETE FROM pagamentos WHERE id = ?");

if ($sql->execute([$id])) {
    echo "Pagamento excluído!";
} else {
    echo "Erro ao excluir!";
}
