<?php
include("../includes/cabecalho.php");
include("../includes/conexao.php");

$sql = $pdo->query("SELECT a.id, c.nome AS cliente, p.nome AS profissional, 
s.nome AS servico, a.data, a.hora, a.status
FROM agendamentos a
JOIN clientes c ON a.cliente_id = c.id
JOIN profissionais p ON a.profissional_id = p.id
JOIN servicos s ON a.servico_id = s.id
ORDER BY a.data, a.hora");

echo "<h2>Agendamentos</h2>";
echo "<a href='cadastrar.php'>Novo Agendamento</a><br><br>";

echo "<table border='1'>
<tr>
<th>Cliente</th>
<th>Profissional</th>
<th>Serviço</th>
<th>Data</th>
<th>Hora</th>
<th>Status</th>
<th>Ações</th>
</tr>";

while ($a = $sql->fetch()) {
    echo "<tr>
        <td>{$a['cliente']}</td>
        <td>{$a['profissional']}</td>
        <td>{$a['servico']}</td>
        <td>{$a['data']}</td>
        <td>{$a['hora']}</td>
        <td>{$a['status']}</td>
        <td>
            <a href='editar.php?id={$a['id']}'>Editar</a> |
            <a href='excluir.php?id={$a['id']}'>Excluir</a>
        </td>
    </tr>";
}
echo "</table>";
