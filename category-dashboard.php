<?php 
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  include_once("php/backend/Users/Login_controller_class.php") ;
  include_once("php/backend/News/Categories_controller_class.php") ;
  if(isset($_SESSION["ID_USER"])){
    $checkUs=$_SESSION["ID_USER"];
    $type=getUserType($checkUs);
    if(strcmp($type,"Admin")==0){

    }else if(strcmp($type,"Reporter")==0){
        header('Location: index.php');
    }else if(strcmp($type,"Registered User")==0){
        header('Location: index.php');
    }
  }else{ 
    header('Location: index.php');
    //no es usuario registrado, no debe volver aqui
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

  function getAllCategories(){
    $loader=new Categories();
    $resultCat=$loader->getAllCategories();
    if ($resultCat!=null&& $resultCat!="stmtfailed"){
        return $resultCat;
    }
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
        
         <!-- Jquery -->
         <script type=text/Javascript src="assets/libs/jquery-3.6.0.min.js"></script>
        
        <!-- sweetalert2 -->
        <script src="assets/js/sweetalert2.js"></script>
        
        <script type=text/Javascript src="assets/js/validate/listboxes.js"></script>
        
        
    </head>
    <body>
        <div class="container">
            <?php include_once('./php/header.php');?>
            <section id="contentSection" class="NewNew">
                <h2>Regsitro de Categorias</h2>
                <form id="CategoriaNueva">
                    <input type="text" id="nombre" name="nombreCategoria" placeholder="Nombre" style="margin-top: 5px;" required>
                    <br> <br>
                    <p>Color:</p>
                    <input type="color" id="color" name="colorS"  style="width:85%;"> <!--value="#ff0000" -->
                    <br> <br>
                    <button type="button" onclick="createCat()">Crear</button>
                    <br> <br>
                </form>

                <h2>Modificar Categorias</h2>
                <form id="ModCategoria">
                    <select name="categorias" id="categorias" placeholder="Seleccione una categoria" style="margin-top: 5px; height: 40px;">
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
                    <br> <br>
                    <input type="text" id="nombreCM" name="nombreCategoria2" placeholder="Nombre" required>
                    <br> <br>
                    <p>Color:</p>
                    <input type="color" id="color2" name="colorS2"  style="width:85%;">
                    <br> <br>
                    <input type="hidden" id="idcat" name="idcat" value=0>
                    <button type="button" onclick="modCat()">Modificar</button> <button  type="button" onclick="delCat()">Eliminar</button>
                    <br> <br>
                </form>

                <h2>Acomodar Categorias</h2>
                <form id="ordCategories">
                    <div class="approveTermsContainer">
                        <div class="newItems">
                            <b>Lista de Categorias:</b><br/>
                            <select multiple="multiple" id='lstBox1'>
                            <?php
                            $loader=new Categories();
                            $resultCat=$loader->getAllCategories();
                            if ($resultCat!=null&& $resultCat!="stmtfailed"){
                                foreach ($resultCat as $cat) {
                                    echo '<option value= "'.$cat["CATEGORY_ID"].'" >'.$cat["DESCRIPTION"].'</option>';
                                }
                            }else{
                                echo'<option value="ajax">Ajax</option>
                                <option value="jquery">jQuery</option>
                                <option value="javascript">JavaScript</option>
                                <opion value="mootool">MooTools</option>
                                <option value="prototype">Prototype</option>
                                <option value="dojo">Dojo</option>';
                            }
                        ?>
                                
                            </select>
                        </div>

                        <div class="transferBtns">
                            <input type='button' id='btnRight' value ='  >  '/>
                            <br/>
                            <input type='button' id='btnLeft' value ='  <  '/>
                        </div>

                        <div class="approvedItems">
                            <b>Orden de Categorias: </b><br/>
                            <select multiple="multiple" id='lstBox2'>
                                
                            </select>
                        </div>

                    </div>

                    <br> <br>
                    <button type="button" onclick="ordCats()">Aplicar</button>
                    <button type="button" onclick="resetPage()">Resetear</button>
                </form>

                <br> <br><br> <br>

            </section>
        </div>
        
    </body>
    
</html>