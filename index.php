<?php 
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  include "php/backend/Users/Login_controller_class.php";
  if(isset($_SESSION["ID_USER"])){
    $checkUs=$_SESSION["ID_USER"];
    $type=getUserType($checkUs);
    if(strcmp($type,"Admin")==0){

    }else if(strcmp($type,"Reporter")==0){

    }else if(strcmp($type,"Registered User")==0){
      
    }
  }else{
    //no es usuario registrado, pero no hay por que regresarlo al login
  }
  

  function getUserType($id_user){
    $ustype=LoginContr::constIDtype($id_user);
    $finalResponse=$ustype->myUserType();
    if($finalResponse!="stmtfailed"&& $finalResponse!="userNotFound"){
        return $finalResponse;
    }else{
        return "error";
    }
  }
?>
<!-- Mich -->
<?php include_once 'php/backend/News/GetDashboardProcess.php'; ?>

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
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
        <script type=text/Javascript src="assets/js/validate/newsSearcher.js"></script>
        
        
    </head>
    <body>
      <div class="container">
        <?php include_once('./php/header.php');?>
        <section id="contentSection">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div id="pon-noticias-aqui">

              <?php
              $i = 1;
              foreach ($res3 as $aux){
              ?>
              <!-- Aqui grandota -->
              <div class="single_post_content"> <?php ?>
                <h2 style="background-color: <?php echo $aux['COLOR']?> ;" ><span><?php echo $aux['DESCRIPTION']; ?></span></h2>
                <?php 
                foreach ($res as $aux2){
                  if($aux['DESCRIPTION'] == $aux2['DESCRIPTION']) {?>
                <div class="single_post_content_left">
                  <ul>
                    <li>
                      <figure class="bsbig_fig"> <a href="single_page.php?newsid=<?php echo $aux2['NEWS_ID']; ?>"> <img alt="" src="<?php echo $aux2['NEWS_PHOTO']; ?>"> <span ></span> </a>
                        <figcaption> <a href="single_page.php?newsid=<?php echo $aux2['NEWS_ID']; ?>"> <?php echo $aux2['TITLE']; ?></a> </figcaption>
                        <p><?php echo $aux2['Resumen']; ?></p>
                      </figure>
                    </li>
                  </ul>
                </div>
                <?php }} ?>
                <!-- Aqui chiquitas --> <!-- <?php ?>
                <div class="single_post_content_right">
                  <ul class="spost_nav">
                    <li>
                      <div > <a href="" class="media-left"> <img alt="" src="<?php echo $aux['NEWS_PHOTO']; ?>"> </a>
                        <div class="media-body"> <a href="" ><?php echo $aux['TITLE']; ?></a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="" class="media-left"> <img alt="" src="<?php echo $aux['NEWS_PHOTO']; ?>"> </a>
                        <div class="media-body"> <a href="" ><?php echo $aux['TITLE']; ?></a> </div>
                      </div>
                    </li>
                  </ul>
                </div> -->
              </div> 
              <?php
              $i = 1; $res = $var->getDashboard();
              }
              ?>

              <!--
              <div class="single_post_content">
                <h2><span>Moda</span></h2>
                <div class="single_post_content_left">
                  <ul>
                    <li>
                      <figure class="bsbig_fig"> <a href="./single_page.php" > <img alt="" src="images/DaveLantern.png"> <span ></span> </a>
                        <figcaption> <a href="./single_page.php">El verde a la moda.</a> </figcaption>
                        <p>Este sujeto de aca arriba, esta bien wapo. Verdad?</p>
                      </figure>
                    </li>
                  </ul>
                </div>
                <div class="single_post_content_right">
                  <ul class="spost_nav">
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/screen.png"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 1</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/DavePlusPlus.jpg"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 2</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/DaveLantern.png"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 3</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/acercate-viejo-acércate-come-closer.gif"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 4</a> </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              
              <div class="single_post_content">
                <h2><span>Tecnologia</span></h2>
                <div class="single_post_content_left">
                  <ul>
                    <li>
                      <figure class="bsbig_fig"> <a href="./single_page.php" > <img alt="" src="images/DavePlusPlus.jpg"> <span ></span> </a>
                        <figcaption> <a href="./single_page.php">Enseña mejor que cualquier Español.</a> </figcaption>
                        <p>Profesor local con canal de YouTube enseña mejor que Españoles e Indios con asento raro.</p>
                      </figure>
                    </li>
                  </ul>
                </div>
                <div class="single_post_content_right">
                  <ul class="spost_nav">
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/screen.png"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 1</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/DavePlusPlus.jpg"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 2</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/DaveLantern.png"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 3</a> </div>
                      </div>
                    </li>
                    <li>
                      <div > <a href="./single_page.php" class="media-left"> <img alt="" src="images/acercate-viejo-acércate-come-closer.gif"> </a>
                        <div class="media-body"> <a href="./single_page.php" > Noticia Dummy 4</a> </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div> -->
              
            </div>
          </div>
        
          <?php include_once('./php/featured.php'); ?>
        </div>
        </section>
        <?php include_once('./php/footer.php') ?>
      </div>
    </body>