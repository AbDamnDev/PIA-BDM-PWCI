<?php 
include_once("Comment_class.php");
class ComContr extends Comments{
    private $ncomid;
    private $nid;
    private $cmtext;
    private $cmdate;
    private $iduser;
    private $cmparent;
    private $cmautortype;
    private $like;
    public function __construct(){
        
    }
    public static function constSetLike($iduser,$newsid,$like){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->like=$like;
        return $instance;
        
    }
    public static function constgetLikes($newsid){
        $instance=new self();
        $instance->nid=$newsid;
        return $instance;
        
    }
    public static function constuserHasLikes($iduser,$newsid){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        return $instance;
        
    }
    public static function constcreateComment($iduser,$newsid,$commenttext,$parent){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->cmtext=$commenttext;
        $instance->cmparent=$parent;
        return $instance;
        
    }
    public static function constDeleteComment($iduser,$newsid,$commentid){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->ncomid=$commentid;
        return $instance;
    }

    public function setUlike(){
        $result=$this->setUnsetLike($this->iduser,$this->nid,$this->like);
        $json=array('result'=>$result);
        return json_encode($json);
    }
    public function getLk(){
        $result=$this->getLikes($this->nid);
        if(strcmp($result,"false")==0){
            $json=array('result'=>'false');
        }else{
            $json=array('result'=>'true','likes'=>$result);
        }
        return json_encode($json);
    }
    public function usHasLike(){
        $result=$this->userHasLike($this->iduser,$this->nid);
        return $result;
    }
    public function createComm(){
        $result=$this->insertComment($this->cmtext,$this->iduser,$this->cmparent,$this->nid);
        return $result;
    }
    public function removeComm(){
        $canDelete=$this->canDeleteComment($this->iduser,$this->nid,$this->ncomid);
        if (strcmp($canDelete,"true")==0){
            $result=$this->deleteComments($this->ncomid,$this->nid);
            $json=array('result'=>$result);
        }else{
            $json=array('result'=>'no se pudo borrar por que no te pertenece el comentario ni administras la noticia');
        }
        return json_encode($json);
    }



}

?>