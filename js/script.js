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
