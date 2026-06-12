<?php
include 'verificar_login.php';

// Dados do administrador logado para pré-preencher o formulário
$sql = "SELECT nome, email FROM administradores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_logado);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/suporte.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Suporte - Casa da Criança</title>
</head>

<body class="body-padrao">
    <?php include 'sidebar.php'; ?>

    <div class="container-geral">
        <?php include 'header.php'; ?>

        <main class="main-suporte">
            <div class="suporte-grid">

                <!-- Coluna informativa -->
                <aside class="suporte-info">
                    <div class="suporte-info-icone"><i class="fa-solid fa-headset"></i></div>
                    <h2>Precisa de ajuda?</h2>
                    <p>Nossa equipe está pronta para te atender. Preencha o formulário e responderemos o mais rápido possível.</p>

                    <ul class="suporte-lista">
                        <li><i class="fa-solid fa-clock"></i> Resposta em até 24h úteis</li>
                        <li><i class="fa-solid fa-envelope"></i> Retorno por e-mail</li>
                        <li><i class="fa-solid fa-shield-halved"></i> Atendimento seguro</li>
                    </ul>
                </aside>

                <!-- Formulário -->
                <div class="suporte-card">
                    <h1 class="suporte-titulo">Suporte Técnico</h1>
                    <p class="suporte-subtitulo">Entre em contato com nossa equipe</p>

                    <form id="form-suporte" class="suporte-form" action="processa-email.php" method="POST">
                        <div class="suporte-campo">
                            <label>Seu Nome</label>
                            <input name="nome" type="text" placeholder="Digite seu nome"
                                value="<?php echo htmlspecialchars($admin['nome'] ?? ''); ?>" required>
                        </div>

                        <div class="suporte-campo">
                            <label>Seu E-mail</label>
                            <input name="email" type="email" placeholder="Digite seu e-mail para contato"
                                value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>" required>
                        </div>

                        <div class="suporte-campo">
                            <label>Assunto <span class="campo-opcional">(opcional)</span></label>
                            <input name="assunto" type="text" placeholder="Assunto da dúvida ou problema">
                        </div>

                        <div class="suporte-campo">
                            <label>Sua Dúvida / Problema</label>
                            <textarea name="mensagem" placeholder="Descreva seu problema ou dúvida" required></textarea>
                        </div>

                        <!-- Honeypot anti-spam -->
                        <input type="text" name="sobrenome_real" class="campo-honeypot" tabindex="-1" autocomplete="off">

                        <button type="submit" class="btn-suporte">
                            <i class="fa-solid fa-paper-plane"></i> Enviar Mensagem
                        </button>
                        <p class="suporte-rodape">Nossa equipe responderá em breve</p>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script src="../js/suporte.js" defer></script>
</body>

</html>
