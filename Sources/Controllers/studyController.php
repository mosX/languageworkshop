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
        
        public function getRandomQuestion($lesson_id){
            $this->m->_db->setQuery(
                        "SELECT `question_collections`.`question_id` "
                        . ", `questions`.*"
                        . " FROM `question_collections`"
                        . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                        . " WHERE `question_collections`.`lesson_id` = ".$lesson_id                        
                        . " AND `questions`.`status` = 1"
                        . " AND `question_collections`.`published` = 1"
                        . " ORDER BY RAND() LIMIT 1"
                    );
            $this->m->_db->loadObject($question);
            
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.`id` as collection_id "
                        . " , `answers`.*"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id` "
                        . " WHERE `answer_collections`.`question_id` = ".$question->id                        
                    );
            $answers = $this->m->_db->loadObjectList();
            $question->answers = $answers;
            
            return $question;
        }
        
        public function startAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $lesson_id = (int)$_GET['lesson_id'];
            
            //проверяем наличие урока
            $lesson = $this->checkLesson($lesson_id);
            if(!$lesson) return;
            
            $question = $this->getRandomQuestion($lesson->id);
            
            $json->session = new stdClass();
            $json->current = new stdClass();
            $json->current->question_id = $question->id;
            $json->current->correct = $question->correct;
            
            if($question->answers){
                foreach($question->answers as $item){
                    $json->current->answers[] = ['id'=>$item->id,'link_id'=>$item->collection_id];
                }
            }
            
            //добавляем в сессию
            $row->lesson_id = $lesson->id;
            $row->value = serialize($json);
            $row->status = 1;
            $row->date = date("Y-m-d H:i:s");
            if($this->m->_db->insertObject('',$row,'id')){
                $question->session_id = $row->id;
                echo json_encode($question);
            }else{
                echo '{"status":"error"}';
            }
            
            /*$json->session = {};
            $json->current = $question;*/
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
    }
?>