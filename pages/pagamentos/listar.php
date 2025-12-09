<?php
include("../includes/cabecalho.php");
include("../includes/conexao.php");

$sql = $pdo->query("
    SELECT p.id, p.valor, p.forma_pagamento, p.data_pagamento, p.status,
           c.nome AS cliente, a.data, a.hora
    FROM pagamentos p
    JOIN agendamentos a ON p.agendamento_id = a.id
    JOIN clientes c ON a.cliente_id = c.id
    ORDER BY p.data_pagamento DESC
");

echo "<h2>Pagamentos</h2>";
echo "<a href='cadastrar.php'>Novo Pagamento</a><br><br>";

echo "<table border='1'>
<tr>
<th>Cliente</th>
<th>Data do Agendamento</th>
<th>Valor</th>
<th>Forma</th>
<th>Pago em</th>
<th>Status</th>
<th>Ações</th>
</tr>";

while ($p = $sql->fetch()) {
    echo "<tr>
        <td>{$p['cliente']}</td>
        <td>{$p['data']} {$p['hora']}</td>
        <td>R$ {$p['valor']}</td>
        <td>{$p['forma_pagamento']}</td>
        <td>{$p['data_pagamento']}</td>
        <td>{$p['status']}</td>
        <td>
            <a href='editar.php?id={$p['id']}'>Editar</a> |
            <a href='excluir.php?id={$p['id']}'>Excluir</a>
        </td>
    </tr>";
}
echo "</table>";
