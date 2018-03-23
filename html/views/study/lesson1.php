<script>
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.session_id = '';
        $scope.answer_id = '';
        $scope.result = null;
        $scope.selected_answer = {};
                
        /*$scope.initAutdios = function(){
            $scope.mySound = new Audio('/html/audio/the.mp3');        
        }
        $scope.initAutdios();*/
            
        $scope.listen = function(event){
            console.log($scope.question);
            
            var sound = new Audio('<?=$this->m->config->assets_source?>/audios/'+$scope.question.audio);
            sound.play();
            
            event.preventDefault();
        }
        
        $scope.setAnswersView = function(type){
            switch(parseInt(type)){
                case 1 : $scope.viewType = 'pick_one';break;
                case 2 : $scope.viewType = 'pick_image';break;
                case 3 : 
                    $scope.viewType = 'missed_word';
                    $scope.question.value = ($scope.question.value).split('____');
                    break;
                case 4 : $scope.viewType = 'translate';break;
                case 5 : $scope.viewType = 'listen_pick';break;
                case 6 : $scope.viewType = 'listen_write';break;
            }
        }
        
        $scope.startStudy = function(event){
            $('#testingModal').modal('show');
            
            $http({
                //url:'/study/get_question/?lesson_id=1',
                url:'/study/start/?lesson_id=1',
                method:'GET',
            }).then(function(ret){
                console.log(ret.data);
                
                if(ret.data.status == 'error'){
                    console.log('ERROR');
                    return;
                }
                
                $scope.result = ret.data.result;
                
                $scope.session_id = ret.data.session_id;
                $scope.question = ret.data;
                
                //$scope.question.value = 'test <span>111</span> test';
                
                $scope.setAnswersView($scope.question.type);
            });
            
            //alert('23423');
            if(event)event.preventDefault();
        }
        
        $scope.selectAnswer = function(event,item){
            if($scope.result != null) return;
            
            $scope.selected_answer = item;
            
            $('.answers_block .item').removeClass('active');
            $(event.target).closest('.item').addClass('active');
            $scope.answer_id = item.collection_id;
            
            event.preventDefault();
        }
            
        $scope.check = function(event){
            if($scope.question.type == 6 || $scope.question.type == 4){
                var answer = $('#answer_input').val();
            }else{
                var answer = $scope.answer_id;
            }
            
            $http({
                url:'/study/check_answer/?answer='+answer+'&session='+$scope.session_id,
                type:'GET',
            }).then(function(ret){
                console.log(ret.data);
                if(ret.data.status == 'success'){
                    if(ret.data.result == 'correct'){
                        $('.answers_block .item.active').addClass('correct');
                        $scope.result = 'correct';
                    }else if(ret.data.result == 'wrong'){
                        //$('.answers_block .item.active').addClass('wrong');
                        $scope.question.wrong = ret.data.wrong;
                        
                        $scope.result = 'wrong';
                    }                    
                    $scope.question.correct = ret.data.correct ;
                    
                    $('.answers_block .item').removeClass('active');
                }else{
                    console.log('ERROR');
                }
            });
            
            event.preventDefault();
        }
        
        $scope.next = function(){
            $http({
                url:'/study/next/?session='+$scope.session_id,
                method:'GET'
            }).then(function(ret){
                $scope.answer_id = 0;
                $scope.selected_answer = {};
                $('#answer_input').val('');
                
                if(ret.data.status == 'error'){
                    console.log('ERROR');
                    return false;
                }
                
                $scope.result = null;
                $scope.question = ret.data;
                
                $scope.setAnswersView($scope.question.type);
            });
        }
        
        $scope.skip = function(event){
            event.preventDefault();
        }
        $scope.startStudy();
    }]);
</script>

<div class="container" ng-controller="pageCtrl" style='padding-bottom:50px;min-height:800px;'>
    <script>
        //var mySound = new Audio('/html/audio/6c980a921aa2d8f76ada94a21bd829cd.mp3');
        //mySound.play();
    </script>
    
    <style>
        .listen{
            position:relative;
            display:inline-block;
            vertical-align: middle;
            color: blue;
            font-weight:bold;            
            margin-right: 10px;
        }
        .listen:after{
            content:'';
            width:10px;
            height: 10px;
            position:absolute;
            top:0px;
            right:-10px;
            background: red;
            cursor:pointer;
        }
    </style>
    
    <h3>Артикли в английском языке</h3>

    <p>Артикль в английском языке – это служебная часть речи, которая служит для выражения категории определенности / неопределенности.</p>

    <p>Определенность означает, что предмет индивидуализирован, выделен из всех остальных предметов этого вида, а неопределенность представляет собой более общую ссылку на этот тип предметов в целом.</p>

    Например:
    The boy has a ball.
    У мальчика есть мячик.

    <p>В указанном примере имеется в виду некий определенный, конкретный мальчик, известный читателю из контекста, а слово «мячик» имеет более общее значение и обозначает, какой тип предмета у него есть.</p>

    <p>В английском языке есть два артикля: определенный the и неопределенный a (an). Оба они произошли от знаменательных частей речи и частично сохранили в себе свое старое значение.</p>

    <p>Определенный артикль <div ng-click='listen($event,"the")' class="listen">the</div> произошел от указательного местоимения that, отсюда и его значение конкретности. Старое значение можно проследить в таких фразах, как: at the (that) time, of the (that) kind.</p>

    <p>Неопределенный артикль a произошел от числительного one, значение которого четко видно во фразах: not a word, a mile’s walk, a cup or two.</p>

    <p>Неопределенный артикль в английском языке имеет два варианта – a и an. Если существительное начинается с согласного звука, то используется форма a, если с гласного – форма an:</p>
    a tree, a worker, a hero
    an apple, an engineer, an hour
    
    <div class='btn btn-primary' ng-click='startStudy($event)'>Пройти задание</div>
    
    <script>
        app.controller('testingModalCtrl', ['$scope','$http',function($scope,$http){
            
        }]);
    </script>
    <style>
        #testingModal .modal-dialog{
            width:800px;
        }
        #testingModal .task_title{
            padding-left:20px;
            text-align: left;
            font-weight: bold;
            font-size: 32px;
            line-height: 38px;
            color:#dddddd;
        }
        #testingModal .modal-body{
            text-align: left;
        }
        #testingModal .modal-footer{
            padding-left:40px;
            padding-right:40px;
        }
                                    
        #testingModal .question_text{
            font-size:22px;
            color:#dddddd;            
        }
        #testingModal .answers_block{
            margin:20px 0px;
        }
        
        
        
        #testingModal .answers_block.pick_one .item, #testingModal .answers_block.listen_pick .item{
            border: 2px solid #5b5b5b;
            margin-bottom:10px;           
            padding: 10px 20px 13px 20px;
            border-radius: 25px; 
            cursor:pointer;
        }
        #testingModal .answers_block.pick_one .item.correct,#testingModal .answers_block.listen_pick .item.correct{
            background:#172503;
            border: 2px solid #65ab00;
            color: #63a702;
        }
        
        #testingModal .answers_block.pick_one .item.wrong,#testingModal .answers_block.listen_pick .item.wrong{
            border: 2px solid #e70800;
            color: #d31711;
            background: #3c0504;
        }        
        #testingModal .answers_block.pick_one:not(.stop) .item:hover,#testingModal .answers_block.pick_one .item.active, #testingModal .answers_block.listen_pick:not(.stop) .item:hover,#testingModal .answers_block.listen_pick .item.active{
            border:2px solid #1caff6;
            color: #0194dc;            
            background: transparent;
        }        
        #testingModal .answers_block.pick_one .item.active,#testingModal .answers_block.listen_pick .item.active{
            background: #011e2b;
        }
        
        
        #testingModal .answers_block.missed_word{
            margin-left:-10px;
            margin-right:-10px;
        }
        #testingModal .answers_block.missed_word .item{
            width:auto; 
            display:inline-block;
            margin-right:10px;
            margin-left:10px;
            
            border: 2px solid #5b5b5b;
            margin-bottom:10px;           
            padding: 10px 20px 13px 20px;
            border-radius: 25px; 
            cursor:pointer;
        }
        #testingModal .answers_block.missed_word .item.correct{
            background:#172503;
            border: 2px solid #65ab00;
            color: #63a702;
        }
        
        #testingModal .answers_block.missed_word .item.wrong{
            border: 2px solid #e70800;
            color: #d31711;
            background: #3c0504;
        }        
        #testingModal .answers_block.missed_word:not(.stop) .item:hover,#testingModal .answers_block.missed_word .item.active{
            border:2px solid #1caff6;
            color: #0194dc;            
            background: transparent;
        }        
        #testingModal .answers_block.missed_word .item.active{
            background: #011e2b;
        }
        
        
        
        #testingModal .answers_block.pick_image{
            margin-left:-10px;
            margin-right:-10px;
        }
        #testingModal .answers_block.pick_image.stop .item:not(.correct) img{
            opacity:0.3;
        }
        #testingModal .answers_block.pick_image .item{
            text-align: center;
            width:164px; 
            height:164px;
            display:inline-block;
            margin-right:10px;
            margin-left:10px;            
            border: 2px solid #5b5b5b;
            margin-bottom:10px;            
            cursor:pointer;
        }
        #testingModal .answers_block.pick_image .item img{
            max-width: 100%;
            max-height: 100%;
        }
        #testingModal .answers_block.pick_image .item.correct{
            background:#172503;
            border: 2px solid #65ab00;
            color: #63a702;
        }
        
        #testingModal .answers_block.pick_image .item.wrong{
            border: 2px solid #e70800;
            color: #d31711;
            background: #3c0504;
        }        
        #testingModal .answers_block.pick_image:not(.stop) .item:hover,#testingModal .answers_block.pick_image .item.active{
            border:2px solid #1caff6;
            color: #0194dc;            
            background: transparent;
        }        
        #testingModal .answers_block.pick_image .item.active{
            background: #011e2b;
        }
        
        
        
        
        #testingModal .skip_btn{
            width:150px;
            height:44px;
            border: 2px solid #bfbfbf;
            color: #dddddd;
            float:left;            
            border-radius: 25px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding:8px 0px;
            cursor:pointer;
        }
        #testingModal .skip_btn:hover{
            background: #2f2e2e;
        }
        #testingModal .check_btn{
            width:150px;
            height:44px;
            border: 2px solid #65ab00;
            background: #65ab00;
            color: white;
            float:left;            
            border-radius: 25px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding:8px 0px;
            cursor:pointer;
            float:right;
        }
        #testingModal .check_btn.wrong{
            background: #e70800;
            border: 2px solid #e70800;
        }
        
        #testingModal .check_btn.wrong:hover{
            background: #d90902;
            border: 2px solid #d90902;
        }
        
        #testingModal .check_btn:hover{
            border: 2px solid #6eb903;
            background: #6eb903;
        }
    </style>
    
    <div ng-controller="testingModalCtrl" class="modal fade" id="testingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title font-header">
                        <div ng-if="question.type == 1" class="task_title">Выберите правильный ответ</div>
                        <div ng-if="question.type == 2" class="task_title">Выберите правильное изображение</div>
                        <div ng-if="question.type == 3" class="task_title">Выберите пропущенное слово</div>
                        <div ng-if="question.type == 4" class="task_title">Переведите текст</div>
                        <div ng-if="question.type == 5" class="task_title">Прослушайте и выберите правильный вариант</div>
                        <div ng-if="question.type == 6" class="task_title">Прослушайте и напишите что вы услышали</div>
                    </h4>
                </div>
                <style>
                    .question_text .word{
                        display:inline-block;
                        position:relative;
                        min-width:50px;
                        font-size:22px;
                        text-align: center;
                        padding:0px 5px;
                        
                    }
                    .question_text .word:after{
                        content:'';
                        left:0px;        
                        position:absolute;
                        bottom:-1px;
                        height: 1px;
                        background: white;
                        width:100%;
                    }
                </style>
                
                <div class="modal-body">
                    <div class="question_text" ng-if="question.type == 1">{{question.value}}</div>
                    <div class="question_text" ng-if="question.type == 2">{{question.value}}</div>
                    <div class="question_text" ng-if="question.type == 3">{{question.value[0]}}<span class="word">{{selected_answer.text}}</span>{{question.value[1]}}</div>
                    <div class="question_text" ng-if="question.type == 4">{{question.value}}</div>
                    <div class="question_text" ng-if="question.type == 5"><div class="btn btn-primary" ng-click="listen($event)">Прослушать</div></div>
                    <div class="question_text" ng-if="question.type == 6"><div class="btn btn-primary" ng-click="listen($event)">Прослушать</div></div>
                    
                    <div class="answers_block {{viewType}} {{result?'stop':''}}">
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
                
                <div class="modal-footer">
                    <div ng-if="!result" ng-click="skip($event)" class="skip_btn">Skip</div>
                    
                    <div ng-if="!result" class="check_btn" ng-click="check($event)">Check</div>
                    <div ng-if="result == 'correct'" class="check_btn correct" ng-click="next()">Далее</div>
                    <div ng-if="result == 'wrong'" class="check_btn wrong" ng-click="next()">Далее</div>
                </div>
            </div>
        </div>
    </div>
</div>


