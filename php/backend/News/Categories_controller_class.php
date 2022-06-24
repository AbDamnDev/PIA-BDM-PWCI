<?php 
include_once( "News_class.php");
class Categories extends News{
    private $ncid;
    private $descp;
    private $color;
    private $order;
    private $admin;
    private $catsord;
    public function __construct(){
        
    }
    public static function constCreateCat($desc,$color,$admin){
        $instance=new self();
        $instance->descp=$desc;
        $instance->color=$color;
        $instance->admin=$admin;
        return $instance;
    }
    public static function constGetCat($catid){
        $instance=new self();
        $instance->ncid=$catid;
        return $instance;
    }
    public static function constDelCat($catid, $admin){
        $instance=new self();
        $instance->ncid=$catid;
        $instance->admin=$admin;
        return $instance;
    }
    public static function constModCat($catid,$desc,$color,$admin){
        $instance=new self();
        $instance->ncid=$catid;
        $instance->descp=$desc;
        $instance->color=$color;
        $instance->admin=$admin;
        return $instance;
    }
    public static function constOrdCats($cats, $admin){
        $instance=new self();
        $instance->catsord=$cats;
        $instance->admin=$admin;
        return $instance;
    }
    public function createCategory(){
        $response=$this->createCat($this->descp,$this->color,$this->admin);
        return $response;
    }
    public function modifyCategory(){
        $response=$this->modCat($this->ncid,$this->descp,$this->color,$this->admin);
        $json=array('result'=>$response);
        return json_encode($json);
    }
    public function deleteCategory(){
        $response=$this->delCat($this->ncid,$this->admin);
        $json=array('result'=>$response);
        return json_encode($json);
    }
    public function ordCategories(){
        $response=$this->ordCats($this->catsord,$this->admin);
        $json=array('result'=>$response);
        return json_encode($json);
    }

    public function getAllCategories(){
        $response=$this->getAllCats();
        return $response;
    }

    public function getCatInfo(){
        $response=$this->getCatInfoM($this->ncid);
        if($response!=null && $response!="stmtfailed"&& $response!="NotFound"){
            //$json["result"]="true";
            //$json["data"]=$response;
            $json=array('result'=>"true",'data'=>$response);
        }else{
            $json=array('result'=>"false");
        }
        return json_encode($json);
        
    }


}

?>