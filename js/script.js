function fecharModal(e) {
  if (e.target === document.getElementById("overlay")) {
    document.getElementById("overlay").classList.remove("open");
  }
}

function toggleMotivo() {
  const val = document.getElementById("select-motivo").value;
  const campo = document.getElementById("campo-motivo-outro");
  campo.style.display = val === "Outro" ? "flex" : "none";
}

  let currentStep = 0;
  const totalSteps = 4;

  function goStep(n) {
    document.getElementById('step-' + currentStep).classList.remove('active');
    document.querySelectorAll('.step-tab')[currentStep].classList.remove('active');
    currentStep = n;
    document.getElementById('step-' + currentStep).classList.add('active');
    document.querySelectorAll('.step-tab')[currentStep].classList.add('active');
    updateFooter();
  }

  function navStep(dir) {
    const next = currentStep + dir;
    if (next < 0 || next >= totalSteps) return;
    goStep(next);
  }

  function updateFooter() {
    document.getElementById('step-indicator').textContent = 'Passo ' + (currentStep + 1) + ' de ' + totalSteps;
    document.getElementById('btn-back').style.display = currentStep > 0 ? 'inline-flex' : 'none';
    document.getElementById('btn-next').style.display = currentStep < totalSteps - 1 ? 'inline-flex' : 'none';
    document.getElementById('btn-salvar').style.display = currentStep === totalSteps - 1 ? 'inline-flex' : 'none';
  }

  function toggleResponsavel() {
    const select = document.getElementById('tipo_responsavel');
    const secao = document.getElementById('secao-responsavel-extra');
    const nomeResp = document.getElementById('nome-responsavel');
    const cpfResp = document.getElementById('cpf-responsavel');
    const telResp = document.getElementById('tel-responsavel');
    if (select.value === 'outro') {
      secao.classList.add('visible');
      nomeResp.required = true;
      cpfResp.required = true;
    } else {
      secao.classList.remove('visible');
      nomeResp.required = false;
      cpfResp.required = false;
      nomeResp.value = '';
      cpfResp.value = '';
      if (telResp) telResp.value = '';
    }
  }

  updateFooter();