<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}
require_once '../conexao.php';

// IMPEDIR CACHE (Coloque isso em todas as páginas do diretório /php)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Tabela 2 - Casa da Criança</title>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="content">
            <h1>Tabela 2</h1>
            <p>Gerenciamento de dados da Tabela 2.</p>
            <div style="padding: 20px; background: white; border-radius: 8px; margin-top: 20px;">
                <p>Área reservada para o conteúdo da segunda tabela.</p>
            </div>
        </main>
    </div>
</body>
</html>