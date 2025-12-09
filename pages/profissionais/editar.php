<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM profissional WHERE id_profissional=$id";
$res = $conexao->query($sql);

if ($res->num_rows === 0) {
    die("Profissional não encontrado.");
}

$prof = $res->fetch_assoc();
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome']);
    $especialidade = trim($_POST['especialidade']);
    $telefone = trim($_POST['telefone']);
    $status = $_POST['status'];

    if ($nome === "" || $telefone === "") {
        $mensagem = "Nome e telefone são obrigatórios.";
    } else {

        // Evitar duplicidade
        $sql_check = "SELECT * FROM profissional 
                      WHERE nome='$nome' AND telefone='$telefone'
                      AND id_profissional<>$id";

        if ($conexao->query($sql_check)->num_rows > 0) {
            $mensagem = "Outro profissional já possui esses dados.";
        } else {

            $sql_update = "UPDATE profissional SET
                           nome='$nome',
                           especialidade='$especialidade',
                           telefone='$telefone',
                           status='$status'
                           WHERE id_profissional=$id";

            if ($conexao->query($sql_update)) {
                $mensagem = "Profissional atualizado!";
            } else {
                $mensagem = "Erro: " . $conexao->error;
            }
        }
    }
}
?>

<h2>Editar Profissional</h2>

<p style="color:red;"><?= $mensagem ?></p>

<form method="POST">
    Nome:<br>
    <input type="text" name="nome" value="<?= $prof['nome'] ?>" required><br><br>

    Especialidade:<br>
    <input type="text" name="especialidade" value="<?= $prof['especialidade'] ?>"><br><br>

    Telefone:<br>
    <input type="text" name="telefone" value="<?= $prof['telefone'] ?>" required><br><br>

    Status:<br>
    <select name="status">
        <option value="ativo" <?= $prof['status']=="ativo"?"selected":"" ?>>Ativo</option>
        <option value="inativo" <?= $prof['status']=="inativo"?"selected":"" ?>>Inativo</option>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>

<br>
<a href="listar.php">Voltar</a>

<?php include "../../includes/footer.php"; ?>
