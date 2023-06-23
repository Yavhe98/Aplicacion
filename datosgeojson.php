<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "nombre_basedatos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ejecutar la consulta SQL para actualizar los valores
$sql = "UPDATE tabla SET valor = 'nuevo_valor' WHERE criterio = 'condicion'";
$result = $conn->query($sql);

// Recuperar los datos actualizados de la base de datos
$sql = "SELECT * FROM tabla WHERE criterio = 'condicion'";
$result = $conn->query($sql);

$registros_actualizados = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros_actualizados[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Actualizar el archivo GeoJSON con los valores actualizados
$geojson_file = 'archivo.geojson';
$geojson_data = json_decode(file_get_contents($geojson_file), true);

foreach ($geojson_data['features'] as &$feature) {
    // Obtener el identificador del registro del GeoJSON
    $registro_id = $feature['properties']['id'];
    
    // Buscar el registro correspondiente en los datos actualizados de la base de datos
    foreach ($registros_actualizados as $registro) {
        if ($registro['id'] == $registro_id) {
            // Actualizar el valor en el GeoJSON con el valor actualizado de la base de datos
            $feature['properties']['valor'] = $registro['valor'];
            break;
        }
    }
}

// Guardar el archivo GeoJSON actualizado
$geojson_file_actualizado = 'archivo_actualizado.geojson';
file_put_contents($geojson_file_actualizado, json_encode($geojson_data, JSON_PRETTY_PRINT));

echo "Archivo GeoJSON actualizado con éxito.";
?>
