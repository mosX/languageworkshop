<style>
    #header{
        height:140px;
        padding:30px 0px;
    }
    #header .navbar-brand{
        margin-right: 30px;
    }
    #header .navbar-brand img{
        width:180px;
    }
    #header .navbar-nav{
        margin-top:20px;
    }
    #header .navbar-nav li{
        vertical-align: middle;
    }
    #header .contacts_info svg{
        width:20px;
        height:20px;
        display:inline-block;
        vertical-align: middle;
    }
    #header .contacts_info{
        margin-right: 20px;
    }
    #header .contacts_info span{
        display:block;
        margin-top:-3px;
        padding-left:30px;
    }
    
    #header .navbar-nav a{
        display:block;
        height:100%;
        width:100%;            
        font-size: 16px;;
        font-weight:bold;
        padding:0px;
        padding-top:10px;
        padding-bottom:10px;
        border-bottom: 2px solid transparent;
        color: #222;        
    }
    #header .navbar-nav li{
        margin-right:25px;
    }
    #header .navbar-nav li:last-child{
        margin-right: 0px;
    }
    
    #header .navbar-nav li:hover a,#header .navbar-nav li.active a{
        border-bottom: 2px solid #fab80f;        
    }
    #header .navbar-nav a:focus,#header .navbar-nav a:hover,#header .navbar-nav a.active{
        background:none;
    }
</style>

<div id="header">
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
                <li class='<?=$this->_controller == 'index' ? 'active':''?>'><a href='/'>ГОЛОВНА</a></li>
                <li class='<?=$this->_controller == 'about' ? 'active':''?>'><a href='/about/'>ПРО ВИКЛАДАЧА</a></li>
                <!--<li class=''><a href=''>ВИЗНАЧИТИ СВІЙ РІВЕНЬ</a></li>-->
                <li class='<?=$this->_controller == 'contacts' ? 'active':''?>'><a href='/contacts/'>КОНТАКТИ</a></li>
            </ul>
                
            <ul class="nav navbar-nav navbar-right">
                <li class='contacts_info'>
                    <div>
                        <svg viewBox="0 0 50 50"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/images/115.svg#icon"></use></svg>
                        <strong>+ 38 (098) 092 07 92</strong>
                    </div>
                    <span>пн- пт  с 9.00 до 18. 00 </span>
                </li>
                <!--<li>
                    <a href="" class="btn btn-primary">Перезвонить мне</a>
                </li>-->
            </ul>
        </div>
    </div>
</div>
