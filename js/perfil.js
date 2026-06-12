/* =========================================================
   PERFIL - Casa da Criança (interações)
   Modais + SweetAlert2 caprichado e acolhedor
   ========================================================= */

// Abre um modal pelo id (com travamento do scroll do fundo)
function abrirModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add("aberto");
    document.body.classList.add("modal-travado");
  }
}

// Fecha um modal pelo id
function fecharModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove("aberto");
    document.body.classList.remove("modal-travado");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Fecha o modal ao clicar fora do conteúdo
  document.querySelectorAll(".modal-perfil").forEach(function (modal) {
    modal.addEventListener("click", function (e) {
      if (e.target === modal) fecharModal(modal.id);
    });
  });

  // Fecha com a tecla ESC
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document.querySelectorAll(".modal-perfil.aberto").forEach(function (m) {
        fecharModal(m.id);
      });
    }
  });

  // Alerta de sucesso após editar o perfil (?atualizado=1)
  if (window.PERFIL_ATUALIZADO && typeof Swal !== "undefined") {
    Swal.fire({
      title: "Tudo certo! 🎉",
      text: "Seus dados foram salvos com sucesso.",
      icon: "success",
      confirmButtonText: "Que ótimo!",
      buttonsStyling: false,
      customClass: {
        popup: "swal-fofo",
        title: "swal-fofo-titulo",
        htmlContainer: "swal-fofo-texto",
        confirmButton: "swal-fofo-confirmar",
        icon: "swal-fofo-icone",
      },
    });
    // Limpa o parâmetro da URL
    history.replaceState(null, "", window.location.pathname);
  }

  // Confirmação amigável e caprichada antes de excluir a conta
  const btnExcluir = document.getElementById("btnExcluir");
  if (btnExcluir && typeof Swal !== "undefined") {
    btnExcluir.addEventListener("click", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Tem certeza?",
        html:
          "<p>Você está prestes a <b>excluir sua conta</b>.</p>" +
          "<p class='swal-fofo-aviso'>Todos os seus dados de acesso serão apagados para sempre e não dá pra voltar atrás.</p>",
        iconHtml: '<i class="fa-solid fa-heart-crack"></i>',
        showCancelButton: true,
        reverseButtons: true,
        focusCancel: true,
        confirmButtonText: "Sim, excluir minha conta",
        cancelButtonText: "Não, quero ficar",
        buttonsStyling: false,
        customClass: {
          popup: "swal-fofo",
          title: "swal-fofo-titulo",
          htmlContainer: "swal-fofo-texto",
          icon: "swal-fofo-icone swal-fofo-icone-perigo",
          confirmButton: "swal-fofo-excluir",
          cancelButton: "swal-fofo-cancelar",
        },
      }).then(function (resultado) {
        if (resultado.isConfirmed) {
          Swal.fire({
            title: "Excluindo...",
            text: "Só um instante 💛",
            allowOutsideClick: false,
            didOpen: function () {
              Swal.showLoading();
            },
            customClass: { popup: "swal-fofo", title: "swal-fofo-titulo" },
          });
          window.location.href = btnExcluir.getAttribute("href");
        }
      });
    });
  }
});
