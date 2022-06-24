<?php
include"../../php/backend/Users/Users_controller_class.php";
include"../../php/backend/scripts.php";

    if(isset($_POST["accion"])&&strcmp($_POST["accion"],"modUser")==0){
        session_start();
        $id =$_SESSION['ID_USER'];
        $isImageset=false;
        $isPwdSet=false;
        $realImage=null;
        $pwd=null;
        if(isset($_FILES)){
            if(!empty($_FILES["profpic"]["name"])){

                $fileName = basename($_FILES["profpic"]["name"]);
                $imageType = strtolower( pathinfo($fileName,PATHINFO_EXTENSION));
                $allowedTypes = array('png','jpg','gif');

                if( in_array($imageType,$allowedTypes) ){

                    $imageName = $_FILES["profpic"]["tmp_name"];
                    $base64Image = base64_encode(file_get_contents($imageName));
                    $realImage = 'data:image/'.$imageType.';base64,'.$base64Image;
                    $isImageset=true;

                }
            }
        }
        if(isset($_POST["contrasena1UP"])&&(!empty($_POST["contrasena1UP"]))&&isset($_POST["contrasena2UP"])&&(!empty($_POST["contrasena2UP"]))){
            if(strcmp($_POST["contrasena1UP"],$_POST["contrasena2UP"])==0){
                //se modifican los datos para cambio de contraseña
                $pwd=$_POST["contrasena1UP"];
                $isPwdSet=true;
            }else{
                echo '<script type="text/javascript"> 
                Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "Las contraseñas no coinciden",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function (result){
                if(result.value){
                    window.location = "../../user-page.php";
                }
                }); 
                </script>';
            }
        }
        $email = $_POST["emailUP"];
        $nombre = $_POST["nombreN"];
        $tel= $_POST["telUP"]; 
        $username= $_POST["nomUsUP"]; 
        $birth= $_POST["fechNacUP"]; 

        if(empty($email)||empty($nombre)||empty($tel)||empty($username)||empty($birth)){
            echo '<script type="text/javascript"> 
                Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "Parece que dejaste campos vacíos",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"}).then(function (result){
                if(result.value){
                    window.location = "../../user-page.php";
                }
                }); 
                </script>';
        }else{
            $mod= UsersContr::consModUser($id,$nombre,$email,$birth,$tel,$username,$pwd,$realImage);
            $finalResponse=$mod->modifyUser();
            if(strcmp($finalResponse,"true")==0){
                echo '<script type="text/javascript"> 
                    Swal.fire({
                    icon: "success",
                    title: "Done",
                    text: "'.$finalResponse.'",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"}).then(function (result){
                    if(result.value){
                        window.location = "../../user-page.php";
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
                        window.location = "../../user-page.php";
                    }
                    }); 
                    </script>';

            }

        }

    }else if(isset($_POST["accion"])&&strcmp($_POST["accion"],"changeUsType")==0){
        session_start();
        $idAdmin =$_SESSION['ID_USER'];
        $newtype= $_POST['type'];
        $idUser=$_POST['usIDCard'];
        $loader=UsersContr::constModTypeUs($idUser,$idAdmin,$newtype);

        $finalResponse=$loader->changeUsType();
        if(strcmp($finalResponse,"true")==0){
            echo '<script type="text/javascript"> 
                    Swal.fire({
                    icon: "success",
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