<?php
include("../includes/conexao.php");

$id = $_GET['id'];

$sql = $pdo->prepare("SELECT * FROM agendamentos WHERE id = ?");
$sql->execute([$id]);
$ag = $sql->fetch();
?>

<form action="atualizar.php" method="POST">
<input type="hidden" name="id" value="<?= $ag['id'] ?>">

Data:<br>
<input type="date" name="data" value="<?= $ag['data'] ?>"><br><br>

Hora:<br>
<input type="time" name="hora" value="<?= $ag['hora'] ?>"><br><br>

Status:<br>
<select name="status">
    <option value="ativo" <?= $ag['status'] == "ativo" ? "selected" : "" ?>>Ativo</option>
    <option value="finalizado" <?= $ag['status'] == "finalizado" ? "selected" : "" ?>>Finalizado</option>
    <option value="cancelado" <?= $ag['status'] == "cancelado" ? "selected" : "" ?>>Cancelado</option>
</select><br><br>

<button type="submit">Salvar</button>
</form>
