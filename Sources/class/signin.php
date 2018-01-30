<?php
class signin{
    private $m;
    //private $newpswrd = null;

    public function __construct(mainframe & $mainframe){
        $this->m =  $mainframe;
    }

    
    public function forgot(){
        $this->validation = true;
        
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        
        
        $this->m->_db->setQuery(
                    "SELECT `users`.`lastname`,`users`.`id`,`users`.`password` "
                    . " FROM `users` "
                    . " WHERE `users`.`email` = '".$email."' "
                    . " AND `users`.`status` = 1"
                    . " LIMIT 1"
                );
        $rows = reset($this->m->_db->loadObjectList());
        
        
        if(!$rows){
            $this->validation = false;
            $this->error->email = _("You entered an invalide email");
        }else if($rows){
            if($rows->lastname != $lastname){
                $this->validation = false;
                $this->error->email = _("You entered an invalide lastname");
            }
        }
        
        
        if($this->validation === false){
	    $this->error = _("You entered not valid data. Try again");
            return;
        }
        
            $salt = makePassword(16);
            $password = strtolower(makePassword(16));
            $crypt = md5(md5($password).$salt);

            $row->password = $crypt . ':' . $salt;
            $row->id = (int)$rows->id;
            $row->bad_auth = 0;
            //$row->last_modified = "0000-00-00 00:00:00";
            $row->last_modified = date('Y-m-d H:i:s');
            

            if($this->m->_db->updateObject('users',$row,'id')){
                include(XPATH_TEMPLATE_FRONT.DS."modules".DS.'email'.DS."emailforgot.php");
                $this->m->add_to_history($row->id, "reset", "changedpassword",$rows->password);
                
		$this->success = _("You have successfully restore your password. A new password has been sent to your E-mail");
                
                $status = (int)sendemail($email, $mailsubject, $mailbody_html, $mailbody_txt);
                
            }else{
		$this->error = _("An error has occurred, please try later");
            }
            
    }
 }
?>
