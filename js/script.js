// Navegación responsive
const navSlide = () => {
  const burger = document.querySelector(".burger");
  const nav = document.querySelector(".nav-links");
  const navLinks = document.querySelectorAll(".nav-links li");

  burger.addEventListener("click", () => {
    nav.classList.toggle("nav-active");
    nav.classList.toggle("show");

    navLinks.forEach((link, index) => {
      if (link.style.animation) {
        link.style.animation = "";
      } else {
        link.style.animation = `navLinkFade 0.5s ease forwards ${
          index / 7 + 0.3
        }s`;
      }
    });

    burger.classList.toggle("toggle");
  });
};

navSlide();

// Inicialización del slider
const swiper = new Swiper(".swiper-container", {
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
  },
});

// Manejo de los formularios
const tabButtons = document.querySelectorAll(".tab-button");
const forms = document.querySelectorAll(".form");

tabButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const tabName = button.getAttribute("data-tab");

    tabButtons.forEach((btn) => btn.classList.remove("active"));
    forms.forEach((form) => form.classList.remove("active"));

    button.classList.add("active");
    document.getElementById(`${tabName}Form`).classList.add("active");
  });
});
const botonesCambioForm = document.querySelectorAll(".tab-button");

botonesCambioForm.forEach((boton) => {
  boton.addEventListener("click", () => {
    const tab = boton.getAttribute("data-tab");
    if (tab == "seguimiento") {
      // Muestra el formulario de seguimiento y oculta el de cotización
      document.getElementById("seguimientoForm").classList.add("active");
      document.getElementById("cotizarForm").classList.remove("active");

      // Limpia el resultado de cotización (si es necesario)
      document.getElementById("resultadoCotizacion").innerHTML = "";
    } else if (tab == "cotizar") {
      // Muestra el formulario de cotización y oculta el de seguimiento
      document.getElementById("cotizarForm").classList.add("active");
      document.getElementById("seguimientoForm").classList.remove("active");

      // Limpia el resultado de seguimiento (si es necesario)
      document.querySelector(".resultadosSeguimiento").innerHTML = "";
    }
  });
});
// Animación de las tarjetas de servicios
const serviceCards = document.querySelectorAll(".service-card");

const observerOptions = {
  threshold: 0.5,
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = 1;
      entry.target.style.transform = "translateY(0)";
    }
  });
}, observerOptions);

serviceCards.forEach((card) => {
  card.style.opacity = 0;
  card.style.transform = "translateY(50px)";
  card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
  observer.observe(card);
});

document.getElementById("cotizarForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevenir el recargo de la página

  document.getElementById("loadingGif").style.display = "block";
  // Crear un objeto FormData con los datos del formulario
  let formData = new FormData(this);

  // Hacer la solicitud AJAX
  fetch("./services/fetch_cotizar.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Obtener la respuesta como texto
    .then((data) => {
      document.getElementById("loadingGif").style.display = "none";
      // Mostrar el resultado en el div
      document.getElementById("resultadoCotizacion").innerHTML =
        '<i class="fa-solid fa-store" style="font-size: 100px; color: #FFF; display: block; margin-bottom: 10px;"></i>' +
        "ENVIO A SUCURSAL: $" +
        data.trim();
    })
    .catch((error) => {
      console.error("Error:", error);
    });
});

document
  .getElementById("seguimientoForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    fetch("./services/seguimiento.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        // Mostrar el resultado en el div
        const resultadosDiv = document.querySelector(".resultadosSeguimiento");
        if (resultadosDiv) {
          resultadosDiv.innerHTML = data;
        } else {
          console.error(
            "No se encontró un elemento con la clase 'resultadosSeguimiento'"
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
