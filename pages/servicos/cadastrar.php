<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

// Token anti reenvio
if (!isset($_SESSION['token_serv'])) {
    $_SESSION['token_serv'] = bin2hex(random_bytes(32));
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token_serv']) {
        die("Operação inválida.");
    }

    $nome = trim($_POST['nome_servico']);
    $descricao = trim($_POST['descricao']);
    $valor = floatval($_POST['valor']);
    $tempo = intval($_POST['tempo_estimado']);

    if ($nome === "" || $valor <= 0 || $tempo <= 0) {
        $mensagem = "Preencha todos os campos corretamente.";
    } else {

        // Verificar duplicidade de serviço
        $sql_check = "SELECT * FROM servico WHERE nome_servico='$nome'";
        if ($conexao->query($sql_check)->num_rows > 0) {
            $mensagem = "Esse serviço já está cadastrado.";
        } else {

            $sql = "INSERT INTO servico (nome_servico, descricao, valor, tempo_estimado)
                    VALUES ('$nome', '$descricao', '$valor', '$tempo')";

            if ($conexao->query($sql)) {
                $mensagem = "Serviço cadastrado com sucesso!";
                unset($_SESSION[']()_
