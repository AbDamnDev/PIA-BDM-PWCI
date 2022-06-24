<?php
include_once("php/backend/Users/Login_controller_class.php");
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
           
        }
      }else{ 
        
        $type="Unregistered User";
      }
?>
<!DOCTYPE html>
<html>
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
        <script type="text/Javascript" src="assets/libs/jquery-3.6.0.min.js"></script>
         <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>

        <script type="text/Javascript" src="assets/js/validate/singlePage.js"></script>
        <!-- Facebook-->
        <script type="text/javascript">
          var URLactual = window.location.href;
          console.log(URLactual);
          function shareFB() {
            FB.ui({
                method: 'share',
                href: URLactual //'https://developers.facebook.com/docs/' //URLactual
            }, function (response) { });
          }
        </script>
    </head>
    <body>
      <!-- Facebook -->
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId            : '1738955803106740',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v13.0'
          });
        };
      </script>
      <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
      <!-- Fin Facebook -->

      <div class="container">
        <?php include('./php/header.php') ?>  
        <section id="contentSection">
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
              <div class="left_content">
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
                          include_once("php/backend/News/News_controller_class.php");
                            echo '<div id="newsBox" data-newsid='.$results['newsid'].' class="single_page">';
                            $newsID =$results['newsid'];
                            $exec = NewsContr::constGetSpecNews($newsID);
                            $finalResponse= $exec->getSpecNews();
                            if($finalResponse!=null){
                              $infoHandler=json_decode($finalResponse,true);
                              echo' <h1>'.$infoHandler['newsInfo'][0]['TITLE'].'</h1>';
                              echo'<div class="post_commentbox"> <i>'.$infoHandler['newsInfo'][0]['SIGN'].'</i> <i> | </i> <i>'.$infoHandler["newsInfo"][0]["DATE_OF_EVENTS"].'</i> <i> | </i> <i>'.$infoHandler["newsInfo"][0]["PLACE_OF_EVENTS"].'</i> </div>';
                              echo '<div class="single_page_content">
          
                              <img id="seeImage" class="img-center" src="images/screen.png" alt="Imagenes de la noticia">
                              <div class="img-center">
                              <button class="botoncito" id="prevImage"><</button> <text id="imageText">Imagen (1/1)</text> <button class="botoncito" id="nextImage">></button>
                              </div>
                              <br>
          
                              <p>'.$infoHandler["newsInfo"][0]["DESCRIPTION"].'</p>
                              
                              <blockquote>'.$infoHandler["newsInfo"][0]["TEXT"].'</blockquote>
                              
                              <video id="videoPreviewP" class="img-center" width="320" height="240" controls>
                                
                              </video>
          
                            </div>';
                            echo'<div class="post_commentbox">
                            <i>Fecha Publicación: '.$infoHandler["newsInfo"][0]["NEWS_PUBLISH_DATE"].'   </i> <i>   |   </i>';
                            if(isset($_SESSION['ID_USER'])&&$_SESSION['ID_USER']>0){
                              include_once("php/backend/Comments/Comment_controller_class.php");
                              $exec=ComContr::constuserHasLikes($_SESSION['ID_USER'],$results['newsid']);
                              $final=$exec->usHasLike();
                              if ($final==1){
                                echo '<button type="button" class="likeBTN" id="likebtn"> <img id="likeimg" class="likeIMG" src="images/like2.png" alt="like"> </button>';
                              }else{
                                echo '<button type="button" class="likeBTN" id="likebtn"> <img id="likeimg" class="likeIMG" src="images/like.png" alt="like"> </button>';
                              }
                              
                            }
                            echo '<i class="numLikes" id="numlikes">  Numero total de likes : '.$infoHandler["newsInfo"][0]["LIKES"].'</i> 
                            <div> <i> Categoria(s): '.$infoHandler["newsInfo"][0]["CATEGORIES_NAME"].'  </i> <i>   |   </i> <i> Palabras clave: '.$infoHandler["newsInfo"][0]["KEY_WORDS"].'</i> </div>
                            </div>';                            
                            
                            //boton compartir
                            echo '<button onclick="shareFB();">Compartir en Facebook</button> <br><br>';

                            echo'<h2 style="margin-top: 5px;">Comentarios</h2>';
                              if(isset($_SESSION['ID_USER'])&&$_SESSION['ID_USER']>0 &&(strcmp($type,"Registered User")==0)){
                                echo '<div class="NewComment row" >
                                <form id="comment_form" action="" method="POST">
                                  <textarea maxlength="200" name="commenttext" id="commenttext" placeholder="Comenta algo..."></textarea>
                                  <button type="submit" id="buttonComment" class="RepplyBTN">Comentar</button>
                                </form>
                                
                              </div>';
                              }
                              echo '<div class="comment_section row"></div></div>';
                            }

                        }else{
                            echo '<div id="newsBox" data-newsid=0 class="single_page">
                            <h1>Unweeter, jueguito para GameJam</h1>
                            <div class="post_commentbox"> <i>Autor</i> <i> | </i> <i>Fecha Acontecimiento</i> <i> | </i> <i>Lugar acontecimiento</i> </div>
                            <div class="single_page_content">
          
                              <img class="img-center" src="images/screen.png" alt="Imagenes de la noticia">
                              <div class="img-center">
                                <button class="botoncito"><</button> <Text>Imagen (1/1)</Text> <button class="botoncito">></button>
                              </div>
                              <br>
          
                              <p>Unweeter es un juego pequeño de un equipo indie para la GGJ 2022. El llamado "Team Trap" compueso pot Mich (Roja) Aguilar, Jose Parga, Lucero Segura, Mabel Aguilar y Lyr Karlson (músico) desarollo el juego en tan solo 3 días con una mecanica de dongeon-crawling roguelike. Es un juego muy bonito con un estilo pixelart chikito y fondos en digitial simulando ser pixelart.</p>
                              
                              <blockquote> Unweeter es un juego pequeño de un equipo indie para la GGJ 2022. El llamado "Team Trap" compueso pot Mich (Roja) Aguilar, Jose Parga, Lucero Segura, Mabel Aguilar y Lyr Karlson (músico) desarollo el juego en tan solo 3 días con una mecanica de dongeon-crawling roguelike. Es un juego muy bonito con un estilo pixelart chikito y fondos en digitial simulando ser pixelart. Sí, es el mismo texto de nuevo. </blockquote>
                              
                              <video class="img-center" width="320" height="240" controls>
                                <source src="movie.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                              </video>
          
                            </div>
          
                            <div class="post_commentbox">
                              <i>Fecha Publicación</i> <i> | </i>
                              <button class="likeBTN"> <img class="likeIMG" src="images/like.png" alt="like"> </button>
                              <i class="numLikes"> Numero total de likes</i> 
                            </div>

                            <!-- boton compartir -->
                            <button onclick="shareFB();">Compartir en Facebook</button> <br><br>
            
                            <h2 style="margin-top: 5px;">Commentarios</h2>
          
                            <div class="NewComment row" >
                              <form>
                                <textarea name="" id="" placeholder="Comenta algo..."></textarea>
                              </form>
                              <button class="RepplyBTN">Comentar</button>
                            </div>
          
                            <div class="comment_section row">
                              <div class="megaComment">
                                <div class="comment">
                                  <div class="flexea">
                                    <div>
                                      <img class="userImgComment" src="images/User.png" alt="">
                                    </div>
                                    <div>
                                      <h5>Nombre</h5>
                                      <text>Comentario</text>
                                      <h6>Fecha</h6>
                                    </div>
                                  </div>
                                  <div>
                                    <button class="RepplyBTN">Responder</button>
                                    <button class="DeleteBTN">Eliminar</button>
                                  </div>
                                </div>
                                <div class="comment Respuestas">
                                    <div class="Reply" >
                                      <div class="flexea">
                                        <div>
                                          <img class="userImgComment" src="images/User.png" alt="">
                                        </div>
                                        <div>
                                          <h5>Nombre</h5>
                                          <text>Respuesta 1</text>
                                          <h6>Fecha</h6>
                                        </div>
                                      </div>
                                      <div>
                                        <button class="RepplyBTN">Responder</button>
                                        <button class="DeleteBTN">Eliminar</button>
                                      </div>
                                    </div>
          
                                    <div class="Reply" >
                                      <div class="flexea">
                                        <div>
                                          <img class="userImgComment" src="images/User.png" alt="">
                                        </div>
                                        <div>
                                          <h5>Nombre</h5>
                                          <text>Respuesta 2</text>
                                          <h6>Fecha</h6>
                                        </div>
                                      </div>
                                      <div>
                                        <button class="RepplyBTN">Responder</button>
                                        <button class="DeleteBTN">Eliminar</button>
                                      </div>
                                    </div>
                                  </div>
                              </div>
          
                              <div class="megaComment">
                                <div class="comment">
                                  <div class="flexea">
                                    <div>
                                      <img class="userImgComment" src="images/User.png" alt="">
                                    </div>
                                    <div>
                                      <h5>Nombre</h5>
                                      <text>Comentario</text>
                                      <h6>Fecha</h6>
                                    </div>
                                  </div>
                                  <div>
                                    <button class="RepplyBTN">Responder</button>
                                    <button class="DeleteBTN">Eliminar</button>
                                  </div>
                                </div>
                                <div class="comment Respuestas">
                                  <!-- Comentario para no confundirme con cierres de DIV-->
                                </div>
                              </div>
          
                            </div>
          
                            
                          </div>';
                        }
          ?>
                 
		            <!-- antes boton compartir -->
              </div>
            </div>
          <?php include('./php/featured.php') ?>  
          </div>
        </section>
      <?php include('./php/footer.php') ?>  
      </div>
      
    </body>
   