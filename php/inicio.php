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
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Início - Casa da Criança</title>
</head>
<body class="body-padrao">
    <?php include 'sidebar.php'; ?>
    <div class="container-geral">
        <header>
            <?php include 'header.php'; ?>  
        </header>
        <main>
            
        </main>
    </div>
</body>
</html>