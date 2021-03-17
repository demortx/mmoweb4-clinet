{$.php.form_hide_input("Modules\Lineage2\Market\Market", "ajax_buy_shop")}
<input type="hidden" name="id" value="{$item_id}">

<div class="row">
    <div class="col-lg-12 text-center">
        {if $item.type == '3'}
            <div id="product-image mb" class="mb-3">
                {$item.char_info.name}
                <br>
                <small>{$.php.get_class_name($item.char_info.class_id)} (Lv. {$item.char_info.level})</small>
            </div>
        {else}
            <div id="product-image" class="mb-3">
                <img {$.php.get_icon_item($item.icon,$item.icon_panel, $sid)}> {$item.name}
            </div>
            {if $item.description?}
            <footer class="blockquote-footer mb-3">{$item.description}</footer>
            {/if}
        {/if}
        <table class="table table-borderless table-striped table-vcenter">
            {if $items_all != null}
                <tr>
                    <td style="width: 30%" class="text-right"><b>{$ajax_buy_shop_contains}</b></td>
                    <td class="text-left">
                        {foreach $items_all as $item_}
                            <div><img width="16px" {$.php.get_icon_item($item_.icon,$item_.icon_panel, $sid)}> {$item_.name} x{$item_.count}</div>
                        {/foreach}
                    </td>
                </tr>
            {/if}
            {if $item.enc > 0}
                <tr>
                    <td style="width: 30%" class="text-right"><b>{$ajax_buy_shop_enchant}</b></td><td class="text-left">+{$item.enc}</td>
                </tr>
            {/if}
            {if $items_all == null && $item.type != "3"}
                <tr>
                    <td style="width: 30%" class="text-right"><b>{$ajax_buy_shop_amount}</b></td><td class="text-left">{$.php.number_format($item.count, 0, ',', ',')}</td>
                </tr>
            {/if}
            {if $item.count > 1}
                <tr>
                    <td style="width: 30%" class="text-right"><b>{$ajax_buy_shop_get}</b></td><td class="text-left"><span class="price-multiplier" data-value="{$step}">{$.php.number_format($step, 0, ',', ',')}</span></td>
                </tr>
            {/if}
            <tr>
                <td style="width: 30%" class="text-right"><b>{$ajax_buy_shop_price}</b>
                </td>

                <td class="text-left">{$package_price}{if $item.type == 1} <code>{$widget_sell_sell_type_1}</code> {else}{if $step} {$ajax_buy_shop_for} {$.php.number_format($step, 0, ',', ',')}{/if}{/if}</td>
            </tr>
            {if $item.aug_1 != "0"}
                <tr>
                    <td style="width: 30%" class="text-right">
                        <b>{$ajax_buy_shop_augment}</b>
                    </td>
                    <td class="text-left">
                        {$.php.get_augmentation($item.aug_1)}<br>{$.php.get_augmentation($item.aug_2)}
                    </td>
                </tr>
            {/if}
            {if $item.a_att_type > 0 || $item.d_att_0 > 0 || $item.d_att_1 > 0 || $item.d_att_2 > 0 || $item.d_att_3 > 0 || $item.d_att_4 > 0 || $item.d_att_5 > 0}
                <tr>
                    <td style="width: 30%" class="text-right">
                        <b>{$ajax_buy_shop_attribute}</b>
                    </td>
                    <td class="text-left">
                        {if $item.a_att_type > 0}
                            {$att[$item.a_att_type]} {$item.a_att_value}
                        {/if}
                        {if $item.d_att_0 > 0}
                            {$att[0]} {$item.d_att_0}
                        {/if}
                        {if $item.d_att_1 > 0}
                            {$att[1]} {$item.d_att_1}
                        {/if}
                        {if $item.d_att_2 > 0}
                            {$att[2]} {$item.d_att_2}
                        {/if}
                        {if $item.d_att_3 > 0}
                            {$att[3]} {$item.d_att_3}
                        {/if}
                        {if $item.d_att_4 > 0}
                            {$att[4]} {$item.d_att_4}
                        {/if}
                        {if $item.d_att_5 > 0}
                            {$att[5]} {$item.d_att_5}
                        {/if}
                    </td>
                </tr>
            {/if}
            {if $item.type == "3"}
                <tr>
                    <td class="text-right" style="width: 50%;"><b>{$ajax_buy_shop_inventory}</b></td>
                    <td class="text-left" style="width: 50%;">
                        {foreach 1..5 as $value index=$index}
                            {$.php.set_item($item.char_inventory[$index].i_i, false, false, '<span data-item="%id%" style="margin: 0;"><img src="%icon%" width="32px"></span>')}
                        {/foreach}
                        <br>
                        <button type="submit" class="btn btn-sm btn-outline-primary submit-btn mt-1" {$.php.btn_ajax("Modules\Lineage2\Market\Market", "ajax_show_inventory", ['id' => $item.shop_id])}>{$ajax_buy_shop_all_inventory}</button>
                    </td>
                </tr>
            {/if}
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

        {if $.site.session->session.user_data.account['error_exception']?}
            <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                {$.site.session->session.user_data.account['error_exception']}
            </p>
        {elseif $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}


            <div class="form-group row justify-content-center">
                <div class="col-lg-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <select id="account_name_market" name="account_name" class="form-control" size="1">
                            <option value="0">{$ajax_buy_shop_choose_account}</option>
                            {foreach $.site.session->session.user_data.account as $login => $info}
                                <option value="{$login}">{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({count($info.char_list)}){/if}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-center char_name_div_market" style="display: none;">
                <div class="col-lg-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-street-view"></i></span>
                        </div>
                        <select id="char_name_market" name="char_name" class="form-control" size="1">
                            <option value="0">{$lang_select_char}</option>
                        </select>
                    </div>
                </div>
            </div>

        {else}
            <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                {$ajax_buy_shop_no_accs}  {$.php.get_sid_name()}
            </p>
        {/if}

        {if $item.count > 1}
            <div class="form-group row justify-content-center">
                <label class="col-10" for="count">{$ajax_buy_shop_enter_amount}</label>
                <div class="col-10">
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calculator"></i></span>
                        </div>
                        <input type="number" min="1" max="9999999" name="count" class="form-control" id="count" value="1">
                    </div>
                </div>
            </div>
        {/if}

        {if $.php.check_pin("pins_market_buy_shop")}
            <div class="form-group row justify-content-center" >
                <label class="col-10" for="pin">{$ajax_buy_shop_pin}</label>
                <div class="col-10">
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-expeditedssl"></i></span>
                        </div>
                        <input type="number" maxlength="4" name="pin" class="form-control" id="pin" placeholder="PIN">
                    </div>
                </div>
            </div>

        {/if}

    </div>
</div>


<script>

    $('#account_name_market').unbind();
    $('body').on('change', '#account_name_market', function (e) {
        let char_list = JSON.parse('{json_encode($char_list)}');
        let account_id = $(this).val();
        let char_name_market = $('#char_name_market');

        {if $item.type != "3"}
        if (account_id != '0') {
            $('.char_name_div_market').show(200);
            char_name_market.find('option').remove().end().prop('disabled', true);
            if (char_list[account_id].length !== 0) {
                let select_char = '';
                $.each(char_list[account_id], function (char_id, name) {
                    if ('Выберите персонажа' == name)
                        select_char = 'selected';
                    else
                        select_char = '';


                    char_name_market.append('<option value="' + name + '" '+select_char+'>' + name + '</option>');
                });
                char_name_market.prop('disabled', false);
            } else {
                char_name_market.append('<option value="0">Нет персонажей</option>');
            }
        } else {
            $('.char_name_div_market').hide(200);
        }
        {/if}
    });
    $('#account_name_market').trigger('change');

    $(document).ready(function() {
        var initial = $('.price-multiplier:eq(0)').data('value');
        var initial_price = $('#price-final').data('initial');

        $('#count').keyup(function() {
            $('.price-multiplier').text((parseFloat(initial) * $('#count').val()).toLocaleString('en-US'));
            $('#price-final').text(' '+ (initial_price * $('#count').val()).toFixed(2));
        })
    })
</script>