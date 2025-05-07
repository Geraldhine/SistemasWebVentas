<?php
include 'conexion.php';

$codigo_verificacion = $_POST['codigo_verificacion'];

// Función para validar entrada
function validar_entrada($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validar y sanitizar entrada
$codigo_verificacion = validar_entrada($codigo_verificacion);

$query = "SELECT * FROM usuarios_temp WHERE codigo_verificacion = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $codigo_verificacion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Mover usuario a la tabla principal
    $query = "INSERT INTO usuarios (nombre_usuario, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $user['nombre_usuario'], $user['email'], $user['password']);
    
    if ($stmt->execute()) {
        // Eliminar usuario de la tabla temporal
        $query = "DELETE FROM usuarios_temp WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();

        echo "<script>alert('Cuenta activada exitosamente. Ahora puede iniciar sesión.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error al activar la cuenta. Por favor, intente nuevamente.'); window.location.href='verificar_codigo.php';</script>";
    }
} else {
    echo "<script>alert('Código de verificación incorrecto.'); window.location.href='verificar_codigo.php';</script>";
}

$stmt->close();
$conn->close();
?>
