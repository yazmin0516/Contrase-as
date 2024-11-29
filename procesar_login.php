<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Configuración para reportar todos los errores y mostrarlos
error_reporting(E_ALL);
ini_set('display_errors', 1); // Mostrar errores (útil para desarrollo, evitar en producción)

// Conectar a la base de datos
$servername = "localhost"; // Nombre del servidor de la base de datos
$username_db = "root"; // Nombre de usuario de la base de datos
$password_db = ""; // Contraseña de la base de datos
$dbname = "sistema_autenticacion"; // Nombre de la base de datos

// Crear una conexión a MySQL
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Termina el script si la conexión falla
}

// Obtener y sanitizar los datos del formulario para prevenir inyecciones SQL
$nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']); // Sanitiza el nombre de usuario
$contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']); // Sanitiza la contraseña

// Preparar la sentencia SQL para prevenir inyecciones SQL
$stmt = $conn->prepare("SELECT id, contraseña, rol FROM usuarios WHERE nombre_usuario = ?");
$stmt->bind_param("s", $nombre_usuario); // Vincula el parámetro del nombre de usuario
$stmt->execute();
$stmt->store_result(); // Almacena el resultado

// Verificar si el usuario existe
if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashed_password, $rol); // Vincula las variables con los resultados
    $stmt->fetch(); // Recupera los valores

    // Verificar la contraseña usando password_verify para comparar con el hash
    if (password_verify($contraseña, $hashed_password)) {
        // Almacenar datos del usuario en la sesión
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['rol'] = $rol;

        // Redireccionar al panel correspondiente según el rol del usuario
        if ($rol == 'admin') {
            header("Location: admin_dashboard.php"); // Redirige al panel de administrador
        } elseif ($rol == 'agente') {
            header("Location: agente_dashboard.php"); // Redirige al panel de agente
        } else {
            header("Location: cliente_dashboard.php"); // Redirige al panel de cliente
        }
        exit(); // Termina el script después de la redirección
    } else {
        // Si la contraseña es incorrecta
        $_SESSION['error_message'] = "Contraseña incorrecta. <a href='iniciodesecion.php'>Intenta de nuevo</a>";
        header("Location: iniciodesecion.php"); // Redirige a la página de inicio de sesión
        exit();
    }
} else {
    // Si el usuario no es encontrado
    $_SESSION['error_message'] = "El usuario no existe. <a href='iniciodesecion.php'>Intenta de nuevo</a>";
    header("Location: iniciodesecion.php"); // Redirige a la página de inicio de sesión
    exit();
}

// Cerrar la declaración y la conexión a la base de datos
$stmt->close();
$conn->close();
?>