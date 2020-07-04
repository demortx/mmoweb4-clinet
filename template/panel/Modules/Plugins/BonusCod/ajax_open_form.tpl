{$.php.form_hide_input("Modules\Plugins\BonusCod\BonusCod", "ajax_get_bonus")}
<input type="hidden" name="select_recipient" value="0">
<div class="form-group row justify-content-center">
    <div class="col-lg-10">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-gift"></i></span>
            </div>
            <input type="text" maxlength="32" name="cod" class="form-control" placeholder="{$lang_input_enter_cod}">
        </div>
    </div>
</div>
<div class="select_recipient" style="display: none;">
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
                <select id="account_name_b_cod" name="account_name" class="form-control" size="1">
                    <option value="0">{$lang_select_account}</option>
                    {foreach $.site.session->session.user_data.account as $login => $info}
                        <option value="{$login}">{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({count($info.char_list)}){/if}</option>
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
                <select id="char_name_b_cod" name="char_name" class="form-control" size="1">
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
<script>
    $('#account_name_b_cod').unbind();
    $('body').on('change', '#account_name_b_cod', function (e) {
        let char_list = JSON.parse('{json_encode($char_list)}');
        let account_id = $(this).val();
        let char_name_b_cod = $('#char_name_b_cod');

        if (account_id != '0') {
            $('.char_name_div').show(200);
            char_name_b_cod.find('option').remove().end().prop('disabled', true);
            if (char_list[account_id].length !== 0) {
                $.each(char_list[account_id], function (char_id, name) {
                    char_name_b_cod.append('<option value="' + name + '">' + name + '</option>');
                });
                char_name_b_cod.prop('disabled', false);
            } else {
                char_name_b_cod.append('<option value="0">{$lang_select_char_not_found}</option>');
            }
        } else {
            $('.char_name_div').hide(200);
        }
    });
</script>