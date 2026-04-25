<?php
require_once '../conexao.php';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $confirmar = $_POST['confirmar_senha'];
    $email_post = $_POST['email'];

    if ($nova_senha === $confirmar) {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql = "UPDATE administradores SET senha = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hash, $email_post);
        $stmt->execute();
        header("Location: ../index.php?msg=Senha alterada!");
    } else {
        echo "Senhas não conferem!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/recuperar.css">
    <title>Nova Senha</title>
</head>
    <body class="recuperar-page">
        <div class="recuperar-container">
            <a href="recuperar_email.php" class="btn-voltar"> ← Voltar</a>
            <img src="../img/logo-casa-da-crianca.png">
            <h2>Nova senha</h2>
            <form method="POST" class="recuperar-form">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <label>Nova senha</label>
                <input type="password" name="nova_senha" placeholder="Digite sua nova senha" required>
                <label style="margin-top:10px;">Confirmar nova senha</label>
                <input type="password" name="confirmar_senha" placeholder="Digite novamente a nova senha" required>
                <button type="submit" class="btn-enviar">Confirmar</button>
            </form>
        </div>
    </body>
</html>