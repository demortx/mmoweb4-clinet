{if $.site.session->session.user_data.account['error_exception']?}
    <input type="hidden" name="account_name" value="error_exception">
{elseif $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
    <div class="form-group row">
        <label class="col-lg-3 col-form-label text-right border-right" for="account_name">{$form_title_account}</label>
        <div class="col-lg-7">
            <select id="account_name" name="details[account_name]" class="form-control" size="1">
                {foreach $.site.session->session.user_data.account as $login => $info}
                    <option value="{$login}">{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({$.php.count($info.char_list)}){/if}</option>
                {/foreach}
            </select>
        </div>
    </div>


    <div class="form-group row">
        <label class="col-lg-3 col-form-label text-right border-right" for="char_id">{$form_title_char}</label>
        <div class="col-lg-7">
            <select id="char_id" name="details[char_name]" class="form-control" size="1">
                <option value="0">{$form_title_char_select}</option>
            </select>
        </div>
    </div>
{else}
    <input type="hidden" name="details[char_name]" value="not_char">
    <input type="hidden" name="details[account_name]" value="not_account">
{/if}



<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_title">{$form_title_title}</label>
    <div class="col-lg-7">
        <input type="text" id="support_title" name="title" class="form-control" placeholder="{$form_title_title_text}" required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_message">{$form_title_message}</label>
    <div class="col-lg-7">
        <textarea id="support_message" name="message" rows="9" class="form-control" placeholder="{$form_title_message_text}" required=""></textarea>
    </div>
</div>