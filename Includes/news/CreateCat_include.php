<?php 
include_once("../../php/backend/News/Categories_controller_class.php");
//include_once("../../php/backend/scripts.php");

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"createCat")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $color=$data["color"];
        $name=$data["nombre"];


        $exec = Categories::constCreateCat($name,$color,$idAdmin);
        $finalResponse=$exec->createCategory();
        header('Content-Type: application/json');
        echo $finalResponse;
       
       
    }

?>