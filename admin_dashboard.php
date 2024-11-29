<?php
include 'verificar_sesion.php';
// Verificar el rol
if ($_SESSION['rol'] != 'admin') {
    echo "Acceso denegado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?> (Administrador)</h2>
        <p>Este es el panel de administración donde puedes gestionar usuarios, ver estadísticas, y más.</p>
        <!-- Agrega aquí las funcionalidades específicas para el administrador -->
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
    </div>
</body>
</html>
