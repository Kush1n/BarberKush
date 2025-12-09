<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM cliente WHERE id_cliente=$id";
$res = $conexao->query($sql);

if ($res->num_rows === 0) {
    die("Cliente não encontrado.");
}

$cliente = $res->fetch_assoc();

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    if ($nome === "" || $telefone === "") {
        $mensagem = "Preencha nome e telefone.";
    } else {

        // Impedir duplicidade de telefone
        $sql_check = "SELECT * FROM cliente 
                      WHERE telefone='$telefone' AND id_cliente<>$id";
        $res_check = $conexao->query($sql_check);

        if ($res_check->num_rows > 0) {
            $mensagem = "Outro cliente já possui esse telefone.";
        } else {

            $sql_update = "UPDATE cliente SET
                           nome='$nome',
                           telefone='$telefone',
                           email='$email'
                           WHERE id_cliente=$id";

            if ($conexao->query($sql_update)) {
                $mensagem = "Cliente atualizado!";
            } else {
                $mensagem = "Erro: " . $conexao->error;
            }
        }
    }
}
?>

<h2>Editar Cliente</h2>

<p style="color:red;"><?= $mensagem ?></p>

<form method="POST">
    Nome:<br>
    <input type="text" name="nome" value="<?= $cliente['nome'] ?>" required><br><br>

    Telefone:<br>
    <input type="text" name="telefone" value="<?= $cliente['telefone'] ?>" required><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $cliente['email'] ?>"><br><br>

    <button type="submit">Salvar</button>
</form>

<br>
<a href="listar.php">Voltar</a>

<?php include "../../includes/footer.php"; ?>
