{$.site._SEO->addTegHTML('footer', 'timeradd', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.plugin.min.js'])}
{$.site._SEO->addTegHTML('footer', 'timer_main', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown.min.js'])}
{if $.site._LANG != 'en' AND $.php.file_exists($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js')}
    {$.site._SEO->addTegHTML('footer', 'timer_lang', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js'])}
{/if}
{$.site._SEO->addTegHTML('head', 'shop_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/css/shop.css?v=' ~ filemtime($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/css/shop.css')])}
{$.site._SEO->addTegHTML('head', 'og:image', 'meta',     ['property'=>'og:image', 'content'=> $item.img])}
{$.site._SEO->addTegHTML('head', 'og:image:alt', 'meta', ['property'=>'og:image:alt', 'content'=> $item.name])}

<div class="my-10 text-center">
    <h2 class="font-w700 text-black mb-10">{$item.name}</h2>
    <h3 class="h5 text-muted mb-0">{$.php.get_sid_name(false, true)}</h3>
</div>

<form>
    {set $sale_ma = 0}
    {set $sale = $.php.get_shop_sale($item.sale_id)}
    <div class="row">

        <div class="col-md-8">
            <div class="block block-rounded p-20">
                {if $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Plugins/Shop/service/custom/widget_{$tpl_enrollment}.tpl")}
                    {include "/panel/Modules/Plugins/Shop/service/custom/widget_{$tpl_enrollment}.tpl"}
                {elseif $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Plugins/Shop/service/widget_{$tpl_enrollment}.tpl")}
                    {include "/panel/Modules/Plugins/Shop/service/widget_{$tpl_enrollment}.tpl"}
                {/if}

                {if $item.start_enable == 1 AND $.php.strtotime($item.start_sell) > $.php.time()}
                    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                        {$shop_item_no_start} {$item.start_sell|date_format:"%Y-%m-%d %H:%M"}!
                    </p>
                {elseif $item.end_enable == 1 AND $.php.strtotime($item.end_sell) < $.php.time()}
                    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                        {$shop_item_end}
                    </p>
                {else}
                    <div class="block">
                        <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#ma">{$lang_trans_game}</a>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="ma" role="tabpanel">
                                <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                    {$service_no_auth}
                                </p>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        </div>

        <div class="col-md-4">
            <div class="block block-rounded ribbon ribbon-bookmark ribbon-left ribbon-warning">
                {if $sale.status}{$sale.time_ribbon}{/if}
                <div class="pt-10 shop-img-wrp">
                    <img class="shop-img" src="{$item.img}" alt="{$item.name}">
                </div>
                <div class="block-content block-content-full shop-price text-center">
                    <div class="font-w600">
                        {if $sale.status}
                            {if $item.complect == 0}{$price_from} {/if}{$.php.percentage($item.price, $sale.sale)} {$payment_system.short_name_valute}
                            <br>
                            <small>
                                <del class="" style="color: rgb(146, 146, 146);">
                                    {if $item.complect == 0}{$price_from} {/if}{$item.price} {$payment_system.short_name_valute}
                                </del>
                            </small>
                            <span class="badge badge-sale ml-1" title="{$lang_label_sale} {$sale.name}">-{$sale.sale}%</span>

                        {else}
                            {$price_from} {$item.price} {$payment_system.short_name_valute}
                        {/if}

                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <div class="font-size-sm text-muted">{$lang_item_desc}</div>
                </div>
                {if $item.html?}
                    <div class="p-20">
                        {$item.html}
                    </div>
                {/if}
            </div>
        </div>

    </div>

</form>



<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        $(document).ready(function(){


            $('body').on('change', '[data-price]', function (e) {
                let this__ = $(this);
                let key = this__.attr('data-apiece');
                if (key) {
                    if (this__.is(':checked')) {
                        $('[data-apiece-count="' + key + '"]').prop('disabled', false).val(1);
                    } else {
                        $('[data-apiece-count="' + key + '"]').prop('disabled', true).val(0);
                    }
                }
                total_sum();
            });

            function total_sum(){
                let item_list = $('[data-price]:checked');
                let sum = 0;
                item_list.each(function( i, e ) {
                    let element = $(e);
                    let key = element.attr("data-apiece");
                    if (key){
                        let count = $('[data-apiece-count="' + key + '"]').val();
                        sum += parseFloat(element.attr('data-price')) * parseFloat(count);
                    }else{
                        sum += parseFloat(element.attr('data-price'));
                    }
                });
                $('[data-total-price]').html( sum.toFixed(2) + " {$payment_system.short_name_valute}");
            }

        });
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