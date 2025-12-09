<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

// Token anti-reenvio
if (!isset($_SESSION['token_prof'])) {
    $_SESSION['token_prof'] = bin2hex(random_bytes(32));
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token_prof']) {
        die("Operação inválida.");
    }

    $nome = trim($_POST['nome']);
    $especialidade = trim($_POST['especialidade']);
    $telefone = trim($_POST['telefone']);
    $status = $_POST['status'];

    if ($nome === "" || $telefone === "") {
        $mensagem = "Nome e telefone são obrigatórios.";
    } else {

        // Verificar duplicidade por nome + telefone
        $sql_check = "SELECT * FROM profissional 
                      WHERE nome='$nome' AND telefone='$telefone'";

        if ($conexao->query($sql_check)->num_rows > 0) {
            $mensagem = "Já existe um profissional com esse nome e telefone.";
        } else {

            $sql = "INSERT INTO profissional (nome, especialidade, telefone, status)
                    VALUES ('$nome', '$especialidade', '$telefone', '$status')";

            if ($conexao->query($sql)) {
                $mensagem = "Profissional cadastrado com sucesso!";
                unset($_SESSION['token_prof']);
            } else {
                $mensagem = "Erro ao cadastrar: " . $conexao->error;
            }
        }
    }
}
?>

<h2>Cadastrar Profissional</h2>

<p style="color:red;"><?= $mensagem ?></p>

<form method="POST">
    <input type="hidden" name="token" value="<?= $_SESSION['token_prof'] ?>">

    Nome:<br>
    <input type="text" name="nome" required><br><br>

    Especialidade:<br>
    <input type="text" name="especialidade"><br><br>

    Telefone:<br>
    <input type="text" name="telefone" required><br><br>

    Status:<br>
    <select name="status">
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
    </select><br><br>

    <button type="submit">Cadastrar</button>
</form>

<br>
<a href="listar.php">Voltar</a>

<?php include "../../includes/footer.php"; ?>
