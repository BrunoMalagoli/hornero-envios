// Toggle para mostrar/ocultar filtros
document.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".filtros-toggle").addEventListener("click", () => {
    document.querySelector(".filtros").classList.toggle("mostrar");
  });
});

document.querySelectorAll(".eliminarEnvioEnSucursal").forEach((boton) => {
  boton.addEventListener("click", (e) => {
    fetch(
      "../services/eliminarEnvioEnSucursal.php?" +
        `delete=${e.currentTarget.value}`
    )
      .then((response) => {
        console.log(response);
        response.status === (200 || 201)
          ? (Swal.fire({
              title: "Registro eliminado correctamente",
              icon: "success",
            }),
            setTimeout(() => window.location.reload(), 2500))
          : Swal.fire({
              title: "Ocurrió un error!",
              text: "Por favor , intentalo otra vez.",
              icon: "error",
            });
      })
      .catch((err) => {
        console.log(err);
        Swal.fire({
          title: "Ocurrió un error!",
          text: `${err} `,
          icon: "error",
        });
      });
  });
});
