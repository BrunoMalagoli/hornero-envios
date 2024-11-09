document.querySelectorAll('input[name="rol"]').forEach((elem) => {
  elem.addEventListener("change", function (event) {
    var sucursalGroup = document.getElementById("sucursal-group");
    sucursalGroup.style.display =
      event.target.value === "u-suc" ? "block" : "none";
  });
});

document.querySelectorAll('input[name="rol"]').forEach((elem) => {
  elem.addEventListener("change", function (event) {
    var sucursalGroup = document.getElementById("centro-g");
    sucursalGroup.style.display =
      event.target.value === "sucursal" ? "block" : "none";
  });
});

document.querySelectorAll('input[name="rols"]').forEach((elem) => {
  elem.addEventListener("change", function (event) {
    var sucursalGroup = document.getElementById("sucursal-g");
    sucursalGroup.style.display =
      event.target.value === "u-suc" ? "block" : "none";
  });
});

// Manejar el envío del formulario de usuario
document.getElementById("user-form").addEventListener("submit", function (e) {
  var rolSeleccionado = document.querySelector('input[name="rol"]:checked');
  var sucursalSelect = document.getElementById("sucursal");

  if (!rolSeleccionado) {
    e.preventDefault();
    alert("Por favor, selecciona un rol.");
  } else if (rolSeleccionado.value === "u-suc" && sucursalSelect.value === "") {
    e.preventDefault();
    alert(
      "Por favor, selecciona una sucursal para usuarios no administradores."
    );
  } else {
    alert("Formulario de usuario enviado");
  }
});

// Manejar el envío del formulario de sucursal
document.getElementById("branch-form").addEventListener("submit", function (e) {
  alert("Formulario de sucursal enviado");
});

function editSucursal(id, nombre, calle, numero, localidad, cp, telefono) {
  document.getElementById("edit-sucursal-id").value = id;
  document.getElementById("edit-nombre-sucursal").value = nombre;
  document.getElementById("edit-calle").value = calle;
  document.getElementById("edit-numero").value = numero;
  document.getElementById("edit-localidad").value = localidad;
  document.getElementById("edit-codigo-postal").value = cp;
  document.getElementById("edit-telefono").value = telefono;
  document.getElementById("edit-branch-form").style.display = "block";
}

function cancelEdit() {
  document.getElementById("edit-branch-form").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  const rolRadios = document.querySelectorAll('input[name="rol"]');
  const centroGroup = document.getElementById("centro-group");

  rolRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      if (this.value === "sucursal") {
        centroGroup.style.display = "block";
      } else {
        centroGroup.style.display = "none";
      }
    });
  });
});

function editarUsuario(id, nombre, email) {
  document.getElementById("edit-user-form").style.display = "block";
  document.getElementById("usuarioId").value = id;
  document.getElementById("edit-nombre").value = nombre;
  document.getElementById("edit-email").value = email;
}

function cancelEditUser() {
  document.getElementById("edit-user-form").style.display = "none";
}

/*

document.querySelectorAll('input[name="rol"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        var sucursalGroup = document.getElementById("sucursal-group");
        sucursalGroup.style.display = event.target.value === "u-suc" ? "block" : "none";
    });
});

document.querySelectorAll('input[name="rols"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        var sucursalGroup = document.getElementById("sucursal-g");
        sucursalGroup.style.display = event.target.value === "u-suc" ? "block" : "none";
    });
});


// Manejar el envío del formulario de usuario
    document.getElementById("user-form").addEventListener("submit", function(e) {
    var rolSeleccionado = document.querySelector('input[name="rol"]:checked');
    var sucursalSelect = document.getElementById("sucursal");

    if (!rolSeleccionado) {
        e.preventDefault();
        alert("Por favor, selecciona un rol.");
    } else if (rolSeleccionado.value === "u-suc" && sucursalSelect.value === "") {
        e.preventDefault();
        alert("Por favor, selecciona una sucursal para usuarios no administradores.");
    } else {
        alert("Formulario de usuario enviado");
    }
});

// Manejar el envío del formulario de sucursal
document.getElementById("branch-form").addEventListener("submit", function(e) {
    alert("Formulario de sucursal enviado");
});


function editSucursal(id, nombre, calle, numero, localidad, cp, telefono) {
    document.getElementById("edit-sucursal-id").value = id;
    document.getElementById("edit-nombre-sucursal").value = nombre;
    document.getElementById("edit-calle").value = calle;
    document.getElementById("edit-numero").value = numero;
    document.getElementById("edit-localidad").value = localidad;
    document.getElementById("edit-codigo-postal").value = cp;
    document.getElementById("edit-telefono").value = telefono;
    document.getElementById("edit-branch-form").style.display = "block";
}

function cancelEdit() {
document.getElementById("edit-branch-form").style.display = "none";
}

document.addEventListener('DOMContentLoaded', function() {
    const rolRadios = document.querySelectorAll('input[name="rol"]');
    const centroGroup = document.getElementById('centro-group');

    rolRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'sucursal') {
                centroGroup.style.display = 'block';
            } else {
                centroGroup.style.display = 'none';
            }
        });
    });
});


function editarUsuario(id, nombre, email, rol, sucursalId) {
    document.getElementById("edit-user-form").style.display = "block";
    document.getElementById("usuarioId").value = id;
    document.getElementById("edit-nombre").value = nombre;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-rol").value = rol;
    document.getElementById("edit-sucursal").value = sucursalId;
}

function cancelEditUser() {
    document.getElementById("edit-user-form").style.display = 'none';
}




























document.querySelectorAll('input[name="rol"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        var sucursalGroup = document.getElementById("sucursal-group");
        sucursalGroup.style.display = event.target.value === "u-suc" ? "block" : "none";
    });
});

document.querySelectorAll('input[name="rol"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        var sucursalGroup = document.getElementById("centro-g");
        sucursalGroup.style.display = event.target.value === "sucursal" ? "block" : "none";
    });
});

document.querySelectorAll('input[name="rols"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        var sucursalGroup = document.getElementById("sucursal-g");
        sucursalGroup.style.display = event.target.value === "u-suc" ? "block" : "none";
    });
});


// Manejar el envío del formulario de usuario
    document.getElementById("user-form").addEventListener("submit", function(e) {
    var rolSeleccionado = document.querySelector('input[name="rol"]:checked');
    var sucursalSelect = document.getElementById("sucursal");

    if (!rolSeleccionado) {
        e.preventDefault();
        alert("Por favor, selecciona un rol.");
    } else if (rolSeleccionado.value === "u-suc" && sucursalSelect.value === "") {
        e.preventDefault();
        alert("Por favor, selecciona una sucursal para usuarios no administradores.");
    } else {
        alert("Formulario de usuario enviado");
    }
});

// Manejar el envío del formulario de sucursal
document.getElementById("branch-form").addEventListener("submit", function(e) {
    alert("Formulario de sucursal enviado");
});


function editSucursal(id, nombre, calle, numero, localidad, cp, telefono) {
    document.getElementById("edit-sucursal-id").value = id;
    document.getElementById("edit-nombre-sucursal").value = nombre;
    document.getElementById("edit-calle").value = calle;
    document.getElementById("edit-numero").value = numero;
    document.getElementById("edit-localidad").value = localidad;
    document.getElementById("edit-codigo-postal").value = cp;
    document.getElementById("edit-telefono").value = telefono;
    document.getElementById("edit-branch-form").style.display = "block";
}

function cancelEdit() {
document.getElementById("edit-branch-form").style.display = "none";
}

document.addEventListener('DOMContentLoaded', function() {
    const rolRadios = document.querySelectorAll('input[name="rol"]');
    const centroGroup = document.getElementById('centro-group');

    rolRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'sucursal') {
                centroGroup.style.display = 'block';
            } else {
                centroGroup.style.display = 'none';
            }
        });
    });
});


function editarUsuario(id, nombre, email) {
    document.getElementById("edit-user-form").style.display = "block";
    document.getElementById("usuarioId").value = id;
    document.getElementById("edit-nombre").value = nombre;
    document.getElementById("edit-email").value = email;
  
}

function cancelEditUser() {
    document.getElementById("edit-user-form").style.display = 'none';
}

*/
