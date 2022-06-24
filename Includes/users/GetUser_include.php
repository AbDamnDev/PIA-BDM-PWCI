<?php 
include"../../php/backend/Users/Users_controller_class.php";
$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"getUserInfo")==0){
        session_start();
        $id =$_SESSION['ID_USER'];

        $idUser = UsersContr::constID($id);
        $finalResponse=$idUser->getUserData();
        echo $finalResponse;
       
    }else if(strcmp($data["accion"],"getSession")==0){ //este es innecesario luego lo reemplazamos
        session_start();
        
        $valueI=strval($_SESSION['ID_USER']);
        $json=array("user"=>$valueI);
        header('Content-Type: application/json');
        echo json_encode($json);

    }

?>