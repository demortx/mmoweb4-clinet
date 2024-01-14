<div class="form-group row justify-content-center">
    <div class="col-lg-10">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
            </div>
            <select id="account_name_in_game" name="account_name" class="form-control" size="1">
                <option value="0">{$lang_select_account}</option>
                {foreach $.site.session->session.user_data.account as $login => $info}
                    <option value="{$login}" {if $info.info.is_banned != 'true'}disabled{/if}>{$login} {if $info.info.is_banned == 'true'}BANNED{/if}</option>
                {/foreach}
            </select>
        </div>
    </div>
</div>