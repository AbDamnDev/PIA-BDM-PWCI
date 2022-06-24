<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/Proyecto-BDM-PWCI/php/backend/Conexion_class.php") ;
include_once __DIR__."/../Conexion_class.php";
class Comments extends Conexion{
    protected function setUnsetLike($id,$newsID,$like){
        if($like==1){
            $stmt = $this->connect()->prepare('INSERT INTO NEWS_LIKES(`NEWS_ID`,`USER_ID`,`ACTIVE`) VALUES(:snews_id,:suser_id,:sbind_bit);');
            $stmt->bindValue(':sbind_bit', (bool)$like, PDO::PARAM_BOOL);
        }else{
            $stmt = $this->connect()->prepare('DELETE FROM NEWS_LIKES WHERE NEWS_ID=:snews_id AND `USER_ID`=:suser_id AND `ACTIVE`=1;');
        }
       
        $stmt->bindValue(':suser_id', (int)$id, PDO::PARAM_INT);
        $stmt->bindValue(':snews_id', (int)$newsID, PDO::PARAM_INT);
        if(!$stmt->execute()){
            $stmt = null;
            $result="false";
        
        }else{
            $result="true";
        }
        $stmt = null;
        return $result;
    }
    protected function getLikes($newsID){
        $stmt = $this->connect()->prepare('SELECT GET_NEWS_LIKES(?) AS"LIKES";');
        if(!$stmt->execute(array($newsID))){
            $stmt = null;
            $result="false";
        }else{
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result= $queryResult[0]['LIKES'];
        }
        $stmt = null;
        return $result;
    }
    protected function userHasLike($id,$newsID){
        $stmt = $this->connect()->prepare('SELECT GET_USER_HAS_LIKE(?,?) AS "HAS_LIKE";');
        if(!$stmt->execute(array($newsID,$id))){
            $stmt = null;
            $result="false";
        }else{
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result= $queryResult[0]['HAS_LIKE'];
        }
        $stmt = null;
        return $result;
    }
    protected function insertComment($comment,$id,$parent,$newsID){
        $stmt = $this->connect()->prepare('CALL insertNewsComments(?,?,?,?); ');
        if(!$stmt->execute(array($comment,$id,$parent,$newsID))){
            $stmt->closeCursor();
            $stmt = null;
            $result="false";
        }else{
            $stmt->closeCursor();
            $result= "true";
        }
        $stmt = null;
        return $result;
    }
    protected function canDeleteComment($id,$newsID,$comm_id){
        $result= "false";
        $stmt = $this->connect()->prepare('SELECT `ACTIVE` FROM USERS WHERE USER_TYPE_ID=1 AND `USER_ID`=?;');
        if(!$stmt->execute(array($id))){
            $stmt = null;
            $result="stmtfailed";
        }else{
            if($stmt->rowCount() == 0){ //como no hay resultados seguimos buscando
                $stmt = null;
                $stmt = $this->connect()->prepare('SELECT `ACTIVE` FROM NEWS WHERE NEWS_ID=? AND CREATED_BY=?;');
                if(!$stmt->execute(array($newsID,$id))){
                    $stmt = null;
                    $result="stmtfailed";
                }else{
                    if($stmt->rowCount() == 0){// no hay resultados buscamos si es el dueño del comentario
                        $stmt=null;
                        $stmt = $this->connect()->prepare('SELECT NC.`ACTIVE` FROM NEWS_COMMENTS AS NC
                        INNER JOIN COMMENTS AS C ON NC.COMMENT_ID=C.COMMENT_ID
                        WHERE NC.COMMENT_ID=? AND NC.NEWS_ID=? AND C.CREATED_BY=?;');
                        if(!$stmt->execute(array($comm_id,$newsID,$id))){
                            $stmt = null;
                            $result="stmtfailed";
                        }else{
                            if($stmt->rowCount() == 0){
                                $result= "false";
                            }else{
                                $result= "true";
                            }
                        }
                    }else{
                        $result= "true";
                    }
                }
            }else{ //si hay un resultado entonces tiene permiso
                $result= "true";
            }
           
        }
        $stmt = null;
        return $result;
    }
    protected function deleteComments($comm_id,$newsID){
        $stmt = $this->connect()->prepare('CALL deleteComments(?,?)');
        if(!$stmt->execute(array($comm_id,$newsID))){
            $stmt = null;
            $result="false";
        }else{
            $result= "true";
        }
        $stmt = null;
        return $result;
    }
}
?>