<?php include_once "php/backend/News/GetDashboardProcess.php"; ?>

<head>
  <link rel="stylesheet" type="text/css" href="assets/css/user-dashboard.css">
  <script type="text/Javascript" src="assets/libs/jquery-3.6.0.min.js"></script>
  <script type="text/Javascript" src="assets/js/validate/formBusqueda.js"></script>
  <link rel="stylesheet" href="assets/css/sweetalert2.css">
  <script src="assets/js/sweetalert2.js"></script>
</head>

<div class="col-lg-4 col-md-4 col-sm-4">
        <aside class="right_content">
          <div class="single_sidebar">
            <h2><span>Noticias Populares</span></h2>
            <ul class="spost_nav">
            <?php
              $i = 1;
              foreach ($res2 as $aux){
              ?>
              <li>
                <div > <a href="single_page.php?newsid=<?php echo $aux['NEWS_ID']; ?>" class="media-left"> <img alt="" src="<?php echo $aux['NEWS_PHOTO']; ?>"> </a>
                  <div class="media-body"> <a href="single_page.php?newsid=<?php echo $aux['NEWS_ID']; ?>"><?php echo $aux['TITLE']; ?></a> </div>
                </div>
              </li>
              <?php
              }
              ?>
            </ul>
            <a href="404.php?Categorias=&Inicio=&Final=">Top Likes</a>
          </div>
          
          <div class="single_sidebar">
            <h2><span>Busqueda</span></h2>
              <div >
              	<form id="formSearch" name="formSearch">
                <input class="user-dashboard-search" id="busqueda" name="busqueda" type="text" placeholder="Search..."/>
                <label for="start">Fecha de publicación:</label> <br>
                <p>Despues de:</p>
                <input type="date" name="fechaMin" id="fechaMin"> <br> <br>
                <p>Antes de:</p>
                <input type="date" name="fechaMax" id="fechaMax">
                <p></p>
                <button type="button"id="Buscar" class="botoncito" onclick="valBusqueda()">Buscar</button>
                </form>
              </div>
          </div>

          <div class="single_sidebar">
            <h2><span>Categorias</span></h2>
              <div >
                <div>
                  <ul>
                  <?php
                  require_once("php/backend/News/Categories_controller_class.php") ;
                            $loader=new Categories();
                            $resultCat=$loader->getAllCategories();
                            if ($resultCat!=null&& $resultCat!="stmtfailed"){
                                foreach ($resultCat as $cat) {
                                  $hexRGB = substr($cat["COLOR"], 1);
                                  if(hexdec(substr($hexRGB,0,2))+hexdec(substr($hexRGB,2,2))+hexdec(substr($hexRGB,4,2))> 381){
                                      //bright color
                                      echo '<li class="cat-item"  data-cat-id="'.$cat["CATEGORY_ID"].'" ><a style="background-color: '.$cat["COLOR"].'; color: black;" href="news-searcher.php?Texto=3&query='.$cat["DESCRIPTION"].'&Orden=1&fechaMin=&fechaMax=">'.$cat["DESCRIPTION"].'</a></li>';
                                  }else{
                                      //dark color
                                      echo '<li class="cat-item"  data-cat-id="'.$cat["CATEGORY_ID"].'" ><a style="background-color: '.$cat["COLOR"].'; color: white;" href="news-searcher.php?Texto=3&query='.$cat["DESCRIPTION"].'&Orden=1&fechaMin=&fechaMax=">'.$cat["DESCRIPTION"].'</a></li>';
                                  }
                                }
                            }else{
                              echo '<li class="cat-item"><a href="#">Deportes</a></li>
                              <li class="cat-item"><a href="#">Moda</a></li>
                              <li class="cat-item"><a href="#">Negocios</a></li>
                              <li class="cat-item"><a href="#">Tecnologia</a></li>
                              <li class="cat-item"><a href="#">Estilo de vida</a></li>
                              <li class="cat-item"><a href="#">Politica</a></li>
                              <li class="cat-item"><a href="#">Entretenimiento</a></li>';
                            }
                        ?>
                    
                  </ul>
                </div>
              </div>
          </div>

        </aside>
</div>