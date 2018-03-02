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
        $scope.tests = <?=$this->m->data ? json_encode($this->m->data) : '{}'?>;
        $scope.questions = 0;
        $scope.current_question_index = 0;
        $scope.results = {};
        $scope.end = false; //статус окончания теста
        $scope.repeat = false;  //статус отображения кнопки повторить тест
        $scope.username = '';
        $scope.lesson_id = <?=(int)$_GET['lesson_id']?>
        
        $scope.start_timestamp = (new Date()).getTime();
        
        
        //считаем сколько есть вопросов всего
        for(var key in $scope.tests){
            $scope.questions++;
        }
        $scope.total = $scope.questions;
        console.log($scope.total);
       
        $scope.setCurrentQuestion = function(){
            //устанавливаем текущий активный вопрос
            $scope.current_question = $scope.tests[$scope.current_question_index];
        }
        
        $scope.setCurrentQuestion();
        
        $scope.handleCurrentQuestion = function(){
            if(!$scope.current_question) return;
            $scope.results[$scope.current_question.question_id] = {};
            $scope.results[$scope.current_question.question_id].answer = $scope.current_answer;
            $scope.results[$scope.current_question.question_id].time = (new Date()).getTime() - $scope.start_timestamp;
            
            $scope.start_timestamp = (new Date()).getTime();
            
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
            
            if($scope.questions == 0) $scope.end = true;
            
            $scope.current_question_index++;
            $scope.setCurrentQuestion();
            
            event.preventDefault();
        }
          
        $scope.selectAnswer = function(event,answer){
            var parent = $(event.target).closest('.item');
            console.log(parent);
            $('.item').removeClass('active');
            $(parent).addClass('active');
            
            $scope.current_answer = answer;
            
            event.preventDefault();
        }
        
        $scope.restartLesson = function(event){
            location.href = location.href;
            event.preventDefault();
        }

        $scope.submit = function(event){
            if($(event.target).hasClass('unactive'))return;
            $scope.handleCurrentQuestion();
                        
            $http({
                url:'/testing/check/',
                method:'POST',
                data:{'results':$scope.results,'username':$('input[name=username]').val(),'lesson_id':$scope.lesson_id}
            }).then(function(ret){
                if(ret.data.status == 'success'){
                    $scope.score = ret.data.score;
                    $scope.hash = ret.data.hash;
                    $scope.message = ret.data.message;
                    
                    $scope.end = true;
                    console.log('REPEAT');
                    $scope.repeat = true;
                    
                    $scope.results = ret.data.results;
                    $('#resultsSuccessModal').modal('show');
                }else{
                    console.log('ERROR');
                    $scope.error = ret.data.message;
                }
            });
            
            event.preventDefault();
        }
    }]);
</script>

<div class="container-fluid" ng-controller="pageCtrl" style="min-height: 800px; position:relative;">    
    <div class="modal fade" id="resultsSuccessModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title font-header"><p><strong>Ви успішно пройшли тест</strong></p></h4>
                </div>

                <div class="modal-body">
                    <p>Ви набрали {{score}} балів.</p>                    
                    <p>{{message}}</p>
                    <button style="margin-top:20px;" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .block{
            position:relative;
            border: 2px solid #fab80f;
            width:700px;
            margin-left:200px;
            margin-top:80px;
            border-radius: 12px;
            padding:30px;
            box-shadow:  0px 0px 32px rgba(30,30,30,0.2);
            margin-bottom:50px;

        }
        .question_block{
            
        }
        .question_block .btn{
            display:block;            
            margin:auto;
            margin-top:30px;
        }
        .question_block .question_left{
            position:absolute;
            border-left:2px solid #fab80f;
            border-bottom:2px solid #fab80f;
            border-radius: 8px;
            width:auto;
            height: 34px;
            text-align: center;
            padding-top:3px;
            padding-left:10px;
            padding-right:10px;            
            font-size: 18px;
            color: #1EA9E3;
            font-weight:bold;
            top:0px;
            right:0px;
        }
        
        .question_block .question{
            text-align: center;
            font-size: 22px;
            margin-left: 0px;
        }
        .question_block .answers_block{            
            margin-top:20px;
            margin-bottom:20px;            
        }
        
        .question_block .answers_block .item{
            border-bottom: 1px solid #fab80f;
            font-size: 16px;
            margin-bottom:15px;
            height:40px;
            border-left:3px solid transparent;
            padding-left:20px;
            padding-top:8px;
            cursor:pointer;
        }
        .question_block .answers_block .item:hover,.question_block .answers_block .item.active{
            border-left:3px solid #1EA9E3;
        }
        
        .results_block{
            width:500px;
            margin:auto;
            margin-top:20px;
            text-align: center;            
        }
        .results_block p{
            font-size: 18px;
        }        
    </style>
    <style>
        #sidebar{
            width:300px;
            border-right: 2px solid #fab80f;
            height: 100%;
            box-shadow: 0px 0px 25px rgba(30,30,30,0.15);
            display:inline-block;
            vertical-align: top;
            position:absolute;
            left:0px;
            top:0px;
            bottom:0px;
            background: #433D39;
        }
        #sidebar ul{
            margin:0px;
            padding:0px;
        }
        #sidebar li{
            height: 60px;
            background: #342e2a;            
            margin-bottom:5px;
        }
        #sidebar li a{
            color: white;
            display:block;
            width:100%;
            height: 100%;
            padding:18px 30px;;
            font-size: 16px;
            font-weight:bold;
            overflow: hidden;
            text-overflow:ellipsis;
            white-space: nowrap;
            border-bottom: 1px solid transparent;
            text-decoration: none;
        }
        #sidebar li.active a,#sidebar li:hover a{
            border-bottom: 1px solid #fab80f;
        }
        
        .content{
            position:relative;
            left:300px;
            right:0px;            
            display:inline-block;
            vertical-align: top;
        }
    </style>
    <div id='sidebar'>
        <ul>
            <?php foreach($this->m->lessons_list as $item){ ?>
                <li><a href='/testing/?lesson_id=<?=$item->id?>'><?=$item->name?></a></li>
            <?php } ?>
        </ul>
    </div>
    <div class='content'>
        <div class="block" ng-cloak>
            <div class="again text-center" ng-if="repeat">
                <div class="btn btn-primary" ng-click="restartLesson($event)" style="width:200px;">Спробувати знову</div>
            </div>

            <div class="results_block" ng-if="end && !repeat">
                <div class="form-group">
                    <p style="font-weight:bold">Введіть ім'я та прізвище, щоб побачити результат.</p>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" value="" name="username">
                    <div class="error">{{error}}</div>
                </div>

                <div class="btn btn-primary" ng-click="submit($event)" style="width:200px;">Отримати результат</div>
            </div>

            
            
            <div class="question_block" ng-cloak="" ng-if="!end && !repeat">
                <div class="question_left">{{total-questions+1}} / {{total}}</div>
                <div class="question">{{current_question.value}}</div>
                <div class="answers_block">
                    
                    <div ng-if='current_question.type == 1' ng-click="selectAnswer($event,item.id)" class="item" ng-repeat="item in current_question.answers">{{item.text}}</div>
                    
                    <div ng-if='current_question.type == 2' ng-click="selectAnswer($event,item.id)" class="item" ng-repeat="item in current_question.answers">
                        <img src='http://languageadmin/assets/images/{{item.filename}}'>
                    </div>
                </div>

                <div class="btn btn-primary {{!current_answer ? 'unactive':''}}" ng-click="nextQuestion($event)" style="width:200px;">Далі</div>
            </div>

            <style>
                #check_results_block .item{
                    margin-bottom:15px;
                }

                #check_results_block .question{
                    font-size: 18px;
                    margin-bottom:10px;
                }
                #check_results_block .answers_block{

                }
                #check_results_block .answers_block .answer{
                    margin-left: 20px;
                    padding-left:10px;
                    margin-bottom:5px;
                }
                #check_results_block .answers_block .selected{
                    border-left:2px solid red;
                }
                #check_results_block .answers_block .correct,#results_block .answers_block .correct.selected{
                    border-left:2px solid green;
                }
            </style>
            <div id="check_results_block" ng-if='results'>
                <div class="item" ng-repeat="item in results">
                    <div class="question">{{item.value}}</div>
                    <div class='answers_block'>
                        <div class='answer{{answer.correct ? " correct":""}}{{answer.selected ? " selected":""}}' ng-repeat='answer in item.answers'>{{answer.text}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>