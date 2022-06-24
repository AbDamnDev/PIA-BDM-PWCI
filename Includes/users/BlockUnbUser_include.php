<?php 
include_once("../../php/backend/Users/Users_controller_class.php");
include_once("../../php/backend/scripts.php");

$data = json_decode( file_get_contents('php://input'),true );
    if(strcmp($data["accion"],"blockUnblock")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $idUser=$data["user"];
        $op=$data["option"];

        $exec = UsersContr::constModBlock($idUser,$idAdmin,$op);
        $finalResponse=$exec->setBlockUnblock();
        if(strcmp($finalResponse,"true")==0){
            echo '<script type="text/javascript"> 
                Swal.fire({
                icon: "Success",
                title: "Done",
                text: "'.$finalResponse.'",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function (result){
                if(result.value){
                    window.location = "../../user-dashboard.php";
                }
                }); 
                </script>';
        }else{
            echo '<script type="text/javascript"> 
                Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "'.$finalResponse.'",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function (result){
                if(result.value){
                    window.location = "../../user-dashboard.php";
                }
                }); 
                </script>';

        }
       
    }

?>