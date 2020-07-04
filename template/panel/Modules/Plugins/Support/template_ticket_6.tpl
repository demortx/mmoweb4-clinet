{if $.site.session->session.user_data.account['error_exception']?}
    <input type="hidden" name="account_name" value="error_exception">
{elseif $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
    <div class="form-group row">
        <label class="col-lg-3 col-form-label text-right border-right" for="account_name">{$form_title_account}</label>
        <div class="col-lg-7">
            <select id="account_name" name="details[account_name]" class="form-control" size="1">
                {foreach $.site.session->session.user_data.account as $login => $info}
                    <option value="{$login}">{$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}({count($info.char_list)}){/if}</option>
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

<input type="hidden" name="title" value="{$title_create_category_6}">

<div class="form-group row is-invalid">
    <label class="col-lg-3 col-form-label text-right border-right" for="details_sharing_yes">{$form_title_sharing}</label>
    <div class="col-lg-7">
        <div class="custom-control custom-radio custom-control-inline mb-5">
            <input class="custom-control-input sharing_account" type="radio" name="details[sharing]" id="details_sharing_yes" value="yes" checked="">
            <label class="custom-control-label" for="details_sharing_yes">{$form_title_yse}</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline mb-5">
            <input class="custom-control-input sharing_account" type="radio" name="details[sharing]" id="details_sharing_no" value="no">
            <label class="custom-control-label" for="details_sharing_no">{$form_title_no}</label>
        </div>
        <div id="info_sharing_yes" class="invalid-feedback">{$form_title_yse_text}</div>
        <div id="info_sharing_no" class="invalid-feedback" style="display: none">{$form_title_no_text}</div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="details_protection_yes">{$form_title_protection}</label>
    <div class="col-lg-7">
        <div class="custom-control custom-radio custom-control-inline mb-5">
            <input class="custom-control-input" type="radio" name="details[protection]" id="details_protection_yes" value="yes" checked="">
            <label class="custom-control-label" for="details_protection_yes">{$form_title_yse}</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline mb-5">
            <input class="custom-control-input" type="radio" name="details[protection]" id="details_protection_no" value="no">
            <label class="custom-control-label" for="details_protection_no">{$form_title_no}</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_loss">{$form_title_loss}</label>
    <div class="col-lg-7">
        <input type="date" id="support_loss" name="details[loss]" class="form-control" placeholder="" required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_contact">{$form_title_contact}</label>
    <div class="col-lg-7">
        <input type="text" id="support_contact" name="details[contact]" class="form-control" placeholder="Skype, Telegram..." required="">
    </div>
</div>


<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_message">{$form_title_message_loss}</label>
    <div class="col-lg-7">
        <textarea id="support_message" name="message" rows="9" class="form-control" placeholder="{$form_title_message_loss_desc}" required=""></textarea>
    </div>
</div>