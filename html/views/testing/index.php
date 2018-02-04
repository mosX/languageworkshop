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
        <?php foreach($this->m->data as $item){ ?>
            <div class="item" data-id="<?=$item->id?>">
                <h3><?=$item->value?></h3>
                <ul>
                    <?php foreach($item->answers as $answer){ ?>
                        <li data-id="<?=$answer->id?>" ng-click="selectAnswer($event)"><?=$answer->text?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <div class="form-group">
            <input type="submit" value="Проверить">
        </div>
    </form>
</div>