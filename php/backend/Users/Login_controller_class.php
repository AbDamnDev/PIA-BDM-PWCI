<?php 
include_once( "Login_class.php");
class LoginContr extends Login{

   private $email;
   private $pwd;
   private $usID;
   private $name;
   private $photo;

   public function __construct(){
        
   }
   public static function constLogin($email,$pwd){
    $instance = new self();
    $instance->loadByLogin( $email,$pwd);
    return $instance;
   }

    protected function loadByLogin($email,$pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }
    public static function constIDtype($usid){
        $instance = new self();
        $instance->loadByIDtype($usid);
        return $instance;
    }
    protected function loadByIDtype($usid) {
        $this->usID = $usid;
        }

   public function loginUser(){
    $response;
       if($this->emptyInputs() == false){
        // echo 'rip en los inputs';
        //header("location: ../login.php?error=emptyInput");
        $response="emptyInput";
       }

       $response= $this->sign_in($this->email,$this->pwd);
       return $response;
   }

    public function myUserType(){
        $response=$this->getTypeUser($this->usID);
        return $response;
    }
    public function myImageAndName(){
        $json=[];
        $jsonencode;
        $response=$this->getImageAndName($this->usID);
        if($response!=null && $response!="stmtfailed"&& $response!="userNotFound"){
            $json["result"]="true";
            $json["data"]=$response;
        }else{
            $json["result"]="false";
        }
        $jsonencode=json_encode($json);
        return $jsonencode;
    }
   private function emptyInputs(){
       $result;
       if( empty($this->email) || empty($this->pwd) ){
           $result = false;
       }else{
           $result = true;
       }
       return $result;
   }


}
?>