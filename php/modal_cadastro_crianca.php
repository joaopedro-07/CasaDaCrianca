<?php
require_once 'processa-cadastro-crianca.php';

extract(ChildDataValidator::fromPost($_POST));
extract(AddressValidator::fromPost($_POST));
extract(SocioeconomicValidator::fromPost($_POST));
extract(GuardianValidator::fromPost($_POST));
?>
<div class="overlay" id="modalOverlay" style="display:none">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
 
    <!-- HEADER -->
    <div class="modal-header">
      <div class="header-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" st  roke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
      </div>
      <span class="modal-title" id="modalTitle">Cadastrar Criança</span>
      <button class="btn-close" onclick="closeModal()" aria-label="Fechar">×</button>
    </div>
 
    <!-- TABS -->
    <div class="tabs" role="tablist">
      <button class="tab active" id="tab-1" role="tab" onclick="goToStep(1)">Identificação</button>
      <button class="tab" id="tab-2" role="tab" onclick="goToStep(2)">Responsáveis</button>
      <button class="tab" id="tab-3" role="tab" onclick="goToStep(3)">Endereço</button>
      <button class="tab" id="tab-4" role="tab" onclick="goToStep(4)">Socioeconômico</button>
    </div>
 
    <!-- FORM -->
    <form id="cadastroForm" action="processa-cadastro-crianca.php" method="POST">
    <div class="modal-body">
 
      <!-- STEP 1: IDENTIFICAÇÃO -->
      <div class="step active" id="step-1">
        <p class="step-title">Identificação</p>
        <div class="form-grid">
 
          <div class="field full">
            <label>Nome completo *</label>
            <input type="text" name="nome_completo" id="nome_completo" placeholder="Digite o nome completo" required>
            <span class="error-msg">Campo obrigatório</span>
          </div>
 
          <div class="field">
            <label>Apelido / Nome social</label>
            <input type="text" name="nome_social" placeholder="Digite o apelido">
          </div>
 
          <div class="field">
            <label>Data de nascimento *</label>
            <input type="date" name="data_nascimento" id="data_nascimento" required onchange="calcularIdade()">
            <span class="error-msg">Campo obrigatório</span>
          </div>
 
          <div class="field">
            <label>Idade</label>
            <div class="computed" id="campo_idade">—</div>
          </div>
 
          <div class="field">
            <label>Sexo *</label>
            <select name="sexo" required>
              <option value="">Selecione</option>
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
              <option value="O">Outro</option>
            </select>
          </div>
 
          <div class="field">
            <label>Estado civil</label>
            <input type="text" name="estado_civil" placeholder="Estado civil">
          </div>
 
          <div class="field">
            <label>Nacionalidade</label>
            <input type="text" name="nacionalidade" placeholder="Brasileira" value="Brasileira">
          </div>
 
          <div class="field">
            <label>Naturalidade</label>
            <input type="text" name="naturalidade" placeholder="Cidade de nascimento">
          </div>
 
          <div class="field">
            <label>Nome da mãe</label>
            <input type="text" name="nome_mae" placeholder="Nome completo da mãe">
          </div>
 
          <div class="field">
            <label>Nome do pai</label>
            <input type="text" name="nome_pai" placeholder="Nome completo do pai">
          </div>
 
          <div class="field">
            <label>CPF</label>
            <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" maxlength="14" oninput="mascaraCPF(this)">
          </div>
 
          <div class="field">
            <label>NIS / PIS</label>
            <input type="text" name="nis" placeholder="Número NIS">
          </div>
 
          <div class="field">
            <label>Profissão</label>
            <input type="text" name="profissao" placeholder="Digite a profissão">
          </div>
 
          <div class="field">
            <label>Escolaridade</label>
            <select name="escolaridade">
              <option value="">Selecione</option>
              <option value="ei">Educação Infantil</option>
              <option value="ef1">Ensino Fund. I</option>
              <option value="ef2">Ensino Fund. II</option>
              <option value="em">Ensino Médio</option>
              <option value="sup">Superior</option>
              <option value="na">Não se aplica</option>
            </select>
          </div>
 
          <div class="field">
            <label>Data de entrada</label>
            <input type="date" name="data_entrada" id="data_entrada" onchange="calcularTempoEntrada()">
          </div>
 
          <div class="field">
            <label>Tempo de entrada</label>
            <div class="computed" id="campo_tempo_entrada">—</div>
          </div>
 
          <div class="field">
            <label>Nº Prontuário</label>
            <input type="text" name="num_prontuario" placeholder="Número do prontuário">
          </div>

        </div>
      </div>
 
      <!-- STEP 2: RESPONSÁVEIS -->
      <div class="step" id="step-2">
        <p class="step-title">Responsáveis</p>
        <div class="form-grid">
 
          <p class="section-label">Responsável principal</p>
 
          <div class="field full">
            <label>Nome do responsável *</label>
            <input type="text" name="responsavel_nome" placeholder="Nome completo do responsável" required>
          </div>
 
          <div class="field">
            <label>Parentesco *</label>
            <select name="responsavel_parentesco" required>
              <option value="">Selecione</option>
              <option value="mae">Mãe</option>
              <option value="pai">Pai</option>
              <option value="avo">Avó / Avô</option>
              <option value="tio">Tio / Tia</option>
              <option value="irmao">Irmão / Irmã</option>
              <option value="outro">Outro</option>
            </select>
          </div>
 
          <div class="field">
            <label>Telefone *</label>
            <input type="tel" name="responsavel_telefone" placeholder="(00) 00000-0000" maxlength="15" oninput="mascaraTel(this)">
          </div>
 
          <div class="field">
            <label>E-mail</label>
            <input type="email" name="responsavel_email" placeholder="email@exemplo.com">
          </div>
 
          <div class="field">
            <label>CPF do responsável</label>
            <input type="text" name="responsavel_cpf" placeholder="000.000.000-00" maxlength="14" oninput="mascaraCPF(this)">
          </div>
 
          <!-- Toggle Responsável 2 -->
          <div class="toggle-row">
            <label class="toggle" for="toggle_resp2">
              <input type="checkbox" id="toggle_resp2" onchange="toggleResponsavel2(this)">
              <span class="toggle-slider"></span>
            </label>
            <span class="toggle-label">Adicionar segundo responsável</span>
          </div>
 
          <div class="responsavel-section" id="responsavel2-section" style="display:none">
            <div class="form-grid">
              <p class="section-label" style="margin-top:0">Segundo responsável</p>
 
              <div class="field full">
                <label>Nome do responsável</label>
                <input type="text" name="responsavel2_nome" placeholder="Nome completo">
              </div>
 
              <div class="field">
                <label>Parentesco</label>
                <select name="responsavel2_parentesco">
                  <option value="">Selecione</option>
                  <option value="mae">Mãe</option>
                  <option value="pai">Pai</option>
                  <option value="avo">Avó / Avô</option>
                  <option value="tio">Tio / Tia</option>
                  <option value="outro">Outro</option>
                </select>
              </div>
 
              <div class="field">
                <label>Telefone</label>
                <input type="tel" name="responsavel2_telefone" placeholder="(00) 00000-0000" maxlength="15" oninput="mascaraTel(this)">
              </div>
            </div>
          </div>
 
        </div>
      </div>
 
      <!-- STEP 3: ENDEREÇO -->
      <div class="step" id="step-3">
        <p class="step-title">Endereço</p>
        <div class="form-grid">
 
          <div class="field">
            <label>CEP *</label>
            <input type="text" name="cep" id="cep" placeholder="00000-000" maxlength="9" oninput="mascaraCEP(this)" onblur="buscarCEP(this.value)" required>
          </div>
 
          <div class="field full">
            <label>Logradouro *</label>
            <input type="text" name="logradouro" id="logradouro" placeholder="Rua, Avenida, etc." required>
          </div>
 
          <div class="field">
            <label>Número</label>
            <input type="text" name="numero" placeholder="Nº">
          </div>
 
          <div class="field">
            <label>Complemento</label>
            <input type="text" name="complemento" placeholder="Apto, bloco...">
          </div>
 
          <div class="field">
            <label>Bairro *</label>
            <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
          </div>
 
          <div class="field">
            <label>Município *</label>
            <input type="text" name="municipio" id="municipio" placeholder="Cidade" required>
          </div>
 
          <div class="field">
            <label>Estado *</label>
            <select name="estado" id="estado_uf" required>
              <option value="">UF</option>
              <option>AC</option><option>AL</option><option>AP</option><option>AM</option>
              <option>BA</option><option>CE</option><option>DF</option><option>ES</option>
              <option>GO</option><option>MA</option><option>MT</option><option>MS</option>
              <option>MG</option><option>PA</option><option>PB</option><option>PR</option>
              <option>PE</option><option>PI</option><option>RJ</option><option>RN</option>
              <option>RS</option><option>RO</option><option>RR</option><option>SC</option>
              <option selected>SP</option><option>SE</option><option>TO</option>
            </select>
          </div>
 
          <div class="field">
            <label>Zona</label>
            <select name="zona">
              <option value="">Selecione</option>
              <option value="urbana">Urbana</option>
              <option value="rural">Rural</option>
            </select>
          </div>
 
          <div class="field full">
            <label>Ponto de referência</label>
            <input type="text" name="referencia" placeholder="Próximo a...">
          </div>
 
          <div class="info-card">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <span>Digite o CEP para preencher o endereço automaticamente.</span>
          </div>
 
        </div>
      </div>
 
      <!-- STEP 4: SOCIOECONÔMICO -->
      <div class="step" id="step-4">
        <p class="step-title">Dados Socioeconômicos</p>
        <div class="form-grid">
 
          <div class="field">
            <label>Renda familiar (R$)</label>
            <input type="number" name="renda_familiar" placeholder="0,00" min="0" step="0.01">
          </div>
 
          <div class="field">
            <label>Nº de membros na família</label>
            <input type="number" name="membros_familia" placeholder="Ex: 4" min="1" max="20">
          </div>
 
          <div class="field">
            <label>Situação da moradia</label>
            <select name="situacao_moradia">
              <option value="">Selecione</option>
              <option value="propria">Própria</option>
              <option value="alugada">Alugada</option>
              <option value="cedida">Cedida</option>
              <option value="ocupada">Ocupada</option>
              <option value="abrigo">Abrigo / Albergue</option>
            </select>
          </div>
 
          <div class="field">
            <label>Recebe benefício social</label>
            <select name="beneficio_social" id="beneficio_social" onchange="toggleBeneficio()">
              <option value="">Selecione</option>
              <option value="sim">Sim</option>
              <option value="nao">Não</option>
            </select>
          </div>
 
          <div class="field full" id="qual_beneficio_field" style="display:none">
            <label>Qual benefício?</label>
            <input type="text" name="qual_beneficio" placeholder="Ex: Bolsa Família, BPC...">
          </div>
 
          <p class="section-label">Vulnerabilidades identificadas</p>
 
          <div class="field full">
            <div class="checkbox-group">
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="violencia"> Situação de violência
              </label>
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="trabalho_infantil"> Trabalho infantil
              </label>
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="uso_drogas"> Uso de drogas na família
              </label>
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="abandono"> Abandono / Negligência
              </label>
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="evasao_escolar"> Evasão escolar
              </label>
              <label class="checkbox-option">
                <input type="checkbox" name="vulnerabilidade[]" value="deficiencia"> Pessoa com deficiência
              </label>
            </div>
          </div>
 
          <p class="section-label">Observações</p>
 
          <div class="field full">
            <label>Observações gerais</label>
            <textarea name="observacoes" placeholder="Informações adicionais relevantes..."></textarea>
          </div>
 
          <div class="info-card">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>
            <span>Ao salvar, o cadastro será enviado para análise. Você poderá editar posteriormente.</span>
          </div>
 
        </div>
      </div>
 
    </div>
 
    <!-- FOOTER -->
    <div class="modal-footer">
      <span class="progress-text" id="progressText">Passo 1 de 4</span>
      <div class="footer-actions">
        <button type="button" class="btn btn-ghost" id="btnCancelar" onclick="closeModal()">Cancelar</button>
        <button type="button" class="btn btn-ghost" id="btnVoltar" onclick="prevStep()" style="display:none">
          ← Voltar
        </button>
        <button type="button" class="btn btn-yellow" id="btnProximo" onclick="nextStep()">
          Próximo →
        </button>
        <button type="submit" class="btn btn-save" id="btnSalvar" style="display:none">
          ✓ Salvar
        </button>
      </div>
    </div>
    </form>
 
  </div>
</div>