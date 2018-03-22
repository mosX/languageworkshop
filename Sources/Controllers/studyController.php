<?php
    class studyController extends Model {
        public function init(){

        }
        
        public function indexAction(){
            
        }
        
        public function lesson1Action(){
            
        }
        
        public function checkLesson($lesson_id){
            $this->m->_db->setQuery(
                        "SELECT `lessons`.* "
                        . " FROM `lessons` "
                        . " WHERE `lessons`.`id` = ".$lesson_id
                    );
            $this->m->_db->loadObject($lesson);
            
            return $lesson;
        }
        
        public function restoreQuestion($session){
            $this->m->_db->setQuery(
                        "SELECT `questions`.* "                        
                        . " FROM `questions`"
                        . " WHERE `questions`.`id` = ".$session->current->question_id
                        . " AND `questions`.`status` = 1"
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($question);
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.`id` as collection_id "
                        . " , `answers`.*"
                        . " , `images`.`filename`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id` "
                        . " LEFT JOIN `images` ON `images`.`id` = `answers`.`image_id`"
                        . " WHERE `answer_collections`.`question_id` = ".$question->id                        
                    );
            $answers = $this->m->_db->loadObjectList();
            $question->answers = $answers;
            
            return $question;
        }
        
        public function getRandomQuestion($lesson_id,$exceptions = null){
            $this->m->_db->setQuery(
                        "SELECT `question_collections`.`question_id` "
                        . ", `questions`.*"
                        . " FROM `question_collections`"
                        . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                        . " WHERE `question_collections`.`lesson_id` = ".$lesson_id                        
                        . " AND `questions`.`status` = 1"
                        . " AND `question_collections`.`published` = 1"
                        . ($exceptions ?  " AND `question_collections`.`question_id` NOT IN (".implode(',',$exceptions).")": "")
                        . " ORDER BY RAND() LIMIT 1"
                    );
            $this->m->_db->loadObject($question);
            
            if(!$question) return false;
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.`id` as collection_id "
                        . " , `answers`.*"
                        . " , `images`.`filename`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id` "
                        . " LEFT JOIN `images` ON `images`.`id` = `answers`.`image_id`"
                        . " WHERE `answer_collections`.`question_id` = ".$question->id
                        . " ORDER BY RAND()"
                    );
            $answers = $this->m->_db->loadObjectList();
            $question->answers = $answers;
            
            return $question;
        }
        
        public function checkActiveSession($lesson_id){
            //проверяем или есть активная сессия за последение 5 минуит
            $this->m->_db->setQuery(
                        "SELECT `sessions`.* "
                        . " FROM `sessions`"
                        . " WHERE `sessions`.`upd_date` > '".date("Y-m-d H:i:s",time()-600)."'"
                        . " AND `sessions`.`lesson_id` = ".$lesson_id
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($session);
            
            return $session;
        }
        
        public function addNewSession($question,$lesson_id){
            $obj->history = array();
            $obj->session = new stdClass();
            $obj->current = new stdClass();
            $obj->current->question_id = $question->id;
            $obj->current->correct = $question->correct;
            
            if($question->answers){
                foreach($question->answers as $item){
                    $obj->current->answers[] = ['id'=>$item->id,'link_id'=>$item->collection_id];
                }
            }
            
            //добавляем в сессию
            $row->lesson_id = $lesson_id;
            $row->value = serialize($obj);
            $row->status = 1;
            $row->date = date("Y-m-d H:i:s");
            $row->upd_date = date("Y-m-d H:i:s");
            if($this->m->_db->insertObject('sessions',$row,'id')){
                $question->session_id = $row->id;
                return true;                
            }else{
                return false;
            }
        }
        
        public function updateSession($session_id,$value=null){
            $this->m->_db->setQuery(
                        "UPDATE `sessions` SET `sessions`.`upd_date` = '".date("Y-m-d H:i:s")."'"
                        . ($value ? " , `sessions`.`value` = '".  serialize($value)."'" : "")
                        . " WHERE `sessions`.`id` = ".(int)$session_id
                        . " LIMIT 1"
                    );
            if($this->m->_db->query()){
                return true;
            }else{
                return false;
            }
        }
        
        public function startAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $lesson_id = (int)$_GET['lesson_id'];
            
            //проверяем наличие урока
            $lesson = $this->checkLesson($lesson_id);
            if(!$lesson) return;
            
            $session = $this->checkActiveSession($lesson_id);
            
            if($session){   //если есть сессия то получаем текущий вопрос по данной сессие
                $question = $this->restoreQuestion(unserialize($session->value));
                $this->updateSession($session->id);
                $question->session_id = $session->id;
                $question->result = unserialize($session->value)->current->result;
                $question->wrong = unserialize($session->value)->current->wrong;
                
                if($question->result === null){
                    unset($question->correct);
                }
            }else{
                $question = $this->getRandomQuestion($lesson->id);    
                $this->addNewSession($question,$lesson->id);
                unset($question->correct);    
            }
                
            echo json_encode($question);
            
            /*$json->session = {};
            $json->current = $question;*/
        }
        
        public function check_answerAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $answer_id = (int)$_GET['answer'];
            $session_id = (int)$_GET['session'];
            
            if(!$answer_id){
                echo '{"status":"error","message":"Вы не выбрали ответ"}';
                return;
            }
                        
            //получаем данную сессию
            $this->m->_db->setQuery(
                        "SELECT `sessions`.* "
                        . " FROM `sessions` "
                        . " WHERE `sessions`.`id` = ".$session_id
                        . " LIMIT 1"
                    );
            
            $this->m->_db->loadObject($data);
            
            if(!$data){
                echo '{"status":"error","message":"Нету такой сессии"}';
                return;
            }
            
            $session = unserialize($data->value);
            
            //проверяем или правильно ответил            
            if($session->current->result == null){
                if($session->current->correct == $answer_id){
                    $session->current->result = 'correct';
                }else{
                    
                    $session->current->wrong = $answer_id;
                    $session->current->result = 'wrong';
                }
            }
            
            $this->m->_db->setQuery(
                        "UPDATE `sessions` "
                        . " SET `sessions`.`value` = '".  serialize($session)."'"
                        . " WHERE `sessions`.`id` = ".$session_id
                        . " LIMIT 1"
                    );
            $this->m->_db->query();
            
            //var_dump($session->current->result);
            if($session->current->result == 'correct'){
                echo '{"status":"success","result":"correct"}';
            }else if($session->current->result == 'wrong'){
                echo '{"status":"success","result":"wrong","correct":"'.$session->current->correct.'","wrong":"'.$session->current->wrong.'"}';
            }
        }
        
        public function get_questionAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $lesson_id = (int)$_GET['lesson_id'];
            
            $lesson = $this->checkLesson($lesson_id);
            
            //получаем случайный вопрос
            $question = $this->getRandomQuestion($lesson->id);
            
            echo json_encode($question);
        }
        
        public function nextAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $session_id = (int)$_GET['session'];
            //получаем сессию и смотрим или текущий вопрос завершен
            $this->m->_db->setQuery(
                        "SELECT `sessions`.* "
                        . " FROM `sessions` "
                        . " WHERE `sessions`.`id` = ".$session_id
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($session);
            
            if(!$session){
                echo '{"status":"error"}';
                return;
            }
            
            $value = unserialize($session->value);
            
            if(!$value->current->result){    //если вопрос еще не выбран
                echo '{"status":"error"}';
                return false;
            }
            $value->history[] = $value->current;
            //получаем уже использованные вопросы
            foreach($value->history as $item)$ids[] = $item->question_id;
                
            //получаем опять рандомный вопрос данного урока
            $question = $this->getRandomQuestion($session->lesson_id,$ids); //который еще не участвовал
            if(!$question){
                $question = $this->getRandomQuestion($session->lesson_id);  //который уже участвовал
            }
            
            $value->current = new stdClass();
            $value->current->question_id = $question->id;
            $value->current->correct = $question->correct;
            
            unset($question->correct);
            
            if($question->answers){
                foreach($question->answers as $item){
                    $value->current->answers[] = ['id'=>$item->id,'link_id'=>$item->collection_id];
                }
            }
            
            if($this->updateSession($session_id,$value)){
                echo json_encode($question);
            }else{
                echo '{"status":"error"}';
            }
        }
    }
?>