/* =========================================================
   SUPORTE - Casa da Criança (envio do formulário)
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("form-suporte");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Enviando...",
      text: "Por favor, aguarde.",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    const formData = new FormData(form);

    fetch("processa-email.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.includes("sucesso")) {
          Swal.fire({
            icon: "success",
            title: "Mensagem enviada!",
            text: "Nossa equipe responderá em breve.",
            confirmButtonColor: "#fcc404",
          });
          form.reset();
        } else {
          Swal.fire({
            icon: "error",
            title: "Ops!",
            text: "Ocorreu um problema ao enviar sua mensagem.",
            confirmButtonColor: "#fcc404",
          });
        }
      })
      .catch(() => {
        Swal.fire({
          icon: "error",
          title: "Sem conexão",
          text: "Não foi possível conectar ao servidor.",
          confirmButtonColor: "#fcc404",
        });
      });
  });
});
