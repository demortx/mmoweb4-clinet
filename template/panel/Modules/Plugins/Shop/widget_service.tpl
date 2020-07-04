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

<form action="/input"  method="post" onsubmit="return false;">
    {$.php.form_hide_input("Modules\Plugins\Shop\Shop", "ajax_buy_service")}
    <input type="hidden" name="shop_id" value="{$item.id}">
    <input type="hidden" id="type_buy" name="type_buy" value="#ma">
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
                            {if $.site.session->session.user_data.account['error_exception']?}
                                <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                    {$.site.session->session.user_data.account['error_exception']}
                                </p>
                            {elseif $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                                <div class="form-group row justify-content-center"><div class="col-lg-10"><div class="in-game-message"></div></div></div>

                                {if $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Plugins/Shop/service/custom/widget_{$tpl_enrollment}_enroll.tpl")}
                                    {include "/panel/Modules/Plugins/Shop/service/custom/widget_{$tpl_enrollment}_enroll.tpl"}
                                {elseif $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Plugins/Shop/service/widget_{$tpl_enrollment}_enroll.tpl")}
                                    {include "/panel/Modules/Plugins/Shop/service/widget_{$tpl_enrollment}_enroll.tpl"}
                                {else}
                                    <div class="form-group row justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <select id="account_name_in_game" name="account_name" class="form-control" size="1">
                                                    <option value="0">{$lang_select_account}</option>
                                                    {foreach $.site.session->session.user_data.account as $login => $info}
                                                        <option value="{$login}">{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({count($info.char_list)}){/if}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row justify-content-center char_name_div">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-street-view"></i></span>
                                                </div>
                                                <select id="char_name_in_game" name="char_name" class="form-control" size="1" disabled>
                                                    <option value="0">{$lang_select_char}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function (event) {
                                            $(document).ready(function(){
                                                $('body').on('change', '#account_name_in_game', function (e) {
                                                    let char_list = JSON.parse('{json_encode($char_list)}');
                                                    let account_id = $(this).val();
                                                    let char_name_in_game = $('#char_name_in_game');

                                                    if (account_id != '0') {
                                                        char_name_in_game.find('option').remove().end().prop('disabled', true);
                                                        if (char_list[account_id].length !== 0) {

                                                            $.each(char_list[account_id], function (char_id, name) {
                                                                char_name_in_game.append('<option value="' + name + '" >' + name + '</option>');
                                                            });
                                                            char_name_in_game.prop('disabled', false);
                                                        } else {
                                                            char_name_in_game.append('<option value="0">{$lang_select_char_not_found}</option>');
                                                        }
                                                    } else {
                                                        char_name_in_game.prop('disabled', true);
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                {/if}


                            {else}
                                <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                    {$lang_notfound_account} {$.php.get_sid_name()}
                                </p>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-sm block-content-full bg-body-light text-center mt-20">
                    <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-money mr-5"></i> {$lang_btn_buy}</button>
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
                            {if $item.complect == 0}{$price_from} {/if}{$.php.percentage($item.price, $sale.sale + $sale_ma)} {$payment_system.short_name_valute}
                            <br>
                            <small>
                                <del class="" style="color: rgb(146, 146, 146);">
                                    {if $item.complect == 0}{$price_from} {/if}{$item.price} {$payment_system.short_name_valute}
                                </del>
                            </small>
                            <span class="badge badge-sale ml-1" title="{$lang_label_sale} {$sale.name}">-{$sale.sale}%</span>

                        {else}
                            {$price_from} {$.php.percentage($item.price, $sale_ma)} {$payment_system.short_name_valute}
                        {/if}

                        {if $sale_ma > 0}
                            <span class="badge badge-sale-ma ml-1" title="{$lang_label_sale} Master Account">-{$sale_ma}%</span>
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