{$.php.form_hide_input("Modules\Lineage2\Market\Market", "ajax_buy_shop")}
<input type="hidden" name="id" value="{$item_id}">

<div class="row">
    <div class="col-lg-12 text-center">
        <div id="product-image">
            <img src="https://l2e-global.com/template/panel/assets/media/icon/61/icon/armor_t77_ul_i00.png?2"> Tallum Plate Armor
        </div>
        <table class="table table-borderless table-striped table-vcenter">
            <tr>
                <td style="width: 50%" class="text-right"><b>Содержит</b></td>
                <td class="text-left">
                    <div><img width="16px" src="https://l2e-global.com/template/panel/assets/media/icon/61/icon/armor_t77_ul_i00.png?2"> Tallum Plate Armor</div>
                    <div><img width="16px" src="https://l2e-global.com/template/panel/assets/media/icon/61/icon/armor_t77_ul_i00.png?2"> Tallum Helm</div>
                    <div><img width="16px" src="https://l2e-global.com/template/panel/assets/media/icon/61/icon/armor_t77_ul_i00.png?2"> Tallum Gloves</div>
                    <div><img width="16px" src="https://l2e-global.com/template/panel/assets/media/icon/61/icon/armor_t77_ul_i00.png?2"> Tallum Boots</div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%" class="text-right"><b>Заточка</b></td><td class="text-left">+0</td>
            </tr>
            <tr>
                <td class="text-right"><b>Количество</b></td><td class="text-left">x1</td>
            </tr>
            <tr>
                <td class="text-right"><b>Цена</b></td><td class="text-left">650.000000</td>
            </tr>
            <tr>
                <td class="text-right"><b>Аугмент</b></td><td class="text-left">-//-</td>
            </tr>
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
                            <option value="0">Выберите аккаунт</option>
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
                У вас нет игровых аккаунтов на этом сервере:  {$.php.get_sid_name()}
            </p>
        {/if}
        
        
        {if $.php.check_pin("pins_change_password_account")}
            <div class="form-group row justify-content-center" >
                <label class="col-10" for="pin">Введите PIN-CODE</label>
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
    });
    $('#account_name_market').trigger('change');


</script>