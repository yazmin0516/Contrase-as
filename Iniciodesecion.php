<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Comprueba si hay un mensaje de error almacenado en la sesión
if (isset($_SESSION['error_message'])) {
    // Si hay un mensaje de error, lo muestra en color rojo
    echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
    // Elimina el mensaje de error de la sesión después de mostrarlo
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <style>
        /* Estilos generales para el cuerpo de la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Estilo del contenedor del formulario */
        .container {
            width: 350px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilos para el título del formulario */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        /* Estilos para las etiquetas de los campos */
        label {
            display: block;
            margin-top: 10px;
            color: #34495e;
        }
        
        /* Posicionamiento relativo del contenedor de entrada */
        .input-container {
            position: relative;
            margin-top: 5px;
        }

        /* Estilos para los campos de texto y contraseña */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            padding-right: 40px; /* Espacio para el ícono de visibilidad de contraseña */
            box-sizing: border-box;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
        }
        
        /* Estilo para el botón de envío */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #1f9fea;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        /* Cambia el color del botón al pasar el ratón */
        button:hover {
            background-color: #2c3e50;
        }
        
        /* Estilos para los párrafos de información */
        p {
            text-align: center;
            margin-top: 15px;
            color: #7f8c8d;
        }
        
        /* Estilos para los enlaces */
        a {
            color: #1f9fea;
            text-decoration: none;
        }
        
        /* Subraya el enlace al pasar el ratón */
        a:hover {
            text-decoration: underline;
        }

        /* Estilo para el icono de alternar visibilidad de contraseña */
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            font-size: 18px;
            color: #7f8c8d;
        }

        /* Cambia el color del icono al pasar el ratón */
        .password-toggle:hover {
            color: #2c3e50;
        }
    </style>
    <script>
        // Función para alternar la visibilidad de la contraseña
        function togglePassword() {
            var contraseña = document.getElementById("contraseña");
            var icono = document.getElementById("toggle-icon");
            // Cambia el tipo de entrada entre "password" y "text"
            if (contraseña.type === "password") {
                contraseña.type = "text";
                icono.textContent = "🙈"; // Ícono cuando la contraseña está visible
            } else {
                contraseña.type = "password";
                icono.textContent = "👁️"; // Ícono cuando la contraseña está oculta
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Inicio de Sesión</h2>
        <!-- Formulario de inicio de sesión -->
        <form action="procesar_login.php" method="POST">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>
    
            <label for="contraseña">Contraseña:</label>
            <div class="input-container">
                <input type="password" id="contraseña" name="contraseña" required>
                <!-- Ícono para alternar visibilidad de la contraseña -->
                <span class="password-toggle" id="toggle-icon" onclick="togglePassword()">👁️</span>
            </div>
    
            <button type="submit">Ingresar</button>
        </form>
        <!-- Enlaces para registrarse o cambiar contraseña -->
        <p>¿No tienes una cuenta? <a href="Registro.php">Regístrate</a></p>
        <p>¿Quieres cambiar tu contraseña? <a href="cambio_de_contrasena.php">Cambiar Contraseña</a></p>
    </div>
</body>
</html>