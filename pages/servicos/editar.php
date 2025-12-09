<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM servico WHERE id_servico=$id";
$res = $conexao->query($sql);

if ($res->num_rows === 0) {
    die("Serviço não encontrado.");
}

$serv = $res->fetch_assoc();
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome_servico']);
    $descricao = trim($_POST['descricao']);
    $valor = floatval($_POST['valor']);
    $tempo = intval($_POST['tempo_estimado']);

    if ($nome === "" || $valor <= 0 || $tempo <= 0) {
        $mensagem = "Preencha todos os campos corretamente.";
    } else {

        // Verificar duplicidade
        $sql_check = "SELECT * FROM servico 
                      WHERE nome_servico='$nome' AND id_servico<>$id";

        if ($conexao->query($sql_check)->num_rows > 0) {
            $mensagem = "Outro serviço já possui esse nome.";
        } else {

            $sql_update = "UPDATE servico SET
                           nome_servico='$nome',
                           descricao='$descricao',
                           valor='$valor',
                           tempo_estimado='$tempo'
                           WHERE id_servico=$id";

            if ($conexao->query($sql_update)) {
                $mensagem = "Serviço atualizado!";
            } else {
                $mensagem = "Erro: " . $conexao->error;
            }
        }
    }
}
?>

<h2>Editar Serviço</h2>

<p style="color:red;"><?= $mensagem ?></p>

<form method="POST">
    Nome do Serviço:<br>
    <input type="text" name="nome_servico" value="<?= $serv['nome_servico'] ?>" required><br><br>

    Descrição:<br>
