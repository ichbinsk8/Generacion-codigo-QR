<?php
include 'config.php';

//Hace la pagina según el ID
if (!isset($_GET['id'])) {
    die("ID no proporcionado");
}

$id = intval($_GET['id']); // Limpiar el ID

// Luego haces la consulta SQL:
$sql = "SELECT * FROM info WHERE ID = $id";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $salida = $_POST['lsalida'];
    $dirige = $_POST['ldirige'];
    
    // Validar que los campos no estén vacíos
    if (!empty($salida) && !empty($dirige)) {
        // Preparar la consulta de inserción
        $sql = "INSERT INTO lugares (LUGAR_SALIDA, LUGAR_DIRIGE, ID_INFO,FECHA_REGISTRO) VALUES (?, ?, ?,NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $salida, $dirige, $id); // Vinculamos los parámetros

        if ($stmt->execute()) {
            echo "<script>alert('✅ datos guardados correctamente.');</script>";
        } else {
            echo "<script>alert('❌ Error al guardar: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<p>Por favor, complete todos los campos.</p>";
    }
}
// Cerrar la conexión
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylecomputador.css">
</head>
<body>
    
    <div class="container">
    <h1>Dueño del computador</h1>
    <form action="" method="post" id="formulario" class="formulario">
    <table>
    <thead>
        <tr>
            <th>Campo</th>
            <th>valor</th>
           
        </tr>
    </thead>
    <tbody>
        <?php
        // Si existen registros, mostrar cada uno en la tabla
        if ($result->num_rows > 0) {
            // Iterar sobre cada columna de cada fila
            while ($row = $result->fetch_assoc()) {
                /*echo "<tr>";
                echo "<td>ID</td>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "</tr>";*/

                echo "<tr>";
                echo "<td>Nombre del Propietario</td>";
                echo "<td>" . $row['NOMBRE_PERSONA'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Identificación </td>";
                echo "<td>" . $row['IDENTIFICACION'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Cargo </td>";
                echo "<td>" . $row['CARGO'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Correo </td>";
                echo "<td>" . $row['CORREO'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>ID del Computador</td>";
                echo "<td>" . $row['ID_COMPUTADOR'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Marca</td>";
                echo "<td>" . $row['MARCA'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Tipo Equipo</td>";
                echo "<td>" . $row['TIPO_EQUIPO'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>Código QR</td>";
                echo "<td><img src='" . $row['QR'] . "' alt='Código QR'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No hay registros en la base de datos.</td></tr>";
        }
        ?>
       
            <!-- Fila para los inputs -->
        <tr>
            <div class="input-wrapper">   
            <td><label >Lugar de donde sale:</label></td>
            <td><input type="text" id="lsalida" name="lsalida" placeholder="Introduce un valor"></td>
            </div>
        </tr>

        <tr>
            <div class="input-wrapper">
            <td><label>Lugar a donde va:</label></td>
            <td><input type="text" id="ldirige" name="ldirige" placeholder="Introduce un valor"></td>
            </div>
        </tr>
         
        
        
    </tbody>
</table>
    <button class="btn" type="submit">Guardar</button>
</form>
</div>

</body>
</html>