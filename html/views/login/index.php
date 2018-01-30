<style>
    .form{
        width:442px;
        display:block;
        margin:auto;
        margin-top:128px;
        margin-bottom:88px;
    }
</style>
<script>
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        console.log('LoginE PAGE');
        $scope.submit = function(){
            $http({
                url:'/login/',
                method:'POST',
                data:$scope.form
            }).then(function(ret){
                console.log(ret.data);
                if(ret.data.status == 'success'){
                    location.href = '/';
                }else if(ret.data.status == 'error'){
                    console.log(ret.data);
                }
            });
            
            event.preventDefault();
        }
    }]);
</script>
<div class='container' ng-controller="pageCtrl">
    <form class='form' ng-submit="submit($event)">
        <div class='title'>АВТОРИЗАЦИЯ</div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <label>E-mail*</label>
                </div>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' placeholder='Email' ng-model="form.email">
                    <div class="error" ng-cloak="">{{error.email}}</div>
                </div>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <label>Пароль*</label>
                </div>
                <div class='col-sm-12'>
                    <input type='password' class='form-control' placeholder="не меньше 8ми символов в разных регистрах" ng-model="form.password">
                    <div class="error" ng-cloak="">{{error.password}}</div>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <a class='pull-left' href=''>Забыли пароль?</a>
                    <a class='pull-right' href=''>Зарегистрироваться</a>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <input type='submit' class='btn' value='Войти'>
        </div>
    </form>
</div>