<form action="/input" method="post" onsubmit="return false;">
    {$.php.form_hide_input("Modules\Globals\Settings\Settings", "change_pwd_ma")}


    <h4 class="font-w400 text-center">{$lang_title}</h4>
    <hr>


    <div class="form-group row">
        <label class="col-md-4 col-form-label text-right border-right" for="input_password_old">
            {$lang_input_password_old}
        </label>
        <div class="col-md-6 pt-5">
            <input type="password" class="form-control" id="input_password_old" name="password_old">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-right border-right" for="input_password_new">
            {$lang_input_password_new}
        </label>
        <div class="col-md-6 pt-5">
            <input type="password" class="form-control" id="input_password_new" name="password_new">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-right border-right" for="input_password_new_confirm">
            {$lang_input_password_new_confirm}
        </label>
        <div class="col-md-6 pt-5">
            <input type="password" class="form-control" id="input_password_new_confirm" name="password_new_confirm">
        </div>
    </div>
    {if $.php.check_pin("pins_change_pwd_ma")}
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-right border-right" for="input_password_pin">
            {$lang_input_password_pin}
        </label>
        <div class="col-md-6 pt-5">
            <input type="password" class="form-control" id="input_password_pin" name="pin">
        </div>
    </div>
    {/if}
    <div class="block-content block-content-sm block-content-full bg-body-light block-settings-save-fix">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-primary submit-form">
                <i class="fa fa-save mr-5"></i> {$lang_button_change}
            </button>
        </div>
    </div>
</form>