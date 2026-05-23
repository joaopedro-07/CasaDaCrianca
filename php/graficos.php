<?php

require '../conexao.php';

$sql = "
    SELECT 
        e.bairro,
        COUNT(c.id) AS total
    FROM tb_enderecos e
    INNER JOIN tb_criancas c
        ON c.endereco_id = e.id
    GROUP BY e.bairro
    ORDER BY total DESC
";

$resultado = mysqli_query($conn, $sql);

$bairros = [];
$criancas_por_bairro = [];

while ($row = mysqli_fetch_assoc($resultado)) {

    $bairro = $row['bairro'];

    $bairros[] = [
        'bairro' => $bairro,
        'total'  => (int)$row['total']
    ];

    $sqlCriancas = "
        SELECT
            c.nome,
            c.data_nasc,
            c.status
        FROM tb_criancas c
        INNER JOIN tb_enderecos e
            ON c.endereco_id = e.id
        WHERE e.bairro = ?
        ORDER BY c.nome ASC
    ";

    $stmt = mysqli_prepare($conn, $sqlCriancas);

    mysqli_stmt_bind_param($stmt, "s", $bairro);

    mysqli_stmt_execute($stmt);

    $resultCriancas = mysqli_stmt_get_result($stmt);

    $criancas = [];

    while ($crianca = mysqli_fetch_assoc($resultCriancas)) {
        $criancas[] = $crianca;
    }

    $criancas_por_bairro[$bairro] = $criancas;
}

$labels = array_column($bairros, 'bairro');

$totais = array_column($bairros, 'total');

$total_geral = array_sum($totais);

$pagina_atual = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráficos — Casa da Criança</title>
  <link rel="stylesheet" href="../styles/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .main-graficos {
      min-height: calc(100vh - 64px);
      background-color: #f8fafc;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .graficos-header h1 { font-size: 22px; font-weight: 700; color: #111827; }
    .graficos-header p  { font-size: 13px; color: #6b7280; margin-top: 2px; }

    .graficos-grid {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 20px;
      align-items: start;
    }
    @media (max-width: 900px) { .graficos-grid { grid-template-columns: 1fr; } }

    .grafico-card {
      background: #fff;
      border: 1px solid #f1f1f1;
      border-radius: 14px;
      padding: 24px;
    }
    .grafico-card__titulo { font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .grafico-card__sub    { font-size: 12px; color: #9ca3af; margin-bottom: 20px; }

    .pizza-wrapper {
      position: relative;
      width: 100%;
      max-width: 380px;
      margin: 0 auto;
      cursor: pointer;
    }

    .pizza-hint {
      text-align: center;
      font-size: 11px;
      color: #9ca3af;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
    }

    .legenda-lista { display: flex; flex-direction: column; gap: 10px; }

    .legenda-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      font-size: 13px;
      color: #374151;
      cursor: pointer;
      padding: 4px 6px;
      border-radius: 7px;
      transition: background 0.15s;
    }
    .legenda-item:hover { background: #f9fafb; }

    .legenda-item__esquerda { display: flex; align-items: center; gap: 8px; }
    .legenda-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
    .legenda-item__bairro { font-weight: 500; color: #111827; }

    .legenda-item__barra-wrap {
      flex: 1;
      height: 5px;
      background: #f3f4f6;
      border-radius: 99px;
      overflow: hidden;
      margin: 0 8px;
    }
    .legenda-item__barra { height: 100%; border-radius: 99px; transition: width 0.6s ease; }
    .legenda-item__total { font-weight: 700; color: #111827; min-width: 20px; text-align: right; }

    .resumo-card {
      background: #fff;
      border: 1px solid #f1f1f1;
      border-radius: 14px;
      padding: 20px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .resumo-card__label { font-size: 13px; color: #6b7280; font-weight: 500; }
    .resumo-card__valor { font-size: 28px; font-weight: 700; color: #111827; }

    .badge-aviso {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #fef3c7;
      color: #92400e;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
      border: 1px solid #fcd34d;
    }

    .modal-bairro-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      padding: 20px;
    }
    .modal-bairro-overlay.open { display: flex; }

    .modal-bairro {
      background: #fff;
      border-radius: 16px;
      width: 100%;
      max-width: 560px;
      max-height: 85vh;
      display: flex;
      flex-direction: column;
      box-shadow: 0 20px 50px rgba(0,0,0,0.18);
      overflow: hidden;
      animation: modalIn 0.2s ease;
    }
    @keyframes modalIn {
      from { opacity: 0; transform: translateY(12px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0)    scale(1);    }
    }

    .modal-bairro__header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 24px 16px;
      border-bottom: 1px solid #f1f1f1;
      flex-shrink: 0;
    }

    .modal-bairro__header-left { display: flex; align-items: center; gap: 10px; }

    .modal-bairro__icone {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .modal-bairro__titulo {
      font-size: 16px;
      font-weight: 700;
      color: #111827;
      line-height: 1.2;
    }
    .modal-bairro__sub {
      font-size: 12px;
      color: #9ca3af;
      margin-top: 1px;
    }

    .modal-bairro__fechar {
      background: none;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      font-size: 22px;
      line-height: 1;
      padding: 4px;
      border-radius: 6px;
      transition: background 0.15s, color 0.15s;
    }
    .modal-bairro__fechar:hover { background: #f3f4f6; color: #374151; }

    .modal-bairro__body {
      overflow-y: auto;
      padding: 16px 24px 24px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .crianca-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      border: 1px solid #f3f4f6;
      border-radius: 10px;
      transition: border-color 0.15s, box-shadow 0.15s;
    }
    .crianca-item:hover {
      border-color: #fcd34d;
      box-shadow: 0 2px 8px rgba(252,196,4,0.12);
    }

    .crianca-item__avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #fef3c7;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 14px;
      font-weight: 700;
      color: #92400e;
    }

    .crianca-item__info { flex: 1; }
    .crianca-item__nome { font-size: 13px; font-weight: 600; color: #111827; }
    .crianca-item__idade { font-size: 11px; color: #9ca3af; margin-top: 1px; }

    .crianca-item__status {
      font-size: 11px;
      font-weight: 600;
      padding: 3px 9px;
      border-radius: 20px;
    }
    .crianca-item__status--ativo   { background: #d1fae5; color: #065f46; }
    .crianca-item__status--inativo { background: #f3f4f6; color: #6b7280; }

    .modal-bairro__vazio {
      text-align: center;
      padding: 30px 0;
      color: #9ca3af;
      font-size: 13px;
    }
  </style>
</head>
<body class="body-padrao">

  <?php include 'sidebar.php'; ?>

  <div class="container-geral">

    <!-- Header -->
    <header class="header-padrao">
      <div class="div-search">
        <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
        </svg>
        <input class="input-search" type="text" placeholder="Pesquisar...">
      </div>
      <div class="lado-direito-header">
        <div class="notificacao-container">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
          <span class="ponto-notificacao"></span>
        </div>
        <div class="linha-vertical-header"></div>
        <div class="perfil-header">
          <div class="avatar-circulo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#92400e"
              stroke-width="2" viewBox="0 0 24 24">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <div class="info-admin">
            <span class="nome-admin">Administrador</span>
            <span class="cargo-admin">Gestor</span>
          </div>
        </div>
      </div>
    </header>

    <!-- Conteúdo -->
    <main class="main-graficos">

      <div class="graficos-header">
        <h1>Gráficos</h1>
        <p>Visualize a distribuição geográfica das crianças cadastradas</p>
      </div>

      <div class="resumo-card">
        <div>
          <p class="resumo-card__label">Total de crianças cadastradas</p>
          <p class="resumo-card__valor"><?= $total_geral ?></p>
        </div>
        <span class="badge-aviso">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
          </svg>
          Dados de teste
        </span>
      </div>

      <div class="graficos-grid">

        <div class="grafico-card">
          <p class="grafico-card__titulo">Distribuição por bairro</p>
          <p class="grafico-card__sub">Crianças cadastradas em Caçapava — SP</p>
          <div class="pizza-wrapper">
            <canvas id="graficoPizza"></canvas>
          </div>
          <p class="pizza-hint">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
            </svg>
            Clique em uma fatia para ver as crianças do bairro
          </p>
        </div>

        <div class="grafico-card">
          <p class="grafico-card__titulo">Detalhamento</p>
          <p class="grafico-card__sub">Clique em um bairro para ver as crianças</p>
          <div class="legenda-lista" id="legendaLista"></div>
        </div>

      </div>
    </main>
  </div>

  <!-- ════ Modal crianças por bairro ════ -->
  <div class="modal-bairro-overlay" id="modalBairroOverlay"
       onclick="if(event.target===this) fecharModalBairro()">
    <div class="modal-bairro">

      <div class="modal-bairro__header">
        <div class="modal-bairro__header-left">
          <div class="modal-bairro__icone" id="modalIcone">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <div>
            <p class="modal-bairro__titulo" id="modalTitulo">—</p>
            <p class="modal-bairro__sub"    id="modalSub">—</p>
          </div>
        </div>
        <button class="modal-bairro__fechar" onclick="fecharModalBairro()">×</button>
      </div>

      <div class="modal-bairro__body" id="modalBody"></div>

    </div>
  </div>

  <script>
    // ── Dados do PHP ──
    const labels  = <?= json_encode($labels) ?>;
    const totais  = <?= json_encode($totais) ?>;
    const total   = <?= $total_geral ?>;
    const dados   = <?= json_encode($criancas_por_bairro) ?>;

    const cores = [
      '#FCC404','#F59E0B','#FBBF24','#FDE68A',
      '#92400E','#78350F','#D97706','#B45309',
    ];

    // ── Gráfico ──
    const ctx = document.getElementById('graficoPizza').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data: totais,
          backgroundColor: cores,
          borderWidth: 2,
          borderColor: '#fff',
          hoverOffset: 10,
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (c) => {
                const pct = ((c.parsed / total) * 100).toFixed(1);
                return ` ${c.parsed} criança(s) — ${pct}%`;
              }
            }
          }
        },
        onClick(event, elements) {
          if (!elements.length) return;
          const idx = elements[0].index;
          abrirModalBairro(idx);
        }
      }
    });

    // ── Legenda ──
    const lista = document.getElementById('legendaLista');
    labels.forEach((bairro, i) => {
      const pct = ((totais[i] / total) * 100).toFixed(1);
      const item = document.createElement('div');
      item.className = 'legenda-item';
      item.title = `Ver crianças de ${bairro}`;
      item.innerHTML = `
        <div class="legenda-item__esquerda">
          <span class="legenda-dot" style="background:${cores[i % cores.length]}"></span>
          <span class="legenda-item__bairro">${bairro}</span>
        </div>
        <div class="legenda-item__barra-wrap">
          <div class="legenda-item__barra"
               style="width:${pct}%; background:${cores[i % cores.length]}">
          </div>
        </div>
        <span class="legenda-item__total">${totais[i]}</span>`;
      item.addEventListener('click', () => abrirModalBairro(i));
      lista.appendChild(item);
    });

    // ── Helpers ──
    function calcularIdade(dataNasc) {
      const nasc = new Date(dataNasc);
      const hoje = new Date();
      let anos = hoje.getFullYear() - nasc.getFullYear();
      const m = hoje.getMonth() - nasc.getMonth();
      if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) anos--;
      return anos;
    }

    function iniciais(nome) {
      return nome.trim().split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(p => p[0].toUpperCase())
        .join('');
    }

    // ── Modal ──
    function abrirModalBairro(idx) {
      const bairro   = labels[idx];
      const cor      = cores[idx % cores.length];
      const criancas = dados[bairro] || [];

      // Header
      document.getElementById('modalTitulo').textContent = bairro;
      document.getElementById('modalSub').textContent =
        `${criancas.length} criança${criancas.length !== 1 ? 's' : ''} cadastrada${criancas.length !== 1 ? 's' : ''}`;
      document.getElementById('modalIcone').style.background = cor + '22';
      document.getElementById('modalIcone').querySelector('svg').style.stroke = cor;

      // Body
      const body = document.getElementById('modalBody');
      if (!criancas.length) {
        body.innerHTML = `<div class="modal-bairro__vazio">Nenhuma criança encontrada neste bairro.</div>`;
      } else {
        body.innerHTML = criancas.map(c => {
          const idade = calcularIdade(c.data_nasc);
          const statusClass = c.status === 'ativo'
            ? 'crianca-item__status--ativo'
            : 'crianca-item__status--inativo';
          return `
            <div class="crianca-item">
              <div class="crianca-item__avatar" style="background:${cor}22; color:${cor}">
                ${iniciais(c.nome)}
              </div>
              <div class="crianca-item__info">
                <p class="crianca-item__nome">${c.nome}</p>
                <p class="crianca-item__idade">${idade} ano${idade !== 1 ? 's' : ''}</p>
              </div>
              <span class="crianca-item__status ${statusClass}">${c.status}</span>
            </div>`;
        }).join('');
      }

      document.getElementById('modalBairroOverlay').classList.add('open');
    }

    function fecharModalBairro() {
      document.getElementById('modalBairroOverlay').classList.remove('open');
    }

    // Fecha com ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') fecharModalBairro();
    });
  </script>

</body>
</html>