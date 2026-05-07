<?php
include 'verificar_login.php';

/* =========================================================
   INDICADORES DO TOPO
   ========================================================= */

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
  <script src="../js/tabela_criancas.js" defer></script>
  <script src="../js/script.js" defer></script>
  <title>Início - Casa da Criança</title>
</head>

<body class="body-padrao">
  <?php include 'sidebar.php'; ?>
  <div class="container-geral">
    <?php include 'header.php'; ?>

    <main class="main-inicio">

      <!-- ============ TOPO: 3 CARDS ============ -->
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

      <!-- ============ BOTÕES ALINHADOS À DIREITA ============ -->
      <section class="actions-bar">
        <a href="renda_beneficios.php" class="button-ver-renda-beneficios">Ver Renda e Benefícios</a>
        <button class="btn-novo" onclick="document.getElementById('overlay').classList.add('open')">+ Adicionar Criança</button>
      </section>

      <!-- ============ TABELA FULL-WIDTH ============ -->
      <section class="lista-criancas">
        <?php include 'tabela_criancas.php'; ?>
      </section>

      <!-- ============ MODAL DE CADASTRO (inalterado) ============ -->
      <form action="processa-cadastro-crianca.php" method="POST">
        <div class="overlay" id="overlay">
          <div class="modal">
            <div class="modal-header">
              <div class="modal-header-left">
                <div class="modal-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <line x1="19" y1="8" x2="19" y2="14" />
                    <line x1="22" y1="11" x2="16" y2="11" />
                  </svg>
                </div>
                <div>
                  <h2>Cadastrar usuário</h2>
                  <p class="modal-header-sub">Preencha todos os campos obrigatórios</p>
                </div>
              </div>
              <button type="button" class="btn-fechar" onclick="document.getElementById('overlay').classList.remove('open')">×</button>
            </div>

            <div class="form-body">
              <div class="steps-bar">
                <button type="button" class="step-tab active" onclick="goStep(0)">1 · Identificação</button>
                <button type="button" class="step-tab" onclick="goStep(1)">2 · Responsáveis</button>
                <button type="button" class="step-tab" onclick="goStep(2)">3 · Endereço</button>
                <button type="button" class="step-tab" onclick="goStep(3)">4 · Socioeconômico</button>
              </div>

              <!-- Step 1 -->
              <div class="form-section active" id="step-0">
                <div class="container-titulo-modal"><p class="section-title">Identificação da criança</p></div>
                <div class="form-row">
                  <div class="form-field">
                    <label class="label-form-cadastro">Nº Matrícula</label>
                    <input name="matricula" class="input-form-cadastro" type="number" placeholder="Ex: 100023" required>
                  </div>
                  <div class="form-field">
                    <label class="label-form-cadastro">NIS</label>
                    <input name="nis" class="input-form-cadastro" type="text" placeholder="Número de Identificação Social" required>
                  </div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field">
                    <label class="label-form-cadastro">Nome da criança</label>
                    <input name="nome-crianca" class="input-form-cadastro" type="text" placeholder="Nome completo" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-field">
                    <label class="label-form-cadastro">CPF da criança</label>
                    <input name="cpf-crianca" class="input-form-cadastro" type="text" placeholder="000.000.000-00" required>
                  </div>
                  <div class="form-field">
                    <label class="label-form-cadastro">Data de nascimento</label>
                    <input name="data-nasc-crianca" class="input-form-cadastro" type="date" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-field">
                    <label class="label-form-cadastro">Cidade de nascimento</label>
                    <input name="cidade-nasc-crianca" class="input-form-cadastro" type="text" placeholder="Município" required>
                  </div>
                  <div class="form-field">
                    <label class="label-form-cadastro">Data de entrada</label>
                    <input name="data-entrada-crianca" class="input-form-cadastro" type="date" required>
                  </div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field">
                    <label class="label-form-cadastro">Status</label>
                    <select name="status" class="input-form-cadastro">
                      <option value="pendente">Selecione uma opção</option>
                      <option value="ativo">Ativo</option>
                      <option value="inativo">Inativo</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Step 2 -->
              <div class="form-section" id="step-1">
                <div class="container-titulo-modal"><p class="section-title">Vínculo de responsabilidade</p></div>
                <div class="form-row col-1">
                  <div class="form-field">
                    <label class="label-form-cadastro">Responsável legal</label>
                    <select name="tipo_responsavel" id="tipo_responsavel" class="input-form-cadastro" required onchange="toggleResponsavel()">
                      <option value="" disabled selected>Selecione uma opção</option>
                      <option value="mae">Mãe</option>
                      <option value="pai">Pai</option>
                      <option value="outro">Outro responsável legal</option>
                    </select>
                  </div>
                </div>

                <div class="container-titulo-modal"><p class="section-title">Identificação da mãe</p></div>
                <div class="form-row">
                  <div class="form-field"><label class="label-form-cadastro">Nome da mãe</label>
                    <input name="nome-mae" id="nome-mae" class="input-form-cadastro" type="text" placeholder="Nome completo" required></div>
                  <div class="form-field"><label class="label-form-cadastro">CPF da mãe</label>
                    <input name="cpf-mae" id="cpf-mae" class="input-form-cadastro" type="text" placeholder="000.000.000-00" required></div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field"><label class="label-form-cadastro">Telefone da mãe</label>
                    <input name="tel-mae" id="tel-mae" class="input-form-cadastro" type="tel" placeholder="(00) 00000-0000"></div>
                </div>

                <div class="container-titulo-modal"><p class="section-title">Identificação do pai</p></div>
                <div class="form-row">
                  <div class="form-field"><label class="label-form-cadastro">Nome do pai</label>
                    <input name="nome-pai" id="nome-pai" class="input-form-cadastro" type="text" placeholder="Nome completo" required></div>
                  <div class="form-field"><label class="label-form-cadastro">CPF do pai</label>
                    <input name="cpf-pai" id="cpf-pai" class="input-form-cadastro" type="text" placeholder="000.000.000-00" required></div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field"><label class="label-form-cadastro">Telefone do pai</label>
                    <input name="tel-pai" id="tel-pai" class="input-form-cadastro" type="tel" placeholder="(00) 00000-0000"></div>
                </div>

                <div id="secao-responsavel-extra" class="secao-responsavel-extra">
                  <div class="container-titulo-modal">
                    <p class="section-title" style="margin-top: 0;"><span class="badge-outro">Outro</span> Dados do responsável legal</p>
                  </div>
                  <div class="form-row">
                    <div class="form-field"><label class="label-form-cadastro">Nome do responsável</label>
                      <input name="nome-responsavel" id="nome-responsavel" class="input-form-cadastro" type="text" placeholder="Nome completo"></div>
                    <div class="form-field"><label class="label-form-cadastro">CPF do responsável</label>
                      <input name="cpf-responsavel" id="cpf-responsavel" class="input-form-cadastro" type="text" placeholder="000.000.000-00"></div>
                  </div>
                  <div class="form-row">
                    <div class="form-field"><label class="label-form-cadastro">Telefone do responsável</label>
                      <input name="tel-responsavel" id="tel-responsavel" class="input-form-cadastro" type="tel" placeholder="(00) 00000-0000"></div>
                    <div class="form-field"><label class="label-form-cadastro">Grau de Parentesco</label>
                      <input name="grau-parentesco-responsavel" id="grau-parentesco-responsavel" class="input-form-cadastro" type="text" placeholder="Digite o grau de parentesco do responsável"></div>
                  </div>
                </div>
              </div>

              <!-- Step 3 -->
              <div class="form-section" id="step-2">
                <div class="container-titulo-modal"><p class="section-title">Endereço residencial</p></div>
                <div class="form-row">
                  <div class="form-field"><label class="label-form-cadastro">CEP</label>
                    <input name="cep" class="input-form-cadastro" type="text" placeholder="00000-000" required></div>
                  <div class="form-field"><label class="label-form-cadastro">Número</label>
                    <input name="numero" class="input-form-cadastro" type="text" placeholder="Nº" required></div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field"><label class="label-form-cadastro">Rua / Logradouro</label>
                    <input name="logradouro" class="input-form-cadastro" type="text" placeholder="Nome da rua, avenida..." required></div>
                </div>
                <div class="form-row col-3">
                  <div class="form-field"><label class="label-form-cadastro">Bairro</label>
                    <input name="bairro" class="input-form-cadastro" type="text" placeholder="Bairro" required></div>
                  <div class="form-field"><label class="label-form-cadastro">Cidade</label>
                    <input name="cidade" class="input-form-cadastro" type="text" placeholder="Município" required></div>
                  <div class="form-field"><label class="label-form-cadastro">UF</label>
                    <input name="uf" class="input-form-cadastro" type="text" placeholder="SP" maxlength="2" required></div>
                </div>
              </div>

              <!-- Step 4 -->
              <div class="form-section" id="step-3">
                <div class="container-titulo-modal"><p class="section-title">Informação socioeconômica</p></div>
                <div class="form-row col-1">
                  <div class="form-field">
                    <label class="label-form-cadastro">Renda familiar (R$)</label>
                    <input name="renda-familiar" class="input-form-cadastro" type="number" placeholder="0,00" required>
                    <p class="field-hint">Informe o valor mensal total da família</p>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-field">
                    <label class="label-form-cadastro">Possui CadÚnico?</label>
                    <div class="radio-group">
                      <label class="radio-label"><input type="radio" name="cad-unico" value="Sim"> Sim</label>
                      <label class="radio-label"><input type="radio" name="cad-unico" value="Não"> Não</label>
                    </div>
                  </div>
                  <div class="form-field">
                    <label class="label-form-cadastro">Recebe benefício?</label>
                    <div class="radio-group">
                      <label class="radio-label"><input type="radio" name="beneficio" value="Sim"> Sim</label>
                      <label class="radio-label"><input type="radio" name="beneficio" value="Não"> Não</label>
                    </div>
                  </div>
                </div>
                <div class="form-row col-1">
                  <div class="form-field">
                    <label class="label-form-cadastro">Situação de risco social</label>
                    <select name="situacao-risco-social" class="input-form-cadastro">
                      <option value="">— selecione —</option>
                      <option>I - Crianças e adolescentes com medida de proteção</option>
                      <option>II - Trabalho infantil</option>
                      <option>III - Vivência de violência ou negligência</option>
                      <option>IV - Abuso e exploração sexual</option>
                      <option>V - Crianças e adolescentes fora da escola</option>
                      <option>VI - Jovens egressos de medida socioeducativa</option>
                      <option>VII - Pessoas com deficiência (PcD)</option>
                      <option>VIII - Idosos em situação de fragilidade</option>
                      <option>IX - Famílias beneficiárias de transferência de renda</option>
                      <option>X - Pessoas em situação de rua</option>
                      <option>XI - Vulnerabilidade por estigmatização</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="container-footer-modal">
                <div class="footer-left"><span id="step-indicator">Passo 1 de 4</span></div>
                <div class="footer-right">
                  <button type="button" class="btn-cancelar" id="btn-back" onclick="navStep(-1)" style="display:none">← Voltar</button>
                  <button type="button" class="btn-salvar" id="btn-next" onclick="navStep(1)">Próximo →</button>
                  <button type="submit" class="btn-salvar" id="btn-salvar" style="display:none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                      <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Salvar usuário
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

    </main>
  </div>
</body>

</html>
