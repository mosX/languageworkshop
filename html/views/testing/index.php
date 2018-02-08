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
        $scope.current_question_index = 0;
        $scope.results = [];
        
        //считаем сколько есть вопросов всего
        for(var key in $scope.tests){
            $scope.questions++;
        }
        
        $scope.setCurrentQuestion = function(){
            //устанавливаем текущий активный вопрос
            $scope.current_question = $scope.tests[$scope.current_question_index];
        }
        
        $scope.setCurrentQuestion();
        
        $scope.handleCurrentQuestion = function(){
            $scope.results[$scope.current_question.question_id] = $scope.current_answer;
            
            
            $scope.current_answer = 0;
        }
        
        $scope.nextQuestion = function(event){            
            if($(event.target).hasClass('unactive'))return;
            
            //проверяем или выбран ответ
            //$('.question_block .item.active').
            if(!$scope.current_answer){
                console.log('Вы должны выбрать ответ');
                event.preventDefault();
                return;
            }
            
            //добавляем в массив 
            $scope.handleCurrentQuestion();
            $scope.questions--;
            
            $scope.current_question_index++;
            $scope.setCurrentQuestion();
            
            event.preventDefault();
        }
        
        /*$scope.selectAnswer = function(event){
            var parent = $(event.target).closest('.item');
            $('li',parent).removeClass('active');
            $(event.target).closest('li').addClass('active');
            
            event.preventDefault();
        }*/
    
        $scope.selectAnswer = function(event,answer){
            var parent = $(event.target).closest('.item');
            console.log(parent);
            $('.item').removeClass('active');
            $(parent).addClass('active');
            
            $scope.current_answer = answer;
            
            event.preventDefault();
        }

        $scope.submit = function(event){
            if($(event.target).hasClass('unactive'))return;
            $scope.handleCurrentQuestion();
            console.log($scope.results);
            /*var results = {};
            $('.item').each(function(){
                var parent = $(this).closest('.item');
                results[$(parent).attr('data-id')] = $('li.active',this).attr('data-id');
            });*/
            
            $http({
                url:'/testing/check/',
                method:'POST',
                data:{'results':$scope.results}
            }).then(function(ret){
                console.log(ret.data);
                if(ret.data.status == 'success'){
                    $scope.score = ret.data.score;
                    $scope.hash = ret.data.hash;
                    $('#resultsSuccessModal').modal('show');
                }else{
                    console.log('ERROR');
                    
                }
            });
            
            event.preventDefault();
        }
    }]);
</script>

<div class="container" ng-controller="pageCtrl" style="min-height: 800px;">
    
    <div class="modal fade" id="resultsSuccessModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title font-header"><p><strong>Вы успешно прошли тест</strong></p></h4>
                </div>

                <div class="modal-body">
                    <p>Вы набрали {{score}} балов.</p>
                    <p>Вы можете показать этот код что бы ваш преподаватель оценил правильность ответов: <strong>{{hash}}</strong>.</p>
                    <button style="margin-top:20px;" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .question_block{
            margin-top:40px;
            position:relative;
        }
        .question_block .question_left{
            position:absolute;
            border:1px solid #1EA9E3;
            border-radius: 5px;
            width:30px;
            height: 30px;
            text-align: center;
            padding-top:3px;
            font-weight:bold;
            left:0px;
        }
        
        .question_block .question{
            font-size: 22px;
            margin-left: 40px;
        }
        .question_block .answers_block{
            margin-left:20px;
            margin-top:20px;
            margin-bottom:20px;
        }
        
        .question_block .answers_block .item{
            height:40px;
            border-left:3px solid transparent;
            padding-left:20px;
            padding-top:8px;
            cursor:pointer;
        }
        .question_block .answers_block .item:hover,.question_block .answers_block .item.active{
            border-left:3px solid #1EA9E3;
        }
    </style>
    <div class="question_block" ng-cloak="">
        <div class="question_left">{{questions}}</div>
        <div class="question">{{current_question.value}}</div>
        <div class="answers_block">
            <div ng-click="selectAnswer($event,item.id)" class="item" ng-repeat="item in current_question.answers">{{item.text}}</div>
        </div>
      
        <div ng-if="questions > 1" class="btn btn-primary {{!current_answer ? 'unactive':''}}" ng-click="nextQuestion($event)" style="width:200px;">Дальше</div>
        <div ng-if="questions <= 1" class="btn btn-primary {{!current_answer ? 'unactive':''}}" ng-click="submit($event)" style="width:200px;">Завершить</div>        
    </div>
</div>