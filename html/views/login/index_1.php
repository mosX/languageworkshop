<div class='container'>
    <script async defer src="https://apis.google.com/js/api.js"></script>

    <script>
        app.controller('authCtrl', ['$scope', '$http', function ($scope, $http) {
                $scope.form = {};

                $scope.submit = function (event) {
                    console.log($scope.form);
                    $http({
                        url: '/login/',
                        method: 'POST',
                        data: $scope.form
                    }).then(function (ret) {
                        console.log(ret.data);
                        if (ret.data.status == 'success') {
                            location.href = '/account/';
                            $scope.error = '';
                        } else {
                            $scope.error = ret.data.message;
                            console.log($scope.error);
                            //console.log('ERROR');
                        }
                    });
                    event.preventDefault();
                }
            }]);
    </script>
    
    <style>
        .auth_block{
            margin-top:44px;
            background: white;
        }
        .inner{
            width:252px;            
            padding:60px 0px 30px 0px;
            margin:auto;            
        }
       
        form{
            display:block;
            margin-bottom:100px;
        }
        
        .auth_block h2{
            font-size:18px;
            margin-bottom:20px;
            text-align: center;
            color: #b7c3cb;
            font-weight:500;
        }        
    </style>
    <form action="" method="POST" ng-submit="submit($event)" ng-controller="authCtrl">
        <div class='auth_block'>
            <div class='inner'>
                <h2>Вход на KomfortTV</h2>
                
                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='tooltip'>Эл.адрес или телефон</div>
                            <input type='text' class='form-control' name='email' placeholder='Email' ng-model="form.email">
                        </div>
                    </div>
                </div>

                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='tooltip'>Пароль</div>
                            <input type='password' class='form-control' value="" name='password' placeholder='Пароль' ng-model="form.password">
                            <div ng-cloak ng-if='error' class='error_side'>{{error}}</div>
                        </div>
                    </div>
                </div>

                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-12' style='text-align: center;'>
                            <input type='submit' class='btn' value='ВХОД'>
                        </div>
                    </div>
                </div>
                <style>
                    .or_line{
                        margin-top:20px;
                        border-top:2px solid #b7c3cb;
                        color: #b7c3cb;
                        text-align: center;
                        font-weight:bold;
                        font-size:12px;
                        line-height: 10px;
                    }
                    .or_line span{
                        font-size:14px;
                        position:relative;
                        top:-6px;
                        background:white;
                        display:inline-block;
                        padding:0px 10px;
                        margin:auto;                            
                    }
                </style>
                <div class="or_line">
                    <span>ИЛИ</span>
                    <div>ВВОЙДИТЕ ЧЕРЕЗ СОЦИАЛЬНУЮ СЕТЬ</div>
                </div>

                <style>
                    .socials{
                        margin:0px;
                        padding: 0px;
                        margin:auto;
                        list-style: none;
                        font-size: 0px;
                        display:inline-block;
                    }

                    .socials li{
                        display:inline-block;
                        vertical-align: top;
                        margin-right:5px;
                    }

                    .socials li:last-child{
                        margin-right:0px;
                    }
                    .socials li a{
                        display:block;
                        background:#b7c3cb;
                        height:82px;
                        width:82px;       
                        position:relative;
                    }

                    .socials li a span{
                        background: url('/html/images/social.png');
                        display:block;
                        top:50%;
                        left:50%;
                        position:absolute;
                    }

                    .socials .facebook a span{
                        width:19px;
                        height:35px;
                        background-position:0px 0px;
                        margin-left:-8px;
                        margin-top:-17px;
                    }

                    .socials .facebook:hover a{
                        background:#3b5998;
                    }

                    .socials .google a span{
                        width:38px;
                        height:24px;
                        background-position:-28px -5px;
                        margin-left:-19px;
                        margin-top:-12px;                            
                    }
                    .socials .google:hover a{
                        background:#e04c40;
                    }
                </style>

                <div class="form-group text-center">
                    <ul class="socials">
                        <li class="facebook"><a href="/login/facebook/"><span></span></a></li>
                        <li class="google" ><a href="/login/google/"><span></span></a></li>
                    </ul>
                </div>
                <div class="form-group text-center">
                    <a style='color: #b7c3cb; font-size:12px;' href='/signin/forgot'>Забыли пароль?</a>
                </div>
            </div>
        </div>
        
        <div class="actions" style="margin-top:8px;">
            <div class='form-group' style="margin:0px; margin-bottom:15px;">
                 <input type='submit' class='btn' value='Войти' style="margin-top:0px">
            </div>

            <div class='form-group text-center' style="margin:0px;">
                <a style="font-weight:normal" href="/registration/">Регистрация</a>
            </div>
        </div>
    </form>
</div>