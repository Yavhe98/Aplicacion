<?php
include("bd.php");
$minDate = $_POST['minDate'] ;
$maxDate = $_POST['maxDate'] ;
$edificio = $_POST['edificio'];
$graficas = array();

if(isset($_POST['consu'])){
  $graficas[] = $_POST['consu'];
}
if(isset($_POST['gene'])){
  $graficas[] = $_POST['gene'];
}


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
  //$fechas[] = $lecturas["Fecha"];
  $generacion[] = $lecturas["Generacion"];
}


// DEFINICIÓN DE GRANULARIDAD: 6 casos mirar GoodNotes (IDEAS)

// Si generacion (el array mas pequeño) tiene mas de 50 registros...

if(in_array('consumo', $graficas)){
  if(in_array('generacion', $graficas)){

    # Consumo y Generacion
    if(count($generacion) > 50 && count($generacion) > 50){
      $consumo_resumen = array_fill(0, 50, 0);
      $generacion_resumen = array_fill(0, 50, 0);
      $paso_con = count($consumo) /50;
      $paso_gen = count($generacion)/50;
      
      for($i = 0; $i < 50; $i++){
        # Agrupar los datos en 50
        for($c=0; $c < $paso_con; $c++){
          $consumo_resumen[$i] += $consumo[($i*$paso_con)+$c];
          $fechas_resumen[$i] = $fechas[($i*$paso_con)+$c];
        }
    
        for($g=0; $g < $paso_gen; $g++){
          $generacion_resumen[$i] += $generacion[($i*$paso_gen)+$g];
        }
      
      }
    }
    
    # Si generacion tiene menos de 50 registros
    elseif(count($generacion) < 50){
      # Se crea la granularidad de "generacion" es decir, 1 dato cada día
      $consumo_resumen = array_fill(0, count($generacion), 0);

      $paso = count($consumo)/count($generacion);
      for($i = 0; $i < count($generacion); $i++){
        for($j = 0; $j < $paso; $j++){
          $consumo_resumen[$i] += $consumo[($i*$paso)+$j];
          $fechas_resumen[$i] = $fechas[($i*$paso)+$j];
        }
        $generacion_resumen[$i] = round($generacion[$i]);
      }
    }

  }
  else{
    # Consumo
    if(count($consumo) > 50){
      $consumo_resumen = array_fill(0, 50, 0);
      for($i = 0; $i < 50; $i++){
        # Agrupar los datos en 50
        $paso_con = count($consumo) /50;
        for($c=0; $c < $paso_con; $c++){
          $consumo_resumen[$i] += $consumo[($i*$paso_con)+$c];
          $fechas_resumen[$i] = $fechas[($i*$paso_con)+$c];
        }
      }
    }
    elseif(count($consumo < 50)){
      for($i=0; $i < count($consumo);$i++){
        $consumo_resumen[$i] = round($consumo[$i]);
        $fechas[$i] = $fechas[$i];
      }
    }
  }
}

else{ # Consumo desactivado

  /*$consulta = "SELECT * FROM generacion WHERE Fecha BETWEEN '$minDate' AND '$maxDate'";
  $lectura = mysqli_query($conn, $consulta);
  while($lecturas = $lectura->fetch_array()){
    $fechas[] = $lecturas["Fecha"];
    $generacion[] = $lecturas["Generacion"];
  }*/

  if(in_array('generacion', $graficas)){
    # Generacion
    if(count($generacion) > 50){
      $generacion_resumen = array_fill(0, 50, 0);
      for($i = 0; $i < 50; $i++){
        # Agrupar los datos en 50
        $paso_gen = count($generacion) /50;
        for($c=0; $c < $paso_gen; $c++){
          $generacion_resumen[$i] += $generacion[round(($i*$paso_gen)+$c)];
          $fechas_resumen[$i] = $fechas[round(($i*$paso_gen)+$c)];
        }
      }
    }
    elseif(count($generacion) < 50){
      for($i=0; $i < count($generacion);$i++){
        $generacion_resumen[] = round($generacion[$i]);
        $fechas_resumen[$i] = $fechas[$i];
      }
    }
  }
}



?>

<script>

var fechas = <?php echo json_encode($fechas_resumen); ?>

var consumo = <?php echo json_encode($consumo_resumen); ?>

var generacion = <?php echo json_encode($generacion_resumen); ?>

var graficas = <?php echo json_encode($graficas); ?>

function encontrarMaximo(array1, array2) {
  // Combina los dos arreglos en uno solo
  var arrayCombinado = array1.concat(array2);

  // Encuentra el máximo valor del arreglo combinado
  var maximo = Math.max(...arrayCombinado);

  if(maximo < 100){
    maximo = 100;
  }
  else if(maximo > 1000){
    maximo = Math.ceil(maximo / 1000) * 1000;
  }
  else{
    maximo = Math.ceil(maximo / 100) * 100;
  }

  // Devuelve el máximo valor
  return maximo;
}

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var datos = [];

if(graficas.includes('generacion') && graficas.includes('consumo')){
  maximo = encontrarMaximo(generacion, consumo);
  
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
    },
    {
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
    }
  ];
}
else if(graficas.includes('consumo')){
    maximo = Math.max(...consumo);
    maximo = Math.ceil(maximo / 1000) * 1000;
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
  maximo = Math.ceil(maximo / 1000) * 1000;
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
    animation: {
      duration: 0 // Desactiva la animación inicial
    },
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
      display: true
    }
  }
});


</script>