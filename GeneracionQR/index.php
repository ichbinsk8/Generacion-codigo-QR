<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['username'];
            header("Location: registro_equipos.php"); // Página protegida
            exit;
        } else {
            echo "<script>alert('❌ Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('❌ Usuario no encontrado.');</script>";
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login QR</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
    <form action="" method="post" class="formulario">
    
    <h1>Ingreso</h1>
            <div class="input-wrapper">
                <input type="text" id="username" name="username" placeholder="Usuario" required>
            </div>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button class="btn" type="submit">Iniciar sesión</button>
    </form>
    </div>
</body>
</html>