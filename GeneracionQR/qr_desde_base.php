<?php
// Incluir la librería para generar el código QR
include 'phpqrcode/qrlib.php';
include 'config.php';

// Consultar la última fila registrada en la tabla 'info'
$sql = "SELECT ID, NOMBRE_PERSONA FROM info ORDER BY ID DESC LIMIT 1";
$result = $conn->query($sql);

$tituloQR = '';
$imagenQR = '';

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastId = $row['ID'];
    $data = $row['NOMBRE_PERSONA'];

    // URL que irá dentro del QR
    $qr_url = "http://192.168.33.60/GeneracionQR/computador.php?id=" . $lastId;

    // Carpeta de destino del código QR
    $folder = 'qr/';
    $filename = $folder . 'qr_' . $lastId . '.png';

    // Generar el código QR
    QRcode::png($qr_url, $filename);

    if (file_exists($filename)) {
        // Mostrar el título e imagen del QR
        $tituloQR = "<h1>Código QR Generado:</h1>";
        $imagenQR = "<img src='$filename' alt='Código QR'>";

        // Guardar la ruta del QR en la base de datos
        $rutaQR = $filename;
        $update_sql = "UPDATE info SET QR = ? WHERE ID = ?";
        $stmt = $conn->prepare($update_sql);
        
        if ($stmt) {
            $stmt->bind_param("si", $rutaQR, $lastId);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "<script>alert('Error al preparar la consulta para guardar la ruta del QR.');</script>";
        }
    } else {
        echo "<script>alert('No se pudo generar el código QR. Verifique permisos en la carpeta qr/');</script>";
    }
} else {
    echo "<script>alert('No se encontró ningún dato para generar el código QR.');</script>";
}

// Consultar todos los registros
$sql = "SELECT * FROM info";
$result = $conn->query($sql);

// Cerrar conexión
$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Registros</title>
    <link rel="stylesheet" href="css/style_qr_desde.css">
 </head>
<body>
<div class="main-wrapper"> <!-- NUEVO CONTENEDOR PARA FLEX -->
        <div class="qr-section">
            <?php
            echo $tituloQR;
            echo $imagenQR;
            ?>
        </div>
    <div class="container">
    <h2>Registros de la Base de Datos</h1>

    <!-- Mostrar la tabla con los registros -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Propietario</th>
                <th>ID del Computador</th>
                <th>Marca</th>
                <th>Tipo equipo</th>
                <th>Código QR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Si existen registros, mostrar cada uno en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['NOMBRE_PERSONA'] . "</td>";
                    echo "<td>" . $row['ID_COMPUTADOR'] . "</td>";
                    echo "<td>" . $row['MARCA'] . "</td>";
                    echo "<td>" . $row['TIPO_EQUIPO'] . "</td>";
                    // Mostrar el QR si tiene la ruta almacenada
                    echo "<td><img src='" . $row['QR'] . "' alt='Código QR'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay registros en la base de datos.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

</body>
</html>>