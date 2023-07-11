<?php 
include("bd.php");

$edificio = 'citic';
$paneles = 28;

$year = '2016';
$precio_panel = 144;
$precio_energia = 0.34;

$consumo = array();
$generacion = array();
$ahorro = array();

$ahorro[0] = -($paneles * $precio_panel);

# Recoge la suma de consumo por mes del edificio seleccionado
$consulta = "SELECT SUM(Consumo) AS 'consumo_medio' FROM $edificio WHERE YEAR(Fecha) >= $year GROUP BY YEAR(Fecha), MONTH(Fecha) ORDER BY Fecha ASC LIMIT 24";
$lectura = mysqli_query($conn, $consulta);
while($lecturas = $lectura->fetch_array()){
  $consumo[] = $lecturas["consumo_medio"];
}

$consulta = "SELECT SUM(Generacion) AS 'generacion_media', Fecha FROM generacion WHERE YEAR(Fecha) >= $year GROUP BY YEAR(Fecha), MONTH(Fecha) order by Fecha Asc limit 24;";
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

$valor_maximo = ceil(max($ahorro)/10000)*10000;
echo $ahorro[0];