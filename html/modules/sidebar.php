<style>
    #sidebar{
        font-size:14px;
        display:inline-block;
        width:270px;            
        margin-right:30px;            
    }
    #sidebar .menu_block{
        padding:26px 12px 16px 26px;
        background: white;
    }

    #sidebar ul{
        margin:0px;
        padding:0px;
        list-style: none;
    }
    #sidebar ul li{            
        height:30px;            
    }
    #sidebar ul li:last-child{
        margin-bottom: 0px;
    }
    #sidebar ul li a{
        display: block;
        padding-top:4px;
        width:100%;
        height:100%;
        color: #515050;
        font-size:16px;
        text-decoration: none;            
        padding-left:30px;
        position:relative;
    }
    #sidebar .logout{
        height:29px;
        background:white;
        margin-top:5px;
        text-align: center;
        display:block;
        color: #222222;
        font-size:14px;
        padding-top:5px;
        font-weight:bold;
    }

    #sidebar ul li.active a,#sidebar ul li:hover a{
        color: #64b5f6;            
    }


    #sidebar ul li span{
        display:block;                
        position:absolute;
        left:0px;
        top:7px;
        background: url('/html/images/sidebar_icons.png');            
    }

    #sidebar ul li span.ico1{
        width:15px;
        height:15px;
        background-position: 0px -19px;
    }
    #sidebar ul li.active span.ico1,#sidebar ul li:hover span.ico1{
        background-position: 0px 0px;
    }

    #sidebar ul li span.ico2{
        width:14px;
        height:14px;
        background-position: -18px -20px;
    }
    #sidebar ul li.active span.ico2,#sidebar ul li:hover span.ico2{
        background-position: -18px -1px;
    }

    #sidebar ul li span.ico3{
        width:18px;
        height:15px;
        background-position: -33px -20px;
    }
    #sidebar ul li.active span.ico3,#sidebar ul li:hover span.ico3{
        background-position: -33px -1px;
    }

    #sidebar ul li span.ico4{
        width:17px;
        height:16px;
        background-position: -52px -20px;
    }
    #sidebar ul li.active span.ico4,#sidebar ul li:hover span.ico4{
        background-position: -52px -1px;
    }

    #sidebar ul li span.ico5{
        width:17px;
        height:14px;
        background-position: -69px -20px;
    }
    #sidebar ul li.active span.ico5,#sidebar ul li:hover span.ico5{
        background-position: -69px -1px;
    }

    #sidebar ul li span.ico6{
        width:17px;
        height:13px;
        background-position: -87px -21px;
    }
    #sidebar ul li.active span.ico6,#sidebar ul li:hover span.ico6{
        background-position: -87px -2px;
    }

    #sidebar ul li span.ico7{
        width:15px;
        height:13px;
        background-position: -104px -21px;
    }
    #sidebar ul li.active span.ico7,#sidebar ul li:hover span.ico7{
        background-position: -104px -2px;
    }
</style>
<div id="sidebar">
    <div class="menu_block">
        <ul>
            <li class="<?=$this->_controller == 'account' ? 'active':''?>"><a href="/account/"><span class="ico1"></span>Профиль</a></li>
            <li class="<?=$this->_controller == 'tariffs' ? 'active':''?>"><a href="/tariffs/"><span class="ico2"></span>Тарифы</a></li>
            <li><a href=""><span class="ico3"></span>История</a></li>
            <li><a href=""><span class="ico4"></span>Закладки</a></li>
            <li><a href=""><span class="ico5"></span>Приобретенные фильмы</a></li>
            <li><a href=""><span class="ico6"></span>Родительский контроль</a></li>
            <li><a href=""><span class="ico7"></span>Устройства</a></li>
            
            <li class="<?=$this->_controller == 'player' ? 'active':''?>"><a href="/player/"><span class="ico7"></span>Плеер</a></li>
            <li class="<?=$this->_controller == 'program' ? 'active':''?>"><a href="/program/"><span class="ico7"></span>Програма</a></li>
            
            <?php foreach($this->templates as $item){ ?>
                <?php
                    switch($item->type){
                        case 1:$page = 'page1'; break;
                        case 2:$page = 'page2'; break;
                        case 3:$page = 'page3'; break;
                        case 4:$page = 'page4'; break;
                        case 5:$page = 'page5'; break;
                    }
                ?>
                <li class="<?=$this->_controller == 'templates' ? 'active':''?>"><a href="/templates/<?=$page?>"><span class="ico7"></span><?=$item->name?></a></li>    
            <?php } ?>
        </ul>
    </div>

    <a href="/logout/" class="logout">Выход</a>
</div>
