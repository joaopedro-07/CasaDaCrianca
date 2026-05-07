<?php
include 'verificar_login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // CRIPTOGRAFIA AQUI

    $sql = "INSERT INTO administradores (nome, email, cpf, genero, telefone, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $email, $cpf, $genero, $telefone, $senha);
    
    if($stmt->execute()) {
        header("Location: perfil.php?sucesso=1");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Cadastrar ADM</title>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'sidebar.php'; ?>
        <main class="content">
            <h2>Cadastrar Novo Administrador</h2>
            <form method="POST" style="max-width: 400px; margin-top: 20px;">
                <input type="text" name="nome" placeholder="Nome Completo" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                <input type="email" name="email" placeholder="E-mail" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                <input type="text" name="cpf" placeholder="CPF" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                <select name="genero" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
                <input type="text" name="telefone" placeholder="Telefone" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                <input type="password" name="senha" placeholder="Senha" required style="width: 100%; margin-bottom: 10px; padding: 8px;">
                <button type="submit" style="background: blue; color: white; padding: 10px 20px; border: none; cursor: pointer;">Salvar</button>
            </form>
        </main>
    </div>
</body>
</html>