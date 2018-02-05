$('document').ready(function(){
    var stop_events = false;
    var carusel_interval = null;

    function setActiveIndicator(index){
        $('.carousel-indicators li').removeClass('active');
        $('.carousel-indicators li[data-slide-to='+index+']').addClass('active');
    }

    $('.carousel-indicators').on('click','li:not(.active)',function(){            
        if(stop_events == true) return false;
        stop_events = true;
        reinitTimeout();
        nextSlider($(this).attr('data-slide-to'));
        return false;
    });

    function nextSlider(index){
        var width = $('.carousel-inner').width();

        if(!index){
            if($('.carousel_custom .item.active').next('.item').length > 0){
                var next = $('.carousel_custom .item.active').next('.item');
            }else{
                var next = $('.carousel_custom .item').eq(0);
            }
        }else{
            var next = $('.carousel_custom .item').eq(index);
        }

        $(next).css({'left':'100%'}).addClass('next');


        $('.carousel_custom .item.active').animate({'left':'-'+width+'px'},800,function(){
            $('.carousel_custom .item').removeClass('active');
            $(next).addClass('active').removeClass('next');
            stop_events = false;
        });
        $('.carousel_custom .item.next').animate({'left':'-0px'},800);

        setActiveIndicator($(next).index());
    }

    function prevSlider(){
        var width = $('.carousel-inner').width();

        if($('.carousel_custom .item.active').prev('.item').length > 0){
            var prev = $('.carousel_custom .item.active').prev('.item');
        }else{
            var prev = $('.carousel_custom .item').last();
        }

        $(prev).css({'left':'-100%'}).addClass('prev');

        $('.carousel_custom .item.active').animate({'left':width+'px'},800,function(){
            $('.carousel_custom .item').removeClass('active');
            $(prev).addClass('active').removeClass('prev');
            stop_events = false;
        });

        $('.carousel_custom .item.prev').animate({'left':'0px'},800);            

        setActiveIndicator($(prev).index());
    }

    var reinitTimeout = function(){
        clearTimeout(carusel_interval);

        carusel_interval = setTimeout(function(){
            if(stop_events == true){
                reinitTimeout();
                return false;
            }
            stop_events = true;
            nextSlider();
            reinitTimeout();
        },5000);
    }
    reinitTimeout();

    $('.carousel_custom .item.active').mouseenter(function(){
        clearTimeout(carusel_interval);
    });
    $('.carousel_custom .item.active').mouseleave(function(){
        reinitTimeout();
    });


    $('.carousel-control.right').click(function(){
        if(stop_events == true) return false;

        stop_events = true;
        reinitTimeout();
        nextSlider();

        return false;
    });

    $('.carousel-control.left').click(function(){
        if(stop_events == true) return false;
        stop_events = true;
        reinitTimeout();

        prevSlider();

        return false;
    });
});