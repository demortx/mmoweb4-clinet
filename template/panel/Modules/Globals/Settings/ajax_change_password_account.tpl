{$.php.form_hide_input("Modules\Globals\Settings\Settings", "change_password_account")}
<input type="hidden" name="account" value="{$account}">
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="input_password_old"> {$lang_input_password_old} </label>
    <div class="col-md-8 pt-5">
        <input type="password" class="form-control" id="input_password_old" name="password_old">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="input_password_new"> {$lang_input_password_new} </label>
    <div class="col-md-8 pt-5">
        <input type="password" class="form-control" id="input_password_new" name="password_new">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="input_password_new_confirm"> {$lang_input_password_new_confirm} </label>
    <div class="col-md-8 pt-5">
        <input type="password" class="form-control" id="input_password_new_confirm" name="password_new_confirm">
    </div>
</div>
{if $.php.check_pin("pins_change_password_account")}
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="input_password_pin"> {$lang_input_password_pin} </label>
    <div class="col-md-8 pt-5">
        <input type="password" maxlength="4" class="form-control" id="input_password_pin" name="pin">
    </div>
</div>
{/if}