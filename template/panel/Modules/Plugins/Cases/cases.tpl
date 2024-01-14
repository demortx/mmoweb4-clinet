<div class="content content-full gamepage">
    <div class="d-flex pt-15">
    </div>
    {*<div class="ghead mb-15">
        <div class="ghead__title">ЗИМНИЙ ИВЕНТ</div>
        <div class="ghead__desc">-30% НА ВСЕ КЕЙСЫ
        </div>
    </div>*}

    {if $shops == false}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$items_not_cfg} {$.php.get_sid_name()}
    </p>
    {else}
    <div class="game mt-15">
        <div class="game__boxes boxes js-filter">
            <div class="boxes__ttl ttl">{$title_select_cases}</div>
            <div class="boxes__sorting sorting">
                <a class="sorting__item" data-category-link="all">{$title_tab_all}</a>

                {foreach $categorys as $cat}
                    {if $.php.in_array($.site._LANG, $cat.lang)}
                        <a class="sorting__item" href="#" data-category-link="cat_{$cat.id}">{$cat.name}</a>
                    {/if}
                {/foreach}
            </div>
            <div class="boxes__list">
                {foreach $shops as $shop}
                    {if $categorys[$shop.category]! AND $.php.in_array($.site._LANG, $categorys[$shop.category]['lang'])}
                        <a href="{$.php.set_url('panel/cases/'~$.php.prepareStringForUrl($shop.name)~'.'~$shop.id)}" class="boxes__box box box_style_{$.php.rand(0,9)}" data-category="cat_{$shop.category}" data-tlt>
                            {set $sale = $.php.get_cases_sale($shop.sale_id)}
                            <div class="box__inner">
                                {if $sale.status}{$sale.time_ribbon}{/if}
                                <div class="box__pic">
                                    <img src="{$shop.img}" alt="" class="box__img">
                                </div>
                                <div class="box__title">{$shop.name}</div>
                                <div class="box__price">
                                    {if $sale.status}
                                        {if $sale.sale_ma == false}{set $sale_ma = false}{/if}
                                        <div class="box__price-new">{$.php.percentage($shop.price, $sale.sale + $sale_ma)} {$payment_system.short_name_valute}</div>
                                        <div class="box__price-old">{if $shop.complect == 0}{$price_from} {/if}{$shop.price} {$payment_system.short_name_valute}</div>
                                    {else}
                                        <div class="box__price-new">{$.php.percentage($shop.price, $sale_ma)} {$payment_system.short_name_valute}</div>
                                    {/if}
                                </div>
                            </div>
                            <div data-tlt-content="" style="display: none;">
                                <div class="tlt">
                                    {foreach $shop.items as $i}
                                    <div class="box__prize prize">
                                        {$.php.set_item($i.id, false, false, '<div class="prize__pic pic-style-0"><img src="%icon%" class="prize__img"></div><div class="prize__content">%name% %add_name%</div>')}
                                    </div>
                                    {/foreach}
                                </div>
                            </div>
                        </a> <!-- END box  -->
                    {/if}
                {/foreach}
            </div> <!-- END boxes__list  -->
        </div> <!-- END boxes  -->
    </div> <!-- END game  -->
    <div class="inf mt-15">
        <div class="inf__title">{$info_title}</div>
        <div class="inf__content">{$info_desc}</div>
    </div>
    {$.site._SEO->addTegHTML('footer', 'timeradd', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.plugin.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'timer_main', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown.min.js'])}
    {if $.site._LANG != 'en' AND $.php.file_exists($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js')}
        {$.site._SEO->addTegHTML('footer', 'timer_lang', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js'])}
    {/if}
    {$.site._SEO->addTegHTML('head', 'game_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/game/css/style.css?v1'])}
    {$.site._SEO->addTegHTML('footer', 'popper.min', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/popper.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'tippy-bundle', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/tippy-bundle.iife.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'game-app', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/js/app.js?v11'])}
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            jQuery(function(){ Codebase.helpers('content-filter'); });
            {ignore}
            $("[data-sale-timer]").each(function(indx, element){
                const __this = $(this);
                let austDay = new Date(__this.attr('data-sale-timer') * 1000);
                let layout = '{dn} {dl} {hnn}{sep}{mnn}{sep}{snn}';
                if(parseInt(__this.attr('data-sale-date')) === 0 ) {
                    layout = '{hnn}{sep}{mnn}{sep}{snn}'
                }
                __this.countdown({
                    until: austDay,
                    layout: layout,
                });
            });
            {/ignore}
        });
    </script>
    {/if}
</div>