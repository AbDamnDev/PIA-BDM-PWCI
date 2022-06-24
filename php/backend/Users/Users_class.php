<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/Proyecto-BDM-PWCI/php/backend/Conexion_class.php") ;
include_once __DIR__."/../Conexion_class.php";
class Users extends Conexion{

    protected function checkEmail($email){
        $stmt = $this->connect()->prepare('SELECT EMAIL FROM USERS WHERE EMAIL = ?;');
        if(!$stmt->execute(array($email))){
            $stmt = null;
            $result="stmtfailed";
            exit();
        }
        $check;
        if($stmt->rowCount() > 0){
            $check = false;
        }else{
            $check = true;
        }
        $stmt = null;
        return $check;
    }
    protected function checkusername($username){
        $check;
        $stmt = $this->connect()->prepare('SELECT `USERNAME` FROM USERS WHERE `USERNAME` = ?;');
        if(!$stmt->execute(array($username))){
            $stmt = null;
            $check="stmtfailed";
            exit();
        }
       
        if($stmt->rowCount() > 0){
            $check = false;
        }else{
            $check = true;
        }
        $stmt = null;
        return $check;

    }

    protected function checkSameKeys($email,$username,$id){
        $result;
        $stmt = $this->connect()->prepare('SELECT `EMAIL`, `USERNAME` FROM USERS WHERE `USER_ID` = ?;');
        if(!$stmt->execute(array($id))){
            $stmt = null;
            $result="stmtfailed";
        }
        if($stmt->rowCount() > 0){
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $baseEmail= $queryResult[0]["EMAIL"];
            $baseUsername= $queryResult[0]["USERNAME"];
            if(strcmp($baseEmail,$email)==0&&strcmp($baseUsername,$username)==0){
                $result="SameEmailnUser";
            }else if(strcmp($baseEmail,$email)==0){
                $result="SameEmail";
            }else if(strcmp($baseUsername,$username)==0){
                $result="SameUser";
            }else{
                $result="DiffEmailnUser";
            }
        }else{
           $result="usNotFound";
        }
        $stmt = null;
        return $result;
    }

    protected function modUser($id,$email,$pwd,$fullname,$username,$phone,$birth,$photo){
        try{
            $stmt = $this->connect()->prepare('CALL modUserInfo(?,?,?,?,?,?,?,?)');
            if(!$stmt->execute(array($id,$email,$pwd,$fullname,$username,$phone,$birth,$photo))){
                $stmt = null;
                $result="stmtfailed";
                return $result;
            }
            $result="true";
            $stmt = null;
            return $result;
        }catch(PDOException $e){
            $result=$e->getMessage();
            $stmt = null;
            return $result;
        }

    }
    protected function register($email,$password, $name, $username, $phone, $birth){
        $stmt = $this->connect()->prepare('CALL registerUser(?,?,?,?,?,?)');
        
        $hashPwd = password_hash($password,PASSWORD_DEFAULT);

        if(!$stmt->execute(array($email,$hashPwd,$name,$username,$phone,$birth))){
            $stmt = null;
            return false;
        }
        $stmt = null;
        return true;
    }

    protected function getID($email){
        $result;
        $stmt = $this->connect()->prepare("SELECT GET_ID_AFTER_REGISTER(?) AS USERID;");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            $result="stmtfailed";
           
        }
        if($stmt->rowCount() == 0){ 
            $stmt = null;
            $result="userNotFound";
           
        }else{
            session_start();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["ID_USER"] = $queryResult[0]["USERID"];
            $result="true";
        }
        $stmt = null;
        return $result;
    }
    protected function getUserInfo($userID){
        $stmt = $this->connect()->prepare('CALL getUserInfo(?);');
        if(!$stmt->execute(array($userID))){
            $stmt = null;
            $result="stmtfailed";
           
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
    protected function getAllUsers($userID){
        $stmt = $this->connect()->prepare('CALL getAllUsers(?);');
        if(!$stmt->execute(array($userID))){
            $stmt = null;
            $result="stmtfailed";
           
        }
        if($stmt->rowCount() == 0){ 
            $stmt = null;
            $result=null;
           
        }else{
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result= $queryResult;
        }
        $stmt = null;
        return $result;
    }
    protected function changeUserType($idUser,$idAdmin,$newtype){
        $stmt = $this->connect()->prepare('CALL changeUserType(?,?,?);');
        if(!$stmt->execute(array($newtype,$idUser,$idAdmin))){
            $stmt = null;
            $result="stmtfailed";
           
        }else{
            $result="true";
        }
        $stmt = null;
        return $result;
    }
    protected function BlockUnblockUser($idUser,$idAdmin,$opblockUnblock){
        $stmt = $this->connect()->prepare('CALL blockUnblockUs(?,?,?);');
        if(!$stmt->execute(array($opblockUnblock,$idUser,$idAdmin))){
            $stmt = null;
            $result="stmtfailed";
           
        }else{
            $result="true";
        }
        $stmt = null;
        return $result;
    }
    protected function delUser($idUser,$idAdmin){
        $stmt = $this->connect()->prepare('CALL delUser(?,?);');
        if(!$stmt->execute(array($idUser,$idAdmin))){
            $stmt = null;
            $result="stmtfailed";
           
        }else{
            $result="true";
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
           
        }
        if($stmt->rowCount() == 0){ 
            $stmt = null;
            //header("location: ../login.php?error=userNotFound");
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