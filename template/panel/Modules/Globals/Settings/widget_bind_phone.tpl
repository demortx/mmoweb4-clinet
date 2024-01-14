{if $.site.session->session.master_account.phone == 0}

    <div class="form-group row div-send-bind-phone">
        <label class="col-md-4 col-form-label text-right border-right" for="t-signup-phone">
            {$label_title_input_phone_lang}
        </label>
        <div class="col-md-6 pt-5">
            <div class="form-text text-muted"><p>{$lang_text_send_phone}</p></div>

            <form action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\Settings\Settings", "bind_phone_send_code")}
                <div class="row gutters-tiny">

                    <div class="input-group col-6">
                        <input id="phone" name="phone" class="form-control" type="tel">
                        <input id="phone_code" name="phone_code" type="hidden">

                    </div>

                    <div class="input-group col-6">
                        {if $.php.check_pin("pins_bind_phone_send_code")}
                        <input type="text" class="form-control" style="max-width: 130px !important;" id="pin" name="pin" placeholder="{$lang_pin_label_placeholder}">
                        {/if}
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-alt-danger submit-form">
                                <i class="fa fa-envelope-o"></i>
                                {$label_btn_phone_sms_lang}
                            </button>
                        </div>
                    </div>

                </div>
                <code>{$label_desc_input_phone_lang}</code>
            </form>
            <div class="mt-10 btn-bind-phone-div">
                <a href="javascript:void(0);">{$lang_btn_show_code}</a>
            </div>
        </div>
    </div>


    <div class="form-group row div-bind-phone" style="display: none">
        <label class="col-md-4 col-form-label text-right border-right" for="t-signup-sms-cod">
            {$label_input_phone_sms_lang}
        </label>
        <div class="col-md-6">
            <div class="form-text text-muted"><p>{$lang_text_send_phone_2}</p></div>
            <form action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\Settings\Settings", "bind_phone")}
                <div class="input-group" >
                    <input type="text" class="form-control" id="cod_confirm" name="cod_confirm" placeholder="{$lang_label_placeholder}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-alt-success submit-form"><i class="fa fa-check"></i>  {$lang_btn_confirm_phone}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>


    <link rel="stylesheet" href="/template/panel/assets/css/intl-telInput/intlTelInput.css?ver=0.1">
    <script src="/template/panel/assets/js/plugins/intl-telInput/intlTelInput.js?ver=0.1"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {

            window.show_enter_code_bind_phone = function () {
                $('.btn-bind-phone-div').hide('fade');
                $('.div-send-bind-phone').hide();
                $('.div-bind-phone').show('fade');
            };

            $('body').on('click', '.btn-bind-phone-div', function (e) {
                $('.btn-bind-phone-div').hide('fade');
                $('.div-send-bind-phone').hide();
                $('.div-bind-phone').show('fade');
            });

            $('body').on('click', '.btn-send-bind-email', function (e) {
                $('.btn-bind-phone-div').hide('fade');
                $('.div-send-bind-phone').hide();
                $('.div-bind-phone').show('fade');
            });

            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "ru",
                nationalMode: false,
                placeholderNumberType: "MOBILE",
                preferredCountries: ["ru", "ua", "by", "md", "kz", "uz", "az", "pl", "am", "ge", "bg", "be", "tj", "kg", "lt", "lv", "ee", "ro", "tm", "ch", "de"],
                separateDialCode: true,
                utilsScript: "/template/panel/assets/js/plugins/intl-telInput/utils.js",
            });
            $('#phone_code').val(iti.getSelectedCountryData().dialCode);

            $('.separate-dial-code').on('click', '.selected-flag, .country',function(){
                $('#phone_code').val(iti.getSelectedCountryData().dialCode);
            });

        });
    </script>
{else}
    <div class="form-group row div-send-bind-phone">
        <label class="col-md-4 col-form-label text-right border-right" for="t-signup-phone">
            {$label_title_input_phone_lang}
        </label>
        <div class="col-md-6 pt-5">
            <div class="form-text text-muted">{$lang_text_settings_phone}</div>

            <form action="/input" method="post" onsubmit="return false;" class="mt-1">
                {$.php.form_hide_input("Modules\Globals\Settings\Settings", "delete_bind_phone")}
                <div class="row gutters-tiny">

                    <div class="input-group col-6">
                        <input id="phone" name="phone" class="form-control" type="tel" value="{$.site.session->session.master_account.phone}" readonly>
                    </div>
                    {if $delete_bind_phone AND $.site.session->session.master_account.email?}
                    <div class="input-group col-6">
                        {if $.php.check_pin("pins_delete_bind_phone")}
                            <input type="text" class="form-control" style="max-width: 130px !important;" id="pin" name="pin" placeholder="{$lang_pin_label_placeholder}">
                        {/if}
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-alt-danger submit-form">
                                <i class="fa fa-times"></i>
                                {$label_btn_phone_del_lang}
                            </button>
                        </div>
                    </div>
                    {/if}
                </div>

            </form>
        </div>
    </div>
{/if}