<?php 
include_once("../../php/backend/News/Categories_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"getCat")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $catID=$data["catNumber"];

        $exec = Categories::constGetCat($catID);
        $finalResponse= $exec->getCatInfo();
        header('Content-Type: application/json');
        echo $finalResponse;
    }

?>