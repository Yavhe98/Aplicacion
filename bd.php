<?php 
/*

$conecta = mysqli_connect("localhost:3306", "root", '', "consumo_ugr");
if(mysqli_connect_errno()){
printf("No se ha podido conectar con la base de datos: %s\n", mysqli_connect_error());
exit();
}
mysqli_set_charset($conecta, "utf8");
}*/
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
/*
// A partir de este punto, puedes ejecutar consultas SQL en tu base de datos

// Ejemplo de consulta: seleccionar todos los registros de una tabla



$sql = "SELECT * FROM citic";
$result = $conn->query($sql);

// Verificar si la consulta retorna resultados
if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $citic[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}


if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $cmaximo[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}


if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $instrumentacion[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}

if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $mentecerebro[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}

if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $politecnico[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}

if ($result->num_rows > 0) {
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        // Acceder a los datos de cada fila
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row["Fecha"]);
        if ($fecha !== false) {
            $politicas[$fecha->format('Y-m-d H:i')] = $row["Consumo"];
        } else {
            echo "Error en el formato de fecha: " . $row["Fecha"];
        }
    }
}
 else {
    echo "No se encontraron resultados.";
}


$fechaMinima = strtotime('2023-01-01');
$fechaMaxima = strtotime('2023-12-31');

$intervalo = ($fechaMaxima - $fechaMinima) / 9;

for ($i = 0; $i < 10; $i++) {
    $fecha = $fechaMinima + ($intervalo * $i);
    echo date('Y-m-d', $fecha) . "<br>";
}




// Cerrar la conexión
$conn->close();
*/
?>
