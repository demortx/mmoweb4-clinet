{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}

<div class="row">
    {foreach $history_list as $item index=$index}
        <div class="col-lg-4 col-md-4">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title">{$.php.get_translation($item.update.shop.section)}</h3>
                </div>
                <div class="block-content">
                    {foreach $item.update.item_shop as $sell}
                        <div style="display: flex;">
                            {$.php.set_item($sell.item_id, false,false, '<div class="item-name"><img src="%icon%"><div><span class="item-name__content">%name% <span class="item-name__additional">%add_name%</span></span></div></div>')}
                            <div style="margin-left: auto; line-height: 32px;">
                                <small>{$item_status[$sell.status]}{if $sell.status == 1} {$ajax_buy_shop_for} {$.php.number_format($sell.earned_money, 2, ".", "")} <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="{$comission_notify}">?</span>{/if}</small>
                            </div>
                        </div>
                    {/foreach}
                    <br>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    {$creation_date} {$item.update.shop.data_create}
                </div>
            </div>
        </div>
    {/foreach}
</div>