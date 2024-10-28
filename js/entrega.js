document.querySelectorAll(".entregaEnvio").forEach((boton) => {
  boton.addEventListener("click", (e) => {
    console.log(e.currentTarget.value);
    fetch(
      "../services/entregarEnvio.php?" + `cod_entrega=${e.currentTarget.value}`
    ).catch((err) => {
      console.log(err);
      Swal.fire({
        title: "Ocurrió un error!",
        text: `${err} `,
        icon: "error",
      });
    });
  });
});
