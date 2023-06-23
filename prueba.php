<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<?php


  $minDate = new DateTime('2015-01-01');
  $maxDate = new DateTime('2022-11-12');


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

print_r($feechas)
?>

  
<script>
/*
var citic = <?php echo json_encode($citic); ?>
var cmaximo = <?php echo json_encode($cmaximo); ?>
var instrumentacion = <?php echo json_encode($instrumentacion); ?>
var mentecerebro = <?php echo json_encode($mentecerebro); ?>
var politecnico = <?php echo json_encode($politecnico); ?>
var politicas = <?php echo json_encode($politicas); ?>

var intervalos = <?php echo json_encode($feechas); ?>

var edificio = <?php echo json_encode($edificio); ?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

console.log(intervalos);
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
});*/
</script>

</body>
</html>