<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";
?>

<h2>Serviços Cadastrados</h2>

<a href="cadastrar.php">Novo Serviço</a><br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Serviço</th>
        <th>Descrição</th>
        <th>Valor</th>
        <th>Tempo (min)</th>
        <th>Ações</th>
    </tr>

<?php
$sql = "SELECT * FROM servico ORDER BY id_servico DESC";
$result = $conexao->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id_servico']."</td>";
    echo "<td>".$row['nome_servico']."</td>";
    echo "<td>".$row['descricao']."</td>";
    echo "<td>R$ ".$row['valor']."</td>";
    echo "<td>".$row['tempo_estimado']."</td>";
    echo "<td>
            <a href='editar.php?id={$row['id_servico']}'>Editar</a> |
            <a href='excluir.php?id={$row['id_servico']}'
               onclick='return confirm(\"Deseja excluir este serviço?\")'>
               Excluir
            </a>
          </td>";
    echo "</tr>";
}
?>

</table>

<?php include "../../includes/footer.php"; ?>
