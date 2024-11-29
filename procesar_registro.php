<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Configuración para reportar errores
error_reporting(E_ALL);
ini_set('display_errors', 0); // En producción, no mostrar errores detallados para evitar exponer información sensible.

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

// Obtener y sanitizar los datos del formulario
$nombre_usuario = trim($_POST['nombre_usuario']); // Elimina espacios en blanco del inicio y final del nombre de usuario
$email = trim($_POST['email']); // Elimina espacios en blanco del email
$contraseña = trim($_POST['contraseña']); // Elimina espacios en blanco de la contraseña
$rol = $_POST['rol']; // Obtiene el rol seleccionado

// Validar campos
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Valida el formato del correo electrónico
    $_SESSION['error_message'] = "El correo electrónico no es válido.";
    header("Location: Registro.php"); // Redirige al formulario de registro
    exit(); // Detiene la ejecución del script
}

if (strlen($contraseña) < 8) {
    // Comprueba que la contraseña tenga al menos 8 caracteres
    $_SESSION['error_message'] = "La contraseña debe tener al menos 8 caracteres.";
    header("Location: Registro.php");
    exit();
}

$roles_validos = ['admin', 'agente', 'cliente']; // Lista de roles válidos
if (!in_array($rol, $roles_validos)) {
    // Verifica que el rol sea uno de los válidos
    $_SESSION['error_message'] = "Rol seleccionado no válido.";
    header("Location: Registro.php");
    exit();
}

// Verificar si el usuario o email ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario=? OR email=?");
$stmt->bind_param("ss", $nombre_usuario, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si el nombre de usuario o el correo electrónico ya están registrados
    $_SESSION['error_message'] = "El nombre de usuario o correo electrónico ya existe.";
    header("Location: Registro.php");
    exit();
} else {
    // Generar hash seguro con bcrypt para la contraseña
    $contraseña_hashed = password_hash($contraseña, PASSWORD_BCRYPT, ['cost' => 12]);

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, contraseña, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre_usuario, $email, $contraseña_hashed, $rol);

    if ($stmt->execute()) {
        // Si la inserción es exitosa
        $_SESSION['success_message'] = "Registro exitoso. ¡Ahora puedes iniciar sesión!";
    } else {
        // Si hay un error al registrar al usuario
        $_SESSION['error_message'] = "Error al registrar el usuario.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();

// Redirige al formulario de registro tras intentar registrar al usuario
header("Location: Registro.php");
exit(); // Detiene la ejecución del script
?>