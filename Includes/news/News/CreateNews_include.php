<?php
include_once("../../../php/backend/News/News_controller_class.php");

    if(isset($_POST["accion"])&&strcmp($_POST["accion"],"agregarNoticia")==0){
        session_start();
        $id =$_SESSION['ID_USER'];

        $isImagesSet=false;
        $isVideoSet=false;
        $realImage=null;
        $images=null;
        $realImages=array();

        $title = $_POST["tituloNoticia"];
        $text=$_POST["cuerpoNoticia"];
        $sign=$_POST["autor"];
        $dateOfEvents=$_POST["fechaAcon"];
        $placeOfEvents=$_POST["lugarAcon"];
        $description=$_POST["descNoticia"]; //sinopsis
        $keyWords=$_POST["myEtiquetas"];
        $categorias=$_POST["myCategories"];
        if(!is_array($categorias)){
            $categorias=explode (",", $categorias);
        }
        if(isset($_FILES)){
            $images=array_filter($_FILES["fotos"]["name"]);
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
            }else{
                echo 'no images uploaded';
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
                //$path = $_SERVER['DOCUMENT_ROOT'].'/Videos/'; //para host
                $path = $_SERVER['DOCUMENT_ROOT'].'/Proyecto-BDM-PWCI/Videos/';
                // Junto el path y el nombre del video para crear mi ruta
                $directory = $path.$basename;
                // El tamaño de mi video en bytes
                $size = $_FILES['video']['size'];

                
                
                $isVideoSet=true;
        }
            if($isVideoSet&&$isImagesSet){
                $mod= NewsContr::constCreateNews($text,$title,$sign,$description,$dateOfEvents,$placeOfEvents,$categorias,$keyWords,
                $realImages,$realvideo,$directory,$basename,$size,$extension,$id);
                $finalResponse=$mod->insertNews();
                echo $finalResponse;
            }else{
                echo 'No se setearon las imagenes o el video';
            }
       
        }

    }