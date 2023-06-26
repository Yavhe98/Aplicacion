<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include("bd.php"); ?>
    <?php
// Por defecto se mostrará el rango de fechas desde hace un mes hasta el dia de hoy
        $minDate = isset($_POST['minDate']) ? $_POST['minDate'] : '2015-01-01 00:00';
        $maxDate = isset($_POST['maxDate']) ? $_POST['maxDate'] : '2015-12-31 00:00';
        $edificio = isset($_POST['edificio']) ? $_POST['edificio'] : 'citic';
?>
</head>
<body>
<?php

$fechas = array();
$datos = array();

$consulta = "SELECT * FROM $edificio WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";

$lectura = mysqli_query($conn, $consulta);

while($lecturas = $lectura->fetch_array()){
  $fechas[] = $lecturas["Fecha"];
  $datos[] = $lecturas["Consumo"];
}


// Calcular el intervalo de tiempo
$paso = count($datos) / 11;

// Generar las fechas intermedias
$fechasIntermedias = [$fechas[0]];
$datosIntermedios = [$datos[0]];

for ($i = 1; $i < 12; $i++) {
  $fechasIntermedias[] = $fechas[($i * $paso)-1];
  $datosIntermedios[] = $datos[($i * $paso)-1];
}

print_r($fechasIntermedias);


?>


<script>

var edificio = <?php echo json_encode($edificio); ?>
var fechas = <?php echo json_encode($fechas); ?>
var datos = <?php echo json_encode($datos); ?>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: fechas,
    datasets: [
      /*{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: datos,
    },*/{
      label: "Sin placa",
      lineTension: 0.3,
      backgroundColor: "rgba(98, 229, 132, 0.8)",
      borderColor: "rgba(1, 160, 42, 0.8)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [1000, 3062, 2263, 1839, 1887, 2682, 31274, 3259, 2849, 24159, 3265, 41984, 30451],
    }
  ],


  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 40000,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
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
