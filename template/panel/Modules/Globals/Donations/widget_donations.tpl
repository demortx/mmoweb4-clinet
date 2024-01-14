<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">{$donate_title}</h3>
    </div>
    <form action="/input" method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Globals\Donations\Donations", "checkout")}
        <div class="block-content pl-50 pr-50">
            <div class="row">
                {if $market}
                <div class="col-md-12">
                    <div class="row gutters-tiny mt-20">
                        <div class="col-6">
                            <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0);">
                                <div class="block-content block-content-full clearfix">
                                    <div class="float-right mt-15 d-none d-sm-block">
                                        <i class="si si-diamond fa-2x text-primary-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-primary" data-toggle="countTo" data-speed="300" data-to="{$.php.intval($.site.session->session.user_data.balance)}">0</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Master account</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="block block-rounded block-bordered block-link-shadow" href="{$.php.set_url('/panel/market/donations')}">
                                <div class="block-content block-content-full clearfix drinkcard-cc">
                                    <div class="float-right mt-15 d-none d-sm-block">
                                        <i class="fa fa-bank fa-2x text-primary-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-primary" data-toggle="countTo" data-speed="300" data-to="{$.php.intval($.site.session->session.user_data.market.balance)}">0</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">Market</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                {/if}
                <div class="col-md-12">
                    <div class="form-group mb-20">
                        <label for="coin">{$donate_input_title_sum}</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">{$payment_system.short_name_valute}</div>
                            <input type="number" class="form-control" min="10" max="10000" id="coin" name="sum" placeholder="{$donate_input_title_enter_sum} {$payment_system.long_name_valute}" value="{$payment_system.rec_payment}" onchange="changeSum($(this).val(),false);" onkeyup="changeSum($(this).val(),false);">
                            <div class="input-group-append"><span class="input-group-text" id="bonus_sum">+0 {$donate_span_title_bonus}</span></div>
                        </div>
                    </div>
                    <div class="form-group  mb-20">
                        <input type="text" id="sum_slider" data-grid="true" data-min="{$payment_system.min_payment}" data-max="{$payment_system.max_payment}" data-from="{$payment_system.rec_payment}" data-postfix=" {$payment_system.short_name_valute}">
                    </div>
                </div>
                <div class="col-md-12" id="calculation_board">
                    {foreach $payment_system.course as $currency => $course}
                        <div class="row border-bottom pt-5">
                            <div class="col-3">
                                {if $course_cfg[$currency]?}{$course_cfg[$currency]['name']}{else}{$currency}{/if}
                            </div>
                            <div class="col-9">
                                <span class="pull-right"><span id="sum_{$currency}">0</span> {if $course_cfg[$currency]?}{$course_cfg[$currency]['icon']}{/if}</span>
                            </div>
                        </div>
                    {/foreach}
                </div>
                <div class="col-md-6 border-left" id="item_board" style="display: none;">

                </div>
                <div class="col-md-12">
                    <div class="form-group mt-20">
                        <label for="payment_method">{$donate_title_pay}</label>
                    </div>
                    <div class="row gutters-tiny mt-20">
                        {set $pay_first = true}
                        {foreach $payment_list as $pay}
                            {if $payment_system[$pay]? AND $payment_system[$pay] === true}
                                <div class="col-sm-3 col-4">
                                    <div class="cc-selector-2">
                                        <input id="{$pay}" type="radio" name="payment_method" value="{$pay}" {if $pay_first}checked="checked"{set $pay_first = false}{/if}/>
                                        <label class="drinkcard-cc" for="{$pay}">
                                            <img class="img-fluid" src="/template/panel/assets/media/payment/{$pay}.png" alt="{$pay}">
                                        </label>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>

                {if $config_cabinet.captcha == 'captcha'}
                    <div class="col-12">
                        <div class="form-group row justify-content-center text-center">
                            <div class="col-12 col-md-6">
                                <label for="captcha">Captcha</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text p-0"><img id="captcha-img" style="border-radius: 3px 0 0 3px;" class="btn-secondary" src="/captcha/img"></span>
                                        <button type="button" class="btn btn-secondary" onclick="$('#captcha-img').attr('src','/captcha/img?'+Math.random());"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                {elseif $config_cabinet.captcha == 'recaptchav2'}
                    <div class="col-12">
                        <div class="form-group row justify-content-center text-center">
                            <div class="col-12 col-md-6">
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" data-sitekey="{$config_cabinet.recaptcha_public_key}"></div>
                                <br>
                            </div>
                        </div>
                    </div>
                {elseif $config_cabinet.captcha == 'recaptchav3'}
                    <input type="hidden" id="captcha" name="captcha">
                    <script src='https://www.google.com/recaptcha/api.js?render={$config_cabinet.recaptcha_public_key}'></script>
                    <script>
                        grecaptcha.ready(function() {
                            grecaptcha.execute('{$config_cabinet.recaptcha_public_key}', { action: 'checkout'})
                                .then(function(token) {
                                    $('#captcha').val(token);
                                });
                        });
                    </script>
                {/if}

            </div>
        </div>
        <div class="block-content block-content-sm block-content-full bg-body-light text-center mt-20">
            <button type="submit" class="btn btn-alt-primary submit-form">
                <i class="fa fa-money mr-5"></i> {$donate_title_pay_btn}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        $("#sum_slider").ionRangeSlider({
            min: {$payment_system.min_payment},
            max: {$payment_system.max_payment},
            from: {$payment_system.rec_payment},
            grid: true,
            postfix: ' {$payment_system.short_name_valute}',
            skin: 'round',
            prettify: function (num) {
                var bonus = 0;
                var bonus_item = [];
                var bonus_item_key = [];
                var bonus_item_html = '<div class="row border-bottom text-center pt-5" style="border-bottom-style: dashed !important;"><div class="col-12">{$donate_title_pay_bonus_item}</div></div>';
                var bonus_item_show = false;
                var payment_method = $("input[name='payment_method']:checked"). val();


                {* Перебираем все бонусы и отрисовываем *}
                {foreach $event_cfg as $bonus_cfg}
                    var temp_agrigator_{$bonus_cfg.id} = {$.php.json_encode($bonus_cfg.agrigator)};
                    if(temp_agrigator_{$bonus_cfg.id}.includes(payment_method) || temp_agrigator_{$bonus_cfg.id}.includes('all')){
                    {foreach $bonus_cfg.data as $lv => $rage first=$first}
                            {if !$first}else {/if}if (num >= {$rage.start} && num <= {$rage.end}) {
                                bonus += (num * {$rage.percent} / 100);
                                {if $bonus_cfg.item_enable == 1}
                                    bonus_item_key[{$bonus_cfg.id}] = {$lv};
                                {/if}
                            }
                    {/foreach}
                    }
                    {if $bonus_cfg.item_enable == 1}
                        bonus_item[{$bonus_cfg.id}] = {$.php.json_encode($bonus_cfg.item)};
                    {/if}
                {/foreach}


                $.each( bonus_item_key, function( key, value ) {
                    if (value !== "undefined"){
                        if (typeof bonus_item[key] !== "undefined") {
                            if (typeof bonus_item[key][value] !== "undefined") {
                                bonus_item_show = true;
                                $.each( bonus_item[key][value], function( idx, item ) {
                                    bonus_item_html += '<div class="row border-bottom pt-5"><div class="col-10"><img src="'+item.icon+'" width="15px"> '+item.name+' '+item.add_name+' '+(item.enc > 0 ? '<span style="color: #bbb529">'+item.enc+'</span>' : '')+' </div><div class="col-2"><span class="pull-right"><span>'+item.count+'</span>x</span></div></div>';
                                });

                            }
                        }
                    }
                });

                if (bonus_item_show){
                    $('#calculation_board').removeClass('col-md-12').addClass("col-md-6");
                    $('#item_board').html(bonus_item_html);
                    $('#item_board').show();
                }else{
                    $('#calculation_board').removeClass('col-md-6').addClass("col-md-12");
                    $('#item_board').html('');
                    $('#item_board').hide();
                }

                {*calculation_board item_board*}

                if(bonus > 0){
                    $('#bonus_sum').html('+'+ Math.floor(bonus) + ' {$donate_span_title_bonus}');
                    return num+", "+"+"+Math.floor(bonus)+" ";
                }else{
                    $('#bonus_sum').html('+'+ 0);
                    return num;
                }

            },
            onChange: function (data) {
                $('#coin').val(data.from);
                changeSum(data.from,true);
            }
        });
        var sum_slider = $("#sum_slider").data("ionRangeSlider");

        window.changeSum = function(sum,slider){

            var sum_usd = Math.round(((sum*{$payment_system.price_valute_cp})*{$payment_system.course.USD})*100)/100;

            $('.sum').val(sum_usd);

            let oi = 0;
            {foreach $payment_system.course as $currency => $course}
            oi = findFirstNonZeroIndex('{$course}');
            $('#sum_{$currency}').html(Math.ceil(sum_usd*{$course}*oi)/oi);
            {/foreach}
            $('#sum_USD').html(sum_usd);

            if(!slider){
                sum_slider.update({
                    from: sum
                });
            }
        };
        function findFirstNonZeroIndex(num) {
            let numberString = Number(num).toLocaleString('fullwide', { maximumSignificantDigits: 21 }).replace('.', '');
            let oi = Array.from(numberString).findIndex(i => i > 0);
            let pos = '10';
            for (var i = 0; i < oi; i++) {
                pos += '0';
            }
            pos = parseInt(pos);
            if (pos < 100) pos = 100;
            return parseInt(pos);
        }
        window.changeSum(document.getElementById("coin").value,true);


    });
</script>