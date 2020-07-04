{set $sale = $.php.get_shop_sale($item.sale_id)}
<h3 class="h5 text-muted mb-0 text-center pt-5">{$lang_service_time}</h3>
<div class="isel-list">
    <div class="isel isel_header">
        <div class="isel__checkbox checkbox checkbox_fill">
            <div class="checkbox__label">
                <div class="checkbox__content checkbox__content_header isel__heading">{$lang_item_name}</div>
            </div>
        </div>
        <div class="isel__quantity isel__quantity_header isel__heading">
            {$lang_pa_day}
        </div>
        {if $item.complect == 0}
            <div class="isel__price isel__price_header isel__heading">
                {$lang_item_price} {if $sale.status}
                    <span class="badge badge-sale ml-1" style="position: absolute;padding: 1px;" title="{$lang_label_sale} {$sale.name}{if $sale_ma > 0} + Master Account{/if}">-{$sale.sale + $sale_ma}%</span>
                {elseif $sale_ma > 0}
                    <span class="badge badge-sale-ma ml-1" style="position: absolute;padding: 1px;" title="{$lang_label_sale} Master Account">-{$sale_ma}%</span>
                {/if}
            </div>
        {/if}
    </div> <!-- END isel isel_header -->
    {foreach $item.items as $ids => $it}
        <div class="isel">
            <div class="isel__checkbox checkbox checkbox_fill">
                <label class="checkbox__label">

                    <input type="radio" class="checkbox__input"
                           name="items[premium]" value="{$it.key}"
                           data-price="{if $sale.status}{$.php.percentage($it.price, $sale.sale + $sale_ma)}{else}{$.php.percentage($it.price, $sale_ma)}{/if}"
                    />
                    <div class="checkbox__block"></div>
                    <div class="checkbox__content">{$it.name}</div>

                </label>
            </div>
            <div class="isel__quantity">
                <em class="font-size-sm text-muted">{$it.visual_day}</em>
            </div>
            <div class="isel__price"  title="{$payment_system.short_name_valute}">{if $sale.status}{$.php.percentage($it.price, $sale.sale + $sale_ma)}{else}{$.php.percentage($it.price, $sale_ma)}{/if}</div>
        </div> <!-- END isel -->
    {/foreach}
    {if $item.complect == 0}
        <div class="isel isel_footer">
            <div class="isel__checkbox checkbox checkbox_fill">

            </div>
            <div class="isel__quantity isel__quantity_header isel__heading">
                {$lang_sum_price}
            </div>
            <div class="isel__price isel__price_header isel__heading" data-total-price>0.00 {$payment_system.short_name_valute}</div>
        </div> <!-- END isel isel_header -->
    {else}
        <div class="isel isel_footer">
            <div class="isel__checkbox checkbox checkbox_fill"></div>
            <div class="isel__quantity isel__quantity_header isel__heading"></div>
            <div class="isel__price isel__price_header isel__heading"></div>
        </div> <!-- END isel isel_header -->
    {/if}
</div> <!-- END isel-list -->