<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";
?>

<h2>Profissionais Cadastrados</h2>

<a href="cadastrar.php">Novo Profissional</a><br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Especialidade</th>
        <th>Telefone</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

<?php
$sql = "SELECT * FROM profissional ORDER BY id_profissional DESC";
$result = $conexao->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id_profissional']."</td>";
    echo "<td>".$row['nome']."</td>";
    echo "<td>".$row['especialidade']."</td>";
    echo "<td>".$row['telefone']."</td>";
    echo "<td>".$row['status']."</td>";
    echo "<td>
            <a href='editar.php?id={$row['id_profissional']}'>Editar</a> |
            <a href='excluir.php?id={$row['id_profissional']}'
               onclick='return confirm(\"Deseja excluir?\")'>
               Excluir
            </a>
          </td>";
    echo "</tr>";
}
?>

</table>

<?php include "../../includes/footer.php"; ?>
