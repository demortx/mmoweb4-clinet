
<div class="row mx-0 justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="pb-20 text-center">

                <h1 class="h4 font-w700 mt-30 mb-10">{$reminder_title_code_lang}</h1>
            </div>
            <!-- END Header -->

            <!-- Reminder Form -->
            <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.js) -->
            <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
            <form class="js-validation-reminder" action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\Reminder\Reminder", "reminder_change")}
                <input type="hidden" name="code" value="{$code}">

                <div class="block block-themed block-rounded block-shadow">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title">{$reminder_title_code_desc_lang}</h3>
                        <div class="block-options">
                            <select class="form-control font-size-xs" id="change_lang" style="height: 30px;">
                                {foreach $config.site.language_list as $lang_key => $lang_title}
                                    <option hreflang="{$lang_key}" value="/{$lang_key}{$.site.uri_string}" {if $.php.select_lang() == $lang_key}selected{/if}>{$lang_title|truncate:3:""|upper}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="reminder-code">{$reminder_title_input_code_lang}</label>
                                <input type="text" class="form-control" id="reminder-code" value="{$code}" disabled>
                                <div class="form-text text-muted">{$reminder_desc_input_code_lang}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="reminder-password">{$reminder_title_input_password_lang}</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" id="reminder-password" name="password" placeholder="********">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="eye">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>

                                </div>
                                <div class="form-text text-muted">{$reminder_desc_input_password_lang}</div>
                            </div>
                        </div>


                        {if $config.cabinet.captcha == 'captcha'}
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="captcha">{$reminder_title_input_captcha_lang}</label>
                                    <div class="input-group">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text p-0"><img id="captcha-img" style="border-radius: 5% 0 0 5%;" class="btn-secondary" src="/captcha/img"></span>
                                            <button type="button" class="btn btn-secondary"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                        </div>
                                        <input type="text" class="form-control" id="captcha" name="captcha" placeholder="">
                                    </div>
                                </div>
                            </div>
                        {elseif $config.cabinet.captcha == 'recaptchav2'}
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="{$config.cabinet.recaptcha_public_key}"></div>
                            <br>
                        {elseif $config.cabinet.captcha == 'recaptchav3'}
                            <input type="hidden" id="captcha" name="captcha">
                            <script src='https://www.google.com/recaptcha/api.js?render={$config.cabinet.recaptcha_public_key}'></script>
                            <script>
                                grecaptcha.ready(function() {
                                    grecaptcha.execute('{$config.cabinet.recaptcha_public_key}', { action: 'reminder_email'})
                                        .then(function(token) {
                                            $('#captcha').val(token);
                                        });
                                });
                            </script>
                        {/if}


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-alt-primary submit-form">
                                <i class="fa fa-asterisk mr-10"></i> {$reminder_menu_lang_btn_change}
                            </button>
                        </div>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="form-group text-center">
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{$.php.set_url('sign-in')}">
                                <i class="fa fa-user text-muted mr-5"></i> {$login_menu_lang_btn_signin}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Reminder Form -->
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        $(document).ready(function () {
            $("#eye").click(function () {
                if ($("#reminder-password").attr("type") === "password") {
                    $("#reminder-password").attr("type", "text");
                    $("#eye").find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $("#reminder-password").attr("type", "password");
                    $("#eye").find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });

    });
</script>