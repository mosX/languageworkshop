<?php
    $mailsubject  = "=?UTF-8?B?" . base64_encode("Запрос для связи с менеджером") ."?=";
    $mailbody_html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>' . sprintf(_("%s NEWSLETTER"), $this->m->config->sitename) . '</title>
    </head>
    <body>
            <div>ID : '.$this->m->_user->id.'</div>
            <div>Email : '.$this->m->_user->email.'</div>
            <div>Firstname : '.$this->m->_user->firstname.'</div>
            <div>Lastname : '.$this->m->_user->lastname.'</div>
            <div>Phone : '.$this->m->_user->phone.'</div>
    </body>
    </html>';
    $mailbody_txt =  "ID : " .$this->m->_user->id. ".\n\n"
                    . "Email : ".$this->m->_user->email.".\n\n"
                    . "Firstname : ".$this->m->_user->firstname. ".\n\n"
                    . "Lastname : ".$this->m->_user->lastname. ".\n\n"
                    . "Phone : ".$this->m->_user->phone. ".\n\n"
                ;
?>