<?php
include_once("php/backend/Users/Login_controller_class.php");
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Noticias Noticiosas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font.css">
        <link rel="stylesheet" type="text/css" href="assets/css/user-dashboard.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/stylesheets.css">
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
        <script src="assets/js/fontawesome.min.js"></script>
    </head>
    <body>
        <main class="user-dashboard">
            <?php include_once('./php/header.php');?>
            <h2>User Dashboard</h2>
            <input
                class="user-dashboard-search"
                type="text"
                placeholder="Search..."
            />
            <div class="user-card-container">
                <?php
                //session_start();
                    //Importar la funcion template
                    require_once './php/userCard.php';
                    include_once('./php/backend/Users/Users_controller_class.php');
                    $tarInit= UsersContr::constID($_SESSION['ID_USER']);
                    $usuarios=$tarInit->getAllU();
                    if($usuarios!=null){
                        //dosomething
                        if(is_array($usuarios)){
                            foreach ($usuarios as $usuario) {
                                if($usuario['PROFILE_PIC']!=null){
                                    echo UserCard(
                                        $usuario['USER_ID'], 
                                        $usuario['USERNAME'], 
                                        $usuario['PROFILE_PIC'], 
                                        $usuario['USER_TYPE_ID'],
                                        $usuario['STATUS']
                                    );
                                }else{
                                    echo UserCard(
                                        $usuario['USER_ID'], 
                                        $usuario['USERNAME'], 
                                        "./images/User.png", 
                                        $usuario['USER_TYPE_ID'],
                                        $usuario['STATUS']
                                    );
                                }
                                
                            }
                        }else{
                            echo UserCard(
                                $usuarios['USER_ID'], 
                                $usuarios['USERNAME'], 
                                $usuarios['PROFILE_PIC'], 
                                $usuarios['USER_TYPE_ID'],
                                $usuarios['STATUS']
                            );

                        }
                        

                    }else{
                         // probar el display de las tarjetas
                        for( $i = 0; $i < 15; $i = $i + 1 ){
                            $id = rand(1,5000);
                            echo UserCard(
                                $id, 
                                'Rana_Anonima'.strval($id), 
                                'https://64.media.tumblr.com/7eb96ffc3d99b2120b33090202feca47/tumblr_mt8hg8AoLe1rie4kjo1_640.png', 
                                rand(1, 3),
                                'A'
                            );
                        }
                    }
                   
                    
                ?>
            </div>
        </main>
    <body>