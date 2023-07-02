<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consumo_ugr";

// Establecer conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM citic";

// Ejecutar consulta
$result = $conn->query($sql);

// Crear un array para almacenar los resultados
$data = array();

// Recorrer los resultados y agregarlos al array
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Convertir a formato JSON y devolver la respuesta
echo json_encode($data);

// Cerrar conexión
$conn->close();
?>
