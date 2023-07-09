<?php

$coste = 0.34;  # €/kWh

$edificio = $_POST["edificio"];
$paneles = $_POST["placas"];

$consumo = array();
$generacion = array();
$ahorro = array();

# Recoge la suma de consumo por mes del edificio seleccionado
$consulta = "SELECT SUM(Consumo) AS 'consumo_medio' FROM $edificio WHERE YEAR(Fecha) = 2015 GROUP BY MONTH(Fecha)";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $consumo[] = $lecturas["consumo_medio"];
}

$consulta = "SELECT SUM(Generacion) AS 'generacion_media' FROM generacion WHERE YEAR(Fecha) = 2015 GROUP BY MONTH(Fecha)";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $generacion[] = $lecturas["generacion_media"] * $paneles;
}

$acumulado = 0;
for($i = 0; $i < 12; $i++){
  if($generacion[$i] > $consumo[$i]){
    $acumulado += $consumo[$i] * $coste;
    $ahorro[$i] = $acumulado;
  }
  else{
    $acumulado += ($consumo[$i] - $generacion[$i])* $coste;
    $ahorro[$i] = $acumulado;
  }
}

foreach ($ahorro as &$a) {
  $a = round($a * $paneles, 2);
}

$valor_maximo = ceil(max($ahorro)/1000000)*1000000;

?>

  
<script>

var ahorro = <?php echo json_encode($ahorro); ?>

var maximo = <?php echo json_encode($valor_maximo); ?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

maximo = Math.round(maximo / 1000) * 1000;

// Bar Chart Example
var ctx = document.getElementById("myAhorroChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"],
    datasets: [{
      label: "Ahorro",
      backgroundColor: "rgba(40, 200, 60, 5.0)",
      borderColor: "rgba(2,117,216,1)",
      data: ahorro,
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
          maxTicksLimit: 12
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: maximo,
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