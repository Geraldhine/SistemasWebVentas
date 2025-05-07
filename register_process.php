<?php
session_start();
include 'conexion.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$captcha = $_POST['captcha'];


// Verificar que las contraseñas coincidan
if ($password !== $password_repeat) {
    echo "<script>alert('Las contraseñas no coinciden. Por favor, intente nuevamente.'); window.location.href='register.php';</script>";
    exit();
}

// Función para validar entrada
function validar_entrada($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validar y sanitizar entrada
$name = validar_entrada($name);
$email = validar_entrada($email);
$password = validar_entrada($password);

// Verificar que el nombre no tenga más de 30 caracteres
if (strlen($name) > 30) {
    echo "<script>alert('El nombre no debe tener más de 30 caracteres.'); window.location.href='register.php';</script>";
    exit();
}


// Chequeo de completitud
if (empty($name) || empty($email) || empty($password)) {
    echo "<script>alert('Todos los campos son obligatorios.'); window.location.href='register.php';</script>";
    exit();
}

// Chequeo de validicidad (Formato del email)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Formato de correo electrónico inválido.'); window.location.href='register.php';</script>";
    exit();
}

// Chequeo de existencia (Verificar si el usuario ya está registrado)
$query = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Este correo electrónico ya está registrado.'); window.location.href='register.php';</script>";
    exit();
}

// Chequeo de limite y rango (Ejemplo: la contraseña debe tener entre 8 y 20 caracteres)
if (strlen($password) < 6 || strlen($password) > 20) {
    echo "<script>alert('La contraseña debe tener entre 8 y 20 caracteres.'); window.location.href='register.php';</script>";
    exit();
}

// Encriptar la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Generar código de activación
$codigo_activacion = rand(100000, 999999);

// Insertar el nuevo usuario en la tabla temporal
$query = "INSERT INTO usuarios_temp (nombre_usuario, email, password, codigo_verificacion) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $name, $email, $hashed_password, $codigo_activacion);

if ($stmt->execute()) {
    // Enviar el código de activación por correo
    $asunto = "Código de Activación";
    $mensaje = "Su código de activación es $codigo_activacion.";
    $cabeceras = "From: no-reply@tu-dominio.com";

    if (mail($email, $asunto, $mensaje, $cabeceras)) {
        echo "<script>alert('Registro exitoso. Por favor, verifique su correo para activar su cuenta.'); window.location.href='verificar_codigo.php';</script>";
    } else {
        echo "<script>alert('Error al enviar el correo. Por favor, intente nuevamente.'); window.location.href='register.php';</script>";
    }
} else {
    echo "<script>alert('Error en el registro. Por favor, intente nuevamente.'); window.location.href='register.php';</script>";
}

$stmt->close();
$conn->close();
?>
