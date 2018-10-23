function post_q(url,data,callback) {
    $.ajax({
        url: "https://game-time.xyz/API/"+url,
        data:{su:id,sa:au},
        success: function(answ){
            try{
                answ = JSON.parse(answ);
            }catch (e){
                alert("Ошибка связи с сервером - пожалуйста обновите страницу");
                return;
            }
            if(answ.status == 'success'){
                callback(answ);
            }else {
                alert("Ошибка с кодом - "+answ.error_code);
            }
        }
    });
}