// Toggle para mostrar/ocultar filtros
document.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".filtros-toggle").addEventListener("click", () => {
    document.querySelector(".filtros").classList.toggle("mostrar");
  });
});
