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
                let char_list = JSON.parse('{json_encode($char_list_full)}');
                let account_id = $(this).val();
                let char_name_in_game = $('#char_name_in_game');

                if (account_id != '0') {
                    char_name_in_game.find('option').remove().end().prop('disabled', true);
                    if (char_list[account_id].length !== 0) {

                        $.each(char_list[account_id], function (char_id, char) {

                            char_name_in_game.append('<option value="' + char.name + '" data-ban="' + char.ban + '" ' + (char.ban == 1 ? '' : 'disabled') + '>' + char.name + ' [' + (char.ban == 1 ? 'Banned' : 'Active') + ']</option>');

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