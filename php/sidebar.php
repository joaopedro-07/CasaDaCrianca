<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <div class="logo">
        <img src="../img/logo-casa-da-crianca.png" alt="Logo" width="120">
    </div>
    
    <nav>
        <a href="inicio.php" class="<?php echo ($pagina_atual == 'inicio.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i> Início
        </a>
        <a href="tabela1.php" class="<?php echo ($pagina_atual == 'tabela1.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-list-check"></i> Tabela 1
        </a>
        <a href="tabela2.php" class="<?php echo ($pagina_atual == 'tabela2.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-list-check"></i> Tabela 2
        </a>
        <a href="perfil.php" class="<?php echo ($pagina_atual == 'perfil.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-user"></i> Perfil
        </a>
    </nav>

    <div class="sidebar-footer">
        2026 © Casa da Criança
    </div>
</div>