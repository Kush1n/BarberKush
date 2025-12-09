<?php include("../includes/cabecalho.php"); ?>
<h2>Novo Pagamento</h2>

<form action="inserir.php" method="POST">

    Agendamento Finalizado:<br>
    <select name="agendamento_id" required>
        <option value="">Selecione</option>
        <?php
        include("../includes/conexao.php");
        $sql = $pdo->query("
            SELECT a.id, c.nome, a.data, a.hora
            FROM agendamentos a
            JOIN clientes c ON a.cliente_id = c.id
            WHERE a.status = 'finalizado'
        ");
        while ($ag = $sql->fetch()) {
            echo "<option value='{$ag['id']}'>
                {$ag['nome']} - {$ag['data']} às {$ag['hora']}
            </option>";
        }
        ?>
    </select><br><br>

    Valor (R$):<br>
    <input type="number" step="0.01" name="valor" required><br><br>

    Forma de Pagamento:<br>
    <select name="forma_pagamento" required>
        <option value="">Selecione</option>
        <option value="dinheiro">Dinheiro</option>
        <option value="pix">PIX</option>
        <option value="cartao">Cartão</option>
    </select><br><br>

    <button type="submit">Registrar Pagamento</button>
</form>
