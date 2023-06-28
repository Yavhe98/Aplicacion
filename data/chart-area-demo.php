<?php
include("bd.php");
$minDate = $_POST['minDate'] ;
$maxDate = $_POST['maxDate'] ;
$edificio = $_POST['edificio'];
$nplacas =  $_POST['counter'];

$fechas = array();
$consumo = array();
$generacion = array();
$consumo_resumen = array();
$generacion_resumen = array();

$consulta = "SELECT * FROM $edificio WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $fechas[] = $lecturas["Fecha"];
  $consumo[] = $lecturas["Consumo"];
}

$consulta = "SELECT * FROM generacion WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $fechas[] = $lecturas["Fecha"];
  $generacion[] = $lecturas["Generacion"];
}


// Definicion de la granularidad
if(count($consumo) > 50){
  $paso = round(count($consumo) /50);
  for($i = 0; $i < 50; $i++){
    for($j = 0; $j < $paso; $j++){
      $consumo_resumen[$i] += $consumo[($i*$paso)+$j];
      $generacion_resumen[$i] += $generacion[($i*$paso)+$j];
      $fechas_resumen[$i] = $fechas[($i*$paso)+$j];
    }
  }
}
else{
  $consumo_resumen = $consumo;
  $generacion_resumen = $generacion;
  $fechas_resumen = $fechas;
}

$valor_maximo = max(max($generacion_resumen), max($consumo_resumen));

?>

<script>

var fechas = <?php echo json_encode($fechas_resumen); ?>

var consumo = <?php echo json_encode($consumo_resumen); ?>

var generacion = <?php echo json_encode($generacion_resumen); ?>

var maximo = <?php echo json_encode($valor_maximo); ?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';


// Area Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: fechas,
    datasets: [
      {
      label: "Consumo",
      lineTension: 0.3,
      backgroundColor: "rgba(255, 0, 0, 0.35)",
      borderColor: "rgba(255, 0, 0, 0.62)",
      pointRadius: 2,
      pointBackgroundColor: "rgba(255, 0, 0, 1)",
      pointBorderColor: "rgba(255, 0, 0, 0.62)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(255, 0, 0, 0.62)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: consumo,
    },{
      label: "Consumo con paneles",
      lineTension: 0.3,
      backgroundColor: "rgba(0, 230, 0, 0.45)",
      borderColor: "rgba(0, 230, 0, 0.62)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: generacion,
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
          maxTicksLimit: 8
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: maximo,
          maxTicksLimit: 10
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