<?php
include"../../php/backend/Users/Users_controller_class.php";
include"../../php/backend/scripts.php";
    if(isset($_POST["accionUp"])&&strcmp($_POST["accionUp"],"registrar")==0){
        $nombreCompleto = $_POST["nombreN"];
        $tel = $_POST["telefonoN"];
        $email = $_POST["correoCrearN"];
        $nomus = $_POST["nomUsR"];
        $birth = $_POST["fechNacN"];
        $pwd = $_POST["newPass"];
        $pwd2 = $_POST["newPassC"];


        $register = UsersContr::constRegister($nombreCompleto,$email,$birth,$tel,$nomus,$pwd,$pwd2);
        $finalResponse=$register->registerUser();
        if(strcmp($finalResponse,"true")==0){
            header('Location: ../../index.php');
            exit;
        }else{
            //header('Location: ../login.php');
            echo '<script type="text/javascript"> 
                Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "'.$finalResponse.'",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function (result){
                if(result.value){
                    window.location = "../../login.php";
                }
                }); 
                </script>';

        }
       
    }else{
        echo "algo esta mal";
    }
   
?>