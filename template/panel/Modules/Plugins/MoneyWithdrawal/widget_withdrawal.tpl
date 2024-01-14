<div class="block block-fx-shadow">
    <div class="block-content">

        {if $money_withdrawal.status}

            <form action="/input"  method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Plugins\MoneyWithdrawal\MoneyWithdrawal", "ajax_withdrawal")}

            <div class="form-group row">
                <label class="col-12" for="delivery_method">{$widget_withdrawal_deli}</label>
                <div class="col-12">
                    <select class="form-control form-control-lg" id="delivery_method" name="delivery_method">
                        <option value="0">{$widget_withdrawal_select}</option>
                        {foreach $money_withdrawal.withdrawal_bank_list as $key => $val}
                            <option value="{$key}">{$val}</option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="withdrawal_wallet">{$widget_withdrawal_card}</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="withdrawal_wallet" name="wallet">
                    </div>
                </div>
            </div>

                <div class="form-group row show_qiwi" style="display: none;">
                    <div class="col-12 text-center">
                        <div class="font-size-sm text-muted">
                            <i class="fa fa-info-circle"></i> <em>{$widget_withdrawal_desc_qiwi}</em>
                        </div>
                    </div>
                </div>
                <div class="form-group row show_card" style="display: none;">
                    <div class="col-12 text-center">
                        <div class="font-size-sm text-muted">
                            <i class="fa fa-info-circle"></i> <em>{$widget_withdrawal_desc_card}</em>
                        </div>
                    </div>
                </div>

                <div class="form-group row show_card"  style="display: none;">
                    <label class="col-12" for="withdrawal_wallet">{$widget_withdrawal_reg_name}</label>
                    <div class="col-12">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" id="reg_name" name="reg_name">
                        </div>
                    </div>
                </div>

                <div class="form-group row show_card"  style="display: none;">
                    <label class="col-12" for="withdrawal_wallet">{$widget_withdrawal_reg_name_f}</label>
                    <div class="col-12">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" id="reg_name_f" name="reg_name_f">
                        </div>
                    </div>
                </div>

            <div class="form-group row">
                <label class="col-12" for="withdrawal_sum">{$widget_withdrawal_sum}</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="number" min="1" max="{$.php.intval($.site.session->session.user_data.balance)}" value="{$.php.intval($.site.session->session.user_data.balance)}" class="form-control" id="withdrawal_sum" name="withdrawal_sum" placeholder="200">
                        <div class="input-group-append">
                            <span class="input-group-text font-w600">{$widget_withdrawal_all}: {$.php.intval($.site.session->session.user_data.balance)} {$payment_system.short_name_valute}</span>
                        </div>
                    </div>
                </div>
            </div>
                {if $.php.check_pin("pins_market_withdrawal")}
                    <div class="form-group row">
                        <label class="col-12" for="pin">{$lang_input_password_pin}</label>
                        <div class="col-12">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text short_name_icon"><i class="fa fa-expeditedssl"></i></span>
                                </div>
                                <input type="number" maxlength="4" name="pin" class="form-control" id="pin" placeholder="PIN">
                            </div>
                        </div>
                    </div>
                {/if}
            <hr>

            <div class="form-group row">
                <div class="col-12 text-center">
                    <div class="font-size-sm text-muted">
                        <i class="fa fa-clock-o"></i> <em>{$widget_withdrawal_time}</em>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <button type="submit" class="btn btn-hero btn-lg btn-block btn-alt-primary submit-form">{$widget_withdrawal_create}</button>
                </div>
            </div>
        </form>

        {else}
            <div class="alert alert-primary alert-dismissable" role="alert">
                <h3 class="alert-heading font-size-h4 font-w400">{$widget_withdrawal_not}</h3>
                <p class="mb-0">{$widget_withdrawal_not_desc}</p>
            </div>

        {/if}


    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        $('body').on('change', "#delivery_method", function (e) {
            if ($(this).val() == 'qiwi'){
                $('.show_qiwi').show();
                $('.show_card').hide();
            }else if($(this).val() == 'card'){
                $('.show_card').show();
                $('.show_qiwi').hide();
            }else{
                $('.show_qiwi').hide();
                $('.show_card').hide();
            }
        });

    });
</script>