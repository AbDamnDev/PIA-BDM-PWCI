<?php
session_start();
if(isset($_SESSION["ID_USER"])){
    header('Location: index.php');
    exit;
}
?>

<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>

<html lang="en">

    <head>

        
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Noticias Noticiosas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font.css">
        <link rel="stylesheet" type="text/css" href="assets/css/estiloLogin.css">
         <!-- Jquery -->
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
        <!--  script type="text/Javascript" src="assets/libs/jquery.validate.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script-->
        <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>
        <link rel="stylesheet" href="assets/css/sweetalert2.css">
        <!-- Validacion Login y Register -->
        <link rel="stylesheet" href="assets/css/CheckPassCSS.css">
        <script type=text/Javascript src="assets/js/validate/loginChecker.js"></script>
        <script type=text/Javascript src="assets/js/validate/formLoginSubmit.js"></script>
        <!--  script type=text/Javascript src="assets/js/validate/formLoginMessage.js"></script-->
        
    </head>

    <body>


        <div id="ContenidoCentral">


            <div id="BarraLateral" style="background-color: rgba(0, 128, 255, 0.50);">
                <br /><br /><br />
                <img style=" height:auto;  width:auto; " src="images/logo.png" class="img-fluid">
                <br /><br /><br />
            </div>

            <div><br /><br /></div>

            <div class="contenedor__todo">

                <div class="caja__trasera">

                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar a la página</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja__trasera-register">
                        <h3>¿Aún no tienes una cuenta?</h3>
                        <p>Regístrate para iniciar sesión</p>
                        <button id="btn__registrarse">Regístrate</button>
                    </div>

                </div>

                <!-- Formulario de Login y Registro -->
                <div class="contenedor__login-register">

                    <!-- Login -->
                    <form  class="formulario_login" id="formLogID" name="formlog" action="Includes\users\Login_include.php" method="POST">
                        <h2>
                            Iniciar sesión
                        </h2>
                        <div class="container-fluid">

                            <div class="row">
                                <p> </p>
                                <input type="text" name="nomUsn" id="nomUsIniciar" placeholder="Nombre de Usuario" minlength=5 required>
                                <p> </p>
                            </div>
                            <br />
                            <div class="row">
                                <p> </p>
                                <input type="password" name="passUsn" id="contrasena" placeholder="Contraseña" minlength=8 required>
                                <p> </p>
                            </div>
                        </div>
                        <br />

                        <div class="container-fluid">
                            <div class="row">
                                <input name="accion" type="hidden" value="login" id="accionIn"/>
                                <input name="validateIn" type="hidden" value="false" id="validateIn"/>
                                <button id="btnLogin" onclick="valLogin()">
                                    Entrar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Register -->
                    <form class="formulario_register" id="formRegID" name="formReg"  action="Includes\users\SignUp_include.php" method="POST">
                        <h2>
                            Registrarse
                        </h2>
                        <div class="row">
                            <p> </p>
                            <input type="text" id="nombre" name="nombreN" placeholder="Nombre(s) y Apellido(s)" minlength=4 pattern="[ñÑa-zA-ZÁ-ÿ ]+" required>
                            <p> </p>
                            <div id="nameMessage"></div>
                        </div>

                        <br />

                        <div class="row">
                            <p> </p>
                            <input type="text" id="telefono" name="telefonoN" placeholder="Teléfono" minlength=10 pattern="[0-9]+" required>
                            <p> </p>
                            <div id="telMessage"></div>
                        </div>

                        <br />

                        <div class="row">
                            <p> </p>
                            <input type="email" id="correoCrear" name="correoCrearN" pattern="[A-Za-z0-9\_\-\.\@]+" placeholder="Correo" minlength=5 required>
                            <p> </p>
                             <div id="emailMessage"></div>
                        </div>

                        <br />

                        <div class="row">
                            <p> </p>
                            <input type="text" id="nomUs"  name="nomUsR" placeholder="Nombre de Usuario" minlength=5 pattern="[A-Za-z0-9_-.]+" required>
                            <p> </p>
                            <div id="usernameMessage"></div>
                        </div>

                        <br />

                        <div class="row">       
                            <p> </p>
                            <input type="date" name="fechNacN" id="fechNac" title="Fecha de Nacimiento" required>
                            <p> </p>
                            <div id="dateMessage"></div>
                        </div>

                        <br/>

                        <div class="row">
                            <p> </p>
                            <input type="password" name="newPass" id="contrasena1" pattern=".{8,}" placeholder="Contraseña" required>
                            <p> </p>
                            <div id="strengthMessage"></div>
                        </div>

                        <br />

                        <div class="row">
                            <p> </p>
                            <input type="password" name="newPassC" id="contrasena2" pattern=".{8,}" placeholder="Confirmar contraseña" required>
                            <p> </p>
                            <div id="myequalMessage"></div>
                        </div>

                        <br />
                        
                        <div class="container-fluid">
                            <div class="row">
                                <input name="validateUp" type="hidden" value="false" id="validateUp"/>
                                <input name="accionUp" type="hidden" id="accionRegIn" value="registrar"/>
                                <button  onclick="valRegister()" >
                                    Crear Cuenta
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>      
        <!-- Javascript -->
        <script src="assets/js/movimientoLogin.js"></script>
        
    </body>

</html>