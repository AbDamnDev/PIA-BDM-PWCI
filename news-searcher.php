<?php
include_once("php/backend/Users/Login_controller_class.php");
include_once("php/backend/News/News_controller_class.php") ;
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
            //header('Location: index.php');
                // TODO: HACER QUE LA PAGINA FUNCIONE PARA QUE CUALQUIER USUARIO HAGA BUSQUEDAS, no necesitar el $_SESSION['ID_USER]
        }
      }else{ 
        //header('Location: index.php');
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
        <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font.css">
        <link rel="stylesheet" type="text/css" href="assets/css/user-dashboard.css">
        <link rel="stylesheet" type="text/css" href="assets/css/news-card.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="assets/css/stylesheets.css">
        <link rel="stylesheet" href="assets/css/sweetalert2.css">

        <script src="assets/js/fontawesome.min.js"></script>
        <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
         <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>
        <script type=text/Javascript src="assets/js/validate/newsSearcher.js"></script>
        <script type=text/Javascript src="assets/js/validate/formBusqueda.js"></script>
    </head>
    <body>
        <main class="user-dashboard" style="background: white;">
            <?php include_once('./php/header.php');?>

            <h2>News Searcher</h2>
            <?php
                
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                    $url = "https://";   
                    else  
                            $url = "http://";   
                $url.= $_SERVER['HTTP_HOST']; 
                $url.= $_SERVER['REQUEST_URI'];    
                $components = parse_url($url,PHP_URL_QUERY);
                parse_str($components, $results);
                $paramAmount= sizeOf($results);
                if (isset($results['query'])&&$results['query']!=null){
                    $querystring=$results['query'];
                }else{
                    $querystring="";
                }
                if (isset($results['Orden'])&&$results['Orden']!=null){
                    $Orderstring=$results['Orden'];
                }else{
                    $Orderstring=0;
                }
                if (isset($results['Texto'])&&$results['Texto']!=null){
                    $Textostring=$results['Texto'];
                }else{
                    $Textostring=0;
                }
                if (isset($results['fechaMin'])&&$results['fechaMin']!=null){
                    $fechMinstring=$results['fechaMin'];
                }else{
                    $fechMinstring=null;
                }
                if (isset($results['fechaMax'])&&$results['fechaMax']!=null){
                    $fechMaxstring=$results['fechaMax'];
                }else{
                    $fechMaxstring=null;
                }

            ?>
            <form method="get" > <!-- name="searchPage" id="searchPage" -->
                <div style="display: flex;">
                    <div style="margin-right: 5px;">
                        <label for="start">Filtros:</label> <br>
                        <ul style="display: flex;">
                            <li style="margin-right: 5px;">
                                <p>Orden</p>
                                <select name="Orden" id="NewOrder">
                                    <option value="1" <?php if ($Orderstring== '1') echo ' selected="selected"'; ?>>Más Reciente</option>
                                    <option value="2" <?php if ($Orderstring== '2') echo ' selected="selected"'; ?>>Más Antigua</option>
                                </select>
                            </li>
                            <li style="margin-right: 5px;">
                                <p>Texto</p>
                                <select name="Texto" id="NewText">
                                    <option value="1" <?php if ($Textostring== '1') echo ' selected="selected"'; ?>>Todas</option>
                                    <option value="2" <?php if ($Textostring== '2') echo ' selected="selected"'; ?>>Titulo</option>
                                    <option value="3" <?php if ($Textostring== '3') echo ' selected="selected"'; ?>>Categoria</option>
                                    <option value="4" <?php if ($Textostring== '4') echo ' selected="selected"'; ?>>Etiqueta</option>
                                    <option value="5" <?php if ($Textostring== '5') echo ' selected="selected"'; ?>>Autor</option>
                                </select>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-right: 5px;">
                        <label for="start">Fecha de publicación:</label> <br>
                        <ul style="display: flex;">
                            <li style="margin-right: 5px;">
                                <p>Despues de:</p>
                                <input type="date" name="fechaMin" id="fechaMin" value="<?php if($fechMinstring!=null) echo $fechMinstring; ?>"> <br> <br>
                            </li>
                            <li style="margin-right: 5px;">
                                <p>Antes de:</p>
                                <input type="date" name="fechaMax" id="fechaMax"  value="<?php if($fechMaxstring!=null) echo $fechMaxstring; ?>">
                            </li>
                        </ul>
                    </div>
                </div>
               
                
                <input class="user-dashboard-search" name="query" type="text" placeholder="Search..." value="<?php echo $querystring ?>"/>

                <button id="Buscar" class="botoncito" onclick="valBusqueda()">Buscar</button>
                <br><br>
                
            </form>
            
            <div class="user-card-container">
                <?php
                    //Importar la funcion template
                    require_once './php/newsSearchCard.php';
                    $news=null;
                    if($paramAmount>0){
                        $iduser=$_SESSION["ID_USER"];
                        $exec=new NewsContr();

                        $Orden = $_GET["Orden"];
                        $fechaMin = $_GET["fechaMin"];
                        $fechaMax = $_GET["fechaMax"];
                        $Texto = $_GET["Texto"];
                        $query = $_GET["query"];
                        $news=$exec->getBusquedaPublica($Orden, $Texto, $fechaMin, $fechaMax, $query);
                        if($news!=null ){
                            $stat;
                            foreach($news as $new){
                                echo NewsCardP(
                                    $new['NEWS_ID'], //id
                                    $new['TITLE'], //nombre de la noticia
                                    $new['Resumen'], //descripcion,resumen
                                    $new['NEWS_PHOTO'], //imagen
                                    $new['DESCRIPTION'], //categorias
                                    $new['KEY_WORDS'], //palabras clave
                                    $new['NEWS_PUBLISH_DATE'] //fecha de publicacion
                                );
                            } 
                            
                        }else{
                            echo 'aun no hay noticia publicadas';
                        }
                    }else{
                    
                        $iduser=$_SESSION["ID_USER"];
                        $exec=new NewsContr();
                        $news=$exec->getAllPubNews();
                        if($news!=null ){
                            $stat; 
                            if(is_array($news)){
                                foreach($news as $new){
                                    echo NewsCardP(
                                        $new['NEWS_ID'], //id
                                        $new['TITLE'], //nombre de la noticia
                                        $new['DESCRIPTION'], //descripcion,resumen
                                        $new['NEWS_PHOTO'], //imagen
                                        $new['CATEGORIES_NAME'], //categorias
                                        $new['KEY_WORDS'], //palabras clave
                                        $new['NEWS_PUBLISH_DATE'] //fecha de publicacion
                                    );
                                }
                            }else{
                                echo NewsCardP(
                                    $news['NEWS_ID'], //id
                                    $news['TITLE'], //nombre de la noticia
                                    $news['DESCRIPTION'], //descripcion,resumen
                                    $news['PHOTO'], //imagen
                                    $news['CATEGORIES_NAME'], //categorias
                                    $news['KEYWORDS'], //palabras clave
                                    $news['NEWS_PUBLISH_DATE'] //fecha de publicacion
                                );
                            }
                            
                        }else{
                            echo 'aun no hay noticia publicadas';
                        }
                    }
                    
                ?>
            </div>
        </main>
    <body>