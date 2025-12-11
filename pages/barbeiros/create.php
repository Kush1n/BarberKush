<?php
require_once "../../includes/db.php";
<<<<<<< HEAD
require_once "../../includes/header.php";
require_once "../../includes/token.php";

=======
require_once "../../includes/auth.php";
require_once "../../includes/header.php";
require_once "../../includes/token.php";

require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
generate_csrf();

function validarCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf); 
    if (strlen($cpf) != 11) return false;
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }
        $d = ((10 * $soma) % 11) % 10;
        if ($cpf[$i] != $d) return false;
    }
    return true;
}

function validarTelefone($telefone) {
    $telefone = preg_replace('/\D/', '', $telefone); 
    if (strlen($telefone) < 10 || strlen($telefone) > 11) return false;
    return $telefone;
}

$erro = "";
<<<<<<< HEAD
$sucesso = "";
=======
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!check_csrf($_POST['csrf'])) {
<<<<<<< HEAD
        $erro = "Ação não autorizada (CSRF inválido).";
    } else {
        $nome = trim($_POST["nome"]);
        $cpf = trim($_POST["cpf"]);
        $telefone = trim($_POST["telefone"]);

        if (empty($nome) || empty($cpf) || empty($telefone)) {
            $erro = "Preencha todos os campos.";
        } elseif (!validarCPF($cpf)) {
            $erro = "CPF inválido. Digite um CPF com 11 dígitos válido.";
        } elseif (!validarTelefone($telefone)) {
            $erro = "Telefone inválido. Digite apenas números (10 ou 11 dígitos).";
        } else {
            $verifica = $pdo->prepare("SELECT id_barbeiro FROM barbeiros WHERE cpf = ?");
            $verifica->execute([$cpf]);

            if ($verifica->rowCount() > 0) {
                $erro = "Já existe um barbeiro com este CPF.";
            } else {
                $sql = $pdo->prepare("INSERT INTO barbeiros (nome, cpf, telefone) VALUES (?, ?, ?)");
                if ($sql->execute([$nome, $cpf, $telefone])) {
                    $sucesso = "Barbeiro cadastrado com sucesso! Redirecionando...";
                    echo '<div class="alert alert-success">' . htmlspecialchars($sucesso) . '</div>';
                    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                    require_once "../../includes/footer.php";
                    exit;
                } else {
                    $erro = "Erro ao cadastrar barbeiro.";
                }
            }
=======
        die("Ação não autorizada (CSRF inválido).");
    }

    $nome = trim($_POST["nome"]);
    $cpf = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);

    if (empty($nome) || empty($cpf) || empty($telefone)) {
        $erro = "Preencha todos os campos.";
    }
    elseif (!validarCPF($cpf)) {
        $erro = "CPF inválido. Digite um CPF com 11 dígitos válido.";
    }
    elseif (!validarTelefone($telefone)) {
        $erro = "Telefone inválido. Digite apenas números (10 ou 11 dígitos).";
    }
    else {
        
        $verifica = $pdo->prepare("SELECT id_barbeiro FROM barbeiros WHERE cpf = ?");
        $verifica->execute([$cpf]);

        if ($verifica->rowCount() > 0) {
            $erro = "Já existe um barbeiro com este CPF.";
        } else {
            
            $sql = $pdo->prepare("INSERT INTO barbeiros (nome, cpf, telefone) VALUES (?, ?, ?)");
            $sql->execute([$nome, $cpf, $telefone]);

            header("Location: index.php");
            exit;
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
        }
    }
}
?>

<h2>Cadastrar Barbeiro</h2>

<?php if ($erro): ?>
<<<<<<< HEAD
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
=======
    <div class="alert alert-danger"><?= $erro ?></div>
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" required>

    <label class="mt-2">CPF:</label>
    <input type="text" name="cpf" class="form-control" maxlength="11" required placeholder="Apenas números">

    <label class="mt-2">Telefone:</label>
    <input type="text" name="telefone" class="form-control" maxlength="11" required placeholder="Apenas números (10 ou 11 dígitos)">

    <br>
    <button class="btn btn-success mt-3">Salvar</button>
    <a href="index.php" class="btn btn-secondary mt-3">Cancelar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
