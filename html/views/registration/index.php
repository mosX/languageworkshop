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
        console.log('REGISTRATE PAGE');
        $scope.submit = function(){
            $http({
                url:'/registration/',
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
        <div class='title'>РЕГИСТРАЦИЯ</div>
        
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
                    <label>Подтвердить Пароль*</label>
                </div>
                <div class='col-sm-12'>
                    <input type='password' class='form-control' placeholder="не меньше 8ми символов в разных регистрах" ng-model="form.password2">
                    <div class="error" ng-cloak="">{{error.password2}}</div>
                </div>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type='checkbox'> Согласен с условиями соглашения
                </div>
                <div class='col-sm-12'>
                    <input type='checkbox'> Согласен получать имейл рассылку
                </div>
            </div>
            <div class="error" ng-cloak="">{{error.main}}</div>
        </div>
        
        <div class='form-group'>
            <input type='submit' class='btn' value='ЗАРЕГИСТРИРОВАТЬСЯ'>
        </div>
    </form>
</div>