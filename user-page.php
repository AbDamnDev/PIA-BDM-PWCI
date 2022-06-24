<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
?>
<?php
include"php/backend/Users/Login_controller_class.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Noticias Noticiosas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font.css">
        <link rel="stylesheet" type="text/css" href="assets/css/stylesheets.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>
        <link rel="stylesheet" href="assets/css/sweetalert2.css">
        
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
        
        <link rel="stylesheet" href="assets/css/CheckPassCSS.css">
        <script type=text/Javascript src="assets/js/validate/loginChecker.js"></script>
        <script type=text/Javascript src="assets/js/validate/formLoginSubmit.js"></script>
        <script type=text/Javascript src="assets/js/validate/loaders.js"></script>
    </head>
    <body>
        <div class="container">
            <?php include_once('./php/header.php'); ?>
            <section id="contentSection" class="NewNew">
                <form class="formulario_register" id="formUser" name="formUser" method="POST" enctype="multipart/form-data" action="">
                    <h2>
                        Información de Usuario
                    </h2>
                    <hr class="solid"> 
    				
    				
                        <p>Imagen de perfil</p>
                        <img class="fotito" id="ProfPic" src="images/User.png" alt="Imagen Usuario"> 
                        <input class="fotito" type="file" id="profPicFile" name="profpic" accept="image/png, image/jpeg, image/gif"/>
                        <div id="fotoMessage"></div>
    				
                    <div class="row">
                        <p> </p>
                        <input type="text" id="nombreUP" name="nombreN" placeholder="Nombre(s) y Apellido(s)" minlength=5 pattern="[ñÑa-zA-ZÁ-ÿ ]+" required>
                        <p> </p>
                        <div id="nameMessage"></div>
                    </div>
    
                    <div class="row">
                        <p> </p>
                        <input type="text" id="telUP" name="telUP" placeholder="teléfono" minlength=10 pattern="[0-9]+" required>
                        <p> </p>
                        <div id="telMessage"></div>
                    </div>
    
                    <div class="row">
                        <p> </p>
                        <input type="email" id="emailUP" name="emailUP" pattern="[A-Za-z0-9\_\-\.\@]+" placeholder="Correo" minlength=4 required>
                        <p> </p>
                        <div id="emailMessage"></div>
                    </div>
    
                    <div class="row">
                        <p> </p>
                        <input type="text" id="nomUsUP1"  name="nomUsUP" placeholder="Nombre de Usuario" minlength=5 pattern="[A-Za-z0-9_-.]+" required>
                        <p> </p>
                        <div id="usernameMessage"></div>
                    </div>
    
                    <div class="row">       
                        <p> </p>
                        <input type="date" name="fechNacUP" id="fechNacUP1" title="Fecha de Nacimiento" required>
                        <p> </p>
                        <div id="dateMessage"></div>
                    </div>
    
                    <br>
                    <h2>
                        Cambio de Contraseña
                    </h2>
                    <hr class="solid">                
    
                    <div class="row">
                        <p> </p>
                        <input type="password" name="contrasena1UP" id="contrasena1UP" pattern=".{8,}" placeholder="Contraseña Nueva">
                        <p> </p>
                        <div id="strengthMessage"></div>
                    </div>
    
                    <div class="row">
                        <p> </p>
                        <input type="password" name="contrasena2UP" id="contrasena2UP" pattern=".{8,}" placeholder="Confirmar Contraseña">
                        <p> </p>
                        <div id="myequalMessage"></div>
                    </div>
    
                    <div class="container-fluid">
                        <div class="row">
                            <input name="accion" type="hidden" id="accionModUs" value="modUser"/>
                            <button type="button" onclick="valModUser()">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
    
                </form>

                <br><br><br>

            </section>
        </div>
    </body>
</html>