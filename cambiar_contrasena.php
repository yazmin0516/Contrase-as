<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Configuración para reportar todos los errores y mostrarlos
error_reporting(E_ALL);
ini_set('display_errors', 1); // Mostrar errores (útil para desarrollo, evitar en producción)

// Definir el costo de bcrypt para el hashing de contraseñas
define('BCRYPT_COST', 12); // Ajusta el costo según lo necesites para balancear seguridad y rendimiento

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

// Obtener datos del formulario y sanitizar para prevenir inyecciones SQL
$nombre_usuario = mysqli_real_escape_string($conn, $_POST['nombre_usuario']);
$contraseña_actual = mysqli_real_escape_string($conn, $_POST['contraseña_actual']);
$nueva_contraseña = mysqli_real_escape_string($conn, $_POST['nueva_contraseña']);

// Verificar si el usuario existe y obtener la contraseña actual almacenada
$stmt = $conn->prepare("SELECT id, contraseña FROM usuarios WHERE nombre_usuario = ?");
$stmt->bind_param("s", $nombre_usuario); // Vincula el parámetro del nombre de usuario
$stmt->execute();
$stmt->bind_result($usuario_id, $hashed_password); // Vincula las variables con los resultados
$stmt->fetch(); // Recupera los valores
$stmt->close();

// Si no se encuentra el usuario
if (!$usuario_id) {
    $_SESSION['error_message'] = "El nombre de usuario no existe.";
    header("Location: cambio_de_contrasena.php"); // Redirige al formulario de cambio de contraseña
    exit(); // Termina la ejecución del script
} elseif (!password_verify($contraseña_actual, $hashed_password)) {
    // Si el nombre de usuario es correcto pero la contraseña actual es incorrecta
    $_SESSION['error_message'] = "La contraseña actual es incorrecta.";
    header("Location: cambio_de_contrasena.php"); // Redirige al formulario de cambio de contraseña
    exit(); // Termina la ejecución del script
} else {
    // Hashear la nueva contraseña con bcrypt y actualizarla en la base de datos
    $nueva_contraseña_hashed = password_hash($nueva_contraseña, PASSWORD_BCRYPT, ['cost' => BCRYPT_COST]);

    // Preparar la sentencia para actualizar la contraseña
    $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
    $stmt->bind_param("si", $nueva_contraseña_hashed, $usuario_id); // Vincula los parámetros

    if ($stmt->execute()) {
        // Si la actualización es exitosa
        $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
        header("Location: Iniciodesecion.php"); // Redirige a la página de inicio de sesión
        exit(); // Termina la ejecución del script
    } else {
        // Si hay un error al actualizar la contraseña
        $_SESSION['error_message'] = "Error al actualizar la contraseña.";
        header("Location: cambio_de_contrasena.php"); // Redirige al formulario de cambio de contraseña
        exit(); // Termina la ejecución del script
    }

    $stmt->close(); // Cierra la declaración
}

$conn->close(); // Cierra la conexión a la base de datos
?>