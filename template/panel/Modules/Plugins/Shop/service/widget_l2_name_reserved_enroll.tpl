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
<div class="form-group row justify-content-center">
    <div class="col-lg-10">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-pencil-square-o"></i></span>
            </div>
            <input type="text" minlength="3" maxlength="16" name="name_reserved" class="form-control"  placeholder="{$l2_name_reserved}">
        </div>
    </div>
</div>
