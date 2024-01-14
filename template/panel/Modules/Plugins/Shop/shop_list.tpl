{$.site._SEO->addTegHTML('footer', 'timeradd', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.plugin.min.js'])}
{$.site._SEO->addTegHTML('footer', 'timer_main', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown.min.js'])}
{if $.site._LANG != 'en' AND $.php.file_exists($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js')}
    {$.site._SEO->addTegHTML('footer', 'timer_lang', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js'])}
{/if}
{$.site._SEO->addTegHTML('head', 'shop_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/css/shop.css?v=' ~ filemtime($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/css/shop.css')])}


<div class="my-10 text-center">
    <h2 class="font-w700 text-black mb-10">{$shop_title}</h2>
    <h3 class="h5 text-muted mb-0">{$.php.get_sid_name(false, true)}</h3>
</div>

{if $.php.count($categorys) AND $.php.count($shops)}

<div class="js-filter" data-numbers="true">
    <div class="p-10 bg-white push">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-category-link="all">
                    {$tab_all}
                </a>
            </li>
            {foreach $categorys as $cat}

                {if $.php.in_array($.site._LANG, $cat.lang)}
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-category-link="cat_{$cat.id}">{$cat.name}</a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>
    <div class="row items-push">
        {foreach $categorys as $cat}
			{foreach $shops as $shop}
				{if $shop.category != $cat.id || !$.php.in_array($.site._LANG, $categorys[$shop.category]['lang'])}
                    {continue}
                {/if}
                <div class="col-md-6 col-lg-4 col-xl-3" data-category="cat_{$shop.category}">
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
                                    {if $sale.sale_ma == false}{set $sale_ma = false}{/if}
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
            {/foreach}
        {/foreach}
    </div>
</div>
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
{else}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$lang_notfound_items} {$.php.get_sid_name()}
    </p>
{/if}