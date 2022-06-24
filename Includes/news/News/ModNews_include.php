<?php
include_once("../../../php/backend/News/News_controller_class.php");
$data = json_decode( file_get_contents('php://input'),true );
if(isset($_POST["accion"])&&strcmp($_POST["accion"],"insertEditorComment")==0){
    session_start();
    $id =$_SESSION['ID_USER'];
    $newsid = $_POST["newsID"];
    $commenttext=$_POST['comentario'];
    if(isset($_POST['idcomentEditor'])&&$_POST['idcomentEditor']!=0){
        $comentId=$_POST['idcomentEditor'];
        $exec = NewsContr::constupEdComm($id,$newsid,$commenttext,$comentId);
        $finalResponse=$exec->upEdComm();
    }else{
        $exec = NewsContr::constinEdiComm($id,$newsid,$commenttext);
        $finalResponse=$exec->inEdComm();
    }
    echo $finalResponse;
}else if(isset($_POST["accion"])&&strcmp($_POST["accion"],"modNews")==0){
        session_start();
        $id =$_SESSION['ID_USER'];

        $isImagesSet=false;
        $isVideoSet=false;
        $realImage=null;
        $images=null;
        $realImages=array();
        $delImages=false;
        $delvideo=false;
        $ismainimagedeleted=false;

        $newsid= $_POST["idNoticia"];
        $title = $_POST["tituloNoticia"];
        $text=$_POST["cuerpoNoticia"];
        $sign=$_POST["autor"];
        $dateOfEvents=$_POST["fechaAcon"];
        $placeOfEvents=$_POST["lugarAcon"];
        $description=$_POST["descNoticia"]; //sinopsis
        $keyWords=$_POST["myEtiquetas"];
        $categorias=$_POST["myCategories"];
        $deletedImages=json_decode( $_POST["photosBDDeleted"],true);
        $deletedCategories=$_POST["categoriesBDDeleted"];
        $storedCategories=$_POST["categoriesBD"];

        if($deletedImages!=null){
            $temp=array();
            foreach($deletedImages as $image ){
                array_push($temp,$image[0]);
            }
            $deletedImages=0;
            $deletedImages=$temp;
        }
        //antes de hacer cualquier tonteria revisamos si el array guardado es el mismo que el enviado
        if(!is_array($categorias)){
            $categorias=explode (",", $categorias);
        }
        if(!is_array($storedCategories)){
            $storedCategories=explode (",", $storedCategories);
        }
        $same = (array_diff( $categorias, $storedCategories ) ==array_diff( $storedCategories,$categorias));
        if($same){
            $categorias=null;
        }else{
            
            //si deleted categories no es null
            if($deletedCategories!=null){
                $deletedCategories=explode (",", $deletedCategories);
                $exec=NewsContr::constDelCats($newsid,$deletedCategories,$id);
                $FINALDELETECATS=$exec->delCats();
                // ahora verificar que se introduzcan categorias nuevas, no las que ya estaban
                //devuelve los elementos del array 1 que no estan presentes en el array 2
                //hacer la diferencia entre el array de stored y el de deleted para despues comparar con las nuevas
                if(is_array($deletedCategories)&&is_array($storedCategories)){
                    $resultado1 = array_diff($storedCategories, $deletedCategories);
                }
                $storedCategories=$resultado1;
            }

        //tonses en array uno van nuevas categorias y en array 2 van las ya insertadas
            if($storedCategories!=null){//puede que se haya borrado todo lo almacenado, de ser asi no comparamos nada y hacemos insercion normal
                if(is_array($categorias)&&is_array($storedCategories)){
                    $resultado = array_diff($categorias, $storedCategories);
                }
                if($resultado!=null){ //aqui hay un error, se conservan los indices del arreglo 1 en diff
                    //si hay categorias nuevas, lo asignamos a categorias para que continue con la insercion normal
                    $categorias=null;
                    $categorias=array();
                    foreach($resultado as $res){
                        array_push($categorias,$res);
                    }
                }
            }
        }
        //primero borramos lo que tengamos que borrar
        if(!empty($deletedImages)){
            $delImages=true;
            if (is_array($deletedImages)){
                foreach($deletedImages as $photo){
                    if($photo['isMain']=="1"){
                        $ismainimagedeleted=true;
                    }
                }

                //strcmp($resultphotos,"true")==0
            }else{
                if($deletedImages['isMain']=="1"){
                    $ismainimagedeleted=true;
                }
            }
        }
        
        //borrar imagenes
        if ($delImages){
            $delpicsexec=NewsContr::constdelPics($newsid,$deletedImages);
            $finaldeletePics=$delpicsexec->delPics();
        }

        if(isset($_FILES)){
            $images=array_filter($_FILES["fotos"]["name"]); //images es el filtro , si da null no continuar
            if($images!=null){
                $imagescount=count($_FILES["fotos"]["name"]);
                if($imagescount>0){
                    for($i=0 ; $i < $imagescount ; $i++ ){
                        $fileName = basename($_FILES["fotos"]["name"][$i]);
                        $imageType = strtolower( pathinfo($fileName,PATHINFO_EXTENSION));
                        $allowedTypes = array('png','jpg','gif');

                        if( in_array($imageType,$allowedTypes) ){

                            $imageName = $_FILES["fotos"]["tmp_name"][$i];
                            $base64Image = base64_encode(file_get_contents($imageName));
                            $realImage = 'data:image/'.$imageType.';base64,'.$base64Image;
                            array_push($realImages,$realImage);
                            $isImagesSet=true;
                        }
                    }
                }
            }
            
            if(!empty($_FILES["video"]["name"])){
                $filename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
                // Nombre de mi video
                $videoName = $_FILES['video']['name'];
                // Mi video en sí 
                $realvideo = $_FILES['video']['tmp_name'];
                // Esto me sirve para saber la extensión, por ejemplo, .mp4
                $extension = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
                $basename   = $filename . "." . $extension;
                // El path en donde quiero que se guarden los videos
                //$path = $_SERVER['DOCUMENT_ROOT'].'/Videos/'; //PARA HOST SE PONE ESTO
                $path = $_SERVER['DOCUMENT_ROOT'].'/Proyecto-BDM-PWCI/Videos/';
                // Junto el path y el nombre del video para crear mi ruta
                $directory = $path.$basename;

                // El tamaño de mi video en bytes
                $size = $_FILES['video']['size'];

                $isVideoSet=true;
            }
        }
        $exec= NewsContr::constModifyNews($newsid,$text,$title,$sign,$description,$dateOfEvents,$placeOfEvents,$categorias,$keyWords,$id);
        $editedNews= $exec->modNews();
        if(strcmp($editedNews,"true")==0){
            //TODO: VER QUE ESTO FUNCIONE TAMBIEN, SOBRE TODO EL DE VIDEO
            if($ismainimagedeleted&& $isImagesSet){ //si se borro la imagen principal y vas a subir  mas imagenes
                $uploadexec=NewsContr::constuploadPics($newsid,$realImages,$id);
                $finalupdatePics=$uploadexec->uploadImages(1);
            }else if($isImagesSet){ //si no se borro la imagen principal y vas a subir  mas imagenes
                $uploadexec=NewsContr::constuploadPics($newsid,$realImages,$id);
                $finalupdatePics=$uploadexec->uploadImages(0);

            }else if($ismainimagedeleted){ //si se borro la imagen principal y no vas a subir más imagenes
                $uploadexec=NewsContr::constGetSpecNews($newsid);
                $finalupdatePics=$uploadexec->setMainImage();
            }else{
                $finalupdatePics="NoImagesModified";
            }
            if($isVideoSet){
                $uploadVidexec=NewsContr::constuploadVideo($newsid,$realvideo,$directory,$basename,$size,$extension,$id);
                $finalupdateVid=$uploadVidexec->uploadVideo();
            }else{
                $finalupdateVid="NoVideosModified";
            }
            if($categorias!=null){
                $finalupdateCats=$exec->inCats();
            }else{
                $finalupdateCats="NoCategoriesModified";
            }
           
            echo json_encode(array('result'=>$editedNews,'images'=>$finalupdatePics,'video'=>$finalupdateVid,'categories'=>$finalupdateCats)) ;
        }else{
            echo json_encode(array('result'=>$editedNews,'images'=>'nothingDoneError','video'=>'nothingDoneError','categories'=>'nothingDoneError'));
        }


}

?>