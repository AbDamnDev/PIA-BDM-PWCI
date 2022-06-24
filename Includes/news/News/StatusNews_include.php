<?php 
include_once("../../../php/backend/News/News_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"changeNewsStatus")==0){
        session_start();
        $idUser =$_SESSION['ID_USER'];
        $newsID=$data["newsID"];
        $newsType=$data["newsSetType"];

        $exec = NewsContr::constChangeNewsStats($idUser,$newsID,$newsType);
        $finalResponse= $exec->setNewsStatus();
        header('Content-Type: application/json');
        echo $finalResponse;
    }else if(strcmp($data["accion"],"newsIdRedirect")==0){
        session_start();
        $_SESSION['idNoticia']=$data['newsID'];
        
        if (isset($_SESSION['idNoticia'])&&$_SESSION['idNoticia']>0){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

?>