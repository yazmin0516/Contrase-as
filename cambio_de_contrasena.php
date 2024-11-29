<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #34495e;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 16px;
        }

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

        button:hover {
            background-color: #2c3e50;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #2c3e50;
        }

        .error {
            color: #e74c3c;
        }

        .success {
            color: #2ecc71;
        }

        .input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #7f8c8d;
        }

        .password-toggle:hover {
            color: #2c3e50;
        }

        .prompt-section {
            margin-top: 10px;
            display: none;
            color: #34495e;
        }

        .prompt-section label {
            font-weight: bold;
        }

        p {
            text-align: center;
            margin-top: 15px;
            color: #7f8c8d;
        }

        a {
            color: #1f9fea;
            text-decoration: none;
        }

        .contrasena-generada {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            text-align: center;
            display: none;
        }
    </style>
    <script src="scripts.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Cambiar Contraseña</h2>
        <form action="cambiar_contrasena.php" method="POST">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>

            <label for="contraseña_actual">Contraseña Actual:</label>
            <div class="input-container">
                <input type="password" id="contraseña_actual" name="contraseña_actual" required>
                <span class="password-toggle" onclick="togglePassword('contraseña_actual')">👁️</span>
            </div>

            <label for="nueva_contraseña">Nueva Contraseña:</label>
            <div class="input-container">
                <input type="password" id="nueva_contraseña" name="nueva_contraseña" required>
                <span class="password-toggle" onclick="togglePassword('nueva_contraseña')">👁️</span>
            </div>

            <button type="button" onclick="mostrarOpciones()">Configurar Contraseña</button>

            <div id="prompt-section" class="prompt-section">
                <label>Configuración de Contraseña:</label><br>
                Longitud (mínimo 8): <input type="number" id="longitud" min="8" value="12"><br>
                <input type="checkbox" id="mayusculas"> Mayúsculas
                <input type="checkbox" id="minusculas" checked> Minúsculas
                <input type="checkbox" id="numeros" checked> Números
                <input type="checkbox" id="especiales"> Caracteres especiales
                <button type="button" onclick="crearContrasena()">Generar Contraseña</button>
            </div>

            <div class="contrasena-generada" id="contrasena-generada">
                <h3>Contraseña Generada:</h3>
                <input type="text" id="contrasena-copy" readonly>
            </div>

            <!-- Agregar aquí los elementos para mostrar la evaluación de la contraseña -->
            <div id="resultado-evaluacion" style="margin-top: 10px; color: #2c3e50;"></div>
            <div id="recomendaciones" style="color: #e74c3c; margin-top: 5px;"></div>

            <button id="enviar-correo" type="button" style="display: none;" onclick="enviarContrasenaPorCorreo()">Enviar Contraseña a Correo</button>

            <button type="submit">Actualizar Contraseña</button>
        </form>
        <p>Regresar <a href="Iniciodesecion.php">Inicio de Seción</a></p>

        <div class="message">

            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']);
            }
            if (isset($_SESSION['success_message'])) {
                echo "<p class='success'>" . $_SESSION['success_message'] . "</p>";
                unset($_SESSION['success_message']);
            }
            ?>

        </div>
    </div>
</body>
</html>