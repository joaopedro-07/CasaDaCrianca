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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body class='body-inicio'>
  <?php include 'sidebar.php'; ?>
  
    <main class="main-container">
      <?php include 'header.php'; ?>

        <div class="content">
            
            <div class="welcome-row">
                <div>
                    <h1 style="font-size: 24px; font-weight: 700;">Visão Geral</h1>
                    <p style="color: var(--text-muted); font-size: 14px;">Gerencie as informações e cadastros da instituição.</p>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button class="btn btn-secondary">
                        <i class="fa-solid fa-chart-simple"></i> Ver Estatísticas das Crianças
                    </button>
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Adicionar Criança
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
                        <i class="fa-solid fa-children"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-details">
                        <h3>Faixa Etária</h3>
                        <div class="value">3–15</div>
                        <span class="subtext">anos de idade atendidos</span>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>
                </div>
            </section>

            <div class="table-controls">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Buscar por nome, CPF, matrícula, mãe, bairro...">
                </div>
                <button class="btn btn-secondary">
                    <i class="fa-solid fa-download"></i> Exportar
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
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h4>Nenhuma criança cadastrada ainda</h4>
                    <p>Comece adicionando uma nova criança ao sistema para visualizar a listagem e os relatórios operacionais.</p>
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Cadastrar primeira criança
                    </button>
                </div>
            </div>

        </div>
    </main>

</body>
</html>