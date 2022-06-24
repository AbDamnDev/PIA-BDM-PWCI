<?php 
include_once("News_class.php") ;
class NewsContr extends News{
    private $nid;
    private $text;
    private $title;
    private $sign;
    private $descr;
    private $dateOfPublish;
    private $dateOfEvents;
    private $placeOfEvents;
    private $categories;
    private $keyWords;
    private $likes;
    private $photos;
    private $realvideo;
    private $video_path;
    private $video_name;
    private $video_size;
    private $video_type;
    private $iduser;
    private $nStatus;
    private $commenttext;
    private $commentid;
    private $delImages;

    public function __construct(){
        
    }
    public static function constCreateNews($text,$title,$sign,$descr,$dateOfEvents,$placeOfEvents,$categories,$keyWords,
    $photos,$realvideo,$video_path,$video_name,$video_size,$video_type,$iduser){
        $instance=new self();
        $instance->text=$text;
        $instance->title=$title;
        $instance->sign=$sign;
        $instance->descr=$descr;
        $instance->dateOfEvents=$dateOfEvents;
        $instance->placeOfEvents=$placeOfEvents;
        $instance->categories=$categories;
        $instance->keyWords=$keyWords;
        $instance->photos=$photos;
        $instance->realvideo=$realvideo;
        $instance->video_path=$video_path;
        $instance->video_name=$video_name;
        $instance->video_size=$video_size;
        $instance->video_type=$video_type;
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constModifyNews($nid,$text,$title,$sign,$descr,$dateOfEvents,$placeOfEvents,$categories,$keyWords,$iduser){
        $instance=new self();
        $instance->nid=$nid;
        $instance->text=$text;
        $instance->title=$title;
        $instance->sign=$sign;
        $instance->descr=$descr;
        $instance->dateOfEvents=$dateOfEvents;
        $instance->placeOfEvents=$placeOfEvents;
        $instance->categories=$categories;
        $instance->keyWords=$keyWords;
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constModImages($nid,$photos){
        $instance=new self();
        $instance->nid=$nid;
        $instance->photos=$photos;
        return $instance;
    }
    public static function constDelCats($nid,$categories,$iduser){
        $instance=new self();
        $instance->nid=$nid;
        $instance->categories=$categories;
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constGetRepNews($iduser){
        $instance=new self();
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constChangeNewsStats($iduser,$newsid,$newsStatus){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->nStatus=$newsStatus;
        return $instance;
        
    }
    public static function constGetSpecNews($newsid){
        $instance=new self();
        $instance->nid=$newsid;
        return $instance;
    }
    public static function constinEdiComm($iduser,$newsid,$commenttext){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->commenttext=$commenttext;
        return $instance;
    }
    public static function constupEdComm($iduser,$newsid,$commenttext,$commentid){
        $instance=new self();
        $instance->iduser=$iduser;
        $instance->nid=$newsid;
        $instance->commenttext=$commenttext;
        $instance->commentid=$commentid;
        return $instance;
    }
    public static function constdelPics($newsid,$delpicsarray){
        $instance=new self();
        $instance->nid=$newsid;
        $instance->delImages=$delpicsarray;
        return $instance;
    }

    public static function constuploadPics($newsid,$photos, $iduser){
        $instance=new self();
        $instance->nid=$newsid;
        $instance->photos=$photos;
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constuploadVideo($newsid,$realvideo,$video_path,$video_name,$video_size,$video_type,$iduser){
        $instance=new self();
        $instance->nid=$newsid;
        $instance->realvideo=$realvideo;
        $instance->video_path=$video_path;
        $instance->video_name=$video_name;
        $instance->video_size=$video_size;
        $instance->video_type=$video_type;
        $instance->iduser=$iduser;
        return $instance;
    }
    public static function constDelNews($newsid,$iduser){
        $instance=new self();
        $instance->nid=$newsid;
        $instance->iduser=$iduser;
        return $instance;
    }
    public function insertNews(){
        $idnotice=$this->createNews($this->text,$this->title,$this->descr,$this->sign,$this->dateOfEvents,$this->keyWords,$this->placeOfEvents,$this->iduser);
        if($idnotice>0){
            $resultcats;
           $isCatArray=is_array($this->categories);
            if($isCatArray){
                $resultcats=$this->insertNewsCats($idnotice,$this->categories,$this->iduser);
            }else{
                $catsarray=array($this->categories);
                $resultcats=$this->insertNewsCats($idnotice,$catsarray,$this->iduser);
            }
            if(strcmp($resultcats,"true")==0){
                $resultphotos;
                $isPhotosArray=is_array($this->photos);
                if($isPhotosArray){
                    $resultphotos=$this->insertNewsPhotos($idnotice,$this->photos,$this->iduser,1);
                }else{
                    $picsarray=array($this->photos);
                    $resultphotos=$this->insertNewsPhotos($idnotice,$picsarray,$this->iduser,1);
                }
                if(strcmp($resultphotos,"true")==0){
                    $resultvideo= $this->insertNewsVideo($idnotice,$this->video_path,$this->video_name,$this->video_type,$this->video_size,$this->iduser);
                    if(strcmp($resultvideo,"true")==0){
                        if(move_uploaded_file($this->realvideo, $this->video_path)){
                            return "true";
                        }else{
                            return "failedMoveVideo";
                        }
                    }else{
                        return "failedInsertVideo";
                    }
                }else{
                    return "failedInsertPhotos";
                }
            }else{
                return "failedInsertCategories";
            }
        }else{
            return "failedInsertNews";
        }
    }
    public function delNews(){
        $result=$this->deleteNews($this->iduser,$this->nid);
        return $result;
    }
    public function getNewsReporter(){
        $result=$this->getRepNews($this->iduser);
        return $result;
    }
    public function getNewsReporterBusqueda($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query){ //Mich
        $result=$this->BusquedaPrivada($this->iduser, $Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query);
        return $result;
    }
    public function getNewsAdminBusqueda($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query){ //Mich
        $result=$this->BusquedaAdmin($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query);
        return $result;
    }
    public function getAllNewsCards(){
        $result=$this->getAllNews();
        return $result;
    }
    public function getAllPubNews(){
        $result=$this->getAllPublishedNews();
        return $result;
    }
    public function getBusquedaPublica($Orden, $Texto, $fechaMin, $fechaMax, $query){ //Mich
        $result=$this->BusquedaPublica($Orden, $Texto, $fechaMin, $fechaMax, $query);
        return $result;
    }
    public function setNewsStatus(){
        $result=$this->changeNewsStatus($this->nid,$this->nStatus,$this->iduser);
        $json=array('result'=>$result);
        return json_encode($json);
    }
    public function getSpecNews(){
        $idUser;
        if(isset($_SESSION['ID_USER'])&&$_SESSION['ID_USER']!=0 &&$_SESSION['ID_USER']!=null){
            $idUser =$_SESSION['ID_USER'];
        }else{
            $idUser=0;
        }
        
        $result=$this->getEditNews($this->nid);
        if($result!=null){
            $PHOTOS=$this->getImageNews($this->nid);
            if($PHOTOS!=null){
                if($result[0]['NEWS_EDITOR_COMMENT']!=null){
                    $comment=$this->getEditorComent($result[0]['NEWS_EDITOR_COMMENT']);
                    if($comment!=null){
                        $json=array('result'=>"true",'newsInfo'=>$result,'images'=>$PHOTOS,'editorComment'=>$comment,'userRequest'=>$idUser);
                        return json_encode($json);
                    }
                }else{
                    $json=array('result'=>"true",'newsInfo'=>$result,'images'=>$PHOTOS,'editorComment'=>"false",'userRequest'=>$idUser);
                    return json_encode($json);
                }    
            }
        }else{
            $json=array('result'=>"false");
            return json_encode($json);
        }
    }
    public function inEdComm(){
        $result=$this->insertEditorComment($this->iduser,$this->nid,$this->commenttext);
        return $result;
    }
    public function upEdComm(){
        $result=$this->updateEditorComment($this->commenttext,$this->commentid);
        return $result;
    }
    public function delPics(){
            $ispicArray=is_array($this->delImages);
            if(!$ispicArray){
                $picssarray=array($this->delImages);
                $resultpics=$this->deleteNewsPhotos($this->nid,$picssarray);
            }else{
                $resultpics=$this->deleteNewsPhotos($this->nid,$this->delImages);
            }
            return $resultpics;
            
    }
    public function delCats(){
        $iscatArray=is_array($this->categories);
        if(!$iscatArray){
            $catssarray=array($this->categories);
            $resultcats=$this->deleteNewsCats($this->nid,$catssarray);
        }else{
            $resultcats=$this->deleteNewsCats($this->nid,$this->categories);
        }
        return $resultcats;
        
    }
    public function inCats(){
        $isCatArray=is_array($this->categories);
        if($isCatArray){
                $resultcats=$this->insertNewsCats($this->nid,$this->categories,$this->iduser);
        }else{
                $catsarray=array($this->categories);
                $resultcats=$this->insertNewsCats($this->nid,$catsarray,$this->iduser);
        }
        return $resultcats;
    }
    public function modNews(){
        //TODO: PROBAR QUE JALE
       $result= $this->modifyNews($this->nid,$this->text,$this->title,$this->sign,$this->descr,$this->dateOfEvents,$this->placeOfEvents,$this->keyWords,$this->iduser);
       return $result;
    }
    public function uploadImages($mainImage){
        $isPhotosArray=is_array($this->photos);
                if($isPhotosArray){
                    $resultphotos=$this->insertNewsPhotos($this->nid,$this->photos,$this->iduser,$mainImage);
                }else{
                    $picsarray=array($this->photos);
                    $resultphotos=$this->insertNewsPhotos($this->nid,$picsarray,$this->iduser,$mainImage);
                }
                return $resultphotos;
    }
    
    public function setMainImage(){
        $images=$this->getImageNews($this->nid);
        if($images!=null){
           $imageSet=$this->setmainImageBD($images[0]['NEWS_PHOTO_ID'],$this->nid); 
        }else{
            $imageSet="false";
        }
        return $imageSet;
    }

    public function uploadVideo(){
        //primero eliminamos el video
        $videoname=$this->getVideoName($this->nid);
        if($videoname!=null){
            if(!(strcmp($videoname,"false")==0)){
                $doc_root = $_SERVER['DOCUMENT_ROOT'];
                //aqui habra que modificar cuando se hostee por la siguiente linea
                //$location_image=$doc_root.'/Videos/'.$videoname[0]['NEWS_VIDEO_NAME'];
                $location_image=$doc_root.'/Proyecto-BDM-PWCI/Videos/'.$videoname;
                if(file_exists($location_image)){
                    $delete  = unlink($location_image);
                    //Y FALTA BORRARLO DE LA BASE DE DATOS
                    $exec=$this->deleteVideo($this->nid,$videoname);
                    if($exec &&$delete){
                        $delete=true;
                    }
                }
            }else{
                $delete=false;  
            }
        }
        if($delete){
            $resultvideo= $this->insertNewsVideo($this->nid,$this->video_path,$this->video_name,$this->video_type,$this->video_size,$this->iduser);
            if(strcmp($resultvideo,"true")==0){
                if(move_uploaded_file($this->realvideo, $this->video_path)){
                    return "true";
                }else{
                    return "failedMoveVideo";
                }
            }else{
                return "failedInsertVideo";
            }
        }else{
            return "failedRemoveVideo";
        }
        
    }
    public function getComments(){
        $result=$this->getNewsComments($this->nid);
        if($result!=null){
            if(is_array($result)){
                $json=array('result'=>"true",'comments'=>$result);
            }else if(!(strcmp($result,"true")==0)){
                $json=array('result'=>"true",'comments'=>$result);
            }else{
                $json=array('result'=>"false");
            }
        }else{
            $json=array('result'=>"false");
        }
        return json_encode($json);
        
    }
}

?>