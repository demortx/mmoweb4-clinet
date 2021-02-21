<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">{$donate_title_market}</h3>
    </div>
    <form action="/input" method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Lineage2\Market\Market", "checkout")}
        <div class="block-content pl-50 pr-50">
            <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-20">
                            <label for="coin">{$donate_input_title_sum}</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">{$payment_system.short_name_valute}</div>
                                <input type="number" class="form-control" min="10" max="10000" id="coin" name="sum" placeholder="{$donate_input_title_enter_sum} {$payment_system.long_name_valute}" value="{$payment_system.rec_payment}" onchange="changeSum($(this).val(),false);" onkeyup="changeSum($(this).val(),false);">
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