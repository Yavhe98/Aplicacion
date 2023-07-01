<?php
include("bd.php");
$minDate = $_POST['minDate'] ;
$maxDate = $_POST['maxDate'] ;
$edificio = $_POST['edificio'];
$nplacas =  $_POST['counter'];

if(isset($_POST['grafica'])){
    $opcionesSeleccionadas = $_POST['grafica'];
    
    var_dump($opcionesSeleccionadas);
}
?>