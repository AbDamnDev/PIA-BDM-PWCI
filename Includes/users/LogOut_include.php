<?php
 session_start();
 
 //unset($_SESSION);
 //unset($_SESSION);
 //$_SESSION = array();
 /*$count=0;

 foreach($_COOKIE as $key => $value){
    if ( $key == "PHPSESSID" ){
       $count++;
    }
 }
 if ($count>0){
    //Destory all cookies here
    foreach($_COOKIE as $key => $value){
          setcookie($key,"",time()-3600,"/");
    }
 }*/
 //session_unset($_SESSION['ID_USER']);
 session_destroy();
 session_start();
 //unset($_SESSION);
 header('Location: ../../login.php');
 exit;
?>