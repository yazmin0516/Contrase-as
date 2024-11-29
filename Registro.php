<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
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
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
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

        .contrasena-generada {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            text-align: center;
            display: none;
        }

        .prompt-section {
            margin-top: 10px;
            display: none;
            color: #34495e;
        }

        .prompt-section label {
            font-weight: bold;
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

        .recomendaciones {
            color: #e74c3c;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="procesar_registro.php" method="POST">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" placeholder="Tu apellido">

            <label for="fecha_nacimiento">Fecha de Nacimiento (DDMMYYYY):</label>
            <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Ejemplo: 01011990">

            <label for="rol">Selecciona tu rol:</label>
            <select id="rol" name="rol" required>
                <option value="">--Selecciona un rol--</option>
                <option value="cliente">Cliente</option>
                <option value="agente">Agente</option>
                <option value="admin">Administrador</option>
            </select>

            <label for="contraseña">Contraseña:</label>
            <div class="input-container">
                <input type="password" id="contraseña" name="contraseña" required oninput="evaluarYMostrarRecomendaciones()">
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
            </div>
            <div id="recomendaciones" class="recomendaciones"></div>

            <button type="button" onclick="mostrarOpciones()">Configurar Contraseña</button>

            <div id="prompt-section" class="prompt-section">
                <label>Configuración de Contraseña:</label><br>
                Longitud (mínimo 8): <input type="number" id="longitud" min="8" value="12"><br>
                <input type="checkbox" id="mayusculas"> Mayúsculas
                <input type="checkbox" id="minusculas" checked> Minúsculas
                <input type="checkbox" id="numeros" checked> Números
                <input type="checkbox" id="especiales"> Caracteres especiales
                <input type="checkbox" id="diccionario"> Usar palabras del diccionario
                <button type="button" onclick="crearContrasena()">Generar Contraseña</button>
            </div>

            <div class="contrasena-generada" id="contrasena-generada">
                <h3>Contraseña Generada:</h3>
                <input type="text" id="contrasena-copy" readonly>
                <button type="button" onclick="copiarContraseña()">Copiar Contraseña</button>
            </div>

            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="Iniciodesecion.php">Inicia Sesión</a></p>
    </div>
</body>
</html>