document.querySelectorAll(".entregaEnvio").forEach((boton) => {
  boton.addEventListener("click", async (e) => {
    const codEntrega = e.currentTarget.value;
    try {
      const response = await fetch(
        `../services/entregarEnvio.php?cod_entrega=${codEntrega}`
      );

      // Verifica si la consulta fue exitosa
      if (response.ok) {
        const etiquetaUrl = `../pages/comprobante.php?cod_entrega=${encodeURIComponent(
          codEntrega
        )}`;
        window.open(etiquetaUrl, "_blank"); // Abre la nueva ventana/pestaña
        window.location.reload();
      } else {
        throw new Error("Error en la entrega del envío");
      }
    } catch (err) {
      console.log(err);
      Swal.fire({
        title: "Ocurrió un error!",
        text: `${err}`,
        icon: "error",
      });
    }
  });
});
