<header >
    <div >
        <div class="col-lg-12 col-md-12 col-sm-12 logo">
                <div><a href="index.php" ><img src="images/logo.png" alt=""></a></div>
        </div>
    </div>
</header>
<section id="navArea">
    <nav class="navbar navbar-inverse" style="display: flex;">
        <div  class="navbar-collapse" style="margin-left: 10px;">
            <ul class="navbar-nav" style="display: flex;">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="contact.php">Contactanos</a></li>
                <li><a href="news-searcher.php">News Searcher</a></li> 
                <!--li><a href="404.php">404</a></li-->
                <?php
               
                if(isset($_SESSION["ID_USER"])){
                    $typeU=LoginContr::constIDtype($_SESSION["ID_USER"]);
                    $finalResponse=$typeU->myUserType();
                    if($finalResponse!="stmtfailed"&& $finalResponse!="userNotFound"){
                        if(strcmp($finalResponse,"Admin")==0){
                            echo '<li><a href="news-editor.php">News Editor</a></li>';
                            echo '<li><a href="news-dashboard.php">News Dashboard</a></li>';
                            echo '<li><a href="user-dashboard.php">User Dashboard</a></li>';
                            echo '<li><a href="category-dashboard.php">Categories Dashboard</a></li>';
                        }else if(strcmp($finalResponse,"Reporter")==0){
                            echo '<li><a href="news-editor.php">News Editor</a></li>';
                            echo '<li><a href="news-dashboard.php">News Dashboard</a></li>';
                        }
                    }
                ?>
                
            </ul>
        </div>

        <div class="LugarUsuario" >
            <?php
            
                $profile = LoginContr::constIDtype($_SESSION["ID_USER"]);
                $encodedResult=$profile->myImageAndName();
                $decodedResult=json_decode($encodedResult,true);
                if($decodedResult!=null && $decodedResult['result']=="true"){
                    $fullname=$decodedResult['data'][0]['USER_FULL_NAME'];
                    $profpic=$decodedResult['data'][0]['PROFILE_PIC'];
                    if($fullname!=null||$profpic!=null){
                        //aqui hay que ver q pedo pa pasar los datos
            ?>

            <div >
                <div id="nomUs" style="color: white"><?php  if($fullname!=null){
                    echo $fullname;
                }else{
                    echo "Anonimo";
                } ?></div>

                <form action="Includes\users\LogOut_include.php" method="post">
                    <input type="submit" name="submitclose" value="Cerrar Sesion" /> <!--class botoncito-->
                </form>
            </div>
            

            <a href="user-page.php"><img id="imgUs" <?php if($profpic!=null){
                echo 'src="'.$profpic.'"';
            }else{
                echo 'src="images/User.png"';
            }
            ?>  alt="Imagen Usuario" width="50" height="50"></a>
            
            
        
            <?php
            }}}else{
                //  ALINEAR LAS COSAS
                echo
                '<ul id="IniciarSesion" class="navbar-nav">
                    <li><a href="login.php" style="color: white" >Iniciar sesion</a></li> 
                </ul>';
            }
            ?>
        </div>
    </nav>
</section>
