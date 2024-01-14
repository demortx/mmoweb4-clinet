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
    {$.php.form_hide_input("Modules\Plugins\Shop\Shop", "ajax_buy_shop")}
    <input type="hidden" name="shop_id" value="{$item.id}">
    <input type="hidden" id="type_buy" name="type_buy" value="#ma">
    {set $sale = $.php.get_shop_sale($item.sale_id)}
    {if $sale.sale_ma == false}{set $sale_ma = false}{/if}
    <div class="row">

        <div class="col-md-8">
            <div class="block block-rounded p-20">
               <h3 class="h5 text-muted mb-0 text-center pt-5">{$lang_list_item}</h3>
               <div class="isel-list">
                    <div class="isel isel_header">
                        <div class="isel__checkbox checkbox checkbox_fill">
                            <div class="checkbox__label">
                                <div class="checkbox__content checkbox__content_header isel__heading">{$lang_item_name}</div>
                            </div>
                        </div>
                        <div class="isel__quantity isel__quantity_header isel__heading">
                                {$lang_item_count}
                        </div>
                        {if $item.complect == 0}
                            <div class="isel__price isel__price_header isel__heading">
                                {$lang_item_price} {if $sale.status}
                                    <span class="badge badge-sale ml-1" style="position: absolute;padding: 1px;" title="{$lang_label_sale} {$sale.name}{if $sale_ma > 0} + Master Account{/if}">-{$sale.sale + $sale_ma}%</span>
                                    {elseif $sale_ma > 0}
                                    <span class="badge badge-sale-ma ml-1" style="position: absolute;padding: 1px;" title="{$lang_label_sale} Master Account">-{$sale_ma}%</span>
                                {/if}
                            </div>
                        {/if}
                    </div> <!-- END isel isel_header -->
                   {foreach $item.items as $ids => $it}
                    <div class="isel">
                        <div class="isel__checkbox checkbox checkbox_fill">
                            <label class="checkbox__label">

                                <input type="checkbox" class="checkbox__input"
                                        {if $item.complect == 1}
                                            checked="" disabled
                                        {else}
                                            name="items[{$it.key}][id]" value="{$it.id}"
                                            data-price="{if $sale.status}{$.php.percentage($it.price, $sale.sale + $sale_ma)}{else}{$.php.percentage($it.price, $sale_ma)}{/if}"
                                                {if $it.apiece?}data-apiece="{$it.key}"{/if}
                                        {/if}
                                />
                                <div class="checkbox__block"></div>
                                {$.php.set_item($it.id,false,false,'<img data-item="'~$it.id~'" class="isel__img" src="%icon%" width="27px" data-toggle="popover" data-placement="top" data-content="%description%" data-original-title="%name% %add_name%"><div class="checkbox__content">%name% %add_name%</div>')}
                                {if $it.enc>0}<span class="text-warning mr-5" title="Enchant">+{$it.enc}</span>{/if}
                                {if $it.apiece?}<span class="text-success mr-5" title="Count pack">x{$it.count}</span>{/if}
                            </label>
                        </div>
                        <div class="isel__quantity">
                            {if $it.apiece?}
                                <div class="input-group input_count">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm minus-btn"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="number" class="form-control form-control-sm text-center qty_input isel__qty" data-apiece-count="{$it.key}" name="items[{$it.key}][count]" value="0" min="0" disabled>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm plus-btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            {else}
                                <em class="font-size-sm text-muted">x{$it.count}</em>
                            {/if}
                        </div>
                        {if $item.complect == 0}
                            <div class="isel__price"  title="{$payment_system.short_name_valute}">{if $sale.status}{$.php.percentage($it.price, $sale.sale + $sale_ma)}{else}{$.php.percentage($it.price, $sale_ma)}{/if}</div>
                        {/if}
                    </div> <!-- END isel -->
                   {/foreach}
                   {if $item.complect == 0}
                    <div class="isel isel_footer">
                        <div class="isel__checkbox checkbox checkbox_fill">

                        </div>
                        <div class="isel__quantity isel__quantity_header isel__heading">
                            {$lang_sum_price}
                        </div>
                        <div class="isel__price isel__price_header isel__heading" data-total-price>0.00 {$payment_system.short_name_valute}</div>
                    </div> <!-- END isel isel_header -->
                   {else}
                       <div class="isel isel_footer">
                           <div class="isel__checkbox checkbox checkbox_fill"></div>
                           <div class="isel__quantity isel__quantity_header isel__heading"></div>
                           <div class="isel__price isel__price_header isel__heading"></div>
                       </div> <!-- END isel isel_header -->
                   {/if}
               </div> <!-- END isel-list -->

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
                        <li class="nav-item">
                            <a class="nav-link" href="#warehouse">{$lang_trans_wh}</a>
                        </li>
                        {if $item.broadcast == 1}
                            <li class="nav-item">
                                <a class="nav-link" href="#nick-name">{$lang_trans_nick}</a>
                            </li>
                        {/if}
                    </ul>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="ma" role="tabpanel">
                            {if $.site.session->session.user_data.account['error_exception']?}
                                <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                    {$.site.session->session.user_data.account['error_exception']}
                                </p>
                            {elseif $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                                <div class="form-group row justify-content-center"><div class="col-lg-10"><div class="in-game-message"></div></div></div>

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
                            {else}
                                <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                    {$lang_notfound_account} {$.php.get_sid_name()}
                                </p>
                            {/if}
                        </div>
                        <div class="tab-pane" id="warehouse" role="tabpanel">
                            <p>{$lang_label_wh_desc}</p>

                        </div>
                        {if $item.broadcast == 1}
                            <div class="tab-pane" id="nick-name" role="tabpanel">
                                <div class="form-group" style="margin-bottom: 11px;">
                                    <label for="recipient" id="recipient">{$lang_label_nick}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text type_icon"><i class="fa fa-street-view"></i></span>
                                        </div><input type="text" id="recipient" class="form-control" name="nick_name" placeholder="MegaMag">
                                    </div>
                                </div>
                                <p>{$lang_label_nick_desc}</p>
                            </div>
                        {/if}
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
            $('body').on('click', '.plus-btn', function (e) {
                let qty_input = $(this).parents('.input_count').find('.qty_input');
                qty_input.val(parseInt(qty_input.val()) + 1 );
                if (qty_input.val() == 1) {
                    qty_input.prop('disabled', false);
                    let key = qty_input.attr('data-apiece-count');
                    $('[data-apiece="'+key+'"]').prop("checked", true);
                }
                total_sum();
            });
            $('body').on('click', '.minus-btn', function (e) {
                let qty_input = $(this).parents('.input_count').find('.qty_input');
                qty_input.val(parseInt(qty_input.val()) - 1 );

                if (qty_input.val() == 0) {
                    qty_input.prop('disabled', true);
                    let key = qty_input.attr('data-apiece-count');
                    $('[data-apiece="'+key+'"]').prop("checked", false);
                }else if (qty_input.val() < 0) {
                    qty_input.val(0);
                }
                total_sum();
            });
            $('body').on('keyup change click', '[data-apiece-count]', function (e) {
                let this__ = $(this);
                let key = this__.attr('data-apiece-count');
                let count = this__.val();
                if(count.length == 0){
                    this__.val(0);
                }else if(count <= 0){
                    this__.prop('disabled', true).val(0);
                    $('[data-apiece="'+key+'"]').prop("checked", false);
                }
                total_sum();
            });
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

            $('.nav-tabs').on('click', '.nav-link',function(){
                $('#type_buy').val($(this).attr('href'));
            });
            $('.nav-link.active').click();



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