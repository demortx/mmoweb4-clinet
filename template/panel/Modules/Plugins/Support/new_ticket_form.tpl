<form action="/input" method="post" onsubmit="return false;">
    {$.php.form_hide_input("Modules\Plugins\Support\Support", "create_ticket")}

    <div class="form-group row">
        <label class="col-lg-3 col-form-label text-right border-right" for="support_category">{$form_title_category}</label>
        <div class="col-lg-7">
            <select id="support_category" name="category" class="form-control" size="1">
                {foreach $category as $cid => $cat}
                    <option value="{$cid}" {if $cid ==$category_select}selected{/if}>{$cat}</option>
                {/foreach}
            </select>
        </div>
    </div>
    {$template_ticket}
    <div class="block-content block-content-sm block-content-full block-settings-save-fix">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-primary submit-form">
                <i class="fa fa-send mr-5"></i> {$form_title_send_btn}
            </button>
        </div>
    </div>
</form>