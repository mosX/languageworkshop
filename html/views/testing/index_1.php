<style>
    ul{
        list-style: none;
    }
    .item ul li{
        width:200px;
        padding:5px 20px;
        cursor:pointer;
        border-left:3px solid transparent;
    }
    .item ul li:hover,.item ul li.active{
        border-left:3px solid #1EA9E3;
    }
</style>
<script>
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.tests = JSON.parse('<?=$this->m->data ? json_encode($this->m->data) : '{}'?>');
        $scope.questions = 0;
        
        //считаем сколько есть вопросов всего
        for(var key in $scope.tests){
            $scope.questions++;
        }
        console.log($scope.questions);
            
        $scope.selectAnswer = function(event){
            var parent = $(event.target).closest('.item');
            $('li',parent).removeClass('active');
            $(event.target).closest('li').addClass('active');
            
            event.preventDefault();
        }
                
        $scope.submit = function(event){
            var results = {};
            $('.item').each(function(){
                //console.log('11');
                var parent = $(this).closest('.item');
                
                results[$(parent).attr('data-id')] = $('li.active',this).attr('data-id');
                
                
            });
            $http({
                url:'/testing/check/',
                method:'POST',
                data:{'results':results}
            }).then(function(ret){
                console.log(ret.data);
            });
            console.log(results);
            
            event.preventDefault();
        }
    }]);
</script>
<div class="container" ng-controller="pageCtrl">
    <form class="form" ng-submit="submit($event)">
        <div class="item" ng-repeat="item in tests" data-id="{{item.id}}" ng-cloak>
            <h3>{{item.value}}</h3>
            <ul>
                <li ng-repeat="answer in item.answers" data-id="{{answer.id}}" ng-click="selectAnswer($event)">{{answer.text}}</li>
            </ul>
        </div>
        <div class="form-group">
            <input type="submit" value="Проверить">
        </div>
    </form>
</div>