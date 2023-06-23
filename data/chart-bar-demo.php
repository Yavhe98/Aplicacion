<?php

if (isset($_POST['minDate']) && isset($_POST['maxDate'])) {
  $minDate = $_POST['minDate'];
  $maxDate = $_POST['maxDate'];

  // Realizar el procesamiento necesario con las variables minDate y maxDate
  // ...

  // Devolver una respuesta si es necesario
  echo 'Procesamiento exitoso';
}
else{
  $minDate = new DateTime('2015-01-01');
  $maxDate = new DateTime('2022-11-12');
}

if (isset($_POST['opcion'])){
  $edificio = $_POST['opcion'];
}
else{
  $edificio = 'citic';
}

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
        $citic[] = [$row["Fecha"], $row["Consumo"]];
    }
} else {
    echo "No se encontraron resultados.";
}

$intervalo = $minDate->diff($maxDate);
$diasTotales = $intervalo->days;

$intervaloEntreFechas = $diasTotales / 11; // Dividir en 11 intervalos para obtener 10 fechas intermedias

$intervalo = array();

for ($i = 1; $i <= 10; $i++) {
    $dias = round($intervaloEntreFechas * $i);
    $fechaIntermedia = clone $minDate;
    $fechaIntermedia->add(new DateInterval('P' . $dias . 'D'));
    $intervalo[] = $fechaIntermedia->format('Y-m-d');
}

$feechas = array_map('strval', $intervalo);

// Cerrar la conexión
$conn->close();

?>

  
<script>
  var citic = <?php echo json_encode($citic); ?>
  /*
var cmaximo = <?php echo json_encode($cmaximo); ?>
var instrumentacion = <?php echo json_encode($instrumentacion); ?>
var mentecerebro = <?php echo json_encode($mentecerebro); ?>
var politecnico = <?php echo json_encode($politecnico); ?>
var politicas = <?php echo json_encode($politicas); ?>
*/
var intervalos = <?php echo json_encode($feechas); ?>

var edificio = <?php echo json_encode($edificio); ?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: intervalos,
    datasets: [{
      label: "Revenue",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [4215, 5312, 6251, 7841, 9821, 14984],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 15000,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>

</body>
</html>