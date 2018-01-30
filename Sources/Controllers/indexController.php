<?php
    class indexController extends Model {
        public function init(){
//            if($this->m->_user->id) redirect('/account/');            
        }
        
        public function indexAction(){
            //p($this->m->_user);
            $this->m->addJS('app/chartsMain')->addJS('app/service')->addJS('app/charts')->addJS('app/quotes')->addJS('app/protocol');
        }
    }
?>