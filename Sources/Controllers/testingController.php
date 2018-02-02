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
            $this->m->data = $this->m->_db->loadObjectList('id');
            
            foreach($this->m->data as $item)$ids[] = $item->id;
            
            //получаем вопросы
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
    }
?>