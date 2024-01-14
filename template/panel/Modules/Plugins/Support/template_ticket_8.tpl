<input type="hidden" name="title" value="{$title_create_category_8}">

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="payment_method">{$form_title_payment_method}</label>
    <div class="col-lg-7">
        <div class="row gutters-tiny mt-20">
            {foreach $payment_list as $pay}
                {if $payment_system[$pay]? AND $payment_system[$pay] === true}
                    <div class="col-sm-2 col-3">
                        <div class="cc-selector-2">
                            <input  checked="checked" id="{$pay}" type="radio" name="details[payment_method]" value="{$pay}" />
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


<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_transactions">{$form_title_transactions}</label>
    <div class="col-lg-7">
        <input type="text" id="support_transactions" name="details[transactions]" class="form-control" placeholder="..." required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_pay_date">{$form_title_pay_date}</label>
    <div class="col-lg-7">
        <input type="date" id="support_pay_date" name="details[pay_date]" class="form-control" placeholder="" required="">
    </div>
</div>


<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_pay_time">{$form_title_pay_time}</label>
    <div class="col-lg-7">
        <input type="time" id="support_pay_time" name="details[pay_time]" class="form-control" placeholder="" required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_sum">{$form_title_sum}</label>
    <div class="col-lg-7">
        <input type="number" id="support_sum" name="details[sum]" class="form-control" placeholder="100" required="">
    </div>
</div>


<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_message">{$form_title_message_comment}</label>
    <div class="col-lg-7">
        <textarea id="support_message" name="message" rows="9" class="form-control" placeholder="{$form_title_message_comment_text}" required=""></textarea>
    </div>
</div>