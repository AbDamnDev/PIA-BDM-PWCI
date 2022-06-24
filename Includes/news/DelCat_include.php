<?php 
include_once("../../php/backend/News/Categories_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"delCat")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $catID=$data["id"];

        $exec = Categories::constDelCat($catID,$idAdmin);
        $finalResponse= $exec->deleteCategory();
        header('Content-Type: application/json');
        echo $finalResponse;
    }

?>