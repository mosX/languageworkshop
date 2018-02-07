<?php
    class feedbackController extends Model {
        public function init(){

        }
        
        public function indexAction(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = json_decode(file_get_contents('php://input'), true);
                $this->disableTemplate();
                $this->disableView();          
                
                $this->validation = true;
                $row->name = trim($_POST['name']);
                $row->phone = trim($_POST['phone']);
                $row->date = date('Y-m-d H:i:s');
                
                if(!$row->name){
                    $this->error->name = "Вы должны ввести имя";
                    $this->validation = false;
                }
                
                if(!$row->phone){
                    $this->error->phone = "Вы должны ввести телефон для контакта с Вами.";
                    $this->validation = false;
                }
                
                if(!$this->validation){
                    $json->status = 'error';
                    $json->error = $this->error;
                    echo json_encode($json);
                    return false;
                }
                
                if($this->m->_db->insertObject('feedback',$row)){
                    echo '{"status":"success"}';
                }else{
                    echo '{"status":"error"}';
                }
            }
        }
    }
?>