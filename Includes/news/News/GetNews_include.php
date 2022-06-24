<?php 
include_once("../../../php/backend/News/News_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"getNewsInfo")==0){
        session_start();
        
        $newsID =$data['idnews'];
        $exec = NewsContr::constGetSpecNews($newsID);
        $finalResponse= $exec->getSpecNews();
        header('Content-Type: application/json');
        echo $finalResponse;  
    }else if(strcmp($data["accion"],"getNewsComments")==0){
        session_start();
        $newsID =$data['idnews'];
        $exec = NewsContr::constGetSpecNews($newsID);
        $finalResponse= $exec->getComments();
        header('Content-Type: application/json');
        echo $finalResponse;  
    }

?>