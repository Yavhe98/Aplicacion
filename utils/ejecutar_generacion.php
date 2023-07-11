<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../bd.php");
    session_start();
    $ef = $_POST["eficiencia"];
    $ar = $_POST["area"];
    $edificio = $_POST["edificio"];

    $_SESSION['edificio'] = $edificio;
    
    $comando = "python .\calculo_generacion.py " . escapeshellarg($ef) . " " . escapeshellarg($ar) . " " . escapeshellarg($edificio);
    $resultado = shell_exec($comando);
    echo "<h5><mark>Se recomiendan $resultado paneles solares en $edificio para una generación óptima</mark></h5>";

    $consulta = "SELECT DISTINCT(area) FROM datos_edificio JOIN $edificio USING(id)";
    $lectura = mysqli_query($conn, $consulta);
    $row = mysqli_fetch_assoc($lectura);
    $area_edificio = $row["area"];

    if($resultado*$ar > $area_edificio){
        $paneles_real = floor($area_edificio / $ar);
        echo "<br><h5><mark>Pero teniendo en cuenta el area del $edificio se propondrán $paneles_real paneles</mark></h5>";
        $_SESSION['paneles'] = $paneles_real;
    }
    else{
        $_SESSION['paneles'] = $resultado;
    }


    
    

}
?>
