<?php 
include "../../includes/header.php";
include "../../includes/conexao.php";

// Criar token para evitar reenvio
if (!isset($_SESSION['token_cliente'])) {
    $_SESSION['token_cliente'] = bin2hex(random_bytes(32));
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token_cliente']) {
        die("Operação inválida!");
    }

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $data_cadastro = date("Y-m-d");

    if ($nome === "" || $telefone === "") {
        $mensagem = "Preencha os campos obrigatórios.";
    } else {

        // Impedir cliente duplicado (mesmo telefone)
        $sql_check = "SELECT * FROM cliente WHERE telefone='$telefone'";
        $res_check = $conexao->query($sql_check);

        if ($res_check->num_rows > 0) {
            $mensagem = "Já existe um cliente com esse telefone.";
        } else {
            $sql = "INSERT INTO cliente (nome, telefone, email, data_cadastro)
                    VALUES ('$nome', '$telefone', '$email', '$data_cadas_
