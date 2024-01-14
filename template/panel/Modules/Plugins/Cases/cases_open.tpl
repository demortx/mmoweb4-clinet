<div class="content content-full gamepage">
    <div class="d-flex pt-15">
    </div>
    {*<div class="ghead">
        <div class="ghead__title">ЗИМНИЙ ИВЕНТ</div>
        <div class="ghead__desc">-30% НА ВСЕ КЕЙСЫ
        </div>
    </div>*}
    <div class="game mt-15">
        <div class="game__header">
            <div class="game__ttl ttl">{$item.name}</div>
            <div class="game__control">
                <div class="sound" data-game-sound="true"></div>
            </div>
        </div>
        <div class="game__container">

            <script>
                var game = {
                    /* Все кейсы которые можно выиграть */
                    items: {$.php.json_encode($item.items)},
                    /* Стили которые будут рандомно добавляться к кейсу */
                    styles: [
                        'itm_style_0',
                        'itm_style_1',
                        'itm_style_2',
                        'itm_style_3',
                        'itm_style_4',
                    ],
                    /* сюда будет записан выиграшный кейс и его содержимое */
                    win: {
                        item: {},
                        items: []
                    },
                    module_form: '{$module_form}',
                    module: '{$module}',
                    cases_id: '{$item.id}',
                    /* Папка со звуками */
                    urlSounds: '{$.const.VIEWPATH}/panel/assets/game/sounds/'
                }

            </script>

            <div class="game__list" style="left: 0px;" data-game-list>
                <!-- Сюда вставляются кейсы -->
            </div>
        </div>
        <div class="game__marker marker">
            <div class="marker__box marker__box_left"></div>
            <div class="marker__pointer"></div>
            <div class="marker__box marker__box_right"></div>
        </div>
        <div class="game__control">
            <div class="gbtn gbtn_decor_1" data-game-start>
                <img src="{$.const.VIEWPATH}/panel/assets/game/images/gbtn/ico-1.svg" alt="" class="gbtn__ico gbtn__ico_mr">
                {set $sale = $.php.get_cases_sale($item.sale_id)}
                {if $sale.status}
                    {if $sale.sale_ma == false}{set $sale_ma = false}{/if}
                    <div class="btn__content">{$open_cases} {$.php.percentage($item.price, $sale.sale + $sale_ma)} {$payment_system.short_name_valute}</div>
                {else}
                    <div class="btn__content">{$open_cases} {$.php.percentage($item.price, $sale_ma)} {$payment_system.short_name_valute}</div>
                {/if}
            </div>
        </div>
        <div class="cases">
            <div class="cases__ttl ttl">{$cases_items}</div>
            <div class="cases__list">
                {foreach $item.items as $i}
                <a href="#" class="cases__case case">
                    <div class="case__pic">
                        <img src="{$i.img}" alt="" class="case__img">
                    </div>
                    <div class="case__title">{$i.name}</div>
                    <div class="case__content">{$i.desc}</div>
                    {if $i.count>1}<div class="case__type">x{$i.count}</div>{/if}
                </a>
                {/foreach}
            </div> <!-- END cases__list  -->
        </div> <!-- END cases  -->
    </div> <!-- END game  -->

    <div class="inf mt-15">
        <div class="inf__title">{$info_title}</div>
        <div class="inf__content">{$info_desc}</div>
    </div>

    {$.site._SEO->addTegHTML('head', 'game_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/game/css/style.css?v1'])}
    {$.site._SEO->addTegHTML('footer', 'popper.min', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/popper.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'tippy-bundle', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/tippy-bundle.iife.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'game-app', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/js/app.js?v17'])}
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            jQuery(function(){ Codebase.helpers('content-filter'); });
        });
    </script>

</div>