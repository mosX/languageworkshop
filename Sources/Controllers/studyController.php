<?php
    class studyController extends Model {
        public function init(){

        }
        
        public function indexAction(){
            
        }
        
        public function lesson1Action(){
            
        }
        
        public function get_questionAction(){
            $this->disableTemplate();
            $this->disableView();
            
            $lesson_id = (int)$_GET['lesson_id'];
            
            $this->m->_db->setQuery(
                        "SELECT `lessons`.* "
                        . " FROM `lessons` "
                        . " WHERE `lessons` = 1"                           
                    );
            $this->m->_db->loadObject($lesson);
            
            //получаем случайный вопрос
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
                        "SELECT `answer_collections`.`answer_id` "
                        . " , `answers`.*"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id` "
                        . " WHERE `answer_collections`.`question_id` = ".$question->id                        
                    );
            $answers = $this->m->_db->loadObjectList();
            $question->answers = $answers;
            
            echo json_encode($question);
        }
    }
?>