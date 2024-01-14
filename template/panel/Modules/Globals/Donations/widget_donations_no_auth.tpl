<div class="my-10 text-center">
    <h2 class="font-w700 text-black mb-10">{$.php.get_sid_name(true, true)}</h2>
    <h3 class="h5 text-muted mb-0">{$donate_title}</h3>
</div>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="block block-rounded block-fx-shadow">
            <form action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\Donations\Donations", "checkout_no_auth")}
                <div class="block-content pl-50 pr-50">
                    <div class="row">
                            <div class="col-md-12">
                                {if $.site.config.in_game_currency[get_sid()]['settings']?}
                                    {if $.php.count($.site.config.in_game_currency[get_sid()]['settings']) > 1}
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group" style="margin-bottom: 11px;">
                                                <label for="recipient" id="recipient-label">{$d_recipient_char}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text type_icon">
                                                            <i class="fa fa-street-view"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" id="recipient" class="form-control" name="recipient" placeholder="MegaMag">
                                                </div>
                                            </div>

                                            <div class="form-group mb-20">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text short_name_icon">Coin</div>
                                                    <input type="number" class="form-control" min="10" max="10000" id="coin" name="sum" placeholder="{$d_recipient_count}" value="{$payment_system.rec_payment}" onchange="changeSum($(this).val(),false);" onkeyup="changeSum($(this).val(),false);">
                                                    <div class="input-group-append"><span class="input-group-text" id="bonus_sum">+0 {$donate_span_title_bonus}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="label-recipient">{$d_title_valuta}</label>
                                                {foreach $.site.config.in_game_currency[$.php.get_sid()]['settings'] as $key => $ingame first=$first_pos}
                                                    <input type="radio" name="type_id" id="label-id-{$key}" value="{$ingame.id}" autocomplete="off" data-type="{$ingame.type}" data-message="{$ingame.message_no_auth}" data-long-name="{$ingame.long_name}" data-price="{$ingame.price}" data-short-name="{$ingame.short_name}" {if $first_pos}checked{/if} />
                                                    <div class="btn-group w-100">
                                                        <label for="label-id-{$key}" class="btn btn-default">
                                                            <span class="fa fa-check-square-o fa-lg"></span>
                                                            <span class="fa fa-square-o fa-lg"></span>
                                                            <div class="content-label w-100 text-left">
                                                                <img src="{$ingame.icon}" class="img-avatar img-avatar16 img-avatar-thumb m-0">
                                                                {$ingame.long_name}
                                                            </div>
                                                        </label>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="in-game-message">

                                            </div>
                                        </div>
                                    </div>
                                    {else}
                                        {foreach $.site.config.in_game_currency[$.php.get_sid()]['settings'] as $key => $ingame}
                                            <input type="radio" name="type_id" value="{$ingame.id}" data-type="{$ingame.type}" data-message="{$ingame.message_no_auth}" data-long-name="{$ingame.long_name}" data-price="{$ingame.price}" data-short-name="{$ingame.short_name}" style="display: none;" checked />

                                            <div class="form-group">
                                                <label for="recipient" id="recipient-label">{if $ingame.type == 'account'}{$d_recipient_account}{else}{$d_recipient_char}{/if}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text type_icon">
                                                            <i class="fa {if $ingame.type == 'account'}fa-user{else}fa-street-view{/if}"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" id="recipient" class="form-control" name="recipient" placeholder="{if $ingame.type == 'account'}XX_Login{else}MegaMag{/if}">
                                                </div>
                                            </div>

                                            <div class="form-group mb-20">
                                                <label for="coin">{$d_recipient_count}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text short_name_icon">{$ingame.short_name}</div>
                                                    <input type="number" class="form-control" min="10" max="10000" id="coin" name="sum" placeholder="{$d_recipient_count} {$ingame.long_name}" value="{$payment_system.rec_payment}" onchange="changeSum($(this).val(),false);" onkeyup="changeSum($(this).val(),false);">
                                                    <div class="input-group-append"><span class="input-group-text" id="bonus_sum">+0 {$donate_span_title_bonus}</span></div>
                                                </div>
                                            </div>


                                            <div class="in-game-message">
                                                {$ingame.message_no_auth}
                                            </div>
                                        {/foreach}
                                    {/if}
                                {else}
                                    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
                                        {$lang_notfound_type_buy}
                                    </p>
                                {/if}

                            </div>
                            <div class="col-md-12">
                                <div class="form-group  mb-20">
                                    <input type="text" id="sum_slider" data-grid="true">
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
    </div>
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
                let bonus = 0;
                let bonus_item = [];
                let bonus_item_key = [];
                let bonus_item_html = '<div class="row border-bottom text-center pt-5" style="border-bottom-style: dashed !important;"><div class="col-12">{$donate_title_pay_bonus_item}</div></div>';
                let bonus_item_show = false;
                let payment_method = $("input[name='payment_method']:checked"). val();
                let price = parseFloat($("input[name='type_id']:checked").data('price'));

                {*/*Перебираем все бонусы и отрисовываем*/*}
                {foreach $event_cfg as $bonus_cfg}
                    let temp_agrigator_{$bonus_cfg.id} = {$.php.json_encode($bonus_cfg.agrigator)};
                    if(temp_agrigator_{$bonus_cfg.id}.includes(payment_method) || temp_agrigator_{$bonus_cfg.id}.includes('all')){
                    {foreach $bonus_cfg.data as $lv => $rage first=$first}
                {if !$first}else {/if}if (Math.floor(num * price) >= {$rage.start} && Math.floor(num * price) <= {$rage.end}) {
                                bonus += (Math.floor(num * price) * {$rage.percent} / 100);
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


                /*calculation_board item_board*/

                if(bonus > 0){
                    $('#bonus_sum').html('+'+ Math.floor(bonus / price) + ' {$donate_span_title_bonus}');
                    return num+", "+"+"+Math.floor(bonus / price)+" ";
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

            let price = $("input[name='type_id']:checked").data('price');

            var sum_usd = Math.round(((sum*({$payment_system.price_valute_cp}*parseFloat(price)))*{$payment_system.course.USD})*100)/100;

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
        function initInGame() {
            let input = $("input[name='type_id']:checked");
            let message = input.data('message');
            let long_name = input.data('long-name');
            let short_name = input.data('short-name');
            let type = input.data('type');
            setTextInputInGame(type, message, long_name, short_name);
        }
        function setTextInputInGame(type, message, long_name, short_name) {

            if (type == 'account'){
                $('#recipient-label').html('{$d_recipient_account}');
                $('.type_icon').html('<i class="fa fa-user"></i>');
                $('#recipient').attr("placeholder", "XX_Login");
            }else{
                $('#recipient-label').html('{$d_recipient_char}');
                $('.type_icon').html('<i class="fa fa-street-view"></i>');
                $('#recipient').attr("placeholder", "MegaMag");
            }

            $('.short_name_icon').html('<i class="fa fa-plus-square"></i>');
            if (short_name.length) {
                $('.short_name_icon').html(short_name);
                let slider = $("#sum_slider").data("ionRangeSlider");
                if(slider){
                    slider.update({
                        postfix: ' '+short_name,
                    });
                }
            }
            if (long_name.length)
                $('#coin').attr("placeholder", "{$d_recipient_count} " + long_name);

            $('.in-game-message').html('');
            if (message.length)
                $('.in-game-message').html(message.replace(/\n/g, '<br>'));


        }
        initInGame();


        $('body').on('change', "input[name='type_id']", function (e) {
            let type = $(this).data('type');
            let message = $(this).data('message');
            let long_name = $(this).data('long-name');
            let short_name = $(this).data('short-name');

            setTextInputInGame(type, message, long_name, short_name);


            window.changeSum(document.getElementById("coin").value,true);
        });

        window.changeSum(document.getElementById("coin").value,true);
    });
</script>