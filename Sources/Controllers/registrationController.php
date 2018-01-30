<?php
    class registrationController extends Model {
        public function init() {
          //$this->m->_template = 'registration';  
          $this->m->addJS('registration');
        }

        public function indexAction(){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->disableTemplate();
                $this->disableView();

                xload('class.registration');                
                $_POST = json_decode(file_get_contents('php://input'), true);
                
                $registration = new Registration($this->m);
                if($registration->registration()){
                    $json->status = 'success';
                    echo json_encode($json);
                    
                    $this->m->_auth->ajaxLogin('/', $_POST['email'], $_POST['password']);
                }else{
                    $json->status = 'error';
                    $json->message = $registration->error;
                    echo json_encode($json);
                }
            }
        }
    }
?>