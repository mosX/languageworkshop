<div class='container'>
    <script async defer src="https://apis.google.com/js/api.js"></script>

    <script>
        app.controller('forgotCtrl', ['$scope', '$http', function ($scope, $http) {
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
        .forgot_block{
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
        
        .forgot_block h2{
            font-size:18px;
            margin-bottom:20px;
            text-align: center;
            color: #b7c3cb;
            font-weight:500;
        }        
    </style>
    <form action="" method="POST" ng-submit="submit($event)" ng-controller="forgotCtrl">
        <div class='forgot_block'>
            <div class='inner'>
                <h2>Востановление пароля</h2>
                
                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='tooltip'>Эл.адрес</div>
                            <input type='text' class='form-control' name='email' placeholder='Email' ng-model="form.email">
                        </div>
                    </div>
                </div>

                
                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-12' style='text-align: center;'>
                            <input type='submit' class='btn' value='ОТПРАВИТЬ'>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </form>
</div>