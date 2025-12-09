<?php include("../includes/cabecalho.php"); ?>
<h2>Novo Agendamento</h2>

<form action="inserir.php" method="POST">
    Cliente:<br>
    <select name="cliente_id" required>
        <option value="">Selecione</option>
        <?php
        include("../includes/conexao.php");
        $c = $pdo->query("SELECT id, nome FROM clientes");
        while ($cli = $c->fetch()) {
            echo "<option value='{$cli['id']}'>{$cli['nome']}</option>";
        }
        ?>
    </select><br><br>

    Profissional:<br>
    <select name="profissional_id" required>
        <option value="">Selecione</option>
        <?php
        $p = $pdo->query("SELECT id, nome FROM profissionais");
        while ($pro = $p->fetch()) {
            echo "<option value='{$pro['id']}'>{$pro['nome']}</option>";
        }
        ?>
    </select><br><br>

    Serviço:<br>
    <select name="servico_id" required>
        <option value="">Selecione</option>
        <?php
        $s = $pdo->query("SELECT id, nome FROM servicos");
        while ($ser = $s->fetch()) {
            echo "<option value='{$ser['id']}'>{$ser['nome']}</option>";
        }
        ?>
    </select><br><br>

    Data:<br>
    <input type="date" name="data" required><br><br>

    Hora:<br>
    <input type="time" name="hora" required><br><br>

    <button type="submit">Cadastrar</button>
</form>
