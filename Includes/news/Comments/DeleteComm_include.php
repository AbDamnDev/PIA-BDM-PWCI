<?php
include_once("../../../php/backend/Comments/Comment_controller_class.php");
$data = json_decode( file_get_contents('php://input'),true );
    if(isset($data["accion"])&&strcmp($data["accion"],"DeleteComment")==0){
        session_start();
        $id =$_SESSION['ID_USER'];
        $comm_id =$data['commid'];
        $newsID =$data['idnews'];

        $exec=ComContr::constDeleteComment($id,$newsID,$comm_id);
        $finalResponse=$exec->removeComm();
        header('Content-Type: application/json');
        echo $finalResponse;
    }
?>