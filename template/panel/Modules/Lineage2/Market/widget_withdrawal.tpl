<div class="block block-fx-shadow">
    <div class="block-content">

        {if $market_cfg.withdrawal_ma OR $market_cfg.withdrawal_bank}

            <form action="/input"  method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Lineage2\Market\Market", "ajax_withdrawal")}
            <div class="form-group row">
                <label class="col-12" for="withdrawal-type">{$widget_withdrawal_title}</label>
                <div class="col-12">
                    <select class="form-control form-control-lg" id="withdrawal-type" name="withdrawal_type" size="2">
                        {if $market_cfg.withdrawal_ma}<option value="withdrawal_ma" selected>{$widget_withdrawal_ma}</option>{/if}
                        {if $market_cfg.withdrawal_bank}<option value="withdrawal_bank">{$widget_withdrawal_real}</option>{/if}
                    </select>
                </div>
            </div>
            <div class="form-group row withdrawal_bank"  style="display: none;">
                <label class="col-12" for="delivery_method">{$widget_withdrawal_deli}</label>
                <div class="col-12">
                    <select class="form-control form-control-lg" id="delivery_method" name="delivery_method">
                        {foreach $market_cfg.withdrawal_bank_list as $key => $val}
                            <option value="{$key}">{$val}</option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="form-group row withdrawal_bank"  style="display: none;">
                <label class="col-12" for="withdrawal_wallet">{$widget_withdrawal_card}</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="withdrawal_wallet" name="wallet">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="withdrawal_sum">{$widget_withdrawal_sum}</label>
                <div class="col-12">
                    <div class="input-group input-group-lg">
                        <input type="number" min="1" max="{$.php.intval($.site.session->session.user_data.market.balance)}" value="{$.php.intval($.site.session->session.user_data.market.balance)}" class="form-control" id="withdrawal_sum" name="withdrawal_sum" placeholder="200">
                        <div class="input-group-append">
                            <span class="input-group-text font-w600">{$widget_withdrawal_all}: {$.php.intval($.site.session->session.user_data.market.balance)} {$payment_system.short_name_valute}</span>
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


        $('body').on('change', "#withdrawal-type", function (e) {
           if ($(this).val() == 'withdrawal_bank'){
               $('.withdrawal_bank').show();
           }else{
                $('.withdrawal_bank').hide();
           }
        });

    });
</script>