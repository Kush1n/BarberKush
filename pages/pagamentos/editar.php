<?php
include("../includes/conexao.php");

$id = $_GET['id'];
$sql = $pdo->prepare("SELECT * FROM pagamentos WHERE id = ?");
$sql->execute([$id]);
$p = $sql->fetch();
?>

<h2>Editar Pagamento</h2>

<form action="atualizar.php" method="POST">
<input type="hidden" name="id" value="<?= $p['id'] ?>">

Valor:<br>
<input type="number" name="valor" step="0.01" value="<?= $p['valor'] ?>" required><br><br>

Forma de Pagamento:<br>
<select name="forma_pagamento">
    <option value="dinheiro" <?= $p['forma_pagamento'] == "dinheiro" ? "selected" : "" ?>>Dinheiro</option>
    <option value="pix" <?= $p['forma_pagamento'] == "pix" ? "selected" : "" ?>>PIX</option>
    <option value="cartao" <?= $p['forma_pagamento'] == "cartao" ? "selected" : "" ?>>Cartão</option>
</select><br><br>

Status:<br>
<select name="status">
    <option value="pago" <?= $p['status'] == "pago" ? "selected" : "" ?>>Pago</option>
    <option value="estornado" <?= $p['status'] == "estornado" ? "selected" : "" ?>>Estornado</option>
</select><br><br>

<button type="submit">Salvar Alterações</button>
</form>
