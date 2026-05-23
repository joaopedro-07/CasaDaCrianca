<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM administradores WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) { 
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_nome'] = $user['nome'];
            header("Location: php/inicio.php");
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/login.css"> <title>Login - Casa da Criança</title>
</head>
<body class="login-page">
    <div class="login-container">
        <img src="img/logoCasaDaCrianca.png" alt="Logo Casa da Criança">
        <h2>Entrar na sua conta</h2>
        
        <form action="" method="POST" class="login-form">
            <label>CPF</label>
            <input type="text" name="cpf" placeholder="Insira seu CPF" required>
            
            <label>Senha</label>
            <input type="password" name="senha" placeholder="Insira sua senha" required>
            
            <a href="php/recuperar_email.php" class="esqueceu-senha">Esqueceu a senha?</a>
            
            <button type="submit" class="btn-entrar">Entrar</button>
        </form>
    </div>
</body>
</html>