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
            header('Location: index.php');
        }
      }else{ 
        header('Location: index.php');
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
        <script type=text/Javascript src="assets/js/validate/newsDashboard.js"></script>
    </head>
    <body>
        <main class="user-dashboard" style="background: white;">
            <?php include_once('./php/header.php');?>

            <h2>News Dashboard</h2>

            <form method="get" >
                <div style="display: flex;">
                    <div style="margin-right: 5px;">
                        <label for="start">Filtros:</label> <br>
                        <ul style="display: flex;">
                            <li style="margin-right: 5px;">
                                <p>Estado</p>
                                <select name="Estado" id="NewState">
                                    <option value="1">Todas</option>
                                    <?php 
                                    if(strcmp($type,"Reporter")==0){
                                        echo '<option value="2">Redacción</option>';
                                    }
                                    ?>
                                    <option value="3">Publicada</option>
                                    <?php 
                                    if(strcmp($type,"Admin")==0){
                                        echo '<option value="4">Terminada</option>';
                                    }
                                    ?>
                                </select>
                            </li>
                            <li style="margin-right: 5px;">
                                <p>Orden</p>
                                <select name="Orden" id="NewOrder">
                                    <option value="1">Más Reciente</option>
                                    <option value="2">Más Antigua</option>
                                </select>
                            </li>
                            <li style="margin-right: 5px;">
                                <p>Texto</p>
                                <select name="Texto" id="NewText">
                                    <option value="1">Todas</option>
                                    <option value="2">Titulo</option>
                                    <option value="3">Categoria</option>
                                    <option value="4">Etiqueta</option>
                                    <?php 
                                    if(strcmp($type,"Admin")==0){
                                        echo '<option value="5">Autor</option>';
                                    }
                                    ?>
                                </select>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-right: 5px;">
                        <label for="start">Fecha:</label> <br>
                        <ul style="display: flex;">
                            <li style="margin-right: 5px;">
                                <p>Despues de:</p>
                                <input type="date" name="fechaMin" id="fechaMin"> <br> <br>
                            </li>
                            <li style="margin-right: 5px;">
                                <p>Antes de:</p>
                                <input type="date" name="fechaMax" id="fechaMax">
                            </li>
                        </ul>
                        
                    </div>
                    <div style="margin-right: 5px;">
                    <label for="start" ></label> <br>
                    <ul style="display: flex;">
                    <li style="margin-right: 5px;">
                    
                                <p>Tipo de fecha</p>
                                <select name="TypeDate" id="TypeDate">
                                    <option value="1">Publicacion</option>
                                    <option value="2">Creacion</option>
                                    <option value="3">Modificacion</option>
                                    <option value="4">de Acontecimientos</option>
                                </select>

                    </li>
                    </ul>
                    </div>
                </div>
                
                
                <input class="user-dashboard-search" name="query_text" type="text" placeholder="Search..."/>

                <button id="Buscar" class="botoncito" onclick="valBusqueda()">Buscar</button>
                <br><br>
                
            </form>
            
            <div class="user-card-container">
                <?php
                    //Importar la funcion template
                    require_once './php/newsCard.php';
                    $news=null;
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                        $url = "https://";   
                        else  
                                $url = "http://";   
                    $url.= $_SERVER['HTTP_HOST']; 
                    $url.= $_SERVER['REQUEST_URI'];    
                    $components = parse_url($url,PHP_URL_QUERY);
                    parse_str($components, $results);
                    $paramAmount= sizeOf($results);


                    if($paramAmount>0){ //Busquedas
                        if(strcmp($type,"Reporter")==0){
                            $iduser=$_SESSION["ID_USER"];
                            $exec=NewsContr::constGetRepNews($iduser);

                            $Estado = $_GET["Estado"];
                            $Orden = $_GET["Orden"];
                            $Texto = $_GET["Texto"];
                            $fechaMin = $_GET["fechaMin"];
                            $fechaMax = $_GET["fechaMax"];
                            $TipoFecha = $_GET["TypeDate"];
                            $query = $_GET["query_text"];
                            $news=$exec->getNewsReporterBusqueda($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query);
                        
                            if($news!=null ){
                                $stat; 
                                foreach($news as $new){
                                    if(strcmp($new['STATUS'],"Publicada")==0){
                                        $stat=1;
                                    }else if(strcmp($new['STATUS'],"Terminada")==0){
                                        $stat=2;
                                    }else if(strcmp($new['STATUS'],"En Redacción")==0){
                                        $stat=3;
                                    }
                                    echo NewsCard(
                                        $new['NEWS_ID'], //id
                                        $new['TITLE'], //nombre de la noticia
                                        $new['DESCRIPTION'], //descripcion,resumen
                                        $new['PHOTO'], //imagen
                                        $stat, //tipo: en publicada, terminada, en redaccion
                                        $type 
                                    );
                                }
                                
                            }
                            
                        }else if(strcmp($type,"Admin")==0){
                            $iduser=$_SESSION["ID_USER"];
                            $exec=new NewsContr();
                            
                            $Estado = $_GET["Estado"];
                            $Orden = $_GET["Orden"];
                            $Texto = $_GET["Texto"];
                            $fechaMin = $_GET["fechaMin"];
                            $fechaMax = $_GET["fechaMax"];
                            $TipoFecha = $_GET["TypeDate"];
                            $query = $_GET["query_text"];
                            $news=$exec->getNewsAdminBusqueda($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query);
                        
                            if($news!=null ){
                                $stat; 
                                foreach($news as $new){
                                    if(strcmp($new['STATUS'],"Publicada")==0){
                                        $stat=1;
                                    }else if(strcmp($new['STATUS'],"Terminada")==0){
                                        $stat=2;
                                    }else if(strcmp($new['STATUS'],"En Redacción")==0){
                                        $stat=3;
                                    }
                                    echo NewsCard(
                                        $new['NEWS_ID'], //id
                                        $new['TITLE'], //nombre de la noticia
                                        $new['DESCRIPTION'], //descripcion,resumen
                                        $new['PHOTO'], //imagen
                                        $stat, //tipo: en publicada, terminada, en redaccion
                                        $type 
                                    );
                                }
                                
                            }
                        }
                    }else{ //Sin Buscar
                        if(strcmp($type,"Reporter")==0){
                            $iduser=$_SESSION["ID_USER"];
                            $exec=NewsContr::constGetRepNews($iduser);
                            $news=$exec->getNewsReporter();
                        
                            if($news!=null ){
                                $stat; 
                                if(is_array($news)){
                                    foreach($news as $new){
                                        if(strcmp($new['STATUS'],"Publicada")==0){
                                            $stat=1;
                                        }else if(strcmp($new['STATUS'],"Terminada")==0){
                                            $stat=2;
                                        }else if(strcmp($new['STATUS'],"En Redacción")==0){
                                            $stat=3;
                                        }
                                        echo NewsCard(
                                            $new['NEWS_ID'], //id
                                            $new['TITLE'], //nombre de la noticia
                                            $new['DESCRIPTION'], //descripcion,resumen
                                            $new['PHOTO'], //imagen
                                            $stat, //tipo: en publicada, terminada, en redaccion
                                            $type 
                                        );
                                    }
                                }else{
                                    if(strcmp($news['STATUS'],"Publicada")==0){
                                        $stat=1;
                                    }else if(strcmp($news['STATUS'],"Terminada")==0){
                                        $stat=2;
                                    }else if(strcmp($news['STATUS'],"En Redacción")==0){
                                        $stat=3;
                                    }
                                    echo NewsCard(
                                        $news['NEWS_ID'], //id
                                        $news['TITLE'], //nombre de la noticia
                                        $news['DESCRIPTION'], //descripcion,resumen
                                        $news['PHOTO'], //imagen
                                        $stat, //tipo: en publicada, terminada, en redaccion
                                        $type
                                    );
                                }
                                
                            }
                            
                        }else if(strcmp($type,"Admin")==0){
                            $iduser=$_SESSION["ID_USER"];
                            $exec=new NewsContr();
                            $news=$exec->getAllNewsCards();
                            if($news!=null ){
                                $stat; 
                                if(is_array($news)){
                                    foreach($news as $new){
                                        if(strcmp($new['STATUS'],"Publicada")==0){
                                            $stat=1;
                                        }else if(strcmp($new['STATUS'],"Terminada")==0){
                                            $stat=2;
                                        }else if(strcmp($new['STATUS'],"En Redacción")==0){
                                            $stat=3;
                                        }
                                        echo NewsCard(
                                            $new['NEWS_ID'], //id
                                            $new['TITLE'], //nombre de la noticia
                                            $new['DESCRIPTION'], //descripcion,resumen
                                            $new['PHOTO'], //imagen
                                            $stat, //tipo: en publicada, terminada, en redaccion
                                            $type 
                                        );
                                    }
                                }else{
                                    if(strcmp($news['STATUS'],"Publicada")==0){
                                        $stat=1;
                                    }else if(strcmp($news['STATUS'],"Terminada")==0){
                                        $stat=2;
                                    }else if(strcmp($news['STATUS'],"En Redacción")==0){
                                        $stat=3;
                                    }
                                    echo NewsCard(
                                        $news['NEWS_ID'], //id
                                        $news['TITLE'], //nombre de la noticia
                                        $news['DESCRIPTION'], //descripcion,resumen
                                        $news['PHOTO'], //imagen
                                        $stat, //tipo: en publicada, terminada, en redaccion
                                        $type
                                    );
                                }
                                
                            }
                        }
                    }
                    
                ?>
            </div>
        </main>
    <body>