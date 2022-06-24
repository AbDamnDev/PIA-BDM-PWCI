<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/Proyecto-BDM-PWCI/php/backend/Conexion_class.php") ;
include_once __DIR__."/../Conexion_class.php";
class News extends Conexion{
        protected function createCat($desc,$color,$idAdmin){
            $stmt = $this->connect()->prepare('CALL createCategory(?,?,?);');
            if(!$stmt->execute(array($desc,$color,$idAdmin))){
                $stmt = null;
                $result="stmtfailed";
            
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function modCat($idcat,$desc,$color,$idAdmin){
            $stmt = $this->connect()->prepare('CALL modCategory(?,?,?,?);');
            if(!$stmt->execute(array($idcat,$desc,$color,$idAdmin))){
                $stmt = null;
                $result="stmtfailed";
            
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function delCat($idcat,$idAdmin){
            $stmt = $this->connect()->prepare('CALL delCategory(?,?);');
            if(!$stmt->execute(array($idcat,$idAdmin))){
                $stmt = null;
                $result="stmtfailed";
            
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function ordCats($cats,$idAdmin){
            $failed=false;
            $i=1;
            foreach($cats as $cat){
                $stmt = $this->connect()->prepare('CALL ordCat(?,?,?);');
                if(!$stmt->execute(array($cat,$i,$idAdmin))){
                    $failed=true;
                }
                $stmt = null;
                $i++;
            }
            if(!$failed){
                $result="true";
            }else{
                $result="false";
            }
            return $result;
        }
        protected function getAllCats(){
            $stmt = $this->connect()->prepare('SELECT `CATEGORY_ID`, `DESCRIPTION`,`COLOR` FROM `CATEGORIES` WHERE `ACTIVE`=1;');
            if(!$stmt->execute()){
                echo 'exectute fail';
                $stmt = null;
                $result="stmtfailed";
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }

        protected function getCatInfoM($catID){
            $stmt = $this->connect()->prepare('SELECT `CATEGORY_ID`, `DESCRIPTION`,`COLOR` FROM `CATEGORIES` WHERE `CATEGORY_ID`=? AND`ACTIVE`=1;');
            if(!$stmt->execute(array($catID))){
                $stmt = null;
                $result="stmtfailed";
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result="NotFound";
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                    //$result = ['data' => $queryResult];
                }
            }
            $stmt = null;
            return $result;
        }

        protected function createNews($text,$title,$description,$sign,$eventdate,$keywords,$eventplace,$userid){
            $stmt = $this->connect()->prepare('CALL createNews(?,?,?,?,?,?,?,?);');
            if(!$stmt->execute(array($text,$title,$description,$sign,$eventdate,$keywords,$eventplace,$userid))){
                $stmt = null;
                $result=0;
            
            }else{
                //$last_id = $this->connect()->lastInsertId();
                if($stmt->rowCount() > 0){ 
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult[0]["lastID"];
                }else{
                    $result=0;
                }
            }
            $stmt = null;
            return $result;
        }

        protected function insertNewsCats($idnotice,$cats,$idAdmin){
            $failed=false;
            foreach($cats as $cat){
                $stmt = $this->connect()->prepare('CALL insertNewsCats(?,?,?);');
                if(!$stmt->execute(array($idnotice,$cat,$idAdmin))){
                    $failed=true;
                }
                $stmt = null;
            }
            if(!$failed){
                $result="true";
            }else{
                $result="false";
            }
            return $result;
        }
        protected function insertNewsPhotos($idnotice,$photos,$idAdmin,$ismainimage){
            $failed=false;
            foreach($photos as $photo){
                $stmt = $this->connect()->prepare('CALL insertNewsPhotos(?,?,?,?);');
                if(!$stmt->execute(array($idnotice,$photo,$ismainimage,$idAdmin))){
                    $failed=true;
                }
                $stmt = null;
                $ismainimage=0;
            }
            if(!$failed){
                $result="true";
            }else{
                $result="false";
            }
            return $result;
        }
        protected function insertNewsVideo($idnoticia,$directory,$vidname,$extension,$size,$userid){
            $stmt = $this->connect()->prepare('CALL insertNewsVideo(?,?,?,?,?,?);');
            if(!$stmt->execute(array($idnoticia,$directory,$vidname,$extension,$size,$userid))){
                $stmt = null;
                $result="false";
            
            }else{
                //$last_id = $this->connect()->lastInsertId();
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function getEditNews($idnews){
            $stmt = $this->connect()->prepare('select * from getNewsView where NEWS_ID=?;');
            if(!$stmt->execute(array($idnews))){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }
        protected function getImageNews($idnews){
            $stmt = $this->connect()->prepare('SELECT `NEWS_PHOTO_ID`,`NEWS_PHOTO`,`IS_MAIN_IMAGE` FROM NEWS_PHOTOS WHERE `NEWS_ID`=? AND `ACTIVE`=1;');
            if(!$stmt->execute(array($idnews))){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }
        protected function getEditorComent($idcomment){
            $stmt = $this->connect()->prepare('SELECT `COMMENT_TEXT` FROM COMMENTS WHERE `COMMENT_ID`=? AND `ACTIVE`=1;');
            if(!$stmt->execute(array($idcomment))){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult[0]["COMMENT_TEXT"];
                }
            }
            $stmt = null;
            return $result;
        }
        protected function getRepNews($iduser){
            $stmt = $this->connect()->prepare('CALL getNewsReporter(?);');
            if(!$stmt->execute(array($iduser))){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }
        protected function getAllNews(){
            $stmt = $this->connect()->prepare('SELECT NEWS_ID,`TITLE`,`DESCRIPTION`,GET_NEWS_MAIN_PHOTO(NEWS_ID) AS "PHOTO",`STATUS`,`CREATED_BY` FROM NEWS WHERE `ACTIVE`=1 AND `STATUS`!="En Redacción" ORDER BY `LAST_UDPATE_DATE` DESC;');
            if(!$stmt->execute()){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }
        protected function getAllPublishedNews(){
            $stmt = $this->connect()->prepare('SELECT *FROM getNewsViewAndImagePublished ORDER BY `NEWS_PUBLISH_DATE` DESC;');
            if(!$stmt->execute()){
                $stmt = null;
                $result=null;
            
            }else{
                if($stmt->rowCount() == 0){ 
                    $stmt = null;
                    $result=null;
                   
                }else{
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $result= $queryResult;
                }
            }
            $stmt = null;
            return $result;
        }
        protected function changeNewsStatus($nid,$nStatus,$iduser){
            if (strcmp($nStatus,"Publicada")==0){
                //añadir fecha de publicacion
                $stmt = $this->connect()->prepare('UPDATE NEWS SET `STATUS` = ?,`LAST_UDPATED_BY`=?, `LAST_UDPATE_DATE`=sysdate(), NEWS_PUBLISH_DATE =sysdate() WHERE `NEWS_ID` = ?;
                ');  
            }else{
                $stmt = $this->connect()->prepare('UPDATE NEWS SET `STATUS` = ?,`LAST_UDPATED_BY`=?, `LAST_UDPATE_DATE`=sysdate() WHERE `NEWS_ID` = ?;
                ');
            }
            if(!$stmt->execute(array($nStatus,$iduser,$nid))){
                $stmt = null;
                $result="false";
            
            }else{
                if (strcmp($nStatus,"Publicada")==0){
                    $stmt = null;
                    $stmt = $this->connect()->prepare('UPDATE NEWS SET NEWS_EDITOR_COMMENT=GET_ID_APPROVED_COMM(NEWS_ID,?) WHERE NEWS_ID=?');
                    if(!$stmt->execute(array($iduser,$nid))){
                        $stmt = null;
                        $result="false";
                    }else{
                        $result="true";
                    }
                }else{
                    $result="true";
                }
            }
            $stmt = null;
            return $result;
        }

        protected function insertEditorComment($id,$newsid,$commenttext){
            $stmt = $this->connect()->prepare('CALL insertEditComm(?,?,?);');
            if(!$stmt->execute(array($id,$newsid,$commenttext))){
                $stmt = null;
                $result="false";
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function updateEditorComment($commenttext,$comentid){
            $stmt = $this->connect()->prepare('CALL updateEditorComment(?,?);');
            if(!$stmt->execute(array($commenttext,$comentid))){
                $stmt = null;
                $result="false";
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function deleteNews($iduser,$newsid){
            $stmt = $this->connect()->prepare('UPDATE `NEWS` SET `ACTIVE`=0, LAST_UDPATE_DATE =sysdate(), LAST_UDPATED_BY= ? WHERE `NEWS_ID`=?;');
            if(!$stmt->execute(array($iduser,$newsid))){
                $stmt = null;
                $result="false";
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function deleteNewsPhotos($idnotice,$photos){
            $failed=false;
            foreach($photos as $photo){
                $stmt = $this->connect()->prepare('DELETE FROM `NEWS_PHOTOS` WHERE `NEWS_PHOTO_ID`=? AND `NEWS_ID`=?;');
                if(!$stmt->execute(array($photo['id'],$idnotice))){
                    $failed=true;
                }
                $stmt = null;
            }
            if(!$failed){
                $result="true";
            }else{
                $result="false";
            }
            return $result;
        }
        protected function deleteVideo($vidname,$idnotice){
            $stmt = $this->connect()->prepare('DELETE FROM `NEWS_VIDEOS` WHERE `NEWS_VIDEO_NAME`=? AND `NEWS_ID`=?;');
            if(!$stmt->execute(array($vidname,$idnotice))){
                $stmt = null;
                $result=false;
            }else{
                $result=true;
            }
            $stmt = null;
            return $result;
        }
        protected function deleteNewsCats($idnotice,$cats){
            $failed=false;
            foreach($cats as $cat){
                $stmt = $this->connect()->prepare('DELETE FROM `NEWS_CATEGORIES` WHERE `CATEGORY_ID`=? AND `NEWS_ID`=? AND `ACTIVE`=1;');
                if(!$stmt->execute(array($cat,$idnotice))){
                    $failed=true;
                }
                $stmt = null;
            }
            if(!$failed){
                $result="true";
            }else{
                $result="false";
            }
            return $result;
        }
        protected function modifyNews($idnotice,$text,$title,$sign,$description,$eventdate,$eventplace,$keywords,$userid){
            $stmt = $this->connect()->prepare('CALL modNewsInfo(?,?,?,?,?,?,?,?,?);');
            if(!$stmt->execute(array($idnotice,$text,$title,$description,$sign,$eventdate,$keywords,$eventplace,$userid))){
                $stmt = null;
                $result="false";
            }else{
                $result="true";
            }
            $stmt = null;
            return $result;
        }
        protected function setmainImageBD($photo,$idnotice){
            //TODO: PROVE THIS WORKS
           $bit=1;
            $stmt = $this->connect()->prepare('UPDATE `NEWS_PHOTOS` SET IS_MAIN_IMAGE=:sbind_bit WHERE `NEWS_PHOTO_ID`=:sphoto_id AND `NEWS_ID`=:snews_id;');
            $stmt->bindValue(':sbind_bit', (bool)$bit, PDO::PARAM_BOOL);
            $stmt->bindValue(':sphoto_id', (int)$photo, PDO::PARAM_INT);
            $stmt->bindValue(':snews_id', (int)$idnotice, PDO::PARAM_INT);
            if(!$stmt->execute()){
                    $failed=true;
                    $result="false";
            }else{
                $result="true";
            }
            $stmt = null;
            
            return $result;
        }
        protected function getVideoName($idnotice){
            $stmt = $this->connect()->prepare('SELECT  `NEWS_VIDEO_NAME` FROM NEWS_VIDEOS WHERE `NEWS_ID`=?;');
            if(!$stmt->execute(array($idnotice))){
                $stmt = null;
                $result="false";
            }else{
                $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result= $queryResult[0]['NEWS_VIDEO_NAME'];
            }
            $stmt = null;
            return $result;
            
        }
        protected function getNewsComments($idnotice){
            $stmt = $this->connect()->prepare('SELECT *FROM getComments WHERE NEWS_ID =? ORDER BY `COMMENT_DATE` DESC;');
            if(!$stmt->execute(array($idnotice))){
                $stmt = null;
                $result="false";
            }else{
                $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result= $queryResult;
            }
            $stmt = null;
            return $result;
        }
        //Mich
        public function getDashboard(){
            $stmt = $this->connect()->query('SELECT * FROM getTopCatPosts');
            //$stmt->execute->fetchAll(PDO::FETCH_ASSOC);
            return $stmt;
        }
        public function topLikes(){
            $stmt = $this->connect()->query('SELECT * FROM getTopLikedPosts');
            return $stmt;
        }
        public function likeReport($Texto, $fechaMin, $fechaMax){
            $SelectAll = false;

            $query = "SELECT * FROM getLikeReport";

            $conditions = array();

            if (!empty($Texto)) {
            $conditions[] = "CATEGORY_ID = $Texto ";
            } 
            if (!empty($fechaMin)) {
            $conditions[] = "NEWS_PUBLISH_DATE >= '$fechaMin'";
            }
            if (!empty($fechaMax)) {
            $conditions[] = "NEWS_PUBLISH_DATE <= '$fechaMax'";
            }

            $sql3 = $query;
            if (count($conditions) > 0) {
            $sql3 .= " WHERE " . implode(' AND ', $conditions);
            } else {
            }


            $stmt = $this->connect()->query($sql3);
            return $stmt;
        }
        public function ActiveCatsWActiveNews(){
            $stmt = $this->connect()->query('SELECT * FROM ActiveCatsWActiveNews');
            return $stmt;
        }
        public function BusquedaPublica($Orden, $Texto, $fechaMin, $fechaMax, $query){

            $select = "SELECT * FROM BusquedaPublica";

            $conditions = array();

            if (!empty($query)){
                switch ($Texto) {
                    case 1:
                        $conditions[] = "TITLE LIKE '%$query%' OR DESCRIPTION LIKE '%$query%' OR KEY_WORDS LIKE '%$query%' OR SIGN LIKE '%$query%'";
                        break;
                    case 2:
                        $conditions[] = "TITLE LIKE '%$query%'";
                        break;
                    case 3:
                        $conditions[] = "DESCRIPTION LIKE '%$query%'";
                        break;
                    case 4:
                        $conditions[] = "KEY_WORDS LIKE '%$query%'";
                        break;
                    case 5:
                        $conditions[] = "SIGN LIKE '%$query%'";
                        break;
    
                }
            }
            

            if (!empty($fechaMin)) {
            $conditions[] = "NEWS_PUBLISH_DATE >= '$fechaMin'";
            }
            if (!empty($fechaMax)) {
            $conditions[] = "NEWS_PUBLISH_DATE <= '$fechaMax'";
            }

            $sql3 = $select;
            if (count($conditions) > 0) {
            $sql3 .= " WHERE " . implode(' AND ', $conditions);
            } else {
            }

            if ($Orden == 1) {
                $sql3 .= " ORDER BY NEWS_PUBLISH_DATE DESC" ;
            } else {
                $sql3 .= " ORDER BY NEWS_PUBLISH_DATE " ;
            }

            $stmt = $this->connect()->query($sql3);
            return $stmt;
        }
        public function BusquedaPrivada($iduser, $Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query){

            $select = "SELECT * FROM BusquedaPrivada";

            $conditions = array();
            $conditions[] = "CREATED_BY = '$iduser'";

            if (!empty($query)){
                switch ($Texto) {
                    case 1:
                        $conditions[] = "TITLE LIKE '%$query%' OR DESCRIPTION LIKE '%$query%' OR KEY_WORDS LIKE '%$query%'";
                        break;
                    case 2:
                        $conditions[] = "TITLE LIKE '%$query%'";
                        break;
                    case 3:
                        $conditions[] = "DESCRIPTION LIKE '%$query%'";
                        break;
                    case 4:
                        $conditions[] = "KEY_WORDS LIKE '%$query%'";
                        break;
    
                }
            }
            
            $fechaNombre;
            switch ($TipoFecha) {
                case 1:{
                    $fechaNombre = "NEWS_PUBLISH_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "NEWS_PUBLISH_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "NEWS_PUBLISH_DATE <= '$fechaMax'";
                    }
                }break;
                case 2:{
                    $fechaNombre = "CREATION_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "CREATION_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "CREATION_DATE <= '$fechaMax'";
                    }
                }break;
                case 3:{
                    $fechaNombre = "LAST_UDPATE_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "LAST_UDPATE_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "LAST_UDPATE_DATE <= '$fechaMax'";
                    }
                }break;
                case 4:{
                    $fechaNombre = "DATE_OF_EVENTS";
                    if (!empty($fechaMin)) {
                    $conditions[] = "DATE_OF_EVENTS >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "DATE_OF_EVENTS <= '$fechaMax'";
                    }
                }break;

            }

            switch ($Estado) {
                case 2:
                    $conditions[] = "STATUS = 'En Redacción'";
                    break;
                case 3:
                    $conditions[] = "STATUS = 'Publicada'";
                    break;
                case 4:
                    $conditions[] = "STATUS = 'Terminada'";
                    break;

            }
            

            $sql3 = $select;
            if (count($conditions) > 0) {
            $sql3 .= " WHERE " . implode(' AND ', $conditions);
            } else {
            }

            if ($Orden == 1) {
                $sql3 .= " ORDER BY '$fechaNombre' DESC" ;
            } else {
                $sql3 .= " ORDER BY '$fechaNombre' " ;
            }

            $stmt = $this->connect()->query($sql3);
            return $stmt;
        }
        public function BusquedaAdmin($Estado, $Orden, $Texto, $fechaMin, $fechaMax, $TipoFecha, $query){

            $select = "SELECT * FROM BusquedaAdmin";

            $conditions = array();

            if (!empty($query)){
                switch ($Texto) {
                    case 1:
                        $conditions[] = "TITLE LIKE '%$query%' OR DESCRIPTION LIKE '%$query%' OR KEY_WORDS LIKE '%$query%'";
                        break;
                    case 2:
                        $conditions[] = "TITLE LIKE '%$query%'";
                        break;
                    case 3:
                        $conditions[] = "DESCRIPTION LIKE '%$query%'";
                        break;
                    case 4:
                        $conditions[] = "KEY_WORDS LIKE '%$query%'";
                        break;
    
                }
            }
            
            $fechaNombre;
            switch ($TipoFecha) {
                case 1:{
                    $fechaNombre = "NEWS_PUBLISH_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "NEWS_PUBLISH_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "NEWS_PUBLISH_DATE <= '$fechaMax'";
                    }
                }break;
                case 2:{
                    $fechaNombre = "CREATION_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "CREATION_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "CREATION_DATE <= '$fechaMax'";
                    }
                }break;
                case 3:{
                    $fechaNombre = "LAST_UDPATE_DATE";
                    if (!empty($fechaMin)) {
                    $conditions[] = "LAST_UDPATE_DATE >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "LAST_UDPATE_DATE <= '$fechaMax'";
                    }
                }break;
                case 4:{
                    $fechaNombre = "DATE_OF_EVENTS";
                    if (!empty($fechaMin)) {
                    $conditions[] = "DATE_OF_EVENTS >= '$fechaMin'";
                    }
                    if (!empty($fechaMax)) {
                    $conditions[] = "DATE_OF_EVENTS <= '$fechaMax'";
                    }
                }break;

            }

            switch ($Estado) {
                case 2:
                    $conditions[] = "STATUS = 'En Redacción'";
                    break;
                case 3:
                    $conditions[] = "STATUS = 'Publicada'";
                    break;
                case 4:
                    $conditions[] = "STATUS = 'Terminada'";
                    break;

            }
            

            $sql3 = $select;
            if (count($conditions) > 0) {
            $sql3 .= " WHERE " . implode(' AND ', $conditions);
            } else {
            }

            if ($Orden == 1) {
                $sql3 .= " ORDER BY '$fechaNombre' DESC" ;
            } else {
                $sql3 .= " ORDER BY '$fechaNombre' " ;
            }

            $stmt = $this->connect()->query($sql3);
            return $stmt;
        }

}
?>