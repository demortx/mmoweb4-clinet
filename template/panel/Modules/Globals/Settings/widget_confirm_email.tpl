{if $.site.session->session.master_account.email_valid == 0}


    {if $.php.is_array($.site.session->session.master_account.email)}

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-right border-right" for="name">
                    {$lang_title_bind_email}
                    <p class="mb-5"><span class="form-text text-muted font-size-sm">{$lang_desc_bind_email}</span></p>
                </label>

                <div class="col-md-6 pt-5">
                    <div class="form-text text-muted"><p>{$lang_text_send_email}</p></div>

                    <form action="/input" method="post" onsubmit="return false;">
                        {$.php.form_hide_input("Modules\Globals\Settings\Settings", "bind_email_send_code")}
                        <div class="input-group div-send-bind-email">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            {if $.site.config.cabinet.pin_shield}<input type="text" class="form-control" style="max-width: 130px !important;" id="pin" name="pin" placeholder="{$lang_pin_label_placeholder}">{/if}
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-alt-danger submit-form">
                                    <i class="fa fa-envelope-o"></i>
                                    {$lang_btn_send_email_bind_email}
                                </button>
                            </div>
                        </div>
                    </form>


                    <div class="mt-10 btn-bind-email-div">
                        <a href="javascript:void(0);">{$lang_btn_show_code}</a>
                    </div>

                    <form action="/input" method="post" onsubmit="return false;">
                        {$.php.form_hide_input("Modules\Globals\Settings\Settings", "bind_email")}
                        <div class="input-group mt-10 div-bind-email" style="display: none;">
                            <input type="text" class="form-control" id="cod_confirm" name="cod_confirm" placeholder="{$lang_label_placeholder}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-alt-success submit-form"><i class="fa fa-check"></i>  {$lang_btn_confirm_email}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        <script>
            document.addEventListener("DOMContentLoaded", function (event) {

                window.show_enter_code_bind = function () {
                    $('.btn-bind-email-div').hide('fade');
                    $('.div-send-bind-email').hide();
                    $('.div-bind-email').show('fade');
                };

                $('body').on('click', '.btn-bind-email-div', function (e) {
                    /*$(this).attr("disabled", true);*/
                    /*$(".pin-shield").prop( "checked", true );*/
                    $('.btn-bind-email-div').hide('fade');
                    $('.div-send-bind-email').hide();
                    $('.div-bind-email').show('fade');
                });

                $('body').on('click', '.btn-send-bind-email', function (e) {
                    $('.btn-bind-email-div').hide('fade');
                    $('.div-send-bind-email').hide();
                    $('.div-bind-email').show('fade');
                });
            });
        </script>


    {else}

        <form action="/input" method="post" onsubmit="return false;">
            {$.php.form_hide_input("Modules\Globals\Settings\Settings", "confirm_email")}

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-right border-right" for="name">
                    {$lang_title}
                    <p class="mb-5"><span class="form-text text-muted font-size-sm">{$lang_desc_confirm}</span></p>
                </label>
                <div class="col-md-6 pt-5">
                    <div class="form-text text-muted"><p>{$lang_text_send_email}</p></div>

                    <button type="submit" class="btn btn-sm btn-alt-danger submit-btn btn-send-confirm-email" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "confirm_email_send_code", ['type' => 'email'])}>
                        <i class="fa fa-envelope-o"></i>
                        {$lang_btn_send_email}
                    </button>


                    <div class="mt-10 btn-confirm-email-div">
                        <a href="javascript:void(0);">{$lang_btn_show_code}</a>
                    </div>

                    <div class="input-group mt-10 div-confirm-email" style="display: none;">
                        <input type="text" class="form-control" id="cod_confirm" name="cod_confirm" placeholder="{$lang_label_placeholder}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-alt-success submit-form"><i class="fa fa-check"></i>  {$lang_btn_confirm_email}</button>
                        </div>
                    </div>


                </div>
            </div>


        </form>

        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                $('body').on('click', '.btn-confirm-email-div', function (e) {
                    /*$(this).attr("disabled", true);*/
                    /*$(".pin-shield").prop( "checked", true );*/
                    $('.btn-confirm-email-div').hide('fade');
                    $('.btn-send-confirm-email').hide();
                    $('.div-confirm-email').show('fade');
                });

                $('body').on('click', '.btn-send-confirm-email', function (e) {
                    $('.btn-confirm-email-div').hide('fade');
                    $('.btn-send-confirm-email').hide();
                    $('.div-confirm-email').show('fade');
                });
            });
        </script>




    {/if}
    <hr>
{/if}