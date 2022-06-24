<?php

$categoria = $_POST["Categoria"];
$FechaInicio = $_POST["FechaInicio"];
$FechaFinal = $_POST["FechaFinal"];

if($categoria == 0){
    $categoria = '';
}

header('Location: 404.php?Categorias='.$categoria.'&Inicio='.$FechaInicio.'&Final='.$FechaFinal.'')

?>