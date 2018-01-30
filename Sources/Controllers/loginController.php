<?php

class loginController extends Model {

    public function init() {
        
    }

    public function indexAction(){
        $this->m->setTitle('Authorisation');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->disableTemplate();
            $this->disableView();
            
            if($this->m->_auth->ajaxLogin('/', $_POST['email'], $_POST['password'])){
                $json->status = 'success';
            }else{
                $json->status = 'error';
                $json->message = $this->m->_auth->error;
            }
            echo json_encode($json);
        }
    } 
}

?>