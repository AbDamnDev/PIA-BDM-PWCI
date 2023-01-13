<?php
class Conexion{

    protected function connect(){
        try{

            $server="localhost"; 
            $username="root"; 
            $password="root"; //esta es la que puede cambiar
            //$password="password"; //root password
            $database="NEWS_DAILY_PLANET";

            $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password);
            return $conn;
        }
        catch(PDOException $error){
            die("Connection failed " . $error->getMessage());
        }
    }
}
?>