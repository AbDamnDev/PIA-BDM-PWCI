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
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/stylesheets.css">
    </head>
    <style>
      table.unstyledTable {
        border: 1px solid #000000;
      }
      table.unstyledTable td, table.unstyledTable th {
        border: 1px solid #AAAAAA;
      }
      table.unstyledTable thead {
        background: #DDDDDD;
      }
      table.unstyledTable thead th {
        font-weight: normal;
      }
      table.unstyledTable tfoot {
        font-weight: bold;
      }
    </style>
    <body>
      <div class="container">
        <?php include('./php/header.php') ?>  
        <section id="contentSection">
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
              <div class="left_content">
                <!-- <div class="error_page">
                  <h3>Ups!</h3>
                  <h1>404</h1>
                  <p>Parece que esta pagina no existe o no esta disponible</p>
                </div> -->

                <form action="FiltroReporte.php" method="POST">
                  <label for="Categoria" class="Subtitulos">Categorias de la noticia</label>
                  <select style="text-align: center" class="caja" name="Categoria" id="Categoria">

                    <option value='0'> Todas </option>

                    <?php
                    $var = new News();
                    $res3 = $var->ActiveCatsWActiveNews();

                    foreach ($res3 as $aux) { 
                      echo ('<option value=' . $aux['CATEGORY_ID'] . '>' . $aux['DESCRIPTION']  . '</option>');
                    }

                    ?>
                  </select>
                  <label for="FechaInicio" class="Subtitulos">Fecha Inicio</label>
                  <input type="date" id="FechaInicio" name="FechaInicio" class="FechaInicio"></input>

                  <label for="FechaFinal" class="Subtitulos">Fecha Final</label>
                  <input type="date" id="FechaFinal" name="FechaFinal" class="FechaFinal"></input>


                  <button id="Buscar" class="button"> Ok </button>
                </form>

                <table class="unstyledTable">
                <thead>
                <tr>
                <th>Sección</th>
                <th>Fecha</th>
                <th>Notica</th>
                <th>Likes</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $categoria = $_GET["Categorias"];
                    $FechaInicio = $_GET["Inicio"];
                    $FechaFinal = $_GET["Final"];
                    $Filtro = $var->likeReport($categoria, $FechaInicio, $FechaFinal);
                    foreach ($Filtro as $aux2){
                      echo ('
                      <tr>
          
                      <td>' . $aux2['DESCRIPTION'] . '</td>
          
                      <td>' . $aux2['NEWS_PUBLISH_DATE'] . '</td>
          
                      <td>' . $aux2['TITLE'] . '</td>
          
                      <td>' . $aux2['LIKES'] . '</td>
                      </tr>
                      ');
                      }
                  ?>
                  <tr></tr>
                </tbody>
                </tr>
                </table>
            </div>
          </div>
          <?php include('./php/featured.php') ?>  
          </div>
        </section>
        <?php include('./php/footer.php') ?>  
      </div>
</body>
   
