<?php
include"../../php/backend/Users/Login_controller_class.php";
include"../../php/backend/scripts.php";
    if(isset($_POST["validateIn"])&&strcmp($_POST["validateIn"],"true")==0){
        $email = $_POST["nomUsn"];
        $pwd = $_POST["passUsn"];

        $login = LoginContr::constLogin($email,$pwd);
        $finalResponse=$login->loginUser();
        if(strcmp($finalResponse,"true")==0){
            header('Location: ../../index.php'. SID);
            exit();
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
            //echo '<script type="text/javascript"> alert('.$finalResponse.')</script>';

        }
       
    }else{
        echo "algo esta mal";
    }
   
?>