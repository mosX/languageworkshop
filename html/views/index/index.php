<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>


<style>       
   #bannerCarousel .item{
       height: 600px;       
   }
   #bannerCarousel .item:hover{
       text-decoration: none;
   }
   #bannerCarousel .content{
       width:1110px;
       margin:auto;
   }
   #bannerCarousel .title{
       width:700px;
        padding:20px 30px 20px 15px;
        /*background: rgba(77,105,190,0.65);*/
        background: rgba(0,0,0,0.4);
        border-radius: 10px;
        box-shadow: 0px 0px 40px rgba(100,100,100,0.5);
        font-size:36px;
        color: white;
        margin-bottom:20px;
        margin-top:100px;
        position:absolute;
        bottom:50px;
   }
   /*#bannerCarousel .item img{
       height:100%;
       margin:auto;
   }*/
   
   
</style>

<!--<div style='display:none'>
    <img src='/html/images/img1.jpg'>
    <img src='/html/images/img2.jpg'>
    <img src='/html/images/img3.jpg'>
</div>-->

<div id="bannerCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">            
        <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#bannerCarousel" data-slide-to="1" class=""></li>
        <li data-target="#bannerCarousel" data-slide-to="2" class=""></li>                
    </ol>

    <div class="carousel-inner">            
        <a href="" class="item active" style="background:url('/html/images/img2_1.jpg') no-repeat center center; background-size: cover">
            <div class='content'>
                <div class='title'>ІНДИВІДУАЛЬНІ ЗАНЯТТЯ</div>
            </div>
        </a>
        <a href="" class="item" style="background:url('/html/images/img3.jpg') no-repeat center center; background-size: cover">
            <div class='content'>
                <div class='title'>НАВЧАННЯ В НЕВЕЛИКИХ ГРУПАХ</div>
            </div>
        </a>
        <a href="" class="item" style="background:url('/html/images/img1.jpg') no-repeat center center; background-size: cover">
            <div class='content'>
                <div class='title'>ПІДГОТОВКА ДО ІСПИТІВ</div>
            </div>
        </a>
    </div>

    <a class="carousel-control left" href="#bannerCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="carousel-control right" href="#bannerCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>

<style>
    #block2{
        padding-top:30px;
        padding-bottom:20px;
        width:100%;
        height:auto;
        background: black url('/html/images/block2_bg.jpg') no-repeat center center;
        background-size: cover;
    }
    #block2 .item{
        margin:auto;
        text-align: left;
        margin-bottom: 30px;
        color: white;
    }
    
    #block2 .item .title{
        color: white;
        font-weight:bold;
        font-size: 18px;
        margin-bottom:10px;
    }
    #block2 .item .text{
        color: white;
        font-size: 14px;
        font-weight:normal;
    }
    #block2 .img_block{
        margin-top:35px;
        float:right;
        width:400px;
        height: 400px;
        background: url('/html/images/img5.jpg') no-repeat center center; 
        background-size:cover;
    }
</style>

<div id="block2">
    <div class='container'>        
        <div class="row">
            <div class="col-sm-7">
                <div class='item'>
                    <div class='title'>КОМУНІКАТИВНА МЕТОДИКА</div>

                    <div class='text'>
                        Комунікативна методика, як зрозуміло вже з її назви, спрямована саме на практику спілкування. Призначена для зняття страху перед спілкуванням.
                        Основною метою цієї методики є навчити студента спочатку вільно розмовляти англійською мовою , а потім думати нею.
                    </div>
                </div>

                <div class='item'>
                    <div class='title'>ІНТЕНСИВНЕ ВИВЧЕННЯ</div>
                    <div class='text'>
                        На початковому етапі вивчення іноземної мови інтенсивне навчання – це найкращий мотиватор!  
                        Сьогодні ви вмієте сказати, як вас звати, завтра – ви вже вмітимете говорити про свою родину / друзів, за тиждень – ви вже вмієте говорити про вихідні і відпустки. 
                    </div>  
                </div>

                <div class='item'>

                    <div class='title'>ІНДИВІДУАЛЬНИЙ ПІДХІД</div>
                    <div class='text'>Використання індивідуального підходу полягає в такій організації навчального процесу, при якому враховуються індивідуальні відмінності учнів, рівень їх здібності до навчання</div>
                </div>

                <div class='item'>                    
                    <div class='title'>АВТЕНТИЧНІ ВІДЕО ТА АУДІО МАТЕРІАЛИ</div>
                    <div class='text'>Щоб розвивати навички розуміння іноземної мови на слух, необхідні для розуміння живої мови,потрібно знайомитись з автентичними текстами, або тими, які звучать, як автентичні. Це можуть бути фрагменти художніх фільмів, телепередач, діалоги, тощо</div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="img_block">
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    #price_block{
        padding-top:40px;
        padding-bottom:40px;
        width:100%;
        min-height:470px;
        border-bottom: 1px solid #ddd;
        background: white
    }
    #price_block h2{
        text-align: center;
        font-size: 46px;
        margin-bottom: 50px;
    }
    #price_block .item{
        margin:auto;
        text-align: center;
    }
    #price_block .item .ico_block{
        height: 100px;
        width:100%;
        text-align: center;
    }
    #price_block .item .ico_block svg{
        width:60px;
        height: 60px;
    }
    #price_block .item .title{
        color: #222;
        font-weight:bold;
        font-size: 20px;
        height:60px;
    }
    #price_block .item .text{
        color: #222;
        font-size: 16px;
        font-weight:bold;
    }
    
    #price_block .notification{
        margin-top:50px;
        border: 2px dashed #fab80f;
        font-weight: bold;
        padding:30px;
        width:100%;
        background:white;
    }
</style>

<div id="price_block">
    <div class='container'>
        <h2>ВАРТІСТЬ НАВЧАННЯ</h2>
        <div class='row'>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <svg viewBox="0 0 50 50"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/images/14.svg#icon"></use></svg>
                    </div>
                    <div class='title'>ПЕРШЕ ЗАНЯТТЯ</div>

                    <div class='text'>
                        БЕЗКОШТОВНО
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <svg viewBox="0 0 50 50"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/images/139.svg#icon"></use></svg>
                    </div>
                    <div class='title'>ІНДИВІДУАЛЬНЕ НАВЧАННЯ</div>
                    <div class='text'>
                        100 ГРН/ 60 ХВ </br> 130 ГРН/ 90 ХВ
                    </div>  
                </div>
            </div>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <svg viewBox="0 0 50 50"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/images/629.svg#icon"></use></svg>
                    </div>
                    <div class='title'>ГРУПОВІ ЗАНЯТТЯ(2-4 ЛЮДИНИ)</div>
                    <div class='text'>80ГРН/60 ХВ</br> 100 ГРН/90 ХВ</div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <svg viewBox="0 0 50 50"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/images/117.svg#icon"></use></svg>
                    </div>
                    <div class='title'>ПІДГОТОВКА ДО ІСПИТІВ</div>
                    <div class='text'>150 ГРН/90 ХВ</div>
                </div>
            </div>
        </div>
        
        <div class='notification'>*ВАРТІСТЬ НАВЧАННЯ ОПЛАЧУЄТЬСЯ ЗА МІСЯЦЬ ВІДПОВІДНО ДО УЗГОДЖЕНОГО ГРАФІКА НАВЧАННЯ</div>
    </div>
</div>


<style>
    #block3{
        padding-top:80px;
        width:100%;
        height:546px;
        background: url('/html/images/img6.jpg') no-repeat center center;
        background-size: cover;
    }
    #block3 .form{        
        width:700px;
        margin:auto;
        margin-top:30px;
    }
    #block3 .form label{
        color: white;
    }
    #block3 h2{
        text-align: center;
        color: white;
        font-size: 60px;
    }
    #block3 h3{
        margin:auto;
        width:600px;
        text-align: center;
        color: white;
        font-size: 20px;
    }
    #block3 .block{
        background: rgba(0,0,0,0.3);
        width:800px;
        padding:40px;
        margin:auto;
        border-radius: 10px;
        box-shadow: 0px 0px 60px rgba(255,255,255,0.2);
    }
</style>

<div id="block3">
    <div class='container'>
        <div class='block'>
            <h2>Есть вопросы или нужна консультация?</h2>
            <h3>Оставьте свои контакты и преподаватель проконсультирует Вас по всем интересующим вопросам</h3>

            <form class='form'>
                <div class='row'>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <label>Имя</label>
                                </div>
                                <div class='col-sm-12'>
                                    <input type='text' class='form-control'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <label>Телефон</label>
                                </div>
                                <div class='col-sm-12'>
                                    <input type='text' class='form-control'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <div class='row'>                            
                                <div class='col-sm-12'><label>&nbsp;</label></div>
                                <div class='col-sm-12'>
                                    <input type='submit' value='Отправить'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    app.controller('mapCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.initMap = function(){
            var lat = 49.23384937, lng = 28.41922224;

            $scope.latlng = new google.maps.LatLng(lat, lng);                            
            var myOptions = {
                zoom: 16,
                draggable: true,
                zoomControl: true,
                scrollwheel: false,
                disableDoubleClickZoom: true,
                center: $scope.latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            $scope.map = new google.maps.Map(document.getElementById("map"), myOptions);


            var marker = new google.maps.Marker({//устанавливаем маркер
                map: $scope.map,
                position: $scope.latlng
            });
        }

        $scope.initMap();
    }]);
</script>

<style>
    #map_block{
        width:100%;
        height:397px;
        background: black;
        position:relative;
    }
    #map_block #map{
        width:100%;
        height: 100%;
    }
    #map_block .map_info{
        position: absolute;
        right: 0px;
        top:40px;
        width:350px;
        height: 150px;
        border-radius: 10px;
        background: white;
        padding:50px 20px;
        z-index:100;
        font-size: 14px;
        color: #222;
        font-weight:bold;
    }
    #map_block .map_info span{
        display:inline-block;
        vertical-align: middle;
        width:70px;
        color: #777;
    }
</style>

<div id="map_block" ng-controller="mapCtrl">
    <div class='container' style='position:relative;'>
        <div class='map_info'>
            <div><span>Адресс:</span> Хмельницкое шоссе 81/47</div>
            <div><span>Телефон:</span>0980920792</div>
        </div>
    </div>
    <div id='map'></div>
</div>
