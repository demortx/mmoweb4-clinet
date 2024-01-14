{$.php.form_hide_input("Modules\Globals\InGameCurrency\InGameCurrency", "buy_in_game")}

{if $.site.config.in_game_currency[get_sid()]['settings']?}
    {if $.php.count($.site.config.in_game_currency[get_sid()]['settings']) > 1}
        <div class="form-group row justify-content-center">
            <div class="col-lg-10">
                {foreach $.site.config.in_game_currency[get_sid()]['settings'] as $key => $ingame first=$first}
                    <div class="">
                        <input type="radio" name="type_id" id="label-id-{$key}" value="{$ingame.id}" autocomplete="off" data-type="{$ingame.type}" data-message="{$ingame.message}" data-long-name="{$ingame.long_name}" data-price="{$ingame.price}" data-short-name="{$ingame.short_name}" {if $first}checked{/if} />
                        <div class="btn-group w-100">
                            <label for="label-id-{$key}" class="btn btn-default" title="{$lang_label_price}: {$ingame.price}">
                                <span class="fa fa-check-square-o fa-lg"></span>
                                <span class="fa fa-square-o fa-lg"></span>
                                <div class="content-label w-100 text-left">
                                    <img src="{$ingame.icon}" class="img-avatar img-avatar16 img-avatar-thumb m-0">
                                    {$ingame.long_name}
                                </div>
                            </label>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    {else}
        {foreach $.site.config.in_game_currency[get_sid()]['settings'] as $key => $ingame}
            <input type="radio" name="type_id" value="{$ingame.id}" data-type="{$ingame.type}" data-message="{$ingame.message}" data-long-name="{$ingame.long_name}" data-price="{$ingame.price}" data-short-name="{$ingame.short_name}" style="display: none;" checked />
        {/foreach}
    {/if}
{else}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$lang_notfound_type_buy}
    </p>
{/if}

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
                        <option value="{$login}" {if $login==$select_account}selected{/if}>{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({count($info.char_list)}){/if}</option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>

    <div class="form-group row justify-content-center char_name_div" style="display: none;">
        <div class="col-lg-10">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-street-view"></i></span>
                </div>
                <select id="char_name_in_game" name="char_name" class="form-control" size="1">
                    <option value="0">{$lang_select_char}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group row justify-content-center">
        <div class="col-lg-10">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text short_name_icon"><i class="fa fa-plus-square"></i></span>
                </div>
                <input type="number" min="1" max="600000" maxlength="6" name="count" class="form-control" id="count-in-game" title="{$lang_current_sale}: {$.site.session->getDiscount()}%" placeholder="{$lang_input_enter_count}">
            </div>
        </div>
    </div>
{else}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$lang_notfound_account} {$.php.get_sid_name()}
    </p>
{/if}

<script>
    function initInGame() {
        let message = $("input[name='type_id']:checked").data('message');
        let long_name = $("input[name='type_id']:checked").data('long-name');
        let short_name = $("input[name='type_id']:checked").data('short-name');
        setTextInputInGame(message, long_name, short_name);
    }
    function setTextInputInGame(message, long_name, short_name) {
        $('.in-game-title').html('');
        if (long_name.length)
            $('.in-game-title').html(long_name);

        $('.short_name_icon').html('<i class="fa fa-plus-square"></i>');
        if (short_name.length)
            $('.short_name_icon').html(short_name);

        $('.in-game-message').html('');
        if (message.length)
            $('.in-game-message').html(message.replace(/\n/g, '<br>'));
    }
    initInGame();
    $('#account_name_in_game').unbind();
    $('body').on('change', '#account_name_in_game', function (e) {
        let type = $("input[name='type_id']:checked").data('type');
        if (type == 'char') {
            let char_list = JSON.parse('{json_encode($char_list)}');
            let account_id = $(this).val();
            let char_name_in_game = $('#char_name_in_game');

            if (account_id != '0') {
                $('.char_name_div').show(200);
                char_name_in_game.find('option').remove().end().prop('disabled', true);
                if (char_list[account_id].length !== 0) {
                    let select_char = '';
                    $.each(char_list[account_id], function (char_id, name) {
                        if ('{$select_char}' == name)
                            select_char = 'selected';
                        else
                            select_char = '';


                        char_name_in_game.append('<option value="' + name + '" '+select_char+'>' + name + '</option>');
                    });
                    char_name_in_game.prop('disabled', false);
                } else {
                    char_name_in_game.append('<option value="0">{$lang_select_char_not_found}</option>');
                }
            } else {
                $('.char_name_div').hide(200);
            }
        }
    });
    $('#account_name_in_game').trigger('change');
    $("input[name='type']").unbind();
    $('body').on('change', "input[name='type_id']", function (e) {
        let type = $(this).data('type');
        let message = $(this).data('message');
        let long_name = $(this).data('long-name');
        let short_name = $(this).data('short-name');

        setTextInputInGame(message, long_name, short_name);

        if (type == 'account')
            $('.char_name_div').hide(200);
        else
            $('#account_name_in_game').trigger('change');

        $('#count-in-game').trigger('change');
    });
    $('#count-in-game').unbind();
    $("#count-in-game").bind("keyup change", function(e) {
        let price = $("input[name='type_id']:checked").data('price');
        let sum = $(this).val() * price;
        $('#out_price').html(sum - (sum * {$.site.session->getDiscount()} / 100));
    });
</script>