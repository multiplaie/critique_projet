$(document).ready(function(){
    var word_state = 0;
    var step = 5;
    var max_state = 255;
    var min_state = 0;
    var default_state = 127;
    var form_enabled = true;

    function changeWordState(){
        $("#critique .word").css('color', 'rgb('+word_state+','+word_state+','+word_state+')');
    }

    function init(){
        getWordStateSaved();
        checkIpExist();

    }

    function getWordStateSaved(){
        $.getJSON({
            type: "POST",
            url: "Database.php",
            data:{action:"getWordStateSaved"},
            success: function(data){

                setWordState(data.result);
                changeWordState();

            }
        });
    }

    function setWordState(value){
        word_state = value;
    }

    function increaseState(){
        if (form_enabled) {
            if (word_state + step > max_state) {
                word_state = max_state;
            }else{
                word_state += step;
            }
        }
    }

    function decreaseState(){
        if (form_enabled) {
            if (word_state - step < min_state) {
                word_state = min_state;
            }else{
                word_state -= step;
            }
        }
    }

    function disabledForm(){
        form_enabled = false;
        $("#critique").addClass('disabled');
    }

    function checkIpExist(){
        $.getJSON('//freegeoip.net/json/?callback=?', function(json){
            $.getJSON({
                type: "POST",
                url: "Database.php",
                data:{data:{ip:json.ip}, action:'checkIpExist'},
                success: function(data){
                    if (data.ip != "0.0.0.0") {
                        disabledForm();
                    };
                }
            });
        });
    }

    function saveVote(answer){
        if (form_enabled) {
            $.getJSON('//freegeoip.net/json/?callback=?', function(json){
                $.ajax({
                    type: "POST",
                    url: "Database.php",
                    data:{data:{geo:json, answer:answer}, action:'insertNewAnswer'},
                    success: function(){
                        disabledForm();
                    }
                });
            });
        }
    }

    $("#critique .btn").bind("click", function(e){
        e.preventDefault();
        var answer = $(this).attr('data-value');
        if (answer == 1) {
            increaseState();
        }else{
            decreaseState();
        }
        changeWordState();
        saveVote(answer);
    });

    init();
});
