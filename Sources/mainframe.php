<?php
xload('class.deals');
xload('class.activity');

class mainframe {
    var $_title = null;
    var $_head  = null;
    var $_template = null;
    var $_lang = null;
    var $maincontent = null;
    var $templatepath = null;
    var $abstemplatepath = null;
    var $config = null;
    var $_db = null;
    private $_islogin = false;
    var $_user = null;
    public $menu = array();
    public $_ip = null;
    
    public $questions;
    
    public $_controller;
    public $_action;
    public $_scripts = array();
    public $_jsparams = array();
    public $_stylesheet = array();
    public $_cssparams = array();
    
    public $protocol = true; //WebSocket или нормальнЫй режим

    function run() {
        $this->setConfig();
        $this->setDB();
        
        $this->_auth = new xAuth($this);
        
        $this->_auth->initSession();        
        //$this->initSession();
        
        $this->parsePath();
        $this->setLang();
        
        $this->checkPlatform();
        
        
        $this->_user = $this->_auth->getUser();
        //$this->_user = $this->getUser();
        
        if (is_object($this->_user) && $this->_user->id > 0){
            $this->_islogin = true;
        }
        
        if($_GET['datatype']== 'ajax')$this->disableTemplate();
        
        $this->page();
        $this->output();
    }
    
    private function checkPlatform(){
        if(preg_match('/Web0S/', $_SERVER['HTTP_USER_AGENT'], $matches) || preg_match('/LG SimpleSmart\.TV/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            //$this->platform = 'webos';
            $this->platform = 'netcast';
        }else if(preg_match('/NetCast/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'netcast';
        }else if(preg_match('/QtEmbedded/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'dunestb';
        }else if(preg_match('/Philips/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'philips';
        }else if(preg_match('/SmartHub/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'samsung';
        }else if(preg_match('/Tizen/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'tizen';
        }else if(preg_match('/iPhone/', $_SERVER['HTTP_USER_AGENT'], $matches)){
            $this->platform = 'iphone';
        }else{
            $this->platform = 'pc';
        }
                
        //$this->platform = 'samsung';
        //$this->platform = 'webos';
    }
    
    public function getUser(){
        if(!$this->_user->id) return;
        
        $this->_db->setQuery(
                    "SELECT `users`.* "
                    //. " FROM `users` WHERE `users`.`email` = '".$this->_user->email."'"
                    . " FROM `users` WHERE `users`.`id` = '".$this->_user->id."'"
                    . " LIMIT 1"
                );
        $this->_db->loadObject($user);
        
        unset($user->password);
        //$this->_user = $user;        
        
        return $user;
    }
    
    public function generateSerial(){
        $rand = (mt_rand() / mt_getrandmax());
        
        return md5($rand);
    }
    
    public function initSession(){
        session_start();
        
        //проверяем или есть мак и сн и если нету то генерируем новые
        if(!$_SESSION['mac'] || !$_SESSION['sn']){
            
            $serial = $this->generateSerial();
            $this->mac = substr($serial,0,16);
            $this->sn = substr($serial,16);
            $_SESSION['sn'] = $this->sn;
            $_SESSION['mac'] = $this->mac;
        }else{
            $this->sn = $_SESSION['sn'];
            $this->mac = $_SESSION['mac'];
        }

        //$sessioncookie = strval(getParam( $_COOKIE, 'session_id', null ));
        $session = $_SESSION['session_id'];
        
        //$server_url = 'http://192.168.0.150:5555/?action=getSession&MAC='.$this->mac.'&SN='.$this->sn.'&sid='.$session;
        $server_url = $this->config->auth_server.'?action=getSession&MAC='.$this->mac.'&SN='.$this->sn.'&sid='.$session;
        
        $ch = curl_init($server_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        $result = curl_exec($ch);
        //p($result);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        //setcookie('session_id', json_decode($result)->id, time() + 14400, '/');
        $this->session_id = json_decode($result)->id;
        
        if($_SESSION['session_id'] != $this->session_id){
            $_SESSION['session_id'] = $this->session_id;
        }

        $this->_user->email = json_decode($result)->user->email;
        $this->_user->id = json_decode($result)->user->id;
    }

    private function affiliates(){
        if (isset($_GET["aff"])) {
            $id = 0;
            $afftrack = strip_tags(trim($_GET["afftrack"]));

            if (!empty($afftrack)) {
                $this->_db->setQuery(   //проверяем или даннЫй код уже был добавлен
                    "SELECT `afftracks`.`id` "
                    . " FROM `afftracks` "
                    . " WHERE `afftracks`.`partner_id` = " . (int)$_GET['aff']
                    . " AND `afftracks`.`afftracker` = '" . $afftrack . "'"
                    . " LIMIT 1"
                    );
                $id = $this->_db->loadResult();
                if (!$id) {
                    $row->partner_id = (int)$_GET['aff'];
                    $row->afftracker = strip_tags(trim($_GET["afftrack"]));
                    $row->date = date('Y-m-d H:i:s');
                    $this->_db->insertObject('afftracks',$row, 'id');

                    $id = $row->id;
                    $row = new stdClass();
                }
            }
            
            $row->partner_id = (int)$_GET['aff'];
            $row->afftracker_id = $id;
            
            $row->uid = $this->_user->uid_id;
            $row->date = date('Y-m-d H:i:s');
            $this->_db->insertObject('affiliate_activity',$row);
            
            setcookie("aff", $row->partner_id.' '.$row->afftracker_id, 0x6FFFFFFF, "/");
            //setcookie("afftrack", strip_tags(trim($_GET["afftrack"])), 0x6FFFFFFF, "/");
            setcookie('campaign_code', null, -1, '/');
            
            /*if("registration" == $this->_path[0]){
                redirect("/registration/");
            }else{
                redirect("/");
            }*/
        } else {
            if (isset($_GET["campaign_code"])){
                $this->_db->setQuery(
                            "SELECT `partners`.`id` "
                            . " FROM `partners` WHERE `partners`.`username` = ".$this->_db->Quote($_GET["campaign_code"]).""
                            . " LIMIT 1"
                        );
                $id = $this->_db->loadResult();
                if($id){
                    setcookie("aff", $id.' 0', 0x6FFFFFFF, "/");
                    if($_COOKIE['campaign_code']){
                        setcookie('campaign_code', null, -1, '/');
                    }
                    
                    /*if ("registration" == $this->_path[0]) {
                        redirect("/registration/?aff=" . $id);
                    } elseif ("page1" == $this->_path[0] || "page2" == $this->_path[0]) {
                        redirect("/" . $this->_path[0] . "/?aff=" . $id);
                    } else {
                        redirect("/?aff=" . $id);
                    }*/
                }
            }else{
                if($_COOKIE['campaign_code']){
                    $this->_db->setQuery(
                                "SELECT `partners`.`id` "
                                . " FROM `partners` WHERE `partners`.`username` = ".$this->_db->Quote($_COOKIE['campaign_code']).""
                                . " LIMIT 1"
                            );
                    $id = $this->_db->loadResult();
                    if($id){
                        setcookie("aff", $id.' 0', 0x6FFFFFFF, "/");
                        setcookie('campaign_code', null, -1, '/');
                    }
                }
            }
        }
    }

    /*private function getOffers(){
        if(!$this->_user->offer_notification) return;
        
        $this->_db->setQuery(
                    "SELECT `offers`.* "
                    . " , `users`.`firstname`"
                    . " , `users`.`lastname`"
                    . " FROM `offers`"
                    . " LEFT JOIN `users` ON `users`.`id` = `offers`.`user_id`"
                    . " WHERE `offers`.`offer_id` = ".$this->_user->id
                    . " AND `offers`.`status` = 0"
                    . " LIMIT 1"
                ); 
        $this->_db->loadObject($row);
        
        return $row;
    }*/
 
    /*private function getDefaultBet(){
        foreach($this->config->betlist as $key=>$amount){
            if($this->_user->balance/1000 < $amount){
                if(!$this->config->betlist[$key-1]){
                    
                    $this->_user->defaultbet = $this->config->betlist[$key]*100;
                }else{
                    
                    $this->_user->defaultbet = $this->config->betlist[$key-1]*100;
                    
                }
                break;
            }
        }
        
        if($this->_user->defaultbet < $this->_user->minbet){
            $this->_user->defaultbet = $this->_user->minbet;
        }
        $this->_user->defaultbet = 2000;
    }*/
    
    /*private function setBets(){
        if($this->mode == 2){
            $this->minbet = $this->config->miniminbet;
            $this->maxbet = $this->config->minimaxbet;
            $this->betlist = $this->config->minibetlist;
        }else{
            $this->minbet = $this->config->minbet;
            $this->maxbet = $this->config->maxbet;
            $this->betlist = $this->config->betlist;
        } 
    }*/
    
    private function setFacebookLib(){
        xload('class.lib.facebook.facebook');
        
        $this->facebook = new Facebook(array(
          'appId'  => $this->config->facebookAppId,
          'secret' => $this->config->facebookAppSecret
        ));
        
        //$user->id = $this->m->facebook->getUser(); //users id
        /*$user = $this->facebook->getUser();
        
        if (!$user->id) {
          $loginUrl = $this->facebook->getLoginUrl(array(    
                                'scope' => 'read_stream, friends_likes, email, publish_actions',
                                'redirect_uri' => 'http://optionnew.com/'
                              ));
            echo "<script>top.location.href='" . $loginUrl . "';</script>\n";
            die();
            return false;
          }*/
        
    }
    public function getUniqueVisitor(){        
        $this->activity = new Activity($this);
        
        $this->activity->visitorUID = $_COOKIE["advuid"];

        if(!$this->activity->visitorUID){  //seting Uids Cookies
            $this->activity->visitorUID = $this->activity->addVisitor();
        }else{      //updating activity time
            
            $this->activity->addActivity();
            $this->activity->updActivity($this->activity->visitorUID);
        }
    }
    
    public function get4Info(){
        if($this->protocol == true) return;   //если вебсокеты отключены
        $this->_db->setQuery(
                    "SELECT `quotes`.`bid`"
                    . " ,`quotes`.`create_date` as date,`stock`.`title` FROM `quotes` "
                    . " LEFT JOIN `stock` ON `stock`.`id` = `quotes`.`type`"
                    . " ORDER BY `quotes`.`create_date` DESC"
                    . " LIMIT 10"
                );
        
        return $this->_db->loadObjectList();
    }
    
    protected function page() {
        $needlogged = array("historygames");

        if (isset($this->_path[0]) && in_array($this->_path[0], $needlogged) && !$this->_islogin) {
            redirect("/signin/");
        }
        
        if(!empty($this->_path['0'])){
            $this->_controller = str_replace('-', '_', $this->_path['0']);
            if (!empty($this->_path['1'])) {
                $this->_action = str_replace('-', '_', $this->_path['1']);
            } else {
                $this->_action = 'index';
            }
        } else {
            $this->_action = 'index';
            $this->_controller = 'index';
        }
        
        xload('class.lib.model');
        
        if (file_exists(XPATH_SOURCES . DS . 'Controllers' .  DS . $this->_controller . 'Controller.php')) {
            
            $objName = $this->_controller . 'Controller';
            
            require_once XPATH_SOURCES . DS . 'Controllers' .  DS . $this->_controller . 'Controller.php';
            $actName = $this->_action . 'Action';
            
            if (method_exists($objName,$actName)) {
                
                $this->controller = new $objName($this);
                ob_start();
                    $this->controller->$actName();
                    unset($this->controller);
                    $this->maincontent = ob_get_contents();
                ob_end_clean();
                
                //die($this->maincontent);
                return;
            } 
        } 
        
        $this->_controller = 'error';
        $this->_action = 'index';
        
        require_once XPATH_SOURCES . DS .'Controllers'. DS . 'errorController.php';
        $this->controller = new errorController($this);
        ob_start();
            $this->controller->indexAction();
            unset($this->controller);
            $this->maincontent = ob_get_contents();
        ob_end_clean();
        
    }
    
    public function disableTemplate(){
        $this->_template = '';
    }
    
    function output() {
        if ($this->_controller == 'error') {
            header('HTTP/1.0 404 Not Found');
        }
        
        if ($this->_template === '') {
            echo $this->maincontent;
        } elseif (!empty($this->_template)) {
            include(XPATH_TEMPLATE_FRONT . DS . 'templates' . DS . $this->_template . '.php');
        } else {            
            include(XPATH_TEMPLATE_FRONT . DS . 'templates' . DS . 'template.php');
        }
    }
    
    public function setDescription($description) {
        $this->_description = strip_tags($description);
    }
    
    public function setKeywords($keywords) {
        $this->_keywords = strip_tags($keywords);
    }
    
    function showPathway() {
        if (count($this->_pathway)) {
            echo "<div class=\"pathway\">";
            $delimiter = isset($this->pathdelimiter) ? $this->pathdelimiter : " >> ";
            foreach ($this->_pathway as $pathelement) {
                $elements[] = "<a href=\"".$pathelement[1]."\">".$pathelement[0]."</a>";
            }
            echo implode($delimiter, $elements);
            echo "</div>";
        }
    }
    
    public function setTemplate($template, $flag = false){
        $this->_template = $template;
        
        if ($flag == true) {
            $this->_title = null;
            $this->_scripts = array();
            $this->_stylesheet = array();
        }
    }
    
    public function setTitle($title) {
        if (!empty($this->_title))
            $this->_title = strip_tags($title) . " - " . $this->_title;
        else
            $this->_title = strip_tags($title);
    }
    
    public function header() {
        echo "<title>" . $this->_title . "</title>\n"
             . ($this->_description != null ? "<meta name=\"description\" content=\"" . $this->_description . "\" />\n" : "")
             . ($this->_keywords != null ? "<meta name=\"keywords\" content=\"" . $this->_keywords . "\" />\n" : "")
             ;
        
        if (is_array($this->_head) && count($this->_head)) echo implode("\n", $this->_head)."\n";
    }
    
    protected function setConfig() {
        include(XPATH_SOURCES . DS . 'configs' .DS. 'config.php');
        foreach($config as $k => $v) {
            $this->config->$k = $v;
        }
    }
    
    protected function setDB() {
        xload('class.lib.database');
        $this->_db = new database($this->config->host, $this->config->user, $this->config->pass, $this->config->db, $this->config->prefix);
    }

    public function add_to_history($user_id = null, $type = null, $action = null, $value = null) {
        $history->user_id = (int)$user_id;
        if (!empty($type))
            $history->type = $type;
        
        if (!empty($action))
            $history->action = $action;
        
        if (!empty($value))
            $history->value = $value;
        
        $history->ip          = $_SERVER["REMOTE_ADDR"];
        $history->user_agent  = $_SERVER["HTTP_USER_AGENT"];
        $refcookiename = "999be3440691882c7227dfad792c7833";//md5("refcookiename-keygames");
        $history->cookie      = $_COOKIE[$refcookiename];
        $history->date        = date("Y-m-d H:i:s");
        if ($this->_db->insertObject("history", $history))
            return true;
        
        return false;
    }
    
    protected function parsePath() {
        $REQUEST_URI = $_SERVER["REQUEST_URI"];

        if (!empty($_SERVER['QUERY_STRING']))
            $REQUEST_URI = str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER["REQUEST_URI"]);

        $path = explode('/', strtolower($REQUEST_URI));
        array_shift($path);

        if (substr($REQUEST_URI, -1) != '/' && 'GET' == $_SERVER['REQUEST_METHOD']) {
            $filename = $path[count($path)-1];

            if (!preg_match("/^.+\..{2,5}$/", $filename)) {
                @header('HTTP/1.1 301 Moved Permanently');
                //@header('Location: ' . $REQUEST_URI . '/' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
                redirect($REQUEST_URI . '/' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
                die();
            }
        }

        if (empty($path[count($path)-1]))
            array_pop($path);

        if (in_array($path[0], $this->config->available_languages)) {
            $this->_lang = $path[0];
            array_shift($path);
        } elseif (!isset($_COOKIE['lang'])) {
            //$this->_lang = self::getLangByIP();
            $this->_lang = $this->config->defaultlang;
        } else {
            $this->_lang = $_COOKIE['lang'];
        }
        setcookie('lang', $this->_lang, 0, '/');
        
        $this->_path = $path;
    }
    
    //если язык не был указан то узнаем язык по АйПи пользователя
    protected function getLangByIP(){
        $this->_ip = $_SERVER["REMOTE_ADDR"];
        $int = self::ip2int($this->_ip);
        
        $country_id = 0;
        
        $query = "SELECT * FROM (SELECT * FROM net_euro WHERE begin_ip <= $int ORDER BY begin_ip DESC LIMIT 1) AS t WHERE end_ip >= $int";
        $this->_db->setQuery($query);
        $country_id = $this->_db->loadResult();
        
        if (empty($country_id)) {
            $query = "SELECT country_id FROM (SELECT * FROM net_country_ip WHERE begin_ip <= $int ORDER BY begin_ip DESC LIMIT 1) AS t WHERE end_ip >= $int";
            $this->_db->setQuery($query);
            $country_id  = $this->_db->loadResult();
        }
        
        $query = "SELECT lang FROM net_country WHERE id = '" . $country_id . "' LIMIT 1";
        $this->_db->setQuery($query);
        $lang = $this->_db->loadResult();
        
        if (empty($lang)) {
            $lang = $this->config->defaultlang;
        }
        
        return $lang;
    }
    
    //переводим АйПи в числовое представление для поиска по базе
    private function ip2int($ip){
        $part = explode(".", $ip);
        $int = 0;
        if (count($part) == 4) {
            $int = $part[3] + 256 * ($part[2] + 256 * ($part[1] + 256 * $part[0]));
        }
        return $int;
    }
    
     protected function setLang() {
        switch ($this->_lang) {
            case 'ar': $territory = 'EG'; break;
            case 'hi': $territory = 'IN'; break;
            default: $territory = strtoupper($this->_lang);
        }

        setlocale(LC_MESSAGES, $this->_lang . '_' . $territory . '.UTF-8');
        putenv("LC_MESSAGES=".$this->_lang . '_' . $territory . '.UTF-8');
        bindtextdomain('messages', XPATH_TEMPLATE_FRONT . DS . 'locale' . DS);
        bind_textdomain_codeset('messages', 'UTF-8');
    }
    
    function islogin() {
        return $this->_islogin;
    }

    function module($name='') {
        if (!empty($name) && file_exists(XPATH_TEMPLATE_FRONT . DS . 'modules' .  DS . $name . '.php')) {
            require_once(XPATH_TEMPLATE_FRONT .DS. 'modules' .  DS . $name . '.php');
        } elseif(!empty($name) && file_exists(XPATH_TEMPLATE .DS. 'modules' .  DS . $name . '.php')){
            require_once(XPATH_TEMPLATE . DS . 'modules' .  DS . $name . '.php');
        }
    }

    function addHeadTag($tag) {
        $this->_head[] = $tag;
    }
    
    public function js() {
        $links = null;
        foreach($this->_scripts as $key => $item) {
            if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $item . '.js')) {
                if ($this->_jsparams[$key] == null) {
                    $links .= '<script src="/html/js/' . $item . '.js" type="text/javascript" /></script>';
                } else {
                    $links .= '<script src="/html/js/' . $item . '.js?' . $this->_jsparams[$key] . '" type="text/javascript" /></script>';
                }
            }
        }
        return $links;
    }
    
    public function addJS($jsfile, $jsparam = null) {
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $jsfile . '.js')) {
            array_push($this->_scripts, $jsfile);
            array_push($this->_jsparams, $jsparam);
        }
        return $this;
    }
    
    public function preAddJS($jsfile, $jsparam = null) {
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $jsfile . '.js')) {
            array_unshift($this->_scripts, $jsfile);
            array_unshift($this->_jsparams, $jsparam);
        }
        return $this;
    }
    
    public function addCSS($name,$version=null) {
        
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $name . '.css')) {
            
            //array_push($this->_stylesheet, $name);
            array_push($this->_stylesheet, $name);
            array_push($this->_cssparams, $version);
            
        }
        return $this;
    }

    public function preAddCSS($name, $version=null){
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $name . '.css')) {
            array_unshift($this->_stylesheet, $name);
            array_unshift($this->_cssparams, $version);
        }
        return $this;
    }
    
    //�?зменить что бы само определяло с какой папки тянуть ЦССК�?
    public function css($flag = false){
        $links = null;
        $data = null;
        //если нужно просто вывести добавленные файлы
        if ($flag == false) {
            foreach($this->_stylesheet as $key=>$file) {
                if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $file . '.css')) {
                    $links .= '<link href="/html/css/' . $file . '.css'. ($this->_cssparams[$key] ? '?'.$this->_cssparams[$key] :''). '" rel="stylesheet" type="text/css" />';
                }
            }
            return $links;
        //если нужно обьеденить и ужать в один файл выбранные файлы
        } else {
            if(!file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS .$this->_controller.DS.$this->_action.'.css')){
                foreach($this->_stylesheet as $file){
                    if (file_exists(XPATH_TEMPLATE_FRONT . '/css/' . $file . '.css')) {
                        $content = file_get_contents(XPATH_TEMPLATE_FRONT . '/css/' . $file . '.css');
                    }
                    //начинаем парсить контент и уберать лишнее
                    $start = strlen($content);
                    
                    $data .= $content;
                    
                    $end = strlen($content);
                }
                
                if(!is_dir(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller)) {
                    mkdir(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller, 0700);
                }
                file_put_contents(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller . DS . $this->_action . '.css', $data);
            }
            
            $links = '<link href="/html/css/' . $this->_controller . '/' . $this->_action . '.css" rel="stylesheet" type="text/css" />';
            return $links;
            
        }
    }
}
?>