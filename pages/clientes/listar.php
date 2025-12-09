<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";
?>

<h2>Clientes Cadastrados</h2>

<a href="cadastrar.php">Novo Cliente</a><br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Data Cadastro</th>
        <th>Ações</th>
    </tr>

<?php
$sql = "SELECT * FROM cliente ORDER BY id_cliente DESC";
$result = $conexao->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id_cliente']."</td>";
    echo "<td>".$row['nome']."</td>";
    echo "<td>".$row['telefone']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['data_cadastro']."</td>";
    echo "<td>
            <a href='editar.php?id={$row['id_cliente']}'>Editar</a> |
            <a href='excluir.php?id={$row['id_cliente']}'
               onclick='return confirm(\"Deseja excluir?\")'>
               Excluir
            </a>
          </td>";
    echo "</tr>";
}
?>

</table>

<?php include "../../includes/footer.php"; ?>
