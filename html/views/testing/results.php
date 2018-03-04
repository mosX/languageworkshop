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

<div class="container" ng-controller="pageCtrl">
    <div class="block" ng-cloak>
        <div id="check_results_block">
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
</div>