<?php
class logoutController extends Model {
    public function init(){
        $this->disableTemplate();
        $this->disableView();
    }
    public function indexAction(){
        $this->m->_auth->logout();
        
        /*$server_url = $this->m->config->auth_server.'?action=disconnectDevice&MAC='.$this->m->mac.'&SN='.$this->m->sn.'&sid='.$this->m->session_id;
        
        $ch = curl_init($server_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        $result = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        $result = json_decode($result);
        
        if($result->status == 1){
            unset($_SESSION['session_id']);
            unset($_SESSION['mac']);
            unset($_SESSION['sn']);
        }
        */
        
        redirect('/');
    }
}
?>