{if $.php.count($categorys) AND $.php.count($shops)}
    {$.site._SEO->addTegHTML('head', 'slick_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick.css'])}
    {$.site._SEO->addTegHTML('head', 'slick_theme', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick-theme.css'])}

    {$.site._SEO->addTegHTML('footer', 'timeradd', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.plugin.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'timer_main', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown.min.js'])}
    {if $.site._LANG != 'en' AND $.php.file_exists($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js')}
        {$.site._SEO->addTegHTML('footer', 'timer_lang', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js'])}
    {/if}
    {$.site._SEO->addTegHTML('head', 'shop_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/css/shop.css?v=' ~ filemtime($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/css/shop.css')])}


    <div class="row items-push js-slider" data-dots="true" data-autoplay="true" data-autoplay-speed="2000">
    {foreach $shops as $shop}
        {if $categorys[$shop.category]! AND $.php.in_array($.site._LANG, $categorys[$shop.category]['lang'])}
            <div class="col-md-6 col-lg-4 col-xl-3  animated fadeIn" data-category="cat_{$shop.category}">
                {set $sale = $.php.get_shop_sale($shop.sale_id)}

                <a class="block block-link-shadow block-rounded ribbon ribbon-bookmark ribbon-left ribbon-warning text-center shop-item" href="{$.php.set_url('panel/shop/'~$.php.prepareStringForUrl($shop.name)~'.'~$shop.id)}">
                    {if $sale.status}{$sale.time_ribbon}{/if}
                    <div class="shop-img-wrp">
                        <img class="shop-img" src="{$shop.img}">
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light shop-name">
                        <div class="font-size-sm text-muted">{$shop.name}</div>
                    </div>
                    <div class="block-content block-content-full shop-price">
                        <div class="font-w600">
                            {if $sale.status}
                                {if $shop.complect == 0}{$price_from} {/if}{$.php.percentage($shop.price, $sale.sale + $sale_ma)} {$payment_system.short_name_valute}
                                <br>
                                <small><del class="" style="color: rgb(146, 146, 146);">
                                        {if $shop.complect == 0}{$price_from} {/if}{$shop.price} {$payment_system.short_name_valute}
                                    </del></small>
                            {else}
                                {if $shop.complect == 0}{$price_from} {/if}{$.php.percentage($shop.price, $sale_ma)} {$payment_system.short_name_valute}
                            {/if}
                        </div>
                    </div>
                </a>
            </div>
        {/if}
    {/foreach}
    </div>

    {$.site._SEO->addTegHTML('footer', 'slick_js', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick.min.js'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        jQuery(function(){ Codebase.helpers('content-filter'); });
        jQuery(function(){ Codebase.helpers('slick'); });
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


