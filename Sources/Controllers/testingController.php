<?php
    class testingController extends Model {
        public function init(){

        }
        
        public function indexAction(){
            $lesson_id = (int)$_GET['lesson_id'];
            //получаем урок
            $this->m->_db->setQuery(
                        "SELECT `lessons`.* "
                        . " FROM `lessons` "
                        . " WHERE `lessons`.`id` = ".$lesson_id
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
                        . " ORDER BY RAND()"
                    );
            $data = $this->m->_db->loadObjectList('question_id');
            
            foreach($data as $item)$ids[] = $item->question_id;
            
            //получаем ответы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.* "
                        . " , `answers`.`text`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id`"
                        . " WHERE `answer_collections`.`question_id` IN (".  implode(',', $ids).")"
                        . " ORDER BY RAND()"
                    );
            $this->m->answers = $this->m->_db->loadObjectList();
            //p($this->m->answers);
            
            foreach($this->m->answers as $item){
                $data[$item->question_id]->answers[] = $item;
            }
            
            foreach($data as $item){    //что бы индексы были по порядку
                $this->m->data[] = $item;
            }            
        }
        
        /*public function resultsAction(){
            $this->m->_db->setQuery(
                        "SELECT `testing_results`.* "
                        . " , `lessons`.`name`"
                        . " FROM `testing_results`"
                        . " LEFT JOIN `lessons` ON `lessons`.`id` = `testing_results`.`lesson_id`"
                        . " WHERE `testing_results`.`id` = 14"
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($result);
            $result->results = unserialize($result->results);
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `question_collections`.* "
                        . " , `questions`.`value`"
                        . " , `questions`.`correct`"
                        . " FROM `question_collections`"
                        . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                        . " WHERE `question_collections`.`lesson_id` = ".(int)$result->lesson_id
                    );
            $data = $this->m->_db->loadObjectList('question_id');
            foreach($data as $item)$ids[] = $item->question_id;
            
            //получаем ответы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.* "
                        . " , `answers`.`text`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id`"
                        . " WHERE `answer_collections`.`question_id` IN (".  implode(',', $ids).")"
                    );
            $answers = $this->m->_db->loadObjectList();
            
            foreach($answers as $item){
                if($item->id == $result->results[$item->question_id]){
                     $item->selected = 'true';
                }
                
                if($data[$item->question_id]->correct == $item->id){
                    $item->correct = 'true';
                }
                
                
                $data[$item->question_id]->answers[] = $item;                                
            }
            $this->m->data = json_encode($data);
            
            //$this->m->testing = $data;
        }*/
        
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
        
        public function getResults($id){
             $this->m->_db->setQuery(
                        "SELECT `testing_results`.* "
                        . " , `lessons`.`name`"
                        . " FROM `testing_results`"
                        . " LEFT JOIN `lessons` ON `lessons`.`id` = `testing_results`.`lesson_id`"
                        . " WHERE `testing_results`.`id` = ".$id
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($result);
            $result->results = unserialize($result->results);
            
            //получаем вопросы
            $this->m->_db->setQuery(
                        "SELECT `question_collections`.* "
                        . " , `questions`.`value`"
                        . " , `questions`.`correct`"
                        . " FROM `question_collections`"
                        . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                        . " WHERE `question_collections`.`lesson_id` = ".(int)$result->lesson_id
                    );
            $data = $this->m->_db->loadObjectList('question_id');
            foreach($data as $item)$ids[] = $item->question_id;
            
            //получаем ответы
            $this->m->_db->setQuery(
                        "SELECT `answer_collections`.* "
                        . " , `answers`.`text`"
                        . " FROM `answer_collections` "
                        . " LEFT JOIN `answers` ON `answers`.`id` = `answer_collections`.`answer_id`"
                        . " WHERE `answer_collections`.`question_id` IN (".  implode(',', $ids).")"
                    );
            $answers = $this->m->_db->loadObjectList();
            
            foreach($answers as $item){
                if($result->results[$item->question_id]['answer']){ //новый вариант со временем
                    if($item->id == $result->results[$item->question_id]['answer']){
                         $item->selected = 'true';
                    }                    
                }else{  //для старого варианта
                    if($item->id == $result->results[$item->question_id]){
                         $item->selected = 'true';
                    }    
                }
                
                if($data[$item->question_id]->correct == $item->id){
                    $item->correct = 'true';
                }
                
                $data[$item->question_id]->answers[] = $item;                                
            }
            //$this->m->data = json_encode($data);
            return $data;
            //$this->m->testing = $data;
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
                $lesson_id = (int)$_POST['lesson_id'];
                $username = strip_tags(trim($_POST['username']));
                if(!$username){
                    echo '{"status":"error","message":"Вы не ввели ваше имя"}';
                    return;
                }
                
                //получаем данный вопрос что бы знать условия
                $this->m->_db->setQuery(
                            "SELECT `lessons`.* "
                            . " FROM `lessons` "
                            . " WHERE `lessons`.`id` = ".$lesson_id
                            . " AND `lessons`.`status` = 1"
                        );
                $this->m->_db->loadObject($lesson);
                
                $terms = unserialize($lesson->terms);
                
                //получаем все вопросы по данному уроку
                $this->m->_db->setQuery(
                            "SELECT `question_collections`.* "
                            . " , `questions`.`value`"
                            . " , `questions`.`correct`"
                            . " , `questions`.`score`"
                            . " FROM `question_collections` "
                            . " LEFT JOIN `questions` ON `questions`.`id` = `question_collections`.`question_id`"
                            . " WHERE `question_collections`.`lesson_id` = ".$lesson_id
                            
                        );
                $questions = $this->m->_db->loadObjectList();
                
                $corrects = 0;
                $score = 0;
                
                foreach($questions as $item){
                    if($results[$item->question_id]['answer']){
                        if($results[$item->question_id]['answer'] == $item->correct){
                            $corrects++;
                            $score += $item->score;                        
                        }
                    }else{
                        if($results[$item->question_id] == $item->correct){
                            $corrects++;
                            $score += $item->score;                        
                        }
                    }
                }
                
                $message = '';
                
                if($terms){
                    foreach($terms as $item){
                        if($score >= $item['from'] && $score <= $item['to']){
                            $message = $item['text'];
                            break;
                        }
                    }
                }
                

                $row->lesson_id = $lesson_id;
                $row->hash = $this->generateHash(); //нужно сгенерировать уникальный ключ и записать данные в базу
                $row->score = $score;
                $row->date = date("Y-m-d H:i:s");
                $row->username = $username;
                $row->results = serialize($results);
                if($this->m->_db->insertObject('testing_results',$row,'id')){
                    
                    if($lesson->show_answers){
                        
                        $results_json = $this->getResults($row->id);
                    }
                    
                    $json->status = 'success';
                    $json->score = $score;
                    $json->hash = $row->hash;
                    $json->message = $message;
                    if($results_json) $json->results = $results_json;
                    
                    echo json_encode($json);
                    //echo '{"status":"success","score":"'.$score.'","hash":"'.$row->hash.'","message":"'.$message.'"}';
                }else{
                    echo '{"status":"error"}';
                }
            }
        }
    }
?>