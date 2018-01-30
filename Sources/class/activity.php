<?php
class Activity{
    protected $m;
    protected $_table = 'visitors';    
    
    public function __construct(mainframe & $mainframe){
        $this->m =  $mainframe;
    }
    
    public function addActivity(){
        $this->getID();
        
        $row->visitor_id = $this->visitorID;
        $row->user_id = $this->m->_user->id;
        $row->page = $_SERVER['REDIRECT_URL'];
        $row->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $row->ip = $_SERVER['REMOTE_ADDR'];
        $row->referer = $_SERVER['HTTP_REFERER'];
        $row->date = date('Y-m-d H:i:s');
        
        if($this->m->_db->insertObject('visitors_activity',$row)) $this->id = $this->m->_db->insertid();
    }
    
    public function addGoal($goal){
        $row->visitor_id = $this->m->activity->visitorID;
        $row->activity_id = $this->m->activity->id;
        $row->goal = $goal;
        $row->date = date('Y-m-d H:i:s');
        $this->m->_db->insertObject('goals',$row);
    }
    
    public function addVisitor($uid = null){
        
        $date = date('Y-m-d H:i:s');
        $row->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $row->ip = $_SERVER['REMOTE_ADDR'];
        $row->date = $date;
        $row->activity = $date;
        
        $this->visitorUID = $row->uid = md5($row->ip.$row->user_agent.(time()));
        
        $this->visitorID = $this->m->_db->insertObject($this->_table,$row);
        $this->addActivity($this->visitorID);   
        
        if($this->id){
            setcookie("advuid", $row->uid , mktime(date('H'),date('i'),date('s'),'12','20','2030'),'/',null);
        }
        
        return $row->uid;
    }
    
    public function getID(){
        
        $this->m->_db->setQuery(
                    "SELECT `".$this->_table."`.`id` "
                    . " FROM `".$this->_table."` "
                    . " WHERE `".$this->_table."`.`uid` = '".$this->visitorUID."'"
                    . " LIMIT 1"
                );
        $this->visitorID = $this->m->_db->loadResult();
        
        if(!$this->visitorID) $this->addVisitor();
    }
    
    public function updActivity($uid){
        $this->m->_db->setQuery(
                    "UPDATE `".$this->_table."` "
                    . " SET `".$this->_table."`.`activity` = '".date('Y-m-d H:i:s')."'"
                    . " WHERE `".$this->_table."`.`uid` = '".$uid."'"
                    . " LIMIT 1"
                );
        $this->m->_db->query();
        
    }
}
?>