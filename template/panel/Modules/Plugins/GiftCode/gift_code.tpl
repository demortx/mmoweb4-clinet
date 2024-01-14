<div class="my-10 text-center">
    <h2 class="font-w700 text-black mb-10">{$gift_code_title}</h2>
    <h3 class="h5 text-muted mb-0">{$.php.get_sid_name(false, true)}</h3>
</div>
{if $.php.is_array($config.items) AND $.php.count($config.items)}
    <div class="row  animated fadeIn mt-50" data-toggle="appear">
        {foreach $config.items as $id => $item}
            <div class="col-md-4">
                <div class="block rounded">
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

        {if $config.free_purchase? AND $config.free_purchase==1}
            <div class="col-md-4">
                <div class="block rounded">
                    <form action="/input" method="post" onsubmit="return false;">
                        {$.php.form_hide_input("Modules\Plugins\GiftCode\GiftCode", "ajax_buy_gift")}
                        <input type="hidden" name="id" value="-1">
                        <div class="block-content block-content-full ribbon ribbon-modern ribbon-primary">
                            <div class="ribbon-box">
                                {$lang_denomination}: {$from} {$config.min_purchase} {$to} {$config.max_purchase} {$payment_system.short_name_valute}
                            </div>
                            <div class="py-20 text-center">
                                <div class="mb-20">
                                    <i class="fa fa-gift fa-4x text-success"></i>
                                </div>
                                <div class="font-size-h4 font-w600">{$title}{if $config.tax > 0}, {$commission} {$config.tax}%{/if}</div>
                                <div class="text-muted pt-5">
                                    <input type="number" id="free-purchase" name="sum" class="form-control" min="{$config.min_purchase}" max="{$config.max_purchase}" value="{$config.min_purchase}" placeholder="{$desc}">
                                </div>
                                <div id="btn-buy-free-purchase" class="pt-20" style="display: none;">
                                    <button type="button" id="btn-buy" class="btn btn-rounded btn-alt-success submit-form">
                                        <i class="fa fa-money mr-5"></i> {$lang_btn_buy}: 0 {$payment_system.short_name_valute}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function (event) {
                    $('body').on('keyup change click', '#free-purchase', function (e) {
                        let this__ = $(this);
                        let sum = parseInt(this__.val());
                        let min = {$config.min_purchase};
                        let max = {$config.max_purchase};
                        let tax = {$config.tax};

                        if (sum > 0){
                            $('#btn-buy-free-purchase').show();
                            if (min <= sum && max >= sum) {
                                $('#btn-buy').html('<i class="fa fa-money mr-5"></i> {$lang_btn_buy}: ' + (sum + (sum / 100 * tax)) + " {$payment_system.short_name_valute}")
                            }else{
                                $('#btn-buy-free-purchase').hide();
                            }
                        }else{
                            $('#btn-buy-free-purchase').hide();
                        }

                    });
                });
            </script>
        {/if}
    </div>
{else}
    <p class="alert alert-warning font-w600 text-center" style="border-radius: 3px;">
        {$lang_notfound_items} {$.php.get_sid_name()}
    </p>
{/if}