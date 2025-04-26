<?php
include 'config.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $ownerName = $_POST['ownerName'];
    $computerID = $_POST['computerID'];
    $identificacion = $_POST['identificacion'];
    $cargo = $_POST['cargo'];
    $correo = $_POST['correo'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipoEquipo'];

    // Validar que los campos obligatorios no estén vacíos
    if (!empty($ownerName) && !empty($computerID)) {
        // Usar sentencia preparada para evitar inyecciones SQL
        $sql = "INSERT INTO info (NOMBRE_PERSONA, ID_COMPUTADOR, CORREO, CARGO, IDENTIFICACION, MARCA, TIPO_EQUIPO) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $ownerName, $computerID, $correo, $cargo, $identificacion, $marca, $tipo);

        if ($stmt->execute()) {
            // Redirigir a la página que genera el QR
            header("Location: qr_desde_base.php");
            exit();
        } else {
            echo "<script>alert('❌ Error al guardar los datos.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('⚠️ Por favor, complete los campos obligatorios.');</script>";
    }
}

$conn->close(); // Cerrar conexión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Códigos QR</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <form action="" method="post" id="formulario" class="formulario">
            <h1>Registro de Computadores</h1>
            <div class="input-wrapper">
                <input type="text" id="ownerName" name="ownerName" placeholder="Nombre completo de la persona" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="identificacion" name="identificacion" placeholder="identificacion" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="correo" name="correo" placeholder="Correo persona" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="cargo" name="cargo" placeholder="cargo" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="computerID" name="computerID" placeholder="ID del equipo" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="marca" name="marca" placeholder="marca" required>
            </div>
            <div class="input-wrapper">
                <input type="text" id="tipoEquipo" name="tipoEquipo" placeholder="Tipo equipo" required>
            </div>
            
            <button class="btn" type="submit">Guardar</button>
            <a href="qr_desde_base.php">Lista de computadores</a>
            <a href="registro_usuarios.php">Registro usuarios</a>
        </form>
        
        <div id="qrcode" class="qrcode">
        
        </div>
    </div>
</body>
</html>
