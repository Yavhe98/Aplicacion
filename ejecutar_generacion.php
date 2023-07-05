<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $ef = $_POST["eficiencia"];
    $ar = $_POST["area"];
    $edificio = $_POST["edificio"];

    $_SESSION['edificio'] = $edificio;

    $comando = "python .\calculo_generacion.py " . escapeshellarg($ef) . " " . escapeshellarg($ar) . " " . escapeshellarg($edificio);
    $resultado = shell_exec($comando);
    echo "Se recomiendan: $resultado paneles solares en $edificio para una generación óptima";

}
?>
