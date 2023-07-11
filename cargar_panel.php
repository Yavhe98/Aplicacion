<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ef = $_POST["eficiencia"];
    $ar = $_POST["area"];
    $edificio = $_POST["edificio"];

    $comando = "python --version";
    ob_start();
    system($comando, $retorno);
    $salida = ob_get_clean();

    echo "El resultado de python es: " . $salida;

}
?>
