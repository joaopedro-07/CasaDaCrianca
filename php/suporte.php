<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
$id_logado = $_SESSION['admin_id'];
require_once '../conexao.php';

// IMPEDIR CACHE (Coloque isso em todas as páginas do diretório /php)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$sql = "SELECT id, nome FROM administradores WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_logado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $linha = mysqli_fetch_assoc($resultado);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Suporte - Casa da Criança</title>
</head>
<body class="body-padrao">
    <?php include 'sidebar.php'; ?>
    <div class="container-geral">
        <header class="header-padrao">
            <div class="div-search">
                <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input class="input-search" type="text" placeholder="Pesquisar criança...">
            </div>
            <div class="lado-direito-header">
                <div class="notificacao-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="ponto-notificacao"></span>
                </div>

                <div class="linha-vertical-header"></div>

                <div class="perfil-header">
                    <div class="avatar-circulo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FCC404" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="info-admin">
                        <span class="nome-admin">
                            <?php echo $linha ? $linha['nome'] : 'Admin'; ?>
                        </span>
                        <span class="cargo-admin">Gerenciador</span>
                    </div>
                </div>
            </div>
        </header>
        <main class="main-formulario">
            <div class="div-formulario">
                <h1 class="titulo-sup">Suporte Técnico</h1>
                <p class="subtitulo-sup">Entre em contato com nossa equipe</p>
                    <form id="form-sup" class="form-suporte" action="processa-email.php" method="POST">
                        <label class="label-form-sup" for="">Seu Nome</label>
                        <input name="nome" type="text" placeholder="Digite seu nome" required>
                        <label class="label-form-sup" for="">Seu E-mail</label>
                        <input name="email" type="email" placeholder="Digite seu e-mail para entrarmos em contato" required>
                        <label class="label-form-sup" for="">Assunto(opcional)</label>
                        <input name="assunto" type="text" placeholder="Digite o assunto da dúvida/problema">
                        <label class="label-form-sup" for="">Sua Dúvida/Problema</label>
                        <textarea name="mensagem" id="" placeholder="Descreva seu problema ou dúvida"></textarea>
                        <input type="text" name="sobrenome_real" style="display:none !important" tabindex="-1" autocomplete="off">
                        <input type="submit" value="Enviar Mensagem">
                        <p class="texto-rodape">Nossa equipe responderá em breve</p>
                    </form>
                    <script>
                        document.getElementById('form-sup').addEventListener('submit', function(e) {
                            e.preventDefault();

                            Swal.fire({
                                title: 'Enviando...',
                                text: 'Por favor, aguarde.',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading() }
                            });

                            const formData = new FormData(this);

                            fetch('processa-email.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                if (data.includes('sucesso')) {
                                    Swal.fire('Sucesso!', 'Sua mensagem foi enviada.', 'success');
                                    this.reset();
                                } else {
                                    Swal.fire('Erro!', 'Ocorreu um problema ao enviar.', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Erro!', 'Não foi possível conectar ao servidor.', 'error');
                            });
                        });
                    </script>
            </div>
        </main>
    </div>
</body>
</html>