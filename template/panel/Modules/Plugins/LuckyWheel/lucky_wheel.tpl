<div class="content content-full gamepage">
    <div class="d-flex pt-15">
    </div>

    {if $items == false}
        <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
            {$items_not_cfg} {$.php.get_sid_name()}
        </p>
    {else}
    <div class="wh mt-10">
        <div class="bprize" data-bprize="hidden">
            <div class="bprize__inner">
                <div class="bprize__title">{$win_title}</div>
                <div data-bprize-container></div>

                <div class="bprize__btn" data-bprize-more>{$next_game}</div>
            </div>
        </div>
        <div class="wh__history history">
            <div class="ttl text-white mb-10">{$history_title}</div>
            <div class="history__container" data-scroll>

                <!-- Блок для показа выиграных итемов НАЧАЛО -->
                <div class="history__box history__box_hidden" data-history-now>
                    <div class="history__date-box">
                        <span class="history__date">{$history_now}</span>
                    </div>
                    <div class="history__list">

                    </div> <!-- END  history__list -->
                </div> <!-- END  history__box -->
                <div class="history_loud">
                <button type="button" class="gbtn gbtn_size_small gbtn_without_accent submit-btn" {$.php.btn_ajax("Modules\Plugins\LuckyWheel\LuckyWheel", "ajax_get_history")}>{$history_loud}</button>
                </div>

            </div> <!-- END  history__container -->
        </div> <!-- END  history -->
        <div class="wh__gamef gamef">
            <div class="ttl mb-10">{$balance_title}</div>
            <div class="gamef__balance mb-20">
                <div class="gamef__gbal gbal" data-bprize-price-container>
                    <div class="gbal__num" data-bprize-price>{$price}</div>
                    <div class="gbal__content">{$price_title} ({$.site.session->config.payment_system.short_name_valute})</div>
                </div>
                {if $max_price_spin > 0}
                <div class="gamef__gbal gbal gbal_color" data-bprize-paid-container data-bprize-paid-msg="{$paid_msg}">
                    <div class="gbal__num" data-bprize-paid-count>0</div>
                    <div class="gbal__content">{$paid_content}</div>
                </div>
                {/if}
                {if $free_spin > 0}
                <div class="gamef__gbal gbal gbal_color" data-bprize-free-container data-bprize-free-msg="{$free_msg}">
                    <div class="gbal__num" data-bprize-free-count>0</div>
                    <div class="gbal__content">{$free_content}</div>
                </div>
                {/if}
            </div>
            <div class="gamef__btns">
                <a href="{$.php.set_url('panel/donations')}" class="gbt mb-10">
                    <img src="{$.const.VIEWPATH}/panel/assets/game/images/gbt/dollar.svg" class="gbt__ico">
                    <span class="gbt__content">{$balance_up}</span>
                </a>
                {*<a href="#" class="gbt">
                    <img src="{$.const.VIEWPATH}/panel/assets/game/images/gbt/code.svg" class="gbt__ico">
                    <span class="gbt__content">Ввести промокод</span>
                </a>*}
            </div>
            {if $.php.intval($.site.session->session.user_data.balance / $price) > 0}
            <div class="gamef__control">
                <div class="gbtn gbtn_decor_2" data-wheel-start>
                    <img src="{$.const.VIEWPATH}/panel/assets/game/images/gbtn/ico-2.svg" alt="" class="gbtn__ico gbtn__ico_mr">
                    <div class="btn__content">{$start_game}</div>
                </div>
            </div>
            {/if}
        </div>
        <script>
            var wheel = {
                /* Все кейсы которые можно выиграть */
                items: {$.php.json_encode($items)},
                /* Итемы которые будут отображены в колесе */
                itemsStorage: [],
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
                    item: { },
                },
                module_form: '{$module_form}',
                module: '{$module}',
                /* Папка со звуками */
                urlSounds: '{$.const.VIEWPATH}/panel/assets/game/sounds/',
                price: "{$price}",
               
                info: {if $max_price_spin > 0 || $free_spin > 0}
                    {
                        {if $max_price_spin > 0 }
                        /* Платные прокрутки */
                        paid: {
                            count: {if $max_price_spin > 0}{$.site.session->session.user_data.lucky_wheel.paid.count} {else}
                            0 {/if},
                            date: {if $max_price_spin > 0}"{$.site.session->session.user_data.lucky_wheel.paid.date}" {else}
                            "" {/if},
                        },
                        {/if}
                        {if $free_spin > 0 }
                        /* Бесплатные прокрутки */
                        free: {
                            count: {if $free_spin > 0} {$.site.session->session.user_data.lucky_wheel.free.count} {else}
                            0 {/if},
                            date: {if $free_spin > 0} "{$.site.session->session.user_data.lucky_wheel.free.date}" {else}
                            "" {/if},
                        },
                        {/if}
                    }
                    {else} false {/if}

            }

        </script>
        <div class="wh__wheel wheel">
            <div class="wheel__arrow"></div>
            <div class="wheel__sound sound" data-game-sound="true"></div>
            <div class="wheel__box" data-wheel-box>
                <div class="wheel__list" data-wheel-list="">
                    <!-- Сюда вставляются кейсы -->
                </div>
            </div>
        </div>
    </div>
    <div class="inf mt-15">
        <div class="inf__title">{$info_title}</div>
        <div class="inf__content">{$info_desc}</div>
        <br>
        <div class="inf__title">{$info_prize}</div>
        <div class="cases">
            <div class="cases__list">
                {foreach $items as $i}

                <a href="javascript:void(0);" class="cases__case case">
                    <div class="case__pic">
                        <img src="{$i.img}" alt="{$i.name}" class="case__img">
                    </div>
                    <div class="case__title">{$i.name} {if $i.enc > 0}<span class="text-warning">+{$i.enc}</span>{/if}</div>
                    <div class="case__type">x{$i.count}</div>
                </a>
                {/foreach}

            </div> <!-- END cases__list  -->
        </div>



    </div>
    <!-- game resources -->
    
    
    {$.site._SEO->addTegHTML('head', 'game_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/game/css/style.css?v46'])}
    {$.site._SEO->addTegHTML('footer', 'popper.min', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/popper.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'tippy-bundle', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/tippy-bundle.iife.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'game-app', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/js/app.js?v46'])}
    {/if}
</div>