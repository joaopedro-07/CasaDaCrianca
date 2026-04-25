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
    <title>Tabela 1 - Casa da Criança</title>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="content">
            <h1>Tabela 1</h1>
            <p>Gerenciamento de dados da Tabela 1.</p>
            
            <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                <tr style="background: #eee;">
                    <th style="padding: 10px;">ID</th>
                    <th>Informação</th>
                    <th>Ações</th>
                </tr>
                <tr>
                    <td style="padding: 10px; text-align: center;">-</td>
                    <td style="text-align: center;">Nenhum dado cadastrado</td>
                    <td style="text-align: center;">-</td>
                </tr>
            </table>
        </main>
    </div>
</body>
</html>