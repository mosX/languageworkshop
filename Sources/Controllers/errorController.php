<?php
class errorController extends Model {
        public function init(){
            
        }
        public function indexAction(){
            $this->m->_template = 'error';
        }
}
?>