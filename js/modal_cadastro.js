  let currentStep = 1;
  const totalSteps = 4;
 
  function goToStep(n) {
    if (n < 1 || n > totalSteps) return;
 
    document.getElementById('step-' + currentStep).classList.remove('active');
    document.getElementById('tab-' + currentStep).classList.remove('active');
    if (n > currentStep) {
      document.getElementById('tab-' + currentStep).classList.add('completed');
    }
 
    currentStep = n;
    document.getElementById('step-' + currentStep).classList.add('active');
 
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach((t, i) => {
      t.classList.remove('active');
      if (i + 1 < currentStep) t.classList.add('completed');
      else if (i + 1 > currentStep) t.classList.remove('completed');
    });
    document.getElementById('tab-' + currentStep).classList.add('active');
 
    document.getElementById('progressText').textContent = 'Passo ' + currentStep + ' de ' + totalSteps;
 
    const btnVoltar = document.getElementById('btnVoltar');
    const btnProximo = document.getElementById('btnProximo');
    const btnSalvar = document.getElementById('btnSalvar');
    const btnCancelar = document.getElementById('btnCancelar');
 
    btnVoltar.style.display = currentStep > 1 ? 'flex' : 'none';
    btnCancelar.style.display = currentStep === 1 ? 'flex' : 'none';
    btnProximo.style.display = currentStep < totalSteps ? 'flex' : 'none';
    btnSalvar.style.display = currentStep === totalSteps ? 'flex' : 'none';
 
    document.querySelector('.modal-body').scrollTop = 0;
  }
 
  function nextStep() {
    if (validateCurrentStep()) goToStep(currentStep + 1);
  }
 
  function prevStep() {
    goToStep(currentStep - 1);
  }
 
  function validateCurrentStep() {
    const step = document.getElementById('step-' + currentStep);
    const required = step.querySelectorAll('[required]');
    let valid = true;
 
    required.forEach(el => {
      const field = el.closest('.field');
      if (!el.value.trim()) {
        el.classList.add('error');
        if (field) field.classList.add('has-error');
        valid = false;
      } else {
        el.classList.remove('error');
        if (field) field.classList.remove('has-error');
      }
    });
 
    if (!valid) {
      const firstError = step.querySelector('.error');
      if (firstError) firstError.focus();
    }
 
    return valid;
  }
 
  function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
    document.getElementById('cadastroForm').reset();
    goToStep(1);
    document.getElementById('campo_idade').textContent = '—';
    document.getElementById('campo_tempo_entrada').textContent = '—';
  }
 
  function calcularIdade() {
    const val = document.getElementById('data_nascimento').value;
    if (!val) { document.getElementById('campo_idade').textContent = '—'; return; }
    const hoje = new Date();
    const nasc = new Date(val);
    let anos = hoje.getFullYear() - nasc.getFullYear();
    const m = hoje.getMonth() - nasc.getMonth();
    if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) anos--;
    const meses = ((hoje.getFullYear() - nasc.getFullYear()) * 12) + hoje.getMonth() - nasc.getMonth();
    if (anos < 0) { document.getElementById('campo_idade').textContent = 'Data inválida'; return; }
    if (anos === 0) {
      document.getElementById('campo_idade').textContent = meses + ' mês' + (meses !== 1 ? 'es' : '');
    } else {
      document.getElementById('campo_idade').textContent = anos + ' ano' + (anos !== 1 ? 's' : '');
    }
  }
 
  function calcularTempoEntrada() {
    const val = document.getElementById('data_entrada').value;
    if (!val) { document.getElementById('campo_tempo_entrada').textContent = '—'; return; }
    const hoje = new Date();
    const entrada = new Date(val);
    if (entrada > hoje) { document.getElementById('campo_tempo_entrada').textContent = 'Data futura'; return; }
    let anos = hoje.getFullYear() - entrada.getFullYear();
    let meses = hoje.getMonth() - entrada.getMonth();
    if (meses < 0) { anos--; meses += 12; }
    let txt = '';
    if (anos > 0) txt += anos + ' ano' + (anos !== 1 ? 's' : '');
    if (meses > 0) txt += (txt ? ' e ' : '') + meses + ' mês' + (meses !== 1 ? 'es' : '');
    if (!txt) txt = 'Recém cadastrado';
    document.getElementById('campo_tempo_entrada').textContent = txt;
  }
 
  function toggleResponsavel2(el) {
    document.getElementById('responsavel2-section').style.display = el.checked ? 'block' : 'none';
  }
 
  function toggleBeneficio() {
    const val = document.getElementById('beneficio_social').value;
    document.getElementById('qual_beneficio_field').style.display = val === 'sim' ? 'block' : 'none';
  }
 
  function mascaraCPF(el) {
    let v = el.value.replace(/\D/g, '').substring(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    el.value = v;
  }
 
  function mascaraTel(el) {
    let v = el.value.replace(/\D/g, '').substring(0, 11);
    if (v.length > 10) v = v.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    else v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    el.value = v;
  }
 
  function mascaraCEP(el) {
    let v = el.value.replace(/\D/g, '').substring(0, 8);
    v = v.replace(/(\d{5})(\d)/, '$1-$2');
    el.value = v;
  }
 
  async function buscarCEP(cep) {
    const c = cep.replace(/\D/g, '');
    if (c.length !== 8) return;
    try {
      const r = await fetch('https://viacep.com.br/ws/' + c + '/json/');
      const d = await r.json();
      if (!d.erro) {
        document.getElementById('logradouro').value = d.logradouro || '';
        document.getElementById('bairro').value = d.bairro || '';
        document.getElementById('municipio').value = d.localidade || '';
        const sel = document.getElementById('estado_uf');
        for (let opt of sel.options) {
          if (opt.value === d.uf) { sel.value = d.uf; break; }
        }
      }
    } catch(e) {}
  }
 
  // Remove erro ao digitar
  document.addEventListener('input', function(e) {
    if (e.target.matches('input, select, textarea')) {
      e.target.classList.remove('error');
      const field = e.target.closest('.field');
      if (field) field.classList.remove('has-error');
    }
  });
 
  // Fechar ao clicar fora
  document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
 
  // ESC fecha
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
  });