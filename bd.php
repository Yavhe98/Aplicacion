<?php
// Detalles de conexión a la base de datos
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "consumo_ugr"; // Nombre de la base de datos

// Establecer la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// A partir de este punto, puedes ejecutar consultas SQL en tu base de datos

// Ejemplo de consulta: seleccionar todos los registros de una tabla
$sql = "SELECT * FROM citic";
$result = $conn->query($sql);

// Verificar si la consulta retorna resultados
if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        echo "Fechita: " . $row["Fecha"] . " - Datito: " . $row["Consumo"] . "<br>";
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>
