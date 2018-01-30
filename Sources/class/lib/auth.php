<?php
xload("class.lib.dbtable");
xload("class.lib.session");

class xAuth {

    public function __construct(mainframe & $mainframe) {
        $this->m = $mainframe;
        $this->_session = new xSession($this->m);
    }

    public function changeSESSID($ssid){
        $ssid = strip_tags(trim($ssid));
        $this->m->_db->setQuery(
                    "SELECT * FROM `x_session` "
                    . " WHERE `x_session`.`session_id` = '".$ssid."'"
                    . " LIMIT 1"
                );
        $session = $this->m->_db->loadObjectList();
        
        if(!$session) return;
        $_COOKIE['PHPSESSID'] = $ssid;
        
        $this->_session->userid = $session[0]->userid;

        setcookie(md5('cookiename'), $ssid, false, '/');
        session_id($ssid);
        session_start();
        
        if((int)$_GET['account_id']){
            $_SESSION[$this->_user->id . ".account"] = (int)$_GET['account_id'];
        }
    }
    
    public function initSession(){
        $sessionCookieName  = md5('cookiename');
        $sessioncookie      = strval( getParam( $_COOKIE, $sessionCookieName, null ) );

        if ($_GET['PHPSESSID']) {
            $this->changeSESSID($_GET['PHPSESSID']);
            return;
        }

        $sessionValueCheck  = self::sessionCookieValue($sessioncookie);

        $this->_session->purge('core');

        if ($sessioncookie && strlen($sessioncookie) == 32 && $this->_session->load($sessionValueCheck)) {
            $this->_session->time = time();
            $this->_session->ip          = $_SERVER["REMOTE_ADDR"];
            $this->_session->user_agent  = $_SERVER['HTTP_USER_AGENT'];
            $this->_session->_session_cookie = $sessioncookie;
            $this->_session->update();

            if ((int)$this->_session->guest) {
                setcookie($sessionCookieName, $this->_session->getCookie(), $this->_session->time + 14400, '/'); // 14400 seconds = 4 hours
            } else {
                if ((int)$this->_session->remember) {
                    setcookie($sessionCookieName, $this->_session->getCookie(), $this->_session->time + 31536000, '/'); // 31536000 seconds = 365 days
                } else {
                    setcookie($sessionCookieName, $this->_session->getCookie(), $this->_session->time + 2592000, '/'); // 2592000 seconds = 30 days
                }
            }
        } else {
            if (isset($_COOKIE[$sessionCookieName])) {
                setcookie($sessionCookieName, null, -1, '/');
                unset($_COOKIE[$sessionCookieName]);
            }

            //$url = strval( getParam( $_SERVER, 'REQUEST_URI', null ) );

            $this->_session->guest       = 1;
            $this->_session->username    = '';
            $this->_session->time        = time();
            //$this->_session->gid         = 0;
            $this->_session->ip          = $_SERVER["REMOTE_ADDR"];
            $this->_session->user_agent  = $_SERVER['HTTP_USER_AGENT'];
            $this->_session->remember    = 0;

            $this->_session->generateId();

            if (!$this->_session->insert()) {
                die();
            }

            setcookie($sessionCookieName, $this->_session->getCookie(), time() + 14400, '/'); // 14400 seconds = 4 hours

            if (getParam($_GET,'lang')){
                setcookie('lang', getParam($_GET, 'lang', ''), time() + 31536000, '/'); //31536000 seconds = 365 days
            }

            //$remCookieValue = strval( getParam( $_COOKIE, $remCookieName, null ) );
            //
            //if ( strlen($remCookieValue) > 64 ) {
            //    $remUser    = substr( $remCookieValue, 0, 32 );
            //    $remPass    = substr( $remCookieValue, 32, 32 );
            //    $remID      = intval( substr( $remCookieValue, 64  ) );
            //
            //    if ( strlen($remUser) == 32 && strlen($remPass) == 32 ) {
            //        $this->login( $remUser, $remPass, 1, $remID );
            //    }
            //}
        }

        if (!empty($this->_session->session_id)) {
            session_id($this->_session->session_id);
        }
        session_start();
    }

    public function sessionCookieName() {
        global $mainframe, $bConfig_live_site;

        if (substr($bConfig_live_site, 0, 7) == 'http://') {
            $hash = md5('site' . substr($bConfig_live_site, 7));
        } elseif (substr($bConfig_live_site, 0, 8) == 'https://') {
            $hash = md5('site' . substr($bConfig_live_site, 8));
        } else {
            $hash = md5('site' . $mainframe->getCfg('live_site'));
        }

        return $hash;
    }

    public function sessionCookieValue($id = null) {
        global $mainframe;
        $type = 2;

        $browser = @$_SERVER['HTTP_USER_AGENT'];

        switch ($type) {
            case 2:
                //$value          = md5( $id . $_SERVER['REMOTE_ADDR'] );
                $value          = md5($id);
                break;
            case 1:
                $remote_addr = explode('.', $_SERVER['REMOTE_ADDR']);
                $ip = $remote_addr[0] . '.' . $remote_addr[1] . '.' . $remote_addr[2];
                $value = mosHash($id . $ip . $browser);
                break;
            default:
                $ip = $_SERVER['REMOTE_ADDR'];
                $value = mosHash($id . $ip . $browser);
                break;
        }

        return $value;
    }

    public function remCookieName_User() {
        $value = 'remembercookie';
        return $value;
    }

    public function remCookieName_Pass() {
        $value = mosHash('remembermecookiepassword' . mainframe::sessionCookieName());
        return $value;
    }

    public function remCookieValue_User($username) {
        $value = md5($username . mosHash(@$_SERVER['HTTP_USER_AGENT']));
        return $value;
    }

    public function remCookieValue_Pass($passwd) {
        $value = md5($passwd . mosHash(@$_SERVER['HTTP_USER_AGENT']));
        return $value;
    }
    
    public function login($url = '/',$email, $password){
        $email = $email ? $email : stripslashes(strval(getParam($_POST, 'email', '    ')));
        $passwd = $password ? $password : stripslashes(strval(getParam($_POST, 'password', '')));

        if (!$email || !$passwd) {
            redirect("/?error=login-incorrect");
            return;
        }

        if (!$this->_session->session_id) {
            redirect('/');
            return;
        }
        
        $this->m->_db->setQuery(//получаем пользователей и на демо и не на демо
                " SELECT `users`.*"
                . " FROM `users` "
                . " WHERE `users`.`email` = " . $this->m->_db->Quote($email)
                //. " AND `users`.`gid` IN (1,2)"
                . " AND `users`.`status` = 1"
                . " LIMIT 1;"
        );
        $row = $this->m->_db->loadObjectList();
        
        if (!$row) {
            redirect("/?error=login-incorrect");
            return;
        } else {
            $row = $row[0];
        }
        
        if ((int) $row->bad_auth >= 5) {
            redirect("/?error=failedlogin");
            return;
        }

        //$refcookiename = "999be3440691882c7227dfad792c7833"; //md5("refcookiename-keygames");

        list($hash, $salt) = explode(':', $row->password);
        $cryptpass = md5(md5($passwd) . $salt);

        if ($hash != $cryptpass){
            //$this->m->add_to_history($row->id, "login", "failedlogin");

            $this->m->_db->setQuery(
                    "UPDATE `users` "
                    . " SET `users`.`bad_auth` = `users`.`bad_auth` + 1 "
                    . " ,`users`.`last_modified` = NOW() "
                    . " WHERE `users`.`id` = " . (int) $row->id
                    . " LIMIT 1;"
            );
            $this->m->_db->query();

            if ($row->bad_auth >= 4) {
                redirect("/?error=failedlogin");
                return;
            }

            redirect("/?error=login-incorrect");
            return;
        }

        $this->m->add_to_history($row->id);

        $this->_session->guest = 0;
        $this->_session->username = $row->email;
        $this->_session->userid = (int) $row->id;
        $this->_session->usertype = "user";
        //$this->_session->gid = (int) $row->gid;
        $this->_session->ip = $_SERVER["REMOTE_ADDR"];
        $this->_session->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->_session->remember    = 0;
        $this->_session->cookie = $_COOKIE[$refcookiename];
        $this->_session->update();

        if ((int)$this->_session->remember) {
            setcookie(md5('cookiename'), $this->_session->getCookie(), $this->_session->time + 31536000, '/'); // 31536000 seconds = 365 days
        } else {
            setcookie(md5('cookiename'), $this->_session->getCookie(), $this->_session->time + 2592000, '/'); // 2592000 seconds = 30 days
        }

        $this->m->_db->setQuery(
                " UPDATE `users` "
                . " SET `users`.`last_login` = NOW() "
                . " ,`users`.`last_ip` = " . $this->m->_db->Quote($_SERVER["REMOTE_ADDR"])
                . ($row->bad_auth ? " ,`users`.`bad_auth` = 0 " : "")
                . " WHERE `users`.`id` = " . (int) $row->id
                . " LIMIT 1;"
        );
        
        if (!$this->m->_db->query()) {
            redirect('/');
            return;
        }

        redirect($url);
    }
    
    public function facebookLogin($url, $me){
          //проверяем или есть такой пользователь
        $this->m->_db->setQuery(
                    "SELECT * FROM `users` WHERE `users`.`facebook_id` = ".$me->id
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($user);
        
        if(!$user){
            $this->error = 'Такого пользователя нету';
            return false;
        }
        
        $this->_session->guest = '0';
        $this->_session->username = $user->facebook_id;
        $this->_session->userid = (int) $user->id;
        $this->_session->usertype = "user";
        $this->_session->gid = (int) $user->gid;
        $this->_session->ip = $_SERVER["REMOTE_ADDR"];
        $this->_session->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->_session->cookie = $_COOKIE[$refcookiename];

        $this->_session->update();
        
        $this->m->_db->setQuery(
                " UPDATE `users` "
                . " SET `users`.`last_login` = NOW() "
                . " ,`users`.`last_ip` = " . $this->m->_db->Quote($_SERVER["REMOTE_ADDR"])
                . " ,`users`.`bad_auth` = 0 "
                . " WHERE `users`.`facebook_id` = " . $user->facebook_id
                . " LIMIT 1;"
        );
        if (!$this->m->_db->query()) {
            //redirect('/');
            return false;
        }

        return true;
        //redirect($url);
    }
    
    public function googleLogin($url, $me){
      //проверяем или есть такой пользователь
        
        $this->m->_db->setQuery(
                    "SELECT * FROM `users` WHERE `users`.`google_id` = '".$me->id."'"
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($user);
        
        if(!$user){
            $_SESSION['google_oauth_login'] = '{"status":"error","message":"Такого пользователя нету"}';
            //$this->m->oauth_json = '{"status":"error","message":"Такого пользователя нету"}'; 
            redirect('/');
            //$this->error = 'Такого пользователя нету';
            return false;
        }
        
        $this->_session->guest = '0';
        $this->_session->username = $user->google_id;
        $this->_session->userid = (int) $user->id;
        $this->_session->usertype = "user";
        $this->_session->gid = (int) $user->gid;
        $this->_session->ip = $_SERVER["REMOTE_ADDR"];
        $this->_session->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->_session->cookie = $_COOKIE[$refcookiename];

        $this->_session->update();
        
        
        $this->m->_db->setQuery(
                " UPDATE `users` "
                . " SET `users`.`last_login` = NOW() "
                . " ,`users`.`last_ip` = " . $this->m->_db->Quote($_SERVER["REMOTE_ADDR"])
                . " ,`users`.`bad_auth` = 0 "
                . " WHERE `users`.`google_id` = " . $user->google_id
                . " LIMIT 1;"
        );
        if (!$this->m->_db->query()) {
            redirect('/');
            return;
        }
        $_SESSION['google_oauth_login'] = '{"status":"success"}';
        redirect('/');
        //$this->m->oauth_json = '{"status":"success"}'; 
        //$this->m->login_status = true;
        //redirect($url);
    }
    
    public function ajaxLogin($url = '/', $login, $passwd){
        if (!$login || !$passwd){
            $this->error = 'Не заполнены все поля';
            return false;
        }

        $this->m->_db->setQuery(    //получаем пользователей и на демо и не на демо
                " SELECT `users`.*"
                . " FROM `users` "
                . " WHERE (`users`.`email` = " . $this->m->_db->Quote($login) . ") OR ( `users`.`phone` = ". $this->m->_db->Quote($login).")"
                . " AND `users`.`status` = 1"                
                . " LIMIT 1"
        );
        $this->m->_db->loadObject($user);
        
        if(!$user){            
            $this->error->email = 'Такой email не зарегестрирован';
            return false;
        }
        if($user && $user->status <= 0){            
            $this->error->main = 'Аккаунт забанен';
            return false;
        }

        if(!$user){            
            $this->error->main = "Не верные данные";
            return false;
        }

        if ($user->status < 0 || (int)$user->bad_withdraw_answer >= 5) {            
            $this->error->main = "Аккаунт забанен";
            return false;
        }

        /*if ((int)$user->bad_auth >= 5) {
            die('{"status":"error","message":"Аккаунт забанен"}');
        }*/

        //$refcookiename = "999be3440691882c7227dfad792c7833"; //md5("refcookiename-keygames");
        
        list($hash, $salt) = explode(':', $user->password);
        
        $cryptpass = md5(md5($passwd) . $salt);
        
        if ($hash != $cryptpass){
            $this->m->add_to_history($user->id, "login", "failedlogin");

            $this->m->_db->setQuery(
                    "UPDATE `users` "
                    //. " SET `users`.`bad_auth` = `users`.`bad_auth` + 1 "
                    . " SET `users`.`bad_auth` = 0 "
                    . " ,`users`.`last_modified` = NOW() "
                    . " WHERE `users`.`id` = " . (int)$user->id
                    . " LIMIT 1;"
            );
            $this->m->_db->query();
            if ($user->bad_auth >= 4) {
                $this->error->main = "Лимит запросов превышен";
                return false;
            }
            
            $this->error->password = "Неправильный пароль";
            return false;
        }

        $this->m->add_to_history($user->id);

        $this->_session->guest = 0;
        $this->_session->username = $user->email;
        $this->_session->userid = (int) $user->id;
        $this->_session->usertype = "user";
        //$this->_session->gid = (int) $user->gid;
        $this->_session->ip = $_SERVER["REMOTE_ADDR"];
        $this->_session->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->_session->remember    = 0;
        $this->_session->cookie = $_COOKIE[$refcookiename];
        $this->_session->update();

        if ((int)$this->_session->remember) {
            setcookie(md5('cookiename'), $this->_session->getCookie(), $this->_session->time + 31536000, '/'); // 31536000 seconds = 365 days
        } else {
            setcookie(md5('cookiename'), $this->_session->getCookie(), 0, '/');
        }

        $this->m->_db->setQuery(
                " UPDATE `users` "
                . " SET `users`.`last_login` = NOW() "
                . " ,`users`.`last_ip` = " . $this->m->_db->Quote($_SERVER["REMOTE_ADDR"])
                . ($user->bad_auth ? " ,`users`.`bad_auth` = 0 " : "")
                . " WHERE `users`.`id` = " . (int)$user->id
                . " LIMIT 1;"
        );
        $this->m->_db->query();
        
        if(!$this->_session->session_id ){            
            $this->error->main = "Нету сессии";
            return false;
        }        
        $this->m->_user = $this->getUser();
        
        return true;
        
        //return array("status" => "success", "url" => "'$url'", 'ssid'=>$this->_session->session_id , 'user' => $row->firstname, 'id' => $row->id, "messages" => $this->m->get_unread_message());
    }

    public function logout($url = '/') {
        $this->_session->delete();

        setcookie(md5('cookiename'), null, -1, '/');

        @session_destroy();
        
        redirect($url);
    }

    public function set($property, $value = null) {
        $this->$property = $value;
    }

    public function get($property, $default = null) {
        if (isset($this->$property)) {
            return $this->$property;
        } else {
            return $default;
        }
    }

    public function getUser(){
        static $instance;
        
        if (is_object($instance))
            return $instance;

        $user_id = intval($this->_session->userid);
        
        if (!$user_id)return array();

        if($this->_session->gid == 3){  //если єто сотрудник
            $this->m->_db->setQuery(
                        "SELECT `internals`.* "
                        . " FROM `internals` "
                        . " WHERE `internals`.`id` = ".$user_id
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($instance);
            
            $instance->session = $this->_session->session_id;
            $instance->gid = 3;
        }else{  //если єто пользователь
            
            $this->m->_db->setQuery(
                    " SELECT `users`.* "
                    . " FROM `users` "
                    //. " WHERE `users`.`gid` IN (1,2)"
                    . " WHERE 1"
                    . " AND `users`.`status` > -1 "
                    . " AND `users`.`id` = " . $this->m->_db->Quote($user_id)
            );
            $this->m->_db->loadObject($instance);
            //unset($instance->password);
        }

        return $instance;
    }
    
     public function getUsersAccount(){
        $this->m->_db->setQuery(
            " SELECT * FROM `accounts` WHERE `user_id` = " . $this->m->_db->Quote($this->m->_user->id)
            . " AND `status` = 1"
            );

        $accounts = $this->m->_db->loadObjectList('id');
        
        return $accounts;
    }

    function checkUserPassword($password) {
        $user_id = intval($this->_session->userid);

        if (!$user_id)
            return false;

        $this->m->_db->setQuery(
                " SELECT `password` "
                . " FROM `users` "
                //. " WHERE `users`.`gid` IN (1,2)"
                . " AND `users`.`status` > -1 "
                . " AND `users`.`id` = " . $this->m->_db->Quote($user_id)
        );

        $this->m->_db->loadObject($row);

        list($hash, $salt) = explode(':', $row->password);

        if (empty($hash))
            return false;

        $cryptpass = md5(md5($password) . $salt);

        if ($hash == $cryptpass) {
            return true;
        } else {
            return false;
        }
    }

    function checkUserAnswer($answer) {
        $user_id = intval($this->_session->userid);

        if (!$user_id)
            return false;

        $this->m->_db->setQuery(
                " SELECT `answer` "
                . " FROM `users` "
                //. " WHERE `users`.`gid` IN (1,2)"
                . " AND `users`.`status` > -1 "
                . " AND `users`.`id` = " . $this->m->_db->Quote($user_id)
        );

        $user_answer = iconv("WINDOWS-1251", "UTF-8", $this->m->_db->loadResult());

        if (empty($user_answer))
            return false;

        if ($user_answer == $answer) {
            return true;
        } else {
            return false;
        }
    }

}
?>
