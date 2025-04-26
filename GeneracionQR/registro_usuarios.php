<?php
include 'config.php';

// Verifica si se envió el formulario con POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashear la contraseña

    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('✅ datos guardados correctamente.');</script>";
    } else {
        echo "<script>alert('❌ Error al guardar: " . $stmt->error . "');</script>";
    }

    $stmt->close();
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
    
    <h1>Registro</h1>
            <div class="input-wrapper">
                <input type="text" id="username" name="username" placeholder="Usuario" required>
            </div>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button class="btn" type="submit">Guardar</button>
    </form>
    </div>
</body>
</html>