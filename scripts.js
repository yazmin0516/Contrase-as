function togglePassword(id) {
    const passwordInput = document.getElementById(id);
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}

// Función para mostrar/ocultar opciones de configuración de contraseña
function mostrarOpciones() {
    const section = document.getElementById('prompt-section');
    const button = document.querySelector("button[onclick='mostrarOpciones()']");

    // Alterna entre ocultar y mostrar
    if (section.style.display === 'none' || section.style.display === '') {
        section.style.display = 'block';
        button.textContent = "Ocultar Opciones";
    } else {
        section.style.display = 'none';
        button.textContent = "Configurar Contraseña";
    }
}

// Función para evaluar la contraseña
function evaluarContrasena(contrasena) {
    let puntuacion = 0;
    const recomendaciones = [];

    if (contrasena.length >= 12) {
        puntuacion += 2;
    } else if (contrasena.length >= 8) {
        puntuacion += 1;
    } else {
        recomendaciones.push("La contraseña debe tener al menos 8 caracteres.");
    }

    const tieneMayusculas = /[A-Z]/.test(contrasena);
    const tieneMinusculas = /[a-z]/.test(contrasena);
    const tieneNumeros = /\d/.test(contrasena);
    const tieneEspeciales = /[!@#$%^&*(),.?":{}|<>]/.test(contrasena);

    if (tieneMayusculas) puntuacion++;
    if (tieneMinusculas) puntuacion++;
    if (tieneNumeros) puntuacion++;
    if (tieneEspeciales) puntuacion++;

    const patronesComunes = ["123456", "password", "qwerty", "abc123"];
    if (patronesComunes.some(patron => contrasena.includes(patron))) {
        recomendaciones.push("Evita utilizar contraseñas comunes o patrones fáciles de adivinar.");
    }

    let nivel;
    if (puntuacion <= 2) {
        nivel = "Baja";
    } else if (puntuacion <= 4) {
        nivel = "Media";
    } else {
        nivel = "Alta";
    }

    return { nivel, recomendaciones };
}

// Función para generar la contraseña
function crearContrasena() {
    const longitud = parseInt(document.getElementById('longitud').value);
    if (longitud < 8) {
        alert("La longitud debe ser igual o mayor a 8.");
        return;
    }

    const mayusculas = document.getElementById('mayusculas').checked;
    const minusculas = document.getElementById('minusculas').checked;
    const numeros = document.getElementById('numeros').checked;
    const especiales = document.getElementById('especiales').checked;

    let caracteres = '';
    if (mayusculas) caracteres += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (minusculas) caracteres += 'abcdefghijklmnopqrstuvwxyz';
    if (numeros) caracteres += '0123456789';
    if (especiales) caracteres += '!@#$%^&*()-_=+[]{}|;:,.<>?';

    if (caracteres === '') {
        alert('Selecciona al menos una opción.');
        return;
    }

    let contrasena = '';
    for (let i = 0; i < longitud; i++) {
        contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }

    document.getElementById('nueva_contraseña').value = contrasena;
    document.getElementById('contrasena-copy').value = contrasena;
    document.getElementById('contrasena-generada').style.display = 'block';
    document.getElementById('enviar-correo').style.display = 'block';

    // Evaluar la contraseña generada
    const evaluacion = evaluarContrasena(contrasena);
    document.getElementById('resultado-evaluacion').innerText = `Nivel de Seguridad: ${evaluacion.nivel}`;
    document.getElementById('recomendaciones').innerText = evaluacion.recomendaciones.join(' ');
}

// Función para enviar la contraseña por correo
function enviarContrasenaPorCorreo() {
    const email = prompt("Por favor ingresa tu dirección de correo electrónico:");
    const contrasena = document.getElementById('nueva_contraseña').value;
    if (!email) {
        alert("No se ha proporcionado un correo electrónico.");
        return;
    }

    // Enviar solicitud al servidor para enviar el correo
    fetch('enviar_contrasena.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email, contrasena: contrasena })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Contraseña enviada a " + email);
        } else {
            alert("Hubo un problema al enviar el correo.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error al enviar el correo.");
    });
}