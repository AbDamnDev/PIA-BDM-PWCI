<?php 
include_once("Users_class.php") ;
class UsersContr extends Users{
   private $email;
   private $pwd;
   private $pwd2;
   private $birth;
   private $tel;
   private $usID;
   private $nomUs;
   private $name;
   private $photo;
   private $admin;
   private $newtype;
   private $opBU;

   public function __construct(){
        
   }
   public static function constID($id){
    $instance = new self();
    $instance->loadById($id);
    return $instance;
   }

   public static function constRegister($name,$email,$birth,$tel,$nomus,$pwd,$pwd2){
    $instance = new self();
    $instance->loadByRegister($name,$email,$birth,$tel,$nomus,$pwd,$pwd2);
    return $instance;
   }

   public static function consModUser($usID,$name,$email,$birth,$tel,$nomus,$pwd,$photo){
    $instance = new self();
    $instance->loadByModUs($usID,$name,$email,$birth,$tel,$nomus,$pwd,$photo);
    return $instance;
   }
   public static function constModTypeUs($usID,$admin,$type){
    $instance = new self();
    $instance->loadByTypeUs($usID,$admin,$type);
    return $instance;
   }
   public static function constModBlock($usID,$admin,$option){
    $instance = new self();
    $instance->loadByBlock($usID,$admin,$option);
    return $instance;
   }
   public static function constDelUser($usID,$admin){
       $instance=new self();
       $instance->admin=$admin;
       $instance->usID=$usID;
       return $instance;
   }
   protected function loadById($id){
    $this->usID=$id;
   }
   protected function loadByRegister($name,$email,$birth,$tel,$nomus,$pwd,$pwd2){
       $this->name=$name;
       $this->email=$email;
       $this->birth=$birth;
       $this->tel=$tel;
       $this->nomUs=$nomus;
       $this->pwd=$pwd;
       $this->pwd2=$pwd2;
   }

   protected function loadByModUs($usID,$name,$email,$birth,$tel,$nomus,$pwd,$photo){
    $this->usID=$usID;
    $this->name=$name;
    $this->email=$email;
    $this->birth=$birth;
    $this->tel=$tel;
    $this->nomUs=$nomus;
    $this->pwd=$pwd;
    $this->photo=$photo;
   }
   protected function loadByTypeUs($usID,$admin,$type){
    $this->admin=$admin;
    $this->usID=$usID;
    $this->newtype=$type;
   }
   protected function loadByBlock($usID,$admin,$option){
    $this->admin=$admin;
    $this->usID=$usID;
    $this->opBU=$option;
   }


   public function registerUser(){
    if( $this->emptyInputs() == false ){
        // echo 'rip en los inputs';
        header("location: ../index.php?error=emptyInput");
        exit();
    }
    if( $this->matchPwd() == false ){
        // echo 'rip en los inputs';
        header("location: ../index.php?error=matchPwd");
        exit();
    }
    if( $this->checkEmail($this->email) == false ){
        // echo 'rip en los inputs';
        header("location: ../index.php?error=userCheck");
        exit();
    }

    if($this->register($this->email, $this->pwd, $this->name, $this->nomUs,$this->tel, $this->birth)){
        $response=$this->getID($this->email);
        return $response;
    }else{
        $response="somethingFailed";
        return $response;
    }

    }

    public function getUserData(){
        $json=[];
        $jsonencode;
        $response;
        if(empty($this->usID)){
            $response="emptyInput";
            $json["result"]=$response;
        }else{
            $response=$this->getUserInfo($this->usID);
            if($response!=null && $response!="stmtfailed"&& $response!="userNotFound"){
                $json["result"]="true";
                $json["data"]=$response;
            }else{
                $json["result"]="false";
            }
        $jsonencode=json_encode($json);
        return $jsonencode;
        }

    }
    public function changeUsType(){
        $response=$this->changeUserType($this->usID,$this->admin,$this->newtype);
        return $response;
    }
    public function modifyUser(){
        $emailnusercheck=$this->checkSameKeys($this->email,$this->nomUs,$this->usID);
        if($emailnusercheck!=null &&$emailnusercheck!="stmtfailed" &&$emailnusercheck!="usNotFound"){
            if($emailnusercheck=="SameEmailnUser"){
                $response=$this->modUser($this->usID,$this->email,$this->pwd,$this->name,$this->nomUs,$this->tel,$this->birth,$this->photo);
                return $response;
            }else if($emailnusercheck=="SameEmail"){
                $checkuser=$this->checkusername($this->nomUs);
                if($checkuser){
                    //continua
                    $response=$this->modUser($this->usID,$this->email,$this->pwd,$this->name,$this->nomUs,$this->tel,$this->birth,$this->photo);
                    return $response;
                }else{
                    //rip
                    $response="ExistingEmail";
                    return $response;
                }
            }else if($emailnusercheck=="SameUser"){
                $checkemail=$this->checkEmail($this->email);
                if($checkemail){
                    //continua
                    $response=$this->modUser($this->usID,$this->email,$this->pwd,$this->name,$this->nomUs,$this->tel,$this->birth,$this->photo);
                    return $response;
                }else{
                    //rip
                    $response="ExistingUsername";
                    return $response;
                }
            }else{ //diferente email y usuario
                $checkuser=$this->checkusername($this->nomUs);
                $checkemail=$this->checkEmail($this->email);
                if($checkemail &&$checkuser){
                    //continua
                    $response=$this->modUser($this->usID,$this->email,$this->pwd,$this->name,$this->nomUs,$this->tel,$this->birth,$this->photo);
                    return $response;

                }else{
                    //rip
                    $response="ExistingEmailnUsername";
                    return $response;
                }

            }
        }
    }
    public function setBlockUnblock(){
        $response=$this->BlockUnblockUser($this->usID,$this->admin,$this->opBU);
        return $response;
    }
    public function deleteUser(){
        $response=$this->delUser($this->usID,$this->admin);
        return $response;
    }
    public function getAllU(){
        return $this->getAllUsers($this->usID);
    }
   private function emptyInputs(){
       $result;
       if( empty($this->email) || empty($this->pwd) || empty($this->birth) || empty($this->name) 
       || empty($this->pwd2) || empty($this->tel)|| empty($this->nomUs)){
           $result = false;
       }else{
           $result = true;
       }
       return $result;
   }


   private function matchPwd(){
    $result;
    if($this->pwd !== $this->pwd2){
        $result = false;
    }else{
        $result = true;
    }
    return $result;
    }

}
?>