<?php
include_once("../../../php/backend/Comments/Comment_controller_class.php");
$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"setUnsetLike")==0){
        session_start();
        $id =$_SESSION['ID_USER'];
        $newsID =$data['idnews'];
        $like =$data['like'];

        $exec=ComContr::constSetLike($id,$newsID,$like);
        $finalResponse=$exec->setUlike();
        header('Content-Type: application/json');
        echo $finalResponse;
    }else if(strcmp($data["accion"],"getLikes")==0){
        session_start();
        //constgetLikes
        $newsID =$data['idnews'];
        $exec=ComContr::constgetLikes($newsID);
        $finalResponse=$exec->getLk();
        header('Content-Type: application/json');
        echo $finalResponse;
    }

?>