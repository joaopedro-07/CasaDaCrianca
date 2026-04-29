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
    <link rel="stylesheet" href="../styles/inicio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Início - Casa da Criança</title>
</head>
<body>
    <div class="main-wrapper">
    <?php include 'sidebar.php'; ?>

    <main class="content">
        <div class="top-header">
            <a href="logout.php" onclick="return confirm('Sair do sistema?')" class="logout-icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>

        <div class="welcome-section">
            <h1>Seja bem vindo, <?php echo explode(' ', $_SESSION['admin_nome'])[0]; ?>!</h1>
        </div>

        <div class="shortcut-container">
            <a href="tabela1.php" class="shortcut-card">
                <i class="fa-solid fa-list-ul"></i>
                <span>Visualizar Tabela 1</span>
            </a>
            <a href="tabela2.php" class="shortcut-card">
                <i class="fa-solid fa-list-ul"></i>
                <span>Visualizar Tabela 2</span>
            </a>
            <a href="dashboard.php" class="shortcut-card">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Visualizar Dashboard</span>
            </a>
        </div>

        <p class="instruction-text">
            Use os menus de navegação acima para explorar as páginas do site. Visualize as duas diferentes tabelas clicando nos botões e acesse o dashboard com gráficos e filtros personalizados para você.
        </p>
    </main>
</div>
</body>
</html>