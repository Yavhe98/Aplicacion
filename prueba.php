<?php

$graficas = [];

if(!isset($_POST['consu']) && !isset($_POST['gene'])){
    $_POST['consu']='consumicion';
    echo "entro tercero <br>";
}
if(isset($_POST['consu'])){
  $graficas[] = $_POST['consu'];
  echo "entro primero <br>";
}
if(isset($_POST['gene'])){
  $graficas[] = $_POST['gene'];
  echo "entro segundo <br>";
}

var_dump($graficas);

?>