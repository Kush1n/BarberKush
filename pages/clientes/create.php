<?php 
require_once "../../includes/db.php"; 
require_once "../../includes/header.php"; 
require_once "../../includes/token.php"; 
<<<<<<< HEAD
=======
require_once "../../includes/auth.php"; 
require_login();
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4

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
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!check_csrf($_POST['csrf'])) {
        $erro = "Ação não autorizada (CSRF inválido).";
    } else {
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $email = trim($_POST['email']);

<<<<<<< HEAD
        if (!validarCPF($cpf)) {
            $erro = "CPF inválido. Digite um CPF com 11 dígitos válido.";
        } 
        elseif (empty($telefone) && empty($email)) {
            $erro = "Preencha pelo menos um contato: telefone ou e-mail.";
        } 
=======
        // Validação CPF
        if (!validarCPF($cpf)) {
            $erro = "CPF inválido. Digite um CPF com 11 dígitos válido.";
        } 
        // Verifica se pelo menos telefone ou email está preenchido
        elseif (empty($telefone) && empty($email)) {
            $erro = "Preencha pelo menos um contato: telefone ou e-mail.";
        } 
        // Valida telefone se preenchido
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
        elseif (!empty($telefone) && !validarTelefone($telefone)) {
            $erro = "Telefone inválido. Digite apenas números (10 ou 11 dígitos).";
        } 
        else {
<<<<<<< HEAD
=======
            // Verifica CPF duplicado
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
            $stmt = $pdo->prepare("SELECT id_cliente FROM clientes WHERE cpf = ?");
            $stmt->execute([$cpf]);

            if ($stmt->rowCount() > 0) {
                $erro = "Este CPF já está cadastrado.";
            } else {
<<<<<<< HEAD
=======
                // Insere cliente
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
                $sql = $pdo->prepare("
                    INSERT INTO clientes (nome, cpf, telefone, email)
                    VALUES (?, ?, ?, ?)
                ");
<<<<<<< HEAD
                if ($sql->execute([$nome, $cpf, $telefone, $email])) {
                    $sucesso = "Cliente cadastrado com sucesso! Redirecionando...";
                    echo '<div class="alert alert-success">' . htmlspecialchars($sucesso) . '</div>';
                    echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
                    require_once "../../includes/footer.php";
                    exit;
                } else {
                    $erro = "Erro ao cadastrar cliente.";
                }
=======
                $sql->execute([$nome, $cpf, $telefone, $email]);
                $sucesso = "Cliente cadastrado com sucesso!";
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
            }
        }
    }
}
?>

<h2>Novo Cliente</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<<<<<<< HEAD
=======
<?php if ($sucesso): ?>
    <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
    <a href="index.php" class="btn btn-success mt-3">Voltar para lista de clientes</a>
<?php endif; ?>

>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
<form method="POST">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" required>

    <label class="mt-2">CPF:</label>
    <input type="text" name="cpf" class="form-control" maxlength="11" required placeholder="Apenas números">

    <label class="mt-2">Telefone:</label>
    <input type="text" name="telefone" class="form-control" maxlength="11" placeholder="Apenas números (10 ou 11 dígitos)">

    <label class="mt-2">Email:</label>
    <input type="email" name="email" class="form-control" placeholder="Preencha se não preencher telefone">

<<<<<<< HEAD
    <button type="submit" class="btn btn-success mt-3">Salvar</button>
=======
    <button class="btn btn-success mt-3">Salvar</button>
>>>>>>> 7ce0ecb848a22d768f1366395108cce54cd029c4
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>

<?php require_once "../../includes/footer.php"; ?>
