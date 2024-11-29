const bancoDePalabras = [
    "sol", "luna", "estrella", "cielo", "mar", "montaña", "río", "bosque", "flor",
    "árbol", "nube", "viento", "fuego", "agua", "tierra", "catarata", "brisa", "noche",
    "día", "amanecer", "atardecer", "cascada", "lago", "isla", "valle", "desierto",
    "ciudad", "aldea", "puente", "sendero", "caminata", "rayo", "relámpago", "nieve",
    "lluvia", "tormenta", "huracán", "tornado", "calor", "frío", "templo", "castillo",
    "pirámide", "túnel", "puerta", "ventana", "silla", "mesa", "cama", "libro", "pájaro",
    "pez", "elefante", "tigre", "león", "gato", "perro", "serpiente", "cocodrilo", "jirafa", "mono"
];

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

    const patronesComunes = ["12345678", "password", "qwerty", "abc123"];
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

function evaluarYMostrarRecomendaciones() {
    const contrasena = document.getElementById('contraseña').value;
    const evaluacion = evaluarContrasena(contrasena);
    const recomendacionesEl = document.getElementById('recomendaciones');

    recomendacionesEl.innerHTML = `Nivel de Seguridad: ${evaluacion.nivel}. ${evaluacion.recomendaciones.join(' ')}`;
}

function mostrarOpciones() {
    const section = document.getElementById('prompt-section');
    const button = document.querySelector("button[onclick='mostrarOpciones()']");

    if (section.style.display === 'none' || section.style.display === '') {
        section.style.display = 'block';
        button.textContent = "Ocultar Opciones";
    } else {
        section.style.display = 'none';
        button.textContent = "Configurar Contraseña";
    }
}

function togglePassword() {
    const passwordInput = document.getElementById('contraseña');
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}

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
    const diccionario = document.getElementById('diccionario').checked;

    let caracteres = '';
    if (mayusculas) caracteres += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (minusculas) caracteres += 'abcdefghijklmnopqrstuvwxyz';
    if (numeros) caracteres += '0123456789';
    if (especiales) caracteres += '!@#$%^&*()-_=+[]{}|;:,.<>?';

    let contrasena = '';

    if (diccionario) {
        let numPalabras = Math.ceil(longitud / 5);
        for (let i = 0; i < numPalabras; i++) {
            const palabraAleatoria = bancoDePalabras[Math.floor(Math.random() * bancoDePalabras.length)];
            contrasena += palabraAleatoria;
            if (contrasena.length >= longitud) break;
        }
        contrasena = contrasena.slice(0, longitud);
    } else {
        if (caracteres === '') {
            alert('Selecciona al menos una opción.');
            return;
        }
        for (let i = 0; i < longitud; i++) {
            contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }
    }

    document.getElementById('contrasena-copy').value = contrasena;
    document.getElementById('contrasena-generada').style.display = 'block';
    document.getElementById('contraseña').value = contrasena;

    const evaluacion = evaluarContrasena(contrasena);
    document.getElementById('recomendaciones').innerText = `Nivel de Seguridad: ${evaluacion.nivel}. ${evaluacion.recomendaciones.join(' ')}`;
}

function copiarContraseña() {
    const contrasenaCopy = document.getElementById("contrasena-copy");
    contrasenaCopy.select();
    document.execCommand("copy");
    alert("Contraseña copiada al portapapeles");
}

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('contraseña').addEventListener('input', evaluarYMostrarRecomendaciones);
});