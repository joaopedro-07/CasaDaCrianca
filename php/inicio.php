<?php
include 'verificar_login.php';

// 1. Total registrado
$sqlTotal = "SELECT COUNT(*) AS total FROM tb_criancas";
$resultTotal = mysqli_query($conn, $sqlTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalRegistrado = (int) $rowTotal['total'];

// 2. Crianças ativas
$sqlAtivas = "SELECT COUNT(*) AS total FROM tb_criancas WHERE status = 'ativo'";
$resultAtivas = mysqli_query($conn, $sqlAtivas);
$rowAtivas = mysqli_fetch_assoc($resultAtivas);
$criancasAtivas = (int) $rowAtivas['total'];

// 3. Percentual
$percentual = $totalRegistrado > 0
  ? round(($criancasAtivas / $totalRegistrado) * 100)
  : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa da Criança - Painel de Controle</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/login.css">
    <script src="../js/modal_cadastro.js"></script>
</head>

<body class='body-inicio'>
  <?php include 'sidebar.php'; ?>
  <?php include 'modal_cadastro_crianca.php'; ?>
  
    <main class="main-container">
      <?php include 'header.php'; ?>

        <div class="content">
            
            <div class="welcome-row">
                <div>
                    <h1 style="font-size: 24px; font-weight: 700;">Visão Geral</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Gerencie as informações e cadastros da instituição.</p>
                </div>
                <div style="display: flex; gap: 12px;">
                    <a href="estatisticas_criancas.php" style="text-decoration: none;">
                        <button class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column">
                                <path d="M3 3v18h18"/>
                                <path d="M18 17V9"/>
                                <path d="M13 17V5"/>
                                <path d="M8 17v-3"/>
                            </svg>
                            Ver Estatísticas das Crianças
                        </button>
                    </a>

                    <button class="btn btn-primary" onclick="document.getElementById('modalOverlay').style.display='flex'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                        Adicionar Criança
                    </button>
                </div>
            </div>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>Crianças Ativas</h3>
                        <div class="value"><span><?= $criancasAtivas ?></span></div>
                        <span class="subtext"><?= $percentual ?>% do total</span>
                    </div>
                    <div class="stat-icon icon-green">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-check">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                    </div>
                </div>

                <div class="stat-card">
                <div class="stat-details">
                        <h3>Total Registrado</h3>
                        <div class="value"><span><?= $totalRegistrado ?></span></div>
                        <span class="subtext">crianças no sistema</span>
                    </div>
                <div class="stat-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-users">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                </div>
            </section>

            <div class="table-controls">
                <div class="search-box">
                    <svg class='search-icon' xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                        <circle class='search-icon' cx="11" cy="11" r="8"/>
                        <path class='search-icon' d="m21 21-4.3-4.3"/>
                    </svg>
                    <input type="text" placeholder="Buscar por nome, CPF, matrícula, mãe, bairro...">
                </div>
                <button class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <path d="M7 10l5 5 5-5"/>
                        <path d="M12 15V3"/>
                    </svg>
                    Exportar
                </button>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nome</th>
                            <th>Data de Nascimento</th>
                            <th>Data de Entrada</th>
                            <th>Tipo de Responsável</th>
                            <th>Nome do Responsável</th>
                            <th>Tel. do Responsável</th>
                        </tr>
                    </thead>
                </table>

                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-open">
                            <path d="m6 14 2-8h11a2 2 0 0 1 2 2v1"/>
                            <path d="M3 19a2 2 0 0 1 2-2h13l3-6H8"/>
                        </svg>
                    </div>
                    <h4>Nenhuma criança cadastrada ainda</h4>
                    <p>Comece adicionando uma nova criança ao sistema para visualizar a listagem e os relatórios operacionais.</p>
                    <button class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                            <path d="M5 12h14"/>
                            <path d="M12 5v14"/>
                        </svg>
                        Cadastrar primeira criança
                    </button>
                </div>
            </div>

        </div>
    </main>

</body>
</html>