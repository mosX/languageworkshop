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
    
    .question_block{
        margin-top:70px;
    }
</style>

<script>
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.tests = <?=$this->m->data ? json_encode($this->m->data) : '{}'?>;
        
        $scope.percents = 0;
        $scope.questions = 0;
        
        $scope.question_index = 0;
        $scope.results = {};
        $scope.end = false; //статус окончания теста
        $scope.repeat = false;  //статус отображения кнопки повторить тест
        $scope.username = '';
        $scope.lesson_id = <?=(int)$_GET['lesson_id']?>
        
        $scope.start_timestamp = (new Date()).getTime();
        
        $scope.selected_answer = '';
        
        $scope.types = {    
            1:'pick_one',
            2:'pick_image',
            3:'missed_word',
            4:'translate',
            5:'listen_pick',
            6:'listen_write'
        }
        
        /*$scope.types = {
            1:'text_quest',
            2:'image_quest'
        }*/
        
        
        //считаем сколько есть вопросов всего
        for(var key in $scope.tests){
            $scope.questions++;
        }
        $scope.total = $scope.questions;
        //console.log($scope.tests);
       
       $scope.listen = function(event){
            console.log($scope.question);
            
            var sound = new Audio('<?=$this->m->config->assets_source?>/audios/'+$scope.question.audio);
            sound.play();
            
            event.preventDefault();
        }
       
        $scope.setCurrentQuestion = function(){
            //устанавливаем текущий активный вопрос
            $scope.question = $scope.tests[$scope.question_index];
            if(!$scope.question) return;
            
            if($scope.question.type == 3){  //пропущеное слово
                $scope.question.value = ($scope.question.value).split('____');
            }
                
            $scope.percents = ($scope.total-$scope.questions+1) / ($scope.total/100);
            
            console.log("Current Question",$scope.question);
        }
        
        $scope.setCurrentQuestion();
        
        $scope.handleCurrentQuestion = function(){
            if(!$scope.question) return;
            console.log($scope.question);
            $scope.results[$scope.question.question_id] = {};
            
            if($scope.question.type == 1 || $scope.question.type == 2 || $scope.question.type == 3 || $scope.question.type == 5){
                $scope.results[$scope.question.question_id].answer = $scope.selected_answer.id;
            }else if($scope.question.type == 4 || $scope.question.type == 6){
                $scope.results[$scope.question.question_id].answer = $('#answer_input').val();
            }
            
            $scope.results[$scope.question.question_id].time = (new Date()).getTime() - $scope.start_timestamp;
            
            console.log($scope.results);
            $scope.start_timestamp = (new Date()).getTime();
            
            $scope.selected_answer = 0;
        }
        
        $scope.nextQuestion = function(event){
            //if($(event.target).hasClass('unactive'))return;
            
            //проверяем или выбран ответ
            //$('.question_block .item.active').
            
            if($scope.question.type == 4 || $scope.question.type == 6){                
                if(($('#answer_input').val()).length == 0){
                    console.log('Вы должны написать ответ');
                    event.preventDefault();
                    return;
                }
            }else{
                if(!$scope.selected_answer){
                    console.log('Вы должны выбрать ответ');
                    event.preventDefault();
                    return;
                }
            }
            
            //добавляем в массив 
            $scope.handleCurrentQuestion();
            $scope.questions--;
            
            if($scope.questions == 0) $scope.end = true;
            
            $scope.question_index++;
            $scope.setCurrentQuestion();
            
            event.preventDefault();
        }
          
        $scope.selectAnswer = function(event,answer){
            var parent = $(event.target).closest('.item');
            console.log(parent);
            $('.item').removeClass('active');
            $(parent).addClass('active');
            
            //$scope.current_answer = answer;
            $scope.selected_answer = answer;
            
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

<div class="container" ng-controller="pageCtrl" style="min-height: 800px; position:relative;">    
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
        #check_results_block .item{
            margin-bottom:15px;
            
        }
        #check_results_block .item img{
            display:block;
            margin:auto;
        }

        #check_results_block .question{
            font-size: 18px;
            margin-bottom:10px;
        }
        #check_results_block .answers_block{

        }
        #check_results_block .item[data-type="1"] .answers_block .answer{
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

        #check_results_block .item[data-type="2"] .answer{
            width:100px;
            height:100px;
            display:inline-block;
            margin-right: 20px;
            box-sizing: content-box;
        }
        #check_results_block .item[data-type="2"] .answer img{
            max-width:100px;
            max-height:100px;
        }

        #check_results_block .item[data-type="2"] .answers_block .answer{        
        }
        #check_results_block .item[data-type="2"] .answers_block .selected{
            border:2px solid red;
        }
        #check_results_block .item[data-type="2"] .answers_block .correct,#results_block .answers_block .correct.selected{
            border:2px solid green;
        }
    </style>
  
        <div style="margin-top:40px;margin-bottom:20px;" class="again text-center" ng-if="repeat">
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
            <!--<div class="question_left">{{total-questions+1}} / {{total}}</div>-->
            <style>
                .progressbar_block{
                    font-size: 0px;
                }
                .progressbar{
                    height: 10px;
                    width:100%;
                    background: black;
                    border: 1px solid #5b5b5b;
                    border-radius: 5px;
                    position: relative;
                    
                    width:80%;
                    font-size: 16px;
                    display:inline-block;
                    vertical-align: middle;
                }
                .progressbar_block .counter{
                    display: inline-block;                    
                    vertical-align: middle;
                    width:20%;
                    text-align: center;
                    color: white;
                    font-size: 18px;
                }
                .progressbar .inner_progressbar{
                    border-radius: 5px 0px 0px 5px;
                    position:absolute;
                    top:0px;
                    bottom:0px;
                    left:0px;
                    background: #65ab00;
                }
            </style>
                        
            <div class="question_body">
                <div class="progressbar_block">
                    <div class="progressbar">
                        <div class="inner_progressbar" style="width:{{percents}}%;"></div>
                    </div>
                    <div class="counter">{{total-questions+1}} / {{total}}</div>
                </div>
                
                <div ng-if="question.type == 1" class="task_title">Выберите правильный ответ</div>
                <div ng-if="question.type == 2" class="task_title">Выберите правильное изображение</div>
                <div ng-if="question.type == 3" class="task_title">Выберите пропущенное слово</div>
                <div ng-if="question.type == 4" class="task_title">Переведите текст</div>
                <div ng-if="question.type == 5" class="task_title">Прослушайте и выберите правильный вариант</div>
                <div ng-if="question.type == 6" class="task_title">Прослушайте и напишите что вы услышали</div>

                <!--<div class="question">{{current_question.value}}</div>-->

                <div class="question_text" ng-if="question.type == 1">{{question.value}}</div>
                <div class="question_text" ng-if="question.type == 2">{{question.value}}</div>
                <div class="question_text" ng-if="question.type == 3">{{question.value[0]}}<span class="word">{{selected_answer.text}}</span>{{question.value[1]}}</div>
                <div class="question_text" ng-if="question.type == 4">{{question.value}}</div>
                <div class="question_text" ng-if="question.type == 5"><div class="btn btn-primary" ng-click="listen($event)">Прослушать</div></div>
                <div class="question_text" ng-if="question.type == 6"><div class="btn btn-primary" ng-click="listen($event)">Прослушать</div></div>


                <div class="answers_block {{types[question.type]}}">
                    <div ng-if="question.type == 1" class="item {{item.collection_id == question.correct ? 'correct':''}} {{item.collection_id == question.wrong ? 'wrong':''}}" ng-click="selectAnswer($event,item)" ng-repeat="item in question.answers" ng-cloak>
                        {{item.text}}
                    </div>

                    <div ng-if="question.type == 2" class="item {{item.collection_id == question.correct ? 'correct':''}} {{item.collection_id == question.wrong ? 'wrong':''}}" ng-click="selectAnswer($event,item)" ng-repeat="item in question.answers" ng-cloak>
                        <img src="<?=$this->m->config->assets_source?>/images/{{item.filename}}">
                    </div>

                    <div ng-if="question.type == 3" class="item {{item.collection_id == question.correct ? 'correct':''}} {{item.collection_id == question.wrong ? 'wrong':''}}" ng-click="selectAnswer($event,item)" ng-repeat="item in question.answers" ng-cloak>
                        {{item.text}}
                    </div>

                    <div ng-if="question.type == 5" class="item {{item.collection_id == question.correct ? 'correct':''}} {{item.collection_id == question.wrong ? 'wrong':''}}" ng-click="selectAnswer($event,item)" ng-repeat="item in question.answers" ng-cloak>
                        {{item.text}}
                    </div>

                    <div ng-if="question.type == 4" class="item" ng-cloak>
                        <input type="text" class="form-control" id="answer_input">
                    </div>

                    <div ng-if="question.type == 6" class="item" ng-cloak>
                        <input type="text" class="form-control" id="answer_input">
                    </div>
                </div>
            </div>
            <!--<div class="btn btn-primary {{!current_answer ? 'unactive':''}}" ng-click="nextQuestion($event)" style="width:200px;">Далі</div>-->
            
            <div class="question_footer">
                <div class="check_btn" ng-click="nextQuestion($event)">Далее</div>                
            </div>            
        </div>

        <div id="check_results_block" ng-if='results'>
            <div class="item" data-type="{{item.type}}" ng-repeat="item in results">
                <div class="question">{{item.value}}</div>
                <div class='answers_block'>
                    <div ng-if="item.type == 1" class='answer{{answer.correct ? " correct":""}}{{answer.selected ? " selected":""}}' ng-repeat='answer in item.answers'>{{answer.text}}</div>

                    <div ng-if="item.type == 2" class='answer{{answer.correct ? " correct":""}}{{answer.selected ? " selected":""}}' ng-repeat='answer in item.answers'>
                        <img src="http://languageadmin/assets/images/{{answer.filename}}">
                    </div>
                </div>
            </div>
        </div>
    
    
</div>