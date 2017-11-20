$(document).ready(function(){
    var word_state = 0;
    var step = 5;
    var max_state = 255;
    var min_state = 0;
    var default_state = 127;

    function changeWordState(){
        $("#critique .word").css('color', 'rgb('+word_state+','+word_state+','+word_state+')');
    }

    function init(){
        word_state = 127;
        changeWordState();
    }

    function increaseState(){
        if (word_state + step > max_state) {
            word_state = max_state;
        }else{
            word_state += step;
        }
    }

    function decreaseState(){
        if (word_state - step < min_state) {
            word_state = min_state;
        }else{
            word_state -= step;
        }
    }

    $("#critique .btn").bind("click", function(e){
        e.preventDefault();
        var action = $(this).attr('data-value');
        if (action == 1) {
            increaseState();
        }else{
            decreaseState();
        }
        changeWordState();
    });

    init();
});
