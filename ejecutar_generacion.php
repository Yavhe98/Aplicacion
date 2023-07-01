<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ef = $_POST["eficiencia"];
    $ar = $_POST["area"];
    $num = $_POST["placas"];

    $comando = "python calculo_generacion.py " . escapeshellarg($ef) . " " . escapeshellarg($ar) . " " . escapeshellarg($num);
    $resultado = shell_exec($comando);
    echo "Resultado de Python: $resultado";
}
?>
