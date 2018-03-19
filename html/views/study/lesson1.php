<script>
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.initAutdios = function(){
            $scope.mySound = new Audio('/html/audio/the.mp3');        
        }
        $scope.initAutdios();
            
        $scope.listen = function(event,name){
            $scope.mySound.play();
        }
        
        $scope.startStudy = function(event){
            $('#testingModal').modal('show');
            
            $http({
                url:'/study/get_question/?lesson_id=1',
                method:'GET',                
            }).then(function(ret){
                console.log(ret.data);
            });
            
            //alert('23423');
            event.preventDefault();
        }
    }]);
</script>

<div class="container" ng-controller="pageCtrl" style='padding-bottom:50px;'>
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
        app.controller('testingModalCtrl', ['$scope','$rootScope','$http',function($scope,$http){

        }]);
    </script>
    <div ng-controller="testingModalCtrl" class="modal fade" id="testingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title font-header"><p><strong>Тестирование</strong></p></h4>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" ng-submit="submit($event)">

                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

