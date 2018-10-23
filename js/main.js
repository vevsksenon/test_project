function post_q(url,data,callback) {
    $.ajax({
        url: "https://game-time.xyz/API/"+url,
        data:{su:id,sa:au},
        success: function(answ){
            try{
                answ = JSON.parse(answ);
            }catch (e){
                setAlert("Ошибка связи с сервером - пожалуйста обновите страницу",true);
                return;
            }
            if(answ.status == 'success'){
                callback(answ);
            }else {
                setAlert("Ошибка с кодом - "+answ.error_code,false);
            }
        }
    });
}

function setAlert(data,fatal) {
    var modal = "<div id='modal_alert'><div class='close_modal'>+</div><p class='text'>"+data+"</p></div>";
    if(fatal){
        $('body').html(modal);
    }else{
        $("#modal_err").html(modal).show();
        $("#modal_err .close_modal").click(function () {
            $("#modal_err").hide().empty();
        })
    }
}