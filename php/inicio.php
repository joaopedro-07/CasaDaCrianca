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
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../styles/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="../styles/tabela_criancas.css">
  <script src="../js/script.js" defer></script>
  <title>Início - Casa da Criança</title>
</head>

<body class="body-padrao">
  <?php include 'sidebar.php'; ?>
  <div class="container-geral">
    <?php include 'header.php'; ?>
    <?php include 'modal_cadastro_crianca.php' ?>

    <main class="main-inicio">

      <section class="stats-grid">
        <div class="stat-card">
          <div class="stat-card__body">
            <span class="stat-card__label">Total Registrado</span>
            <span class="stat-card__value"><?= $totalRegistrado ?></span>
            <span class="stat-card__sub">crianças no sistema</span>
          </div>
          <div class="stat-card__icon stat-card__icon--amber">
            <span class="iconify" data-icon="lucide:users" data-width="22" data-height="22"></span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-card__body">
            <span class="stat-card__label">Crianças Ativas</span>
            <span class="stat-card__value"><?= $criancasAtivas ?></span>
            <span class="stat-card__sub"><?= $percentual ?>% do total</span>
          </div>
          <div class="stat-card__icon stat-card__icon--green">
            <span class="iconify" data-icon="lucide:activity" data-width="22" data-height="22"></span>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-card__body">
            <span class="stat-card__label">Faixa Etária</span>
            <span class="stat-card__value">3–15</span>
            <span class="stat-card__sub">anos</span>
          </div>
          <div class="stat-card__icon stat-card__icon--blue">
            <span class="iconify" data-icon="lucide:bar-chart-2" data-width="22" data-height="22"></span>
          </div>
        </div>
      </section>

      <section class="actions-bar">
        <a href="renda_beneficios.php" class="button-ver-renda-beneficios">Ver Renda e Benefícios</a>
        <button class="btn-novo" onclick="document.getElementById('overlay').classList.add('open')">+ Adicionar Criança</button>
      </section>

      <section class="lista-criancas">
        <?php include 'tabela_criancas.php'; ?>
      </section>
    </main>
  </div>
  <script>
    document.querySelectorAll('.tc-row-clicavel').forEach(row => {
      row.addEventListener('click', function() {
        console.log("1. Linha clicada!");
        const id = this.getAttribute('data-id');
        console.log("2. ID capturado:", id);
        abrirMeuModal(id);
      });
    });

    function abrirMeuModal(id) {
  const modal = document.getElementById('modalCrianca');
  console.log("3. Elemento modal encontrado:", modal);

  if (modal) {
    // EM VEZ DE: modal.style.display = 'block';
    // USE ISSO:
    modal.classList.add('open'); 
    
    // Opcional: travar o scroll do fundo
    document.body.style.overflow = 'hidden'; 
    
    console.log("4. Classe 'open' adicionada com sucesso.");
  }
}

    function fecharModal() {
      document.getElementById('modalCrianca').classList.remove('open');
      document.body.style.overflow = '';
      cancelarEdicao();
    }

    function ativarEdicao() {
      document.getElementById('modalContent').classList.add('modo-edicao');
      document.getElementById('modalBody').scrollTop = 0;
    }

    function cancelarEdicao() {
      document.getElementById('modalContent').classList.remove('modo-edicao');
    }

    function confirmarSalvar() {
      showSwal({
        type: 'warning',
        title: 'Confirmar alterações?',
        text: 'Todas as informações da ficha serão atualizadas. Deseja continuar?',
        btns: [{
            label: 'Cancelar',
            style: 'cancel',
            action: closeSwal
          },
          {
            label: 'Sim, salvar',
            style: 'confirm',
            action: salvarDados
          }
        ]
      });
    }

    function salvarDados() {
      closeSwal();
      const nome = document.getElementById('e_nome').value;
      document.getElementById('v_nome').textContent = nome;
      document.getElementById('nomeHeader').textContent = nome;
      const iniciais = nome.split(' ').slice(0, 2).map(p => p[0]).join('').toUpperCase();
      document.getElementById('avatarInicial').textContent = iniciais;

      document.getElementById('v_cpf').textContent = document.getElementById('e_cpf').value;
      document.getElementById('v_nis').textContent = document.getElementById('e_nis').value;
      document.getElementById('v_cidade_nasc').textContent = document.getElementById('e_cidade_nasc').value;
      document.getElementById('v_mae').textContent = document.getElementById('e_mae').value;
      document.getElementById('v_tel_mae').textContent = document.getElementById('e_tel_mae').value;
      document.getElementById('v_pai').textContent = document.getElementById('e_pai').value;
      document.getElementById('v_tel_pai').textContent = document.getElementById('e_tel_pai').value;
      document.getElementById('v_resp').textContent = document.getElementById('e_resp').value + ' — ' + document.getElementById('e_tel_mae').value;
      document.getElementById('v_cep').textContent = document.getElementById('e_cep').value;
      document.getElementById('v_logr').textContent = document.getElementById('e_logr').value;
      document.getElementById('v_num').textContent = document.getElementById('e_num').value;
      document.getElementById('v_bairro').textContent = document.getElementById('e_bairro').value;
      document.getElementById('v_cidade').textContent = document.getElementById('e_cidade').value;
      document.getElementById('v_uf').textContent = document.getElementById('e_uf').value;
      const comp = document.getElementById('e_comp').value;
      const vComp = document.getElementById('v_comp');
      vComp.textContent = comp || '—';
      vComp.className = 'tc-field-view tc-info-value' + (comp ? '' : ' muted');
      const renda = parseFloat(document.getElementById('e_renda').value) || 0;
      document.getElementById('v_renda').textContent = renda.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
      });
      document.getElementById('v_cadunico').textContent = document.getElementById('e_cadunico').value;
      document.getElementById('v_beneficio').textContent = document.getElementById('e_beneficio').value;
      document.getElementById('v_risco').textContent = document.getElementById('e_risco').value;

      const dataN = document.getElementById('e_nasc').value;
      if (dataN) document.getElementById('v_nasc').textContent = dataN.split('-').reverse().join('/');
      const dataE = document.getElementById('e_entrada').value;
      if (dataE) document.getElementById('v_entrada').textContent = dataE.split('-').reverse().join('/');

      cancelarEdicao();

      setTimeout(() => {
        showSwal({
          type: 'success',
          title: 'Salvo com sucesso!',
          text: 'As informações da criança foram atualizadas com sucesso.',
          btns: [{
            label: 'Ok, fechar',
            style: 'confirm green',
            action: closeSwal
          }]
        });
      }, 120);
    }

    function showSwal({
      type,
      title,
      text,
      btns
    }) {
      const iconEl = document.getElementById('swalIcon');
      const svgEl = document.getElementById('swalSvg');
      iconEl.className = 'swal-icon ' + type;
      if (type === 'warning') {
        svgEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
      } else {
        svgEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
      }
      document.getElementById('swalTitle').textContent = title;
      document.getElementById('swalText').textContent = text;
      const btnsEl = document.getElementById('swalBtns');
      btnsEl.innerHTML = '';
      btns.forEach(b => {
        const btn = document.createElement('button');
        btn.textContent = b.label;
        btn.className = b.style === 'cancel' ? 'swal-btn-cancel' : 'swal-btn-confirm ' + (b.style === 'confirm green' ? 'green' : '');
        btn.onclick = b.action;
        btnsEl.appendChild(btn);
      });
      document.getElementById('swalOverlay').classList.add('open');
    }

    function closeSwal() {
      document.getElementById('swalOverlay').classList.remove('open');
    }

    document.getElementById('modalCrianca').addEventListener('click', function(e) {
      if (e.target === this) fecharModal();
    });
    document.getElementById('swalOverlay').addEventListener('click', function(e) {
      if (e.target === this) closeSwal();
    });
  </script>
</body>

</html>