<footer >
  <div class="footer_top">
    <div >
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div >
          <h2>Categorias</h2>
          <ul class="tag_nav">
          <?php
                  include_once("php/backend/News/Categories_controller_class.php") ;
                            $loader=new Categories();
                            $resultCat=$loader->getAllCategories();
                            if ($resultCat!=null&& $resultCat!="stmtfailed"){
                                foreach ($resultCat as $cat) {
                                    echo '<li data-cat-id="'.$cat["CATEGORY_ID"].'" ><a href="news-searcher.php?Texto=3&query=='.$cat["CATEGORY_ID"].'&Orden=1&fechaMin=&fechaMax=">'.$cat["DESCRIPTION"].'</a></li>';
                                }
                            }else{
                              echo '<li><a href="#">Deportes</a></li>
                              <li><a href="#">Moda</a></li>
                              <li><a href="#">Negocios</a></li>
                              <li><a href="#">Tecnologia</a></li>
                              <li><a href="#">Estilo de vida</a></li>
                              <li><a href="#">Politica</a></li>
                              <li><a href="#">Entretenimiento</a></li>';
                            }
                        ?>
            
          </ul>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div >
          <h2>Info. Contacto</h2>
          <p>Noticias Noticiosas S.A. de C.V.</p>
          <p>Cel: +81 8116016577</p>
          <p>Tel: +85 85574442</p>
          <p>Correo: noticiasnoticiosas@fake.com</p>
        </div>
      </div>
    </div>
  </div>
</footer>