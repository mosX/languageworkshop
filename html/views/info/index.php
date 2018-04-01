<style>
    h2{
        color: #222;
        font-size: 30px;
        text-align: left;
        position:relative;
        display:inline-block;
    }
    h2::after {
        display: block;
        content: '';
        position: absolute;
        height: 2px;
        width: 40%;
        left: 0;
        background: #fab80f;
        bottom: -10px;
    }
    .tests{
        margin-top:30px;        
    }
    
    .tests .row{
        margin-left:-20px; 
        margin-right:-20px;
    }
    
    .tests .item_block{
        text-decoration: none;
        position:relative;
        height: 200px;
        width:340px;
        display:inline-block;
        vertical-align: top;
        margin-left:20px;
        margin-right:20px;
        margin-bottom:20px;
    }
    
    .tests .item_block:hover .item{
        transform: scale(1.1);
    }
    
    .tests .item_block .item{
        height: 200px;
        overflow:hidden;
        z-index: 100;
        transition: transform 0.4s;
        border: 1px solid #ddd;
        cursor:pointer;
        box-shadow: 0px 0px 12px rgba(36,36,36,0.2);
        background: white;
    }
    
    .tests .item .image_block{
        height: 150px;
        width:100%;
    }
    
    .tests .item .title{
        padding:10px 20px;
        text-align: center;
        position:relative;
        font-size: 16px;
        font-weight: bold;
    }
    
    .tests .item .description{
        padding:10px 20px;
        text-align: justify;
    }
    .tests .item:hover .description{
        height: auto;
    }
</style>

<script>
    $('document').ready(function(){
        $('.tests .item_block').hover(function(){
            //$('.tests .item_block').css({'z-index':'1'});
            $(this).css({'z-index':'3'});
            
            $('.item',this).animate({'height':200+$('.description',this).height() +20+ 'px'},400,function(){
                $(this).closest('.item_block').css({'z-index':'2'});
            });
        },function(){
            //$(this).css({'z-index':'2'});
            $('.item',this).animate({'height':'200px'},400,function(){
                $(this).closest('.item_block').css({'z-index':'1'});
            });
        });
    });
</script>
<style>
    .language{
        font-size: 24px;
        margin:15px 0px;
    }
</style>
<div class='container' style='min-height: 800px;'>
    <h2>СТАТТІ</h2>
    <div class='tests'>
        <div class="row text-center">
            <a href="/info/article1" class='item_block'>
                <div class="item">
                    <div class='image_block' style='background: url("/html/images/articles/poster2.jpg") no-repeat center center; background-size: cover;'></div>
                    <div class='title'>Що таке рівні володіння мовою?</div>
                    <div class='description'></div>
                </div>
            </a>

            <a href="/info/article2" class='item_block'>
                <div class="item">
                    <div class='image_block' style='background: url("/html/images/articles/poster1.jpg") no-repeat center center; background-size: cover;'></div>
                    <div class='title'>Тонкощі польської мови</div>
                    <div class='description'></div>
                </div>
            </a>

        </div>
    </div>    
</div>