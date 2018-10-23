<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>Какая то игра</title>

    <link rel="stylesheet" href="/css/main.css">
    <script type="application/javascript" src="/js/jquery.js"></script>
    <script type="application/javascript" src="/js/main.js"></script>
    <script type="application/javascript" src="/js/Menu.js"></script>
    <script src="https://vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script>
    <script>
        /*document.ondragstart = stop;
        document.onselectstart = stop;
        document.oncontextmenu = stop;
        function stop() {return false}*/
    </script>
</head>
<body>
<div id="load_fon">
    <div id="center_fon_block">
        <div id="load_overflow">
            <div id="loading_bar"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        id = "<?=$_GET['viewer_id']?>";
        au = "<?=$_GET['auth_key']?>";
        
        var menu = new Menu();
        menu.Init(id,au);
    })
</script>
<div id="main_container">
    <?
        //var_dump($_GET);
        //пошаговая игра под водой.
        //автобой - но можно смотреть как анимируются выстрелы и удары противников
        //можно ставить оружия (первый слот всегда в приоритете и если не хватает энергии
        //на второй слот то будет аваковать только первый и срабатывать эффекты конца хода
        // такаие как пополнение энергии или щиты если на них хватает энергии
        // Начальный этап (база - ангар с 1 кораблём где можно устанавливать и хранить модули "оружия"
        //,реактор - производит энергию - можно улучшать, склад реакторов -
        // хранит определённое количество реакторов
        // 1 реактор содержит 1 ход или одно нападение на противника (человек или монстр)
        // улучшая реактор увеличивается скорость производства реакторов, склад увеличивает максимальное количество
        // хранимое на базе. Магазин - в нём можно заказать корабли (с разным количеством слотов), оружия для атаки
        // которые тратят энергию и наносят урон, щиты которые тратят энергию и окружают корабль
        // щитом определённой прочности(срабатывает всегда),
        // регенераторы которые тратят энергию и ремонтируют
        // сам корабль(срабатывают только когда у корабля не полная прочность).
        //
        //
        // http://websketches.ru/assets/files/blog/2d_igra_na_unity_pr/player.png - интересная картинка )
        //
        ?>
    <div class="button_container">
        <div class="energy_lost">Потратить энергию</div>
        <div class="user_data">Получить данные пользователя</div>
        <div class="update_energy_max">Увеличить максимальное количество энергии</div>
        <div class="update_energy_speed">Увеличить скорость восстановления энергии</div>
    </div>
    <div class="panel_container">
        <div class="lvl_val"></div>
        <div class="money_val"></div>
        <div class="mineral_val"></div>
        <div class="cristal_val"></div>
        <div class="experience_val"></div>
        <div class="energy_val"></div>
        <div class="timer_energy_val"></div>
    </div>
</div>
</body>
</html>