
function Menu() {
    this.menu = ('div.panel_container');
    this.gold = null;
}

Menu.prototype.Init = function (id,au) {
    var obj = this;

    var data = {su:id,sa:au};

    post_q('opengame',data,function (answ) {

        $('#load_overflow').animate({'width' : '50%'}, 1000,function () {

        });

        obj.updateMenu(answ);

        $('.energy_lost').click(function () {
            post_q('energylost',data,function (data) {
                obj.updateMenu(data);
            });
        });
        $('.user_data').click(function () {
            post_q('user',data,function (data) {
                obj.updateMenu(data);
            });
        });
        $('.update_energy_max').click(function () {
            post_q('energymax',data,function (data) {
                obj.updateMenu(data);
            });
        });
        $('.update_energy_speed').click(function () {
            post_q('energyspeed',data,function (data) {
                obj.updateMenu(data);
            });
        });

        obj.EnergyTimer = setInterval(function () {
            time_client = new Date().getTime()/1000;
            time_client = parseInt(time_client);
            time_client_to_server = time_client+time_delta;
            razn = time_client_to_server - time_last_update;
            count_energy = parseInt(razn/sec_per_energy);
            razn_timer = razn%sec_per_energy;
            razn_timer = sec_per_energy-razn_timer;
            if(count_energy >= max_energy){
                count_energy = max_energy;
                razn_timer = 0;
            }
            $('.energy_val').text(count_energy+"/"+max_energy);
            if(razn_timer > 0){
                var sec = razn_timer%60;
                if(sec < 10){
                    sec = "0"+sec;
                }
                var min = parseInt(razn_timer/60);
                if(min < 10){
                    min = "0"+min;
                }

                $('.timer_energy_val').text(min+":"+sec);
            }else{
                $('.timer_energy_val').text("");
            }
        },1000);

        $('#load_overflow').animate({'width' : '100%'}, 1000,function () {
            $("#load_fon").hide();
        });
    });

}

Menu.prototype.updateMenu = function (answ) {
    time_server = new Date(answ.time).getTime() / 1000;
    time_last_update = new Date(answ.user_data.last_update_energy).getTime() / 1000;

    time_client = new Date().getTime()/1000;
    time_client = parseInt(time_client);

    time_delta = time_server-time_client;

    max_energy = answ.user_data.max_energy_val;
    sec_per_energy = answ.user_data.seconds_per_energy_val;

    $('.lvl_val').text(answ.user_data.user_lvl);
    $('.money_val').text(answ.user_data.money);
    $('.mineral_val').text(answ.user_data.mineral);
    $('.cristal_val').text(answ.user_data.cristal);
    $('.experience_val').text(answ.user_data.experience);
}