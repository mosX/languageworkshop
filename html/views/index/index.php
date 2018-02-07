<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>

<style>
    #bannerCarousel .content{
       width:100%;
       height:600px;
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
</style>

<div id="bannerCarousel" class="carousel_custom slide">
    <ol class="carousel-indicators">            
        <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#bannerCarousel" data-slide-to="1" class=""></li>
        <li data-target="#bannerCarousel" data-slide-to="2" class=""></li>                
    </ol>

    <div class="carousel-inner">            
        <div href="" class="item active">
            <div class='content' style="position:absolute;background:url('/html/images/img2_1.jpg') no-repeat center center; background-size: cover">
                <div class="container">
                    <div class='title'>ІНДИВІДУАЛЬНІ ЗАНЯТТЯ</div>
                </div>
            </div>
        </div>
        <div href="" class="item">
            <div class='content' style="position:absolute;background:url('/html/images/img3.jpg') no-repeat center center; background-size: cover">
                <div class="container">
                    <div class='title'>НАВЧАННЯ В НЕВЕЛИКИХ ГРУПАХ</div>
                </div>
            </div>
        </div>
        <div href="" class="item">
            <div class='content' style="position:absolute;background:url('/html/images/img1.jpg') no-repeat center center; background-size: cover">
                <div class="container">
                    <div class='title'>ПІДГОТОВКА ДО ІСПИТІВ</div>
                </div>
            </div>
        </div>
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
        position:relative;
        color: white;
        font-weight:bold;
        font-size: 18px;
        margin-bottom:10px;
        display:inline-block;
    }
    #block2 .item .title:after{
        content:'';
        width:150px;
        height: 2px;
        background: #fab80f;
        position:absolute;
        left:0px;
        
        bottom:-3px;
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
        box-shadow: 0px 0px 32px rgba(0,0,0,0.45);
        border: 2px solid #222;
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
        padding-top:20px;
        padding-bottom:40px;
        width:100%;
        min-height:470px;
        border-bottom: 1px solid #ddd;
        background: #fdfbf5;
    }
    #price_block h2{
        position:relative;
        text-align: center;
        font-size: 46px;
        margin-bottom: 70px;
    }
    
    #price_block h2:after{
        display:block;
        content:'';
        position:absolute;
        height: 2px;
        width:200px;
        left:50%;
        margin-left: -100px;
        background: #fab80f;
        bottom:-10px;
    }
    
    #price_block .item{
        background: white;
        margin:auto;
        text-align: center;
        border: 2px solid #fab80f; 
        border-radius: 12px;
        height: 300px;
        padding:30px 10px;
        box-shadow: 0px 0px 20px rgba(32,32,32,0.17);
    }
    #price_block .item .ico_block{
        height: 100px;
        width:100%;
        text-align: center;
        position:relative;
        margin-bottom: 20px;
    }
    /*#price_block .item .ico_block svg{
        width:60px;
        height: 60px;
    }*/
    #price_block .item .title{
        position:relative;
        color: #222;
        font-weight:bold;
        font-size: 20px;
        line-height: 22px;
        height:60px;
        margin-bottom:10px;
    }
    
    #price_block .item .text{
        color: #222;
        font-size: 16px;
        font-weight:bold;
    }
    
    #price_block .notification{
        margin-top:50px;
        border: 2px dashed #fab80f;        
        font-size:18px;
        font-weight: bold;
        padding:30px;
        width:100%;
        background:white;
    }
    #price_block .item .ico_block .ico{
        background: url('/html/images/sprite.png');
        margin:auto;
        position:relative;
    }
    #price_block .item .ico_block .ico.ico1{
        width:100px;
        height:98px;
        background-position:-0px -2px;
    }
    #price_block .item .ico_block .ico.ico2{
        width:100px;
        height:100px;
        background-position:-460px -4px;
    }
    #price_block .item .ico_block .ico.ico3{
        width:100px;
        height:100px;
        background-position:-358px -0px;
    }
    #price_block .item .ico_block .ico.ico4{
        top:20px;
        width:100px;
        height:60px;
        background-position:-112px -26px;
    }
</style>

<div id="price_block">
    <div class='container'>
        <h2>ВАРТІСТЬ НАВЧАННЯ</h2>
        <div class='row'>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <div class='ico ico1'></div>
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
                        <div class='ico ico2'></div>
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
                        <div class='ico ico3'></div>
                    </div>
                    <div class='title'>ГРУПОВІ ЗАНЯТТЯ(2-4 ЛЮДИНИ)</div>
                    <div class='text'>80ГРН/60 ХВ</br> 100 ГРН/90 ХВ</div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class='item'>
                    <div class='ico_block'>
                        <div class='ico ico4'></div>
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
        line-height: 50px;
        margin-bottom:30px;
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
<script>
    app.controller('feedbackCtrl', ['$scope', '$http', function ($scope, $http){
            console.log('feedBack');
            $scope.form = {};
            $scope.submit = function(event){
                $http({
                    url:'/feedback/',
                    method:'POST',
                    data:$scope.form
                }).then(function(ret){
                    if(ret.data.status == 'error'){
                        $scope.error = ret.data.error;
                    }else{
                        $('#feedbackSuccessModal').modal('show');
                        $scope.form = {};
                        $scope.error = {};
                    }
                });
            
                event.preventDefault();
            }
            
    }]);
</script>
<div id="block3" ng-controller="feedbackCtrl">
    <div class='container'>
        <div class='block'>
            <h2>Маєте питання чи потрібна консультація?</h2>
            <h3>Залишіть свої контакти і викладачь проконсультує по всім питанням що Вас цікавлять</h3>            

            <form class='form' ng-submit="submit($event)">
                <div class='row'>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <label>Ім'я</label>
                                </div>
                                <div class='col-sm-12'>
                                    <input type='text' class='form-control' ng-model="form.name">
                                    <div class="error" ng-if="error.name" ng-cloak="">{{error.name}}</div>
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
                                    <input type='text' class='form-control' ng-model="form.phone">
                                    <div class="error" ng-if="error.phone" ng-cloak="">{{error.phone}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <div class='row'>                            
                                <div class='col-sm-12'><label>&nbsp;</label></div>
                                <div class='col-sm-12'>
                                    <input type='submit' value='Відправити'>
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
    $('document').ready(function(){
        //$('#feedbackSuccessModal').modal('show');
    });
</script>

<div class="modal fade" id="feedbackSuccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title font-header"><p><strong>Заявка успешно добавлена</strong></p></h4>
            </div>

            <div class="modal-body">
                <p>Ваша заявка была принята.</p>
                <p>С Вами свяжутся в ближайшее время.</p>
                <button style="margin-top:20px;" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
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
        box-shadow: 0px 0px 20px rgba(0,0,0,0.2); 
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
            <div><span>Адреса:</span> Хмельницьке шосе 81/47</div>
            <div><span>Телефон:</span>0980920792</div>
        </div>
    </div>
    <div id='map'></div>
</div>
