<?php 
include_once("../../php/backend/News/Categories_controller_class.php");
//jamas incluir cosas que no sean para el controlador

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"modCat")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $catID=$data["id"];
        $color=$data["color"];
        $name=$data["nombre"];

        $exec = Categories::constModCat($catID,$name,$color,$idAdmin);
        $finalResponse= $exec->modifyCategory();
        header('Content-Type: application/json');
        echo $finalResponse;
    }else if(strcmp($data["accion"],"ordCats")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $cats=$data['cats'];

        $exec = Categories::constOrdCats($cats,$idAdmin);
        $finalResponse= $exec->ordCategories();
        header('Content-Type: application/json');
        echo $finalResponse;



    }

?>