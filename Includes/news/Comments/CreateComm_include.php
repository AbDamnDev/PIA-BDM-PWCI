<?php
include_once("../../../php/backend/Comments/Comment_controller_class.php");

    if(isset($_POST["accion"])&&strcmp($_POST["accion"],"insertNewComment")==0){
        session_start();
        $id =$_SESSION['ID_USER'];
        $commentext =$_POST['commenttext'];
        $newsID =$_POST['newsid'];
        if($_POST['parent']=="null"){
            $parent=null;
        }else{
            $parent=$_POST['parent'];
        }

        $exec=ComContr::constcreateComment($id,$newsID,$commentext,$parent);
        $finalResponse=$exec->createComm();
        echo $finalResponse;
    }
?>