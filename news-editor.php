<?php
use function MongoDB\BSON\toJSON;
include_once("php/backend/Users/Login_controller_class.php");
include_once("php/backend/News/Categories_controller_class.php") ;
    session_start();
    $type;

    function getUserType($id_user){
        $ustype=LoginContr::constIDtype($id_user);
        $finalResponse=$ustype->myUserType();
        if($finalResponse!="stmtfailed"&& $finalResponse!="userNotFound"){
            return $finalResponse;
        }else{
            return "error";
        }
      }
      if(isset($_SESSION["ID_USER"])){
        $checkUs=$_SESSION["ID_USER"];
        $type=getUserType($checkUs);
        if(strcmp($type,"Admin")==0){
    
        }else if(strcmp($type,"Reporter")==0){
           
        }else if(strcmp($type,"Registered User")==0){
            header('Location: index.php');
        }
      }else{ 
        header('Location: index.php');
        //no es usuario registrado, no debe volver aqui
      }
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
        <link rel="stylesheet" href="assets/css/sweetalert2.css">
        
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
         <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>
        
        <script type=text/Javascript src="assets/js/validate/formNewsEditor.js"></script>
    </head>
    <body>
        <div class="container">
            <?php include_once('./php/header.php'); ?>
            <section id="contentSection" class="NewNew">

                <p  data-idcmeditor=0 id="staticComent">Aqui va el comentario del editor para que se edite la noticia despues</p>
                <br>
                <form id="noticiaNueva" name="FormNoticia" method="POST" action="">
                    <?php 
                        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                        $url = "https://";   
                        else  
                                $url = "http://";   
                        $url.= $_SERVER['HTTP_HOST']; 
                        $url.= $_SERVER['REQUEST_URI'];    
                        $components = parse_url($url,PHP_URL_QUERY);
                        parse_str($components, $results);
                        //echo $results['newsid'];
                        if(isset($results['newsid'])&& $results['newsid']!=0){
                            echo '<input name="idNoticia" id="idnoticia" value='.$results['newsid'].' type="hidden"/>';
                        }else{
                            echo '<input name="idNoticia" id="idnoticia" value=0 type="hidden"/>';
                        }
                    ?>
                    <input name="accion" id="accionNoticia" value="agregarNoticia" type="hidden"/>
                    <input name="autor" value="0" id="autor" type="hidden"/>
                    <input name="autorID" value="0" id="autorID" type="hidden"/>
                    <p>Titulo de la noticia:</p>
                    <input type="text" id="titulo" name="tituloNoticia" placeholder="Titulo"  style="margin-top: 5px;" required>
                    <br><br>
                    <p>Categoria(s) de la noticia:</p>
                    <select name="categorias" id="categorias" placeholder="Seleccione una categoria">
                    <option value="0">Selecciona una categoria</option>
                    <?php
                            $loader=new Categories();
                            $resultCat=$loader->getAllCategories();
                            if ($resultCat!=null&& $resultCat!="stmtfailed"){
                                foreach ($resultCat as $cat) {
                                    echo '<option value= "'.$cat["CATEGORY_ID"].'" >'.$cat["DESCRIPTION"].'</option>';
                                }
                            }
                        ?>
                    </select>
                    <div class="ParaNotitas">
                    </div>
                    <br> <br>
                    <div>
                    <br>
                    <p>Etiqueta(s) de la noticia:</p>
                    <input type="text" id="etiquetas" name="etiNoticia" placeholder="Etiquetas">
                    <div class="ParaEtiquetas">
                        <!--div class="CategoriaEnEditor">
                            <text>Esto es una etiqueta.</text>
                            <button>X</button>
                        </div-->
                    </div>
                        </div>
                    <br> <br><br>
                    <div>
                    <p>Fecha de los acontecimientos:</p>
                    <input type="date" id="fechaAcon" name="fechaAcon" required>
                    </div>
                    <br> <br>
                    <p>Lugar de los acontecimientos:</p>
                    <input type="text" id="lugarAcon" name="lugarAcon" placeholder="Lugar de los acontecimientos" required>
                    <br> <br>
                    <p>Descripcion breve de la noticia:</p>
                    <textarea  name="descNoticia" id="descripcion" maxlength="300" placeholder="Sinopsis de noticia" required></textarea>
                    <br> <br>
                    <p>Cuerpo de la noticia:</p>
                    <textarea  name="cuerpoNoticia" id="cuerpo" placeholder="Escribe aqui tu noticia" required></textarea>
                    <br> <br>
                    <p>Imagenes:</p>
                    <input type="file" id="foto" name="fotos[]" accept="image/png, image/jpeg, image/gif" multiple/>
                    <br>
                    <button type="button" id="resetImages" onclick="resetImagesF()">Borrar todas las imagenes</button>
                    <button type="button" id="manageImages" onclick="manageImagesF()">Gestionar Imagenes</button>
                    <br> <br>
                    <p>Video:</p>
                    <input type="file" id="video" name="video" accept="video/mp4" /><!--Vamos a quitarle el required para reutilizarlo en modificar -->
                    <br>
                    <button type="button" id="resetVideo" onclick="resetVideoF()">Borrar el video</button>
                    <button type="button" id="manageVideos" onclick="">Gestionar Videos</button>
                    <br>
                    <?php 
                    if(strcmp($type,"Reporter")==0){
                        echo'<br><button type="button" id="Guardar" onclick="valNews()">Guardar como borrador</button>';
                        echo'<br><button type="button" id="Eliminar" onclick="eliminarNoticia()">Eliminar Noticia</button>
                        <br> <br>';
                    }else if(strcmp($type,"Admin")==0){
                        if(isset($results['newsid'])&& $results['newsid']!=0){
                            echo'<br><button type="button" id="Publicar" onclick="publicarNoticia()">Publicar</button> ';
                            echo'<button type="button" id="Guardar" onclick="valNews()">Guardar como borrador</button>';
                            echo'<button type="button" id="Eliminar" onclick="eliminarNoticia()">Eliminar Noticia</button> <br> <br>';
                        }else{
                            echo'<br><button type="button" id="Guardar" onclick="valNews()">Guardar como borrador</button>
                            <br> <br>';
                        }
                       
                    }
                    ?>
                </form>
                <br>
                <?php 
                   
                    if(strcmp($type,"Admin")==0){
                        echo'<form id="comentarioEditor">
                            <input type="hidden" name="idcomentEditor" id="idcomentEditor" value=0 >
                            <textarea maxlength="200"  name="comentario" id="comentario" placeholder="Comentario para la noticia" required></textarea>
                            <br><button type="button" id="Comentar" onclick="valEdComment()">Comentar</button>
                            <br> <br>
                            </form>'; 
                    }
                ?>
            </section>
            
        </div>
        <div class="contenedor__imagenes" id="imageContainer">
            <div class="NewNew">
                <div>
                <img class="img-center" name="seeImage" id="seeImage" src="images/screen.png" width="500" height="300" alt="">
                <div class="img-center">
                    <button class="botoncito" id="prevImage"><</button> <Text>Imagenes</Text> <button class="botoncito" id="nextImage">></button>
                </div>
                <br> <br>
                </div>
                <h4 style="background-color:white;">Listado de imagenes:</h4>
                <div class="ParaFotos">
                    <!--div class="FotoEnEditor" data-src="0" data-ismain=0 data-photoID=0>
                            <p></p>
                            <text >Esto es una Foto.</text>
                            <button id="btnDeleteImage" type="button">X</button>
                    </div-->
                </div>
                <br> <br>
                <div>
                <br> <br>
                <button id="closeManageImages" onclick="closeManageImagesF()">Cerrar</button>
                </div>
            </div>
            
        </div>
        <div class="contenedor__video" id="videoContainer">
            <div class="NewNew">
                <div>
                <video class="img-center" id="videoPreviewP" width="320" height="240" autoplay="autoplay" controls muted>
                      <!--source src="movie.mp4" type="video/mp4"-->
                </video>
                <div class="img-center" id="videobuttons">
                    <button class="botoncito" id="prevVideo"><</button> <Text>Videos</Text> <button class="botoncito" id="nextVideo">></button>
                </div>
                <br> <br>
                </div>
                <h4 style="background-color:white;">Listado de videos:</h4>
                <div class="ParaVideos">
                    <!--div class="VideoEnEditor" data-src="0" data-ismain=0 data-photoID=0>
                            <p></p>
                            Videos\625b72a1d3714-1650160289.mp4
                            <text >Esto es una Foto.</text>
                            <button id="btnDeleteVideo" type="button">X</button>
                    </div-->
                </div>
                <br> <br>
                <div>
                <br> <br>
                <button id="closeManageVideos" onclick="">Cerrar</button>
                </div>
            </div>
        </div>
    </body>
</html>