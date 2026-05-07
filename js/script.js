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
  document.getElementById("step-" + currentStep).classList.remove("active");
  document
    .querySelectorAll(".step-tab")
    [currentStep].classList.remove("active");
  currentStep = n;
  document.getElementById("step-" + currentStep).classList.add("active");
  document.querySelectorAll(".step-tab")[currentStep].classList.add("active");
  updateFooter();
}

function navStep(dir) {
  const next = currentStep + dir;
  if (next < 0 || next >= totalSteps) return;
  goStep(next);
}

function updateFooter() {
  document.getElementById("step-indicator").textContent =
    "Passo " + (currentStep + 1) + " de " + totalSteps;
  document.getElementById("btn-back").style.display =
    currentStep > 0 ? "inline-flex" : "none";
  document.getElementById("btn-next").style.display =
    currentStep < totalSteps - 1 ? "inline-flex" : "none";
  document.getElementById("btn-salvar").style.display =
    currentStep === totalSteps - 1 ? "inline-flex" : "none";
}

function toggleResponsavel() {
  const select = document.getElementById("tipo_responsavel");
  const secao = document.getElementById("secao-responsavel-extra");
  const nomeResp = document.getElementById("nome-responsavel");
  const cpfResp = document.getElementById("cpf-responsavel");
  const telResp = document.getElementById("tel-responsavel");
  if (select.value === "outro") {
    secao.classList.add("visible");
    nomeResp.required = true;
    cpfResp.required = true;
  } else {
    secao.classList.remove("visible");
    nomeResp.required = false;
    cpfResp.required = false;
    nomeResp.value = "";
    cpfResp.value = "";
    if (telResp) telResp.value = "";
  }
}

updateFooter();

function buscarDadosCrianca(id) {
  fetch("buscar_detalhes.php?id=" + id)
    .then((response) => response.json())
    .then((dados) => {
      if (dados.erro) {
        alert(dados.erro);
        return;
      }

      // Preenchendo os campos do modal
      document.getElementById("edit-id").value = dados.id;
      document.getElementById("edit-nome").value = dados.nome_crianca;
      document.getElementById("edit-cpf").value = dados.cpf_crianca;
      document.getElementById("edit-nis").value = dados.nis;
      document.getElementById("edit-data-nasc").value = dados.data_nasc;

      // Dados dos responsáveis (vêm do seu SQL com JOIN)
      document.getElementById("edit-mae").value = dados.nome_mae;
      document.getElementById("edit-pai").value = dados.nome_pai;
      document.getElementById("edit-resp-nome").value = dados.nome_responsavel;
      document.getElementById("edit-parentesco").value = dados.tipo_responsavel;

      // Endereço
      document.getElementById("edit-logradouro").value = dados.logradouro;
      document.getElementById("edit-bairro").value = dados.bairro;

      // Comando para abrir o modal
      document.getElementById("modalEditar").style.display = "block";
    });
}

(function () {
  const wrapper = document.getElementById("tc-wrapper");
  if (!wrapper) return;

  const colunas = JSON.parse(wrapper.dataset.colunas || "{}");
  const presets = JSON.parse(wrapper.dataset.presets || "{}");
  const dataset = JSON.parse(
    document.getElementById("tc-dataset")?.textContent || "[]",
  );

  /* ---------- BUSCA EM TEMPO REAL ---------- */
  const inputBusca = document.getElementById("tc-input-busca");
  const tbody = document.getElementById("tc-tbody");
  const contador = document.getElementById("tc-contador");
  const linhas = Array.from(tbody.querySelectorAll("tr[data-search]"));

  function aplicarFiltro() {
    const termo = inputBusca.value.trim().toLowerCase();
    let visiveis = 0;
    linhas.forEach((tr) => {
      const conteudo = tr.dataset.search || "";
      const mostrar = !termo || conteudo.includes(termo);
      tr.style.display = mostrar ? "" : "none";
      if (mostrar) visiveis++;
    });
    contador.textContent =
      visiveis + (visiveis === 1 ? " registro" : " registros");
  }

  inputBusca?.addEventListener("input", aplicarFiltro);

  /* ---------- MODAL DE EXPORTAÇÃO ---------- */
  const overlay = document.getElementById("tc-overlay-export");
  const btnAbrir = document.getElementById("tc-btn-abrir-export");
  const btnFechar = document.getElementById("tc-btn-fechar-export");
  const btnCancel = document.getElementById("tc-btn-cancelar-export");
  const btnCSV = document.getElementById("tc-btn-exportar-csv");
  const grid = document.getElementById("tc-export-grid");
  const info = document.getElementById("tc-export-info");

  function abrirModal() {
    overlay.classList.add("open");
    atualizarInfo();
  }
  function fecharModal() {
    overlay.classList.remove("open");
  }

  btnAbrir?.addEventListener("click", abrirModal);
  btnFechar?.addEventListener("click", fecharModal);
  btnCancel?.addEventListener("click", fecharModal);
  overlay?.addEventListener("click", (e) => {
    if (e.target === overlay) fecharModal();
  });

  /* Monta a grid de checkboxes agrupada por categoria */
  function montarGrid() {
    const categorias = {};
    Object.entries(colunas).forEach(([key, col]) => {
      (categorias[col.cat] = categorias[col.cat] || []).push({ key, ...col });
    });

    grid.innerHTML = "";
    Object.entries(categorias).forEach(([cat, items]) => {
      const catEl = document.createElement("div");
      catEl.className = "tc-export-cat";
      catEl.innerHTML = `<div class="tc-export-cat-titulo">${cat}</div>`;

      const opts = document.createElement("div");
      opts.className = "tc-export-options";
      items.forEach((it) => {
        const id = "tc-col-" + it.key;
        const lbl = document.createElement("label");
        lbl.className = "tc-export-option";
        lbl.innerHTML = `
                    <input type="checkbox" id="${id}" value="${it.key}">
                    <span>${it.label}</span>
                `;
        opts.appendChild(lbl);
      });
      catEl.appendChild(opts);
      grid.appendChild(catEl);
    });

    grid.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
      cb.addEventListener("change", () => {
        cb.closest(".tc-export-option").classList.toggle("checked", cb.checked);
        atualizarInfo();
      });
    });
  }

  function setSelecao(chaves) {
    const set = new Set(chaves);
    grid.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
      cb.checked = set.has(cb.value);
      cb.closest(".tc-export-option").classList.toggle("checked", cb.checked);
    });
    atualizarInfo();
  }

  function atualizarInfo() {
    const sel = grid.querySelectorAll('input[type="checkbox"]:checked').length;
    info.textContent =
      sel + (sel === 1 ? " coluna selecionada" : " colunas selecionadas");
    btnCSV.disabled = sel === 0;
  }

  /* Presets */
  document.querySelectorAll(".tc-preset-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const p = btn.dataset.preset;
      if (p === "clear") return setSelecao([]);
      if (p === "all") return setSelecao(Object.keys(colunas));
      if (presets[p]) return setSelecao(presets[p]);
    });
  });

  /* Exportação CSV */
  btnCSV?.addEventListener("click", () => {
    const selecionadas = Array.from(
      grid.querySelectorAll('input[type="checkbox"]:checked'),
    ).map((cb) => cb.value);
    if (!selecionadas.length) return;

    const termo = (inputBusca?.value || "").trim().toLowerCase();
    const dados = dataset.filter((row) => {
      if (!termo) return true;
      return Object.values(row)
        .map((v) => String(v ?? "").toLowerCase())
        .join(" ")
        .includes(termo);
    });

    const cabecalho = selecionadas.map((k) => colunas[k]?.label || k);
    const linhasCSV = dados.map((row) =>
      selecionadas.map((k) => formatarValorCSV(k, row[k])),
    );

    const csv = [cabecalho, ...linhasCSV]
      .map((linha) => linha.map(escaparCSV).join(";"))
      .join("\n");

    baixarCSV(csv, gerarNomeArquivo());
    fecharModal();
  });

  function formatarValorCSV(key, val) {
    if (val === null || val === undefined || val === "") return "";
    if (
      [
        "data_nasc_crianca",
        "data_entrada_crianca",
        "ultimo_status_data",
      ].includes(key)
    ) {
      const d = new Date(val);
      if (!isNaN(d)) {
        const dd = String(d.getDate()).padStart(2, "0");
        const mm = String(d.getMonth() + 1).padStart(2, "0");
        return `${dd}/${mm}/${d.getFullYear()}`;
      }
    }
    if (key === "renda_familiar") {
      const n = Number(val);
      if (!isNaN(n)) return n.toFixed(2).replace(".", ",");
    }
    if (key === "tipo_responsavel") {
      const map = { mae: "Mãe", pai: "Pai", outro: "Outro" };
      return map[val] || String(val);
    }
    return String(val);
  }

  function escaparCSV(v) {
    const s = String(v ?? "");
    if (/[";\n]/.test(s)) return '"' + s.replace(/"/g, '""') + '"';
    return s;
  }

  function gerarNomeArquivo() {
    const d = new Date();
    const ts =
      d.getFullYear() +
      String(d.getMonth() + 1).padStart(2, "0") +
      String(d.getDate()).padStart(2, "0");
    return `criancas_${ts}.csv`;
  }

  function baixarCSV(conteudo, nome) {
    const blob = new Blob(["\ufeff" + conteudo], {
      type: "text/csv;charset=utf-8;",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = nome;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }

  /* Init */
  montarGrid();
  setSelecao(
    Object.entries(colunas)
      .filter(([, c]) => c.default)
      .map(([k]) => k),
  );
})();