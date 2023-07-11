<?php

//session_start();

$edificio = $_SESSION["edificio"];
$paneles = $_SESSION['paneles'];

$year = $_POST["year"];
$precio_total = $_POST["precio_instalacion"];
$precio_energia = $_POST["precio_energia"];

$consumo = array();
$generacion = array();
$ahorro = array();

$ahorro[0] = -($precio_total);

# Recoge la suma de consumo por mes del edificio seleccionado
$consulta = "SELECT SUM(Consumo) AS 'consumo_medio' FROM $edificio WHERE YEAR(Fecha) >= $year GROUP BY YEAR(Fecha), MONTH(Fecha) ORDER BY Fecha ASC LIMIT 12";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $consumo[] = $lecturas["consumo_medio"];
}

$consulta = "SELECT SUM(Generacion) AS 'generacion_media' FROM generacion WHERE YEAR(Fecha) >= $year GROUP BY YEAR(Fecha), MONTH(Fecha) order by Fecha Asc limit 12;";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $generacion[] = $lecturas["generacion_media"];
}

$acumulado = $ahorro[0];

// $acumulado += ($generacion[$i] > $consumo[$i]) ? ($consumo[$i] * $coste) : ($generacion[$i] * $coste);
for($i = 1; $i < count($consumo); $i++){
  if($generacion[$i] > $consumo[$i]){
    $acumulado += $consumo[$i] * $precio_energia;
    $ahorro[$i] = $acumulado;
  }
  else{
    $acumulado +=  $generacion[$i]* $precio_energia;
    $ahorro[$i] = $acumulado;
  }
}

foreach ($ahorro as &$a) {
  $a = round($a, 2);
}

$valor_maximo = max($ahorro);
$valor_minimo = min($ahorro);

?>

  
<script>

var ahorro = <?php echo json_encode($ahorro); ?>

var maximo = <?php echo json_encode($valor_maximo); ?>

var minimo = <?php echo json_encode($valor_minimo); ?>

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
          display: true
        },
        ticks: {
          maxTicksLimit: 24
        }
      }],
      yAxes: [{
        ticks: {
          min: minimo,
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