<?php
class Registration{
    protected $_table = 'users';
 
    public function __construct(mainframe & $mainframe){
        $this->m =  $mainframe;
    }
    
    public function changePassword(){
        //проверяем был введен пароль или нет
        $this->validation = true;
        
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['new_password'];
        
        if($this->m->_user->password){  //если пароль есть
            //$password = $this->checkPassword($new_password);
            
            list($hash, $salt) = explode(':', $this->m->_user->password);
            $cryptpass = md5(md5($old_password) . $salt);
            
            if ($hash != $cryptpass){
                $this->validation = false;
                $this->error = 'Вы ввели не правильный пароль';
                return false;
            }
            
            if($new_password != $confirm_password){
                $this->validation = false;
                $this->error = 'Пароли не совпадают';
                return false;
            }
            
            $password = $this->checkPassword($new_password);
            
            $this->m->_db->setQuery(
                        "UPDATE `users` SET `users`.`password` = '".$password."'"
                        . " WHERE `users`.`id` = ".$this->m->_user->id
                        . " LIMIT 1"
                    );
            if($this->m->_db->query()){
                echo '{"status":"success"}';
            }else{
                echo '{"status":"error"}';
            }
        }else{
            if($new_password != $confirm_password){
                $this->validation = false;
                $this->error = 'Пароли не совпадают';
                return false;
            }
     
            $password = $this->checkPassword($new_password);
            
            $this->m->_db->setQuery(
                        "UPDATE `users` SET `users`.`password` = '".$password."'"
                        . " WHERE `users`.`id` = ".$this->m->_user->id
                        . " LIMIT 1"
                    );
            if($this->m->_db->query()){                
                echo '{"status":"success"}';
            }else{
                
                echo '{"status":"error"}';
            }
        }        
    }
    
    public function googleRegistrate($data){        
        $row->google_id = $data->id;
        $row->firstname = $data->given_name;
        $row->lastname = $data->family_name;
        $row->email = $data->email;
        
        $row->date = date('Y-m-d');
                
        //если все хорошо то генерируем промокод
        $row->promocode = $this->generatePromo();
        
        makeHtmlSafe($row);
        //include(XPATH_TEMPLATE_FRONT.DS."modules".DS.'email'.DS."emailreg.php");
        //$status = (int)sendemail($row->email, $mailsubject, $mailbody_html, $mailbody_txt);
        
        if($this->m->_db->insertObject('users',$row)){
            return true;
        }else{
            return false;
        }
    }
    
    public function facebookRegistrate($data){
        $row->facebook_id = $data->id;
        $row->firstname = $data->first_name;
        $row->lastname = $data->last_name;
        $row->email = $data->email;
        
        //$row->parent = $this->checkPromo($_POST['promo']);        
        //$row->parent = $arr[1];
        
        $row->date = date('Y-m-d');
                
        //если все хорошо то генерируем промокод
        $row->promocode = $this->generatePromo();
        
        makeHtmlSafe($row);
        //include(XPATH_TEMPLATE_FRONT.DS."modules".DS.'email'.DS."emailreg.php");
        //$status = (int)sendemail($row->email, $mailsubject, $mailbody_html, $mailbody_txt);
        
        if($this->m->_db->insertObject('users',$row)){
            return true;
        }else{
            return false;
        }
    }
    
    public function changePersonalInfo(){        
        $this->validation = true;
                
        $row->id = $this->m->_user->id;        
        $row->firstname = $this->checkFirstname($_POST['firstname']);        
        $row->lastname = $this->checkLastname($_POST['lastname']);
        
        
        if(trim($_POST['email']) != $this->m->_user->email){
            $row->email = $this->checkEmail($_POST['email']);
        }

        //$row->company = $this->checkCompany($_POST['company']);        
        $row->phone = $this->checkPhone($_POST['phone']);
        $row->address = $_POST['address'];
        $row->postal_code = $_POST['postal_code'];
        
        $row->lat = strip_tags(trim($_POST['lat']));
        $row->lng = strip_tags(trim($_POST['lng']));
        
        $row->last_modified = date('Y-m-d H:i:s');
        
        if($this->validation == false){            
            return false;
        }
        
        if($this->m->_db->updateObject('users',$row,'id')){
            return true;
        }else{
            return false;
        }     
    }
    
    
    public function registration(){
        $this->validation = true;
        
        $row->email = $this->checkEmail($_POST['email']);
        
        $row->password = $this->checkPassword($_POST['password']);
        $this->confirmPassword($_POST['password'],$_POST['password2']);
        
        $row->date = date('Y-m-d');
        
        if(!$this->validation){
            return false;
        }
        
        makeHtmlSafe($row);
        
        //include(XPATH_TEMPLATE_FRONT.DS."modules".DS.'email'.DS."emailreg.php");
        //$status = (int)sendemail($row->email, $mailsubject, $mailbody_html, $mailbody_txt);
        
        if($this->m->_db->insertObject('users',$row)){
            return true;
        }else{
            return false;
        }
    }
    
    public function checkPromo($promo){
        $promo = trim($promo);
        
        if(!$promo) return;
        
        //Проверяем у кого есть такой промокод
        $this->m->_db->setQuery(
                    "SELECT COUNT(`users`.`id`) "
                    . " FROM `users` "
                    . " WHERE `users`.`promocode` = '".$promo."'"
                    . " LIMIT 1"
                );
        $parent = $this->m->_db->loadResult();
                
        if(!$parent){
            $this->error->promo = _("You need to enter promo");
            $this->validation = false;           
        }
        
        //return array($promo,$parent);
        return $parent;
    }
    
    public function confirmPassword($password,$password2){
        $password = trim($password);
        if($password != $password2 || strlen($password2) == 0){
            $this->error->password2 = _("Passwords does not match");
            $this->validation = false;
            return false;
        }        
    }
    
    public function checkPassword($password){
        $password = trim($password);
        
        if (empty($password) || strlen($password) < 4 || strlen($password) > 40) {
            $this->error->password = _("You have used incorrect symbols, or incorrect length");
            $this->validation = false;
            return false;
        }else if(!preg_match('/^([a-z0-9])+$/i',$password)){
            $this->error->password = _("You have used incorrect symbols, or incorrect length");
            $this->validation = false;
            return false;
        }
        $this->pswrd = $password;
        $salt   = makePassword(16);
        $crypt  = md5(md5($password) . $salt);
        $password  = $crypt . ':' . $salt;

        return $password;
    }
    /*public function checkCountry($country){
        return $country;
    }*/
    
    public function checkPhone($phone){
        $phone = strip_tags(trim($phone));
        
        if(!$phone){
            $this->error->login = 'Вы должны ввести телефон';
            $this->validation = false;
        }
        
        return $phone;
    }
    
    public function checkAddress($address){
        return $address;
    }
    
    public function checkCity($city){
        return $city;
    }
    
    public function checkPostcode($postcode){
        return $postcode;
    }
    
    public function checkRegion($region){
        return $region;
    }
    
    /*public function checkCompany($company){
        return $company;
    }*/
    
    public function checkEmail($email){
        $email = strip_tags(trim($email));
        
        if(!$email){
            $this->error->login = 'Вы должны ввести имейл';
            $this->validation = false;
            return false;
        }
        
        $this->m->_db->setQuery(
                    "SELECT `users`.`id` "
                    . " FROM `users` WHERE `users`.`email` = '".$email."'"
                    . " LIMIT 1"
                );
        $ret = $this->m->_db->loadResult();
        
        if($ret){
            $this->error->email = 'Такой имейл уже используется.';
            $this->validation = false;            
        }
        
        return $email;
    }
    
    public function checkBirthday($year, $month ,$day){
        $birthday = date("Y-m-d",strtotime($year.'-'.$month.'-'.$day));
        
        return $birthday;
    }
    
    public function checkFirstname($firstname){
        $firstname = strip_tags(trim($firstname));
        
        if(!$firstname){
            $this->error->firstname = 'Вы должны ввести ваше имя';
            $this->validation = false;
        }
        
        return $firstname;
    }
    
    public function checkLastname($lastname){
        $lastname = strip_tags(trim($lastname));
        
        if(!$lastname){
            $this->error->lastname = 'Вы должны ввести вашу фамиию';
            $this->validation = false;
        }
        
        return $lastname;
    }
    
    public function checkGender($gender){
        $gender = (int)$gender;
        
        return $gender;
    }
}
?>
