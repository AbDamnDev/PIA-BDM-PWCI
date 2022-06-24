<?php 
include_once("../../../php/backend/News/News_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"deleteNews")==0){
        session_start();
        $iduser=$_SESSION['ID_USER'];
        $newsID =$data['id'];
        $exec = NewsContr::constDelNews($newsID,$iduser);
        $finalResponse= $exec->delNews();
        header('Content-Type: application/json');
        echo $finalResponse;  
    }

?>