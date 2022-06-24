<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/Proyecto-BDM-PWCI/php/backend/Conexion_class.php");
include_once __DIR__."/../Conexion_class.php";
class Login extends Conexion{
    
    protected function sign_in($email,$password){
        $result;
        $stmt = $this->connect()->prepare('CALL loginEmail(?)');
        if(!$stmt->execute(array($email))){
            $stmt = null;
            $result="stmtfailed";
            return $result;
        }

        $check;
        if($stmt->rowCount() == 0){ 
            $stmt = null;
          
            $result="userNotFound";
            return $result;
           
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($password,$pwdHashed[0]["USER_PWD"]);
        
        
       
        if( $checkPwd == false ){
            $stmt = null;
          
            $result="wrongPassword";
            
        }else if($checkPwd == true){
            session_start();
            $_SESSION["ID_USER"] = $pwdHashed[0]["USER_ID"];
          
            $stmt = null;
           
            $result="true";
            
        }
        $stmt = null;
        return $result;
        
    }

    protected function getTypeUser($userID){
        $result;
        $stmt = $this->connect()->prepare("SELECT GET_USER_TYPE_DESC(USER_TYPE_ID) AS USERTYPE FROM USERS WHERE `USER_ID`= ? ;");
        if(!$stmt->execute(array($userID))){
            $stmt = null;
            $result="stmtfailed";
            return $result;
           
        }
        if($stmt->rowCount() == 0){ 
            $stmt = null;
            $result="userNotFound";
           
        }else{
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result= $queryResult[0]["USERTYPE"];
        }
        $stmt = null;
        return $result;
    }

    protected function getImageAndName($userID){
        
        $result;
        $stmt = $this->connect()->prepare('CALL getImageAndName(?);');
        if(!$stmt->execute(array($userID))){
            $stmt = null;
            $result="stmtfailed";
            return $result;
           
        }
        if($stmt->rowCount() == 0){ 
            $stmt = null;
            $result="userNotFound";
           
        }else{
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result= $queryResult;
        }
        $stmt = null;
        return $result;


    }

}
?>