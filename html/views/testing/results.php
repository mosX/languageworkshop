<script>    
    app.controller('pageCtrl', ['$scope', '$http', function ($scope, $http){
        $scope.results = <?=$this->m->data?>;
        console.log($scope.results);
    }]);
</script>

<style>
    .block{
        position:relative;
        border: 2px solid #fab80f;
        width:700px;
        margin:auto;
        margin-top:80px;
        border-radius: 12px;
        padding:30px;
        box-shadow:  0px 0px 32px rgba(30,30,30,0.2);
        margin-bottom:50px;
    }
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

<div class="container" ng-controller="pageCtrl">
    <div class="block" ng-cloak>
        <div id="check_results_block">
            <div class="item" ng-repeat="item in results">
                <div class="question">{{item.value}}</div>
                <div class='answers_block'>
                    <div class='answer{{answer.correct ? " correct":""}}{{answer.selected ? " selected":""}}' ng-repeat='answer in item.answers'>{{answer.text}}</div>
                </div>
            </div>
        </div>
    </div>
</div>