<input type="hidden" name="title" value="{$title_create_category_7}">


<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_loss">{$form_title_date}</label>
    <div class="col-lg-7">
        <input type="date" id="support_loss" name="details[date]" class="form-control" placeholder="" required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_loss">{$form_title_time}</label>
    <div class="col-lg-7">
        <input type="time" id="support_loss" name="details[time]" class="form-control" placeholder="" required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_contact">{$form_title_bot_name}</label>
    <div class="col-lg-7">
        <input type="text" id="support_contact" name="details[bot_name]" class="form-control" placeholder="Bot1, Bot2..." required="">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-3 col-form-label text-right border-right" for="support_message">{$form_title_message_bot}</label>
    <div class="col-lg-7">
        <textarea id="support_message" name="message" rows="9" class="form-control" placeholder="{$form_title_message_bot}" required=""></textarea>
    </div>
</div>

