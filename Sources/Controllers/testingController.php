<?php
    class testingController extends Model {
        public function init(){

        }
        
        public function indexAction(){            
            //получаем урок
            $this->m->_db->setQuery(
                        "SELECT `lessons`.* "
                        . " FROM `lessons` "
                        . " WHERE `lessons`.`id` = 1"
                    );
            $this->m->_db->loadObject($data);
            $this->m->lesson = $data;            
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `question_collections`.* "
                        . " , `questions`.`value`"
                        . " FROM `question_collections` "
                        . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                        . " WHERE `question_collections`.`lesson_id` = ".(int)$this->m->lesson->id
                    );
            $this->m->data = $this->m->_db->loadObjectList('question_id');
            
            foreach($this->m->data as $item)$ids[] = $item->question_id;
            
            //получаем ответы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.* "
                        . " , `answers`.`text`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id`"
                        . " WHERE `answer_collections`.`question_id` IN (".  implode(',', $ids).")"
                    );
            $this->m->answers = $this->m->_db->loadObjectList();
            //p($this->m->answers);
            
            foreach($this->m->answers as $item){
                $this->m->data[$item->question_id]->answers[] = $item;
            }
        }
        
        public function generateHash(){
            $hash = makeDigitPassword(8);
            
            $this->m->_db->setQuery(
                        "SELECT `testing_results`.`id` FROM `testing_results`"
                        . " WHERE `testing_results`.`hash` = '".$hash."'"
                        . " LIMIT 1"
                    );
            $check = $this->m->_db->loadResult();
            if($check) $this->generateHash();
            
            return $hash;
        }
        
        public function checkAction(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->disableTemplate();
                $this->disableView();
                $_POST = json_decode(file_get_contents('php://input'), true); 
                
                foreach($_POST['results'] as $key=>$item){
                    $ids[] = $key;
                }
                
                $results = $_POST['results'];
                //p($ids);
                
                //получаем все вопросы по данному уроку
                $this->m->_db->setQuery(
                            "SELECT `question_collections`.* "
                            . " , `questions`.`value`"
                            . " , `questions`.`correct`"
                            . " FROM `question_collections` "
                            . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                            . " WHERE `question_collections`.`lesson_id` = 1"
                            
                        );
                $questions = $this->m->_db->loadObjectList();
                
                $corrects = 0;
                foreach($questions as $item){                    
                    if($results[$item->question_id] == $item->correct) $corrects++;
                }
                
                if($corrects == 0) {
                    echo '{"status":"success","score":"0"}';
                    return;
                }
                
                $row->lesson_id = 1;
                $row->hash = $this->generateHash(); //нужно сгенерировать уникальный ключ и записать данные в базу
                $row->score = $corrects;
                $row->date = date("Y-m-d H:i:s");
                $row->results = serialize($results);
                if($this->m->_db->insertObject('testing_results',$row)){
                    echo '{"status":"success","score":"'.$corrects.'","hash":"'.$row->hash.'"}';
                }else{
                    echo '{"status":"error"}';
                }
            }
        }
    }
?>