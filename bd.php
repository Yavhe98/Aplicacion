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

    // Cerrar la conexión
    //$conn->close();
?>
