<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/recuperar.css">
    <title>Recuperar Senha</title>
</head>
    <body class="recuperar-page">
        <div class="recuperar-container">
            <a href="../index.php" class="btn-voltar"> ← Voltar</a>
            <img src="../img/logo-casa-da-crianca.png">
            <h2>Redefinir senha</h2>
            <form action="redefinir_senha.php" method="GET" class="recuperar-form">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="Digite o seu e-mail" required>
                <p class="instrucao">Digite o seu e-mail para redefinir sua senha.</p>
                <button type="submit" class="btn-enviar">Enviar</button>
            </form>
        </div>
    </body>
</html>