<style>    
    #header{
        border-bottom:1px solid #8b8d90;
    }
    #header .topmenu{
        height:62px;
        width:100%;
        background: url('/html/images/header_bg.jpg') no-repeat center center;;
        background-size: cover;
    }
    #header .head{
        height:68px;
        width:100%;
        background: white;
        
    }
    #header .navbar-header{
        width:255px;
        height: 100%;
    }
    #header .navbar-brand{
        padding:0px;
        height: 100%;
        padding-top:5px;
    }
    
    #header .navbar-nav{
        height: 100%;
        font-size: 18px;
    }
    
    #header .topmenu .navbar-nav > li > a{
        /*padding:20px 20px;*/
        height: 100%;
    }
    #header .head .navbar-nav > li > a{
        padding:23px 24px;
        height: 100%;
    }
    #header .topmenu .navbar-nav > li > a{
        color: white;
    }
    #header .topmenu .navbar-nav > li > a:hover{
        background:transparent;            
    }
    
    #header .head .navbar-nav > li > a:hover{
        background:transparent;            
    }
    #header .head .navbar-nav > li > a{
        color: black;
    }
    #header .navbar-nav{
        height: 36px;
        margin-top:15px;
        vertical-align: middle;
            
    }
    #header .topmenu .navbar-nav a,#header .head .navbar-nav li a{
        padding:8px 20px;        
    }
    #header .topmenu .navbar-nav a:active,#header .head .navbar-nav li a:active{
        background: transparent;
    }
    #header .topmenu .navbar-nav a:focus,#header .head .navbar-nav li a:focus{
        background: transparent;
    }
    #header .head .navbar-nav.navbar-right li a{
        padding-left:0px;
        padding-right:0px;
    }
    #header .head .navbar-nav.navbar-right li{
        margin-right: 25px;
    }
    #header .head .navbar-nav.navbar-right li:last-child{
        margin:0px;
    }
    #header .wallet_ico{
        width:30px;
        height: 22px;
        background: url('/html/images/wallet.png');
        display:inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }
</style>

<div id="header">
    <div class="topmenu">
        <div class="container">
            <div class="navbar-header">&nbsp;</div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">ОБЗОР РЫНКА</a></li>
                    <li><a href="#">ПАРТНЕРСТВО</a></li>
                    <li><a href="#">ПОДДЕРЖКА</a></li>
                    <li><a href="#">НОВОСТИ</a></li>
                </ul>
                <style>
                    
                    #header .topmenu .navbar-nav li a.language{
                        text-align: center;
                        height: 36px;
                        padding:0px;                        
                    }
                    #header .topmenu .navbar-nav li a.language .lang{
                        border-radius: 14px;
                        height: 100%;
                        width:50px;
                        padding-top:6px;                        
                        border: 2px solid #fbb914;
                        display:inline-block;
                        vertical-align: middle;
                    }
                </style>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a  data-toggle="dropdown" aria-haspopup="true"  class='language' href="#">
                            <div class="lang">RU</div>
                            <div class="caret"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/ru/">Русский</a>
                            <a class="dropdown-item" href="/en/">Английский</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="head">                
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/html/images/logo.png"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php if($this->_user->id){ ?>
                        <li class="active"><a href="/trade/">ТОРГИ</a></li>
                        <li><a href="/account/change/">ОБМЕН</a></li>
                        <li><a href="/account/cabinet/">КОШЕЛЕК</a></li>
                    <?php }else{ ?>
                        <li class="active"><a href="/registration/">ОТКРЫТЬ СЧЕТ</a></li>
                        <li><a href="#">ОБУЧЕНИЕ</a></li>
                        <li><a href="/help/payments/">ПОПОЛНЕНИЕ И ВЫВОД</a></li>
                        <li><a href="#">ОТЗЫВЫ</a></li>
                    <?php } ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if($this->_user->id){ ?>
                        <li><a href=""><div class="wallet_ico"></div>(0BTC)<div class="caret dark"></div></a></li>
                        <style>
                            .dropdown-menu{
                                border: 1px solid #8b8d90;
                                padding: 12px 20px;
                                width:260px;
                                top:53px;
                            }
                            .dropdown-menu .dropdown-item{
                                text-decoration: none;
                                border-bottom: 1px solid #d6d3ca;
                                text-align: center;
                                font-size:16px;
                                color: black;
                                display:block;
                                height: 38px;
                            }
                            .dropdown-menu .dropdown-item.active,.dropdown-menu .dropdown-item:hover{
                                color:#fbb914;
                                
                            }
                        </style>
                        <li>
                            <a data-toggle="dropdown" aria-haspopup="true" href="/"><?=$this->_user->email?><div class="caret dark"></div></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/account/verification/">Верификация</a>
                                <a class="dropdown-item" href="#">Личные сообщения</a>
                                <a class="dropdown-item" href="/account/affiliate/">Реферальная программа</a>
                                <a class="dropdown-item" href="/account/settings/">Настройка</a>
                                <a class="dropdown-item" href="/logout/">Выйти</a>
                            </div>
                        </li>
                        
                    <?php }else{ ?>
                        <li><a href="/login/">ВХОД</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>        
    </div>
</div>