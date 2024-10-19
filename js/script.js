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
  // Crear un objeto FormData con los datos del formulario
  let formData = new FormData(this);

  // Hacer la solicitud AJAX
  fetch("./services/cotizar.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Obtener la respuesta como texto
    .then((data) => {
      // Mostrar el resultado en el div
      document.getElementById("resultadoCotizacion").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
});

// document.getElementById("seguimientoForm").addEventListener("submit", (e) => {
//   e.preventDefault();
//   alert("Rastreando envío. "); // Aquí podrías implementar la lógica real de rastreo
// });

// document.getElementById("contactForm").addEventListener("submit", (e) => {
//   e.preventDefault();
//   alert("Mensaje enviado. Gracias por contactarnos.");
// });
