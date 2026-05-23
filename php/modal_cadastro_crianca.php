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
        <button type="button" class="btn-fechar"
          onclick="document.getElementById('overlay').classList.remove('open')">×</button>
      </div>

      <div class="form-body">
        <div class="steps-bar">
          <button type="button" class="step-tab active" onclick="goStep(0)">1 · Identificação</button>
          <button type="button" class="step-tab" onclick="goStep(1)">2 · Responsáveis</button>
          <button type="button" class="step-tab" onclick="goStep(2)">3 · Endereço</button>
          <button type="button" class="step-tab" onclick="goStep(3)">4 · Socioeconômico</button>
        </div>

        <!-- STEP 0 - Identificação -->
        <div class="form-section active" id="step-0">
          <div class="container-titulo-modal">
            <p class="section-title">Identificação da criança</p>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="label-form-cadastro">Nº Matrícula</label>
              <input name="matricula" class="input-form-cadastro" type="number" placeholder="Ex: 100023" required>
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">NIS</label>
              <input name="nis" class="input-form-cadastro" type="text" placeholder="Número de Identificação Social"
                required>
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
              <label class="label-form-cadastro">Gênero</label>
              <select name="genero" class="input-form-cadastro" required>
                <option value="" disabled selected>Selecione o gênero</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Não-binário">Não-binário</option>
                <option value="Não informado">Prefiro não informar</option>
              </select>
            </div>
          </div>

          <!-- NOVO: Gênero e Idade -->
          <div class="form-row">
            <div class="form-field">
              <label class="label-form-cadastro">Data de nascimento</label>
              <input name="data-nasc-crianca" id="data-nasc-crianca" class="input-form-cadastro" type="date" required
                onchange="calcularIdade()">
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">Idade</label>
              <input name="idade" id="idade-crianca" class="input-form-cadastro" type="text"
                placeholder="Calculada automaticamente" readonly>
            </div>
          </div>

          <div class="form-row">
            <div class="form-field">
              <label class="label-form-cadastro">Estado de nascimento</label>

              <select name="estado-nasc-crianca" id="estado" class="input-form-cadastro" required>
                <option value="">Selecione o estado</option>
              </select>
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">
                Cidade de nascimento
              </label>

              <select id="cidadeNascimento" name="cidade-nasc-crianca" class="input-form-cadastro" required>
                <option value="">Selecione uma cidade</option>
              </select>
            </div>

            <div class="form-field">
              <label class="label-form-cadastro">
                Data de entrada
              </label>

              <input name="data-entrada-crianca" class="input-form-cadastro" type="date" id="data-entrada-crianca"
                required onchange="calcularTempoEntrada()">
            </div>

            <div class="form-field">
              <label class="label-form-cadastro">
                Quanto tempo desde a entrada
              </label>

              <input name="entrada-tempo" id="tempo-entrada-crianca" class="input-form-cadastro" type="text"
                placeholder="Calculada automaticamente" readonly>
            </div>
          </div>
          <div class="form-row col-1">
            <div class="form-field">
              <label class="label-form-cadastro">Status</label>
              <select name="status" class="input-form-cadastro">
                <option value="" disabled selected>Selecione o status</option>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- STEP 1 - Responsáveis -->
        <div class="form-section" id="step-1">
          <div class="container-titulo-modal">
            <p class="section-title">Vínculo de responsabilidade</p>
          </div>
          <div class="form-row col-1">
            <div class="form-field">
              <label class="label-form-cadastro">Responsável legal</label>
              <select name="tipo_responsavel" id="tipo_responsavel" class="input-form-cadastro" required
                onchange="toggleResponsavel()">
                <option value="" disabled selected>Selecione quem é o responsável legal</option>
                <option value="mae">Mãe</option>
                <option value="pai">Pai</option>
                <option value="outro">Outra pessoa (preencher abaixo)</option>
              </select>
            </div>
          </div>

          <!-- Mãe -->
          <div id="secao-mae">
            <div class="container-titulo-modal">
              <p class="section-title" id="titulo-mae">Identificação da mãe <span class="badge-opcional"
                  id="badge-mae-opcional"
                  style="display:none; font-size:11px; background:#e5e7eb; color:#6b7280; padding:2px 7px; border-radius:10px; font-weight:500;">Opcional</span>
              </p>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Nome da mãe</label>
                <input name="nome-mae" id="nome-mae" class="input-form-cadastro" type="text"
                  placeholder="Nome completo">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">CPF da mãe</label>
                <input name="cpf-mae" id="cpf-mae" class="input-form-cadastro" type="text" placeholder="000.000.000-00">
              </div>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Telefone da mãe</label>
                <input name="tel-mae" id="tel-mae" class="input-form-cadastro" type="tel" placeholder="(00) 00000-0000">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">Profissão da mãe</label>
                <select name="profissao-mae" class="input-form-cadastro">
                  <option value="" disabled selected>Selecione a profissão</option>
                  <option value="Trabalha em casa">Trabalha em casa (afazeres domésticos)</option>
                  <option value="Empregado formal">Empregado formal (CLT / funcionário público)</option>
                  <option value="Profissional liberal ou autônomo">Profissional liberal ou autônomo</option>
                  <option value="Trabalhador rural">Trabalhador rural</option>
                  <option value="Desempregado">Desempregado / em busca de trabalho</option>
                  <option value="Aposentado">Aposentado / Pensionista</option>
                  <option value="Não sabe/Não informado">Não sabe / Não informado</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Pai -->
          <div id="secao-pai">
            <div class="container-titulo-modal">
              <p class="section-title">Identificação do pai <span class="badge-opcional" id="badge-pai-opcional"
                  style="display:none; font-size:11px; background:#e5e7eb; color:#6b7280; padding:2px 7px; border-radius:10px; font-weight:500;">Opcional</span>
              </p>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Nome do pai</label>
                <input name="nome-pai" id="nome-pai" class="input-form-cadastro" type="text"
                  placeholder="Nome completo">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">CPF do pai</label>
                <input name="cpf-pai" id="cpf-pai" class="input-form-cadastro" type="text" placeholder="000.000.000-00">
              </div>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Telefone do pai</label>
                <input name="tel-pai" id="tel-pai" class="input-form-cadastro" type="tel" placeholder="(00) 00000-0000">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">Profissão do pai</label>
                <select name="profissao-pai" class="input-form-cadastro">
                  <option value="" disabled selected>Selecione a profissão</option>
                  <option value="Trabalha em casa">Trabalha em casa (afazeres domésticos)</option>
                  <option value="Empregado formal">Empregado formal (CLT / funcionário público)</option>
                  <option value="Profissional liberal ou autônomo">Profissional liberal ou autônomo</option>
                  <option value="Trabalhador rural">Trabalhador rural</option>
                  <option value="Desempregado">Desempregado / em busca de trabalho</option>
                  <option value="Aposentado">Aposentado / Pensionista</option>
                  <option value="Não sabe/Não informado">Não sabe / Não informado</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Outro responsável -->
          <div id="secao-responsavel-extra" class="secao-responsavel-extra" style="display:none;">
            <div class="container-titulo-modal">
              <p class="section-title" style="margin-top: 0;"><span class="badge-outro">Outro</span> Dados do
                responsável legal</p>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Nome do responsável</label>
                <input name="nome-responsavel" id="nome-responsavel" class="input-form-cadastro" type="text"
                  placeholder="Nome completo">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">CPF do responsável</label>
                <input name="cpf-responsavel" id="cpf-responsavel" class="input-form-cadastro" type="text"
                  placeholder="000.000.000-00">
              </div>
            </div>
            <div class="form-row">
              <div class="form-field">
                <label class="label-form-cadastro">Telefone do responsável</label>
                <input name="tel-responsavel" id="tel-responsavel" class="input-form-cadastro" type="tel"
                  placeholder="(00) 00000-0000">
              </div>
              <div class="form-field">
                <label class="label-form-cadastro">Grau de Parentesco</label>
                <input name="grau-parentesco-responsavel" id="grau-parentesco-responsavel" class="input-form-cadastro"
                  type="text" placeholder="Digite o grau de parentesco do responsável">
              </div>
            </div>
            <div class="form-row col-1">
              <div class="form-field">
                <label class="label-form-cadastro">Profissão do responsável</label>
                <select name="profissao-responsavel" class="input-form-cadastro">
                  <option value="" disabled selected>Selecione a profissão</option>
                  <option value="Trabalha em casa">Trabalha em casa (afazeres domésticos)</option>
                  <option value="Empregado formal">Empregado formal (CLT / funcionário público)</option>
                  <option value="Profissional liberal ou autônomo">Profissional liberal ou autônomo</option>
                  <option value="Trabalhador rural">Trabalhador rural</option>
                  <option value="Desempregado">Desempregado / em busca de trabalho</option>
                  <option value="Aposentado">Aposentado / Pensionista</option>
                  <option value="Não sabe/Não informado">Não sabe / Não informado</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- STEP 2 - Endereço -->
        <div class="form-section" id="step-2">
          <div class="container-titulo-modal">
            <p class="section-title">Endereço residencial</p>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label class="label-form-cadastro">CEP</label>
              <input name="cep" class="input-form-cadastro" type="text" placeholder="00000-000" required>
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">Número</label>
              <input name="numero" class="input-form-cadastro" type="text" placeholder="Nº" required>
            </div>
          </div>
          <div class="form-row col-1">
            <div class="form-field">
              <label class="label-form-cadastro">Rua / Logradouro</label>
              <input name="logradouro" class="input-form-cadastro" type="text" placeholder="Nome da rua, avenida..."
                required>
            </div>
          </div>
          <div class="form-row col-3">
            <div class="form-field">
              <label class="label-form-cadastro">Bairro</label>
              <input name="bairro" class="input-form-cadastro" type="text" placeholder="Bairro" required>
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">Cidade</label>
              <input name="cidade" class="input-form-cadastro" type="text" placeholder="Município" required>
            </div>
            <div class="form-field">
              <label class="label-form-cadastro">UF</label>
              <input name="uf" class="input-form-cadastro" type="text" placeholder="SP" maxlength="2" required>
            </div>
          </div>
        </div>

        <!-- STEP 3 - Socioeconômico -->
        <div class="form-section" id="step-3">
          <div class="container-titulo-modal">
            <p class="section-title">Informação socioeconômica</p>
          </div>
          <div class="form-row col-1">
            <div class="form-field">
              <label class="label-form-cadastro">Renda familiar (R$)</label>
              <input name="renda-familiar" class="input-form-cadastro" type="number" step="0.01" min="0"
                placeholder="0,00" required>
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
                <option value="" disabled selected>Selecione a situação de risco</option>
                <option>I - Crianças e adolescentes com medida de proteção</option>
                <option>II - Trabalho infantil</option>
                <option>III - Vivência de violência ou negligência</option>
                <option>IV - Abuso e exploração sexual</option>
                <option>V - Crianças e adolescentes fora da escola</option>
                <option>VI - Jovens egressos de medida socioeducativa</option>
                <option>VII - Pessoas com deficiência (PcD)</option>
                <option>VIII - Famílias beneficiárias de transferência de renda</option>
                <option>IX - Pessoas em situação de rua</option>
                <option>X - Vulnerabilidade por estigmatização</option>
              </select>
            </div>
          </div>
        </div>

        <div class="container-footer-modal">
          <div class="footer-left"><span id="step-indicator">Passo 1 de 4</span></div>
          <div class="footer-right">
            <button type="button" class="btn-cancelar" id="btn-back" onclick="navStep(-1)" style="display:none">←
              Voltar</button>
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

<script>
  const estadoSelect  = document.getElementById('estado');
  const cidadeSelect  = document.getElementById('cidadeNascimento');

  async function carregarEstados() {
    try {
      const res    = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
      const estados = await res.json();

      estados.forEach(({ sigla, nome }) => {
        estadoSelect.appendChild(new Option(nome, sigla));
      });
    } catch {
      console.error('Erro ao carregar estados.');
    }
  }

  async function carregarCidades(uf) {
    cidadeSelect.innerHTML = '<option value="">Carregando...</option>';
    cidadeSelect.disabled  = true;

    try {
      const res    = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`);
      const cidades = await res.json();

      cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
      cidades.forEach(({ nome }) => {
        cidadeSelect.appendChild(new Option(nome, nome));
      });
    } catch {
      cidadeSelect.innerHTML = '<option value="">Erro ao carregar</option>';
    } finally {
      cidadeSelect.disabled = false;
    }
  }

  estadoSelect.addEventListener('change', (e) => {
    if (e.target.value) carregarCidades(e.target.value);
  });

  carregarEstados();

  const campoCep = document.querySelector('input[name="cep"]');

  campoCep.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 8);
    if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
    this.value = v;
  });

  campoCep.addEventListener('blur', async function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    this.value    = 'Buscando...';
    this.disabled = true;

    try {
      const res  = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      const data = await res.json();

      if (data.erro) throw new Error('CEP não encontrado');

      document.querySelector('input[name="logradouro"]').value = data.logradouro || '';
      document.querySelector('input[name="bairro"]').value     = data.bairro     || '';
      document.querySelector('input[name="cidade"]').value     = data.localidade || '';
      document.querySelector('input[name="uf"]').value         = data.uf         || '';

      this.value = cep.replace(/(\d{5})(\d{3})/, '$1-$2');
      document.querySelector('input[name="numero"]').focus();

    } catch (err) {
      alert(err.message === 'CEP não encontrado'
        ? 'CEP não encontrado. Verifique e tente novamente.'
        : 'Erro ao buscar o CEP. Tente novamente.');
      this.value = '';
    } finally {
      this.disabled = false;
    }
  });

  function diffDatas(dataInicio) {
    const inicio = new Date(dataInicio);
    const hoje   = new Date();

    let anos  = hoje.getFullYear() - inicio.getFullYear();
    let meses = hoje.getMonth()    - inicio.getMonth();
    let dias  = hoje.getDate()     - inicio.getDate();

    if (dias < 0) {
      meses--;
      dias += new Date(hoje.getFullYear(), hoje.getMonth(), 0).getDate();
    }
    if (meses < 0) { anos--; meses += 12; }

    return { anos, meses, dias };
  }

  function calcularIdade() {
    const input      = document.getElementById('data-nasc-crianca');
    const campoIdade = document.getElementById('idade-crianca');

    if (!input.value) { campoIdade.value = ''; return; }

    const { anos } = diffDatas(input.value);
    campoIdade.value = anos >= 0 ? `${anos} ano(s)` : '';
  }

  function calcularTempoEntrada() {
    const input       = document.getElementById('data-entrada-crianca');
    const campoSaida  = document.getElementById('tempo-entrada-crianca');

    if (!input.value) { campoSaida.value = ''; return; }

    const { anos, meses, dias } = diffDatas(input.value);
    campoSaida.value = `${anos} ano(s), ${meses} mês(es) e ${dias} dia(s)`;
  }

  function toggleResponsavel() {
    const tipo = document.getElementById('tipo_responsavel').value;

    const campos = {
      mae:  { nome: 'nome-mae',         cpf: 'cpf-mae',         badge: 'badge-mae-opcional' },
      pai:  { nome: 'nome-pai',         cpf: 'cpf-pai',         badge: 'badge-pai-opcional' },
      outro:{ nome: 'nome-responsavel', cpf: 'cpf-responsavel', grau: 'grau-parentesco-responsavel' },
    };

    // Reseta tudo
    ['mae', 'pai'].forEach(p => {
      document.getElementById(campos[p].nome).required  = false;
      document.getElementById(campos[p].cpf).required   = false;
      document.getElementById(campos[p].badge).style.display = 'none';
    });
    document.getElementById(campos.outro.nome).required = false;
    document.getElementById(campos.outro.cpf).required  = false;
    document.getElementById(campos.outro.grau).required = false;
    document.getElementById('secao-responsavel-extra').style.display = 'none';

    // Aplica regras conforme seleção
    const regras = {
      mae:   () => {
        document.getElementById(campos.mae.nome).required = true;
        document.getElementById(campos.mae.cpf).required  = true;
        document.getElementById(campos.pai.badge).style.display = 'inline';
      },
      pai:   () => {
        document.getElementById(campos.pai.nome).required = true;
        document.getElementById(campos.pai.cpf).required  = true;
        document.getElementById(campos.mae.badge).style.display = 'inline';
      },
      outro: () => {
        document.getElementById(campos.outro.nome).required = true;
        document.getElementById(campos.outro.cpf).required  = true;
        document.getElementById(campos.outro.grau).required = true;
        document.getElementById('secao-responsavel-extra').style.display = 'block';
        document.getElementById(campos.mae.badge).style.display = 'inline';
        document.getElementById(campos.pai.badge).style.display = 'inline';
      },
    };

    regras[tipo]?.();
  }
</script>