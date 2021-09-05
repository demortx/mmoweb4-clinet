<div class="my-10 text-center">
    <h2 class="font-w700 text-black mb-10">{$gift_code_title}</h2>
    <h3 class="h5 text-muted mb-0">{$.php.get_sid_name(false, true)}</h3>
</div>
{if $.php.count($items)}
    <div class="row  animated fadeIn mt-50" data-toggle="appear">
        {foreach $items as $id => $item}
            <div class="col-md-4">
                <div class="block">
                    <div class="block-content block-content-full ribbon ribbon-modern ribbon-primary">
                        <div class="ribbon-box">
                            {$lang_denomination}: {$item.denomination} {$payment_system.short_name_valute}
                        </div>
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="fa fa-gift fa-4x text-success"></i>
                            </div>
                            <div class="font-size-h4 font-w600">{$item.name}</div>
                            <div class="text-muted">{$item.desc}</div>
                            <div class="pt-20">
                                <button type="button" class="btn btn-rounded btn-alt-success submit-form" {$.php.btn_ajax("Modules\Plugins\GiftCode\GiftCode", "ajax_buy_gift", ['id' => $id])}>
                                    <i class="fa fa-money mr-5"></i> {$lang_btn_buy}: {$item.price} {$payment_system.short_name_valute}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
{else}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$lang_notfound_items} {$.php.get_sid_name()}
    </p>
{/if}