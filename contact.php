<?php
include"php/backend/Users/Login_controller_class.php";
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
      <link rel="stylesheet" type="text/css" href="assets/css/font.css">
      <link rel="stylesheet" type="text/css" href="assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="assets/css/stylesheets.css">
  </head>
  <body>

  <div class="container">
    
    <?php include('./php/header.php') ?>  
    <section id="contentSection">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
          <div class="left_content">
            <div class="contact_area">
              <h2>Contactanos</h2>
              <p>¿Tienes una noticia para nosotros? Haznos saber.</p>
              <form action="#" class="contact_form">
                <input class="form-control" type="text" placeholder="Nombre">
                <input class="form-control" type="email" placeholder="Email">
                <textarea class="form-control" cols="30" rows="10" placeholder="Mesage"></textarea>
                <input type="submit" value="Send Message" class="botoncito">
              </form>
            </div>
          </div>
      </div>
      <?php include('./php/featured.php') ?>  
      </div>
    </section>
  <?php include('./php/footer.php') ?>  
  </div>
  
  </body>
    