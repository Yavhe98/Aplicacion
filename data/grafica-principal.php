<?php
include("bd.php");
$minDate = $_POST['minDate'] ;
$maxDate = $_POST['maxDate'] ;
$edificio = $_POST['edificio'];
if(isset($_POST['grafica'])){
  $graficas = $_POST['grafica'];
}
else{
  $graficas = [];
}


$fechas = array();
$consumo = array();
$generacion = array();

# Si consumo está seleccionado en el checkbox...

$consulta = "SELECT * FROM $edificio WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $fechas[] = $lecturas["Fecha"];
  $consumo[] = $lecturas["Consumo"];
}


# Si generación está seleccionado en el checkbox...

$consulta = "SELECT * FROM generacion WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $fechas[] = $lecturas["Fecha"];
  $generacion[] = $lecturas["Generacion"];
}




// DEFINICIÓN DE GRANULARIDAD

// Si generacion (el array mas pequeño) tiene mas de 50 registros...
if(count($generacion) > 50){
  $consumo_resumen = array_fill(0, 50, 0);
  $generacion_resumen = array_fill(0, 50, 0);
  $paso_con = count($consumo) /50;
  $paso_gen = count($generacion)/50;
  for($i = 0; $i < 50; $i++){

    for($c=0; $c < $paso_con; $c++){
      $consumo_resumen[$i] += $consumo[round(($i*$paso_con)+$c)];
      $fechas_resumen[$i] = $fechas[round(($i*$paso_con)+$c)];
    }

    for($g=0; $g < $paso_gen; $g++){
      $generacion_resumen[$i] += $generacion[round(($i*$paso_gen)+$g)];
    }
  
  }
}
# Si generacion tiene menos de 50 registros, pero consumo tiene mas...
elseif(count($consumo) > 50){
  # Se crea la granularidad de "generacion" es decir, 1 dato cada día
  $consumo_resumen = array_fill(0, count($generacion), 0);
  $generacion_resumen = $generacion;
  $paso = count($consumo)/count($generacion);
  for($i = 0; $i < $paso; $i++){
    for($j = 0; $j < $paso; $j++){
      $consumo_resumen[$i] += $consumo[round(($i*$paso)+$j)];
      $fechas_resumen[$i] = $fechas[round(($i*$paso)+$j)];
    }
  }
}
# Si los dos tienen menos de 50... 
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

var graficas = <?php echo json_encode($graficas); ?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var datos = [];

if(graficas.includes('generacion') && graficas.includes('consumo')){
  datos = [
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
      label: "Generacion",
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
    }];
}
else if(graficas.includes('consumo')){
    maximo = Math.max(...consumo);
    datos = [
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
    }];
}
else if(graficas.includes('generacion')){
  maximo = Math.max(...generacion);
  datos = [{
      label: "Generacion",
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
    }];
}

// Area Chart Example
var ctx = document.getElementById("myLineChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: fechas,
    datasets: datos,

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
          maxTicksLimit: 15
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