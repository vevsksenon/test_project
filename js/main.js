function post_q(url,data,callback) {
    $.ajax({
        url: "https://game-time.xyz/API/"+url,
        data:{su:id,sa:au},
        success: function(answ){
            try{
                answ = JSON.parse(answ);
            }catch (e){
                setAlert("Ошибка связи с сервером - пожалуйста обновите страницу");
                return;
            }
            if(answ.status == 'success'){
                callback(answ);
            }else {
                setAlert("Ошибка с кодом - "+answ.error_code);
            }
        }
    });
}

function setAlert(data) {
    var modal = "<div id='modal_alert'><div class='text'>"+data+"</div></div>";
    $("#modal_err").html(modal);
}