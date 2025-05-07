<?php
session_start();
include 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Función para validar entrada
function validar_entrada($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validar y sanitizar entrada
$email = validar_entrada($email);
$password = validar_entrada($password);

$query = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['doble_factor'] = $user['doble_factor'];
        
        if ($user['doble_factor']) {
            // Generar el código de verificación
            $codigo_verificacion = rand(100000, 999999);

            // Guardar el código de verificación en la base de datos
            $query = "UPDATE usuarios SET codigo_verificacion = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            
            if ($stmt === false) {
                die("Error en la preparación de la declaración: " . $conn->error);
            }

            $stmt->bind_param("si", $codigo_verificacion, $user['id']);
            $stmt->execute();
            
            // Enviar el código de verificación por correo
            $asunto = "Código de Verificación";
            $mensaje = "Su código de verificación es $codigo_verificacion.";
            $cabeceras = "From: no-reply@tu-dominio.com";

            if (mail($user['email'], $asunto, $mensaje, $cabeceras)) {
                echo "<script>alert('Código de verificación enviado. Por favor, revise su correo.'); window.location.href='verificar_codigo_doble_factor.php';</script>";
            } else {
                echo "<script>alert('Error al enviar el correo. Por favor, intente nuevamente.'); window.location.href='login.php';</script>";
            }
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='login.php';</script>";
}

$stmt->close();
$conn->close();
?>
