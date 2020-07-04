{set $sale = $.php.get_shop_sale($item.sale_id)}
<h3 class="h5 text-muted mb-0 text-center pt-5">{$lang_service_color}</h3>
<div class="isel-list isel-list_flex mt-10 ">
    {foreach $item.items as $ids => $it}
        <div class="isel isel_color">
            <div class="isel__checkbox checkbox checkbox_fill">
                <label class="checkbox__label">
                    <input type="radio" class="checkbox__input"
                        name="items[color]" value="{$it.key}"
                        data-price="{if $sale.status}{$.php.percentage($item.price, $sale.sale + $sale_ma)}{else}{$.php.percentage($item.price, $sale_ma)}{/if}"
                    />
                    <div class="checkbox__block"></div>
                    <div class="isel__color" style="background-color: {$it.color};"></div>
                </label>
            </div>
        </div> <!-- END isel -->
    {/foreach}
</div> <!-- END isel-list -->