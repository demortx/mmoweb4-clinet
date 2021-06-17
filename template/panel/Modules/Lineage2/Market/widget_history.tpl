{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}
{*
<div class="row">
    {foreach $history_list as $item index=$index}
        <div class="col-lg-4 col-md-4">
            <div class="block block-bordered">
                <div class="block-header">
                    <h3 class="block-title">{$.php.get_translation($item.update.shop.section)} ({$shop_type[$item.update.shop.type]}) <small class="pull-right">#{$item.update.shop.id}</small></h3>
                </div>
                <div class="block-content">
                    {foreach $item.update.item_shop as $sell}
                        <div style="display: flex;">
                            {$.php.set_item($sell.item_id, false,false, '<div class="item-name"><img src="%icon%"><div><span class="item-name__content">%name% <span class="item-name__additional">%add_name%</span></span></div></div>')}
                            <div style="margin-left: auto; line-height: 32px;">
                                <small>
                                    {$item_status[$sell.status]}{if $sell.status == 1} {$ajax_buy_shop_for} {$.php.floatval($.php.number_format($sell.earned_money, 2, ".", ""))} <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="{$comission_notify}">?</span>{/if}
                                </small>
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
*}
<style>
    .w-32 {
        width: 32px !important;
    }
    .h-32 {
        height: 32px !important;
    }
</style>

<div class="block rounded">
    <div class="block-content block-content-full">
        <ul class="list list-timeline list-timeline-modern pull-t">
            {foreach $history_list as $item index=$index}

            <li data-toggle="tooltip" data-placement="left" title="{$shop_status[$item.update.shop.status]}">
                <div class="list-timeline-time">#{$item.update.shop.id}</div>
                <img src="/template/panel/assets/media/market/{$item.update.shop.section}.png" width="32" height="32" class="list-timeline-icon rounded">

                <div class="list-timeline-content">
                    <p class="font-w600">{$.php.get_translation($item.update.shop.section)} ({$shop_type[$item.update.shop.type]})</p>
                    <p class="{if $item.update.shop.status == -1}text-danger{elseif $item.update.shop.status == 0}text-info{elseif $item.update.shop.status == 1}text-warning{elseif $item.update.shop.status == 2}text-danger{/if}">{$shop_status[$item.update.shop.status]}</p>
                    <div class="row">
                        <div class="col-sm-12 col-xl-12">
                            <ul class="nav-users push">
                                {foreach $item.update.item_shop as $sell}
                                    <li>
                                        <a href="javascript:void(0);" style="padding:3px 0px 3px 62px;">

                                            {set $it = $.php.set_item($sell.item_id, false,true)}
                                            <img {$.php.get_icon_item($it.icon,$it.icon_panel, $this->sid, false)}  class="img-avatar rounded w-32 h-32">

                                            {if $sell.count > 1}{set $count_ = '<span class="text-primary-darker">x'~$sell.count~'</span>'}{else}{set $count_ = ''}{/if}
                                            {if $sell.enc > 0}{set $enc_ = '<span class="text-warning">+'~$sell.enc~'</span>'}{else}{set $enc_ = ''}{/if}
                                            {$it.name} {$count_}{$enc_}<div class="font-w400 font-size-xs text-muted">{$it.add_name}</div>
                                            {if $sell.status == 0}
                                                <i class="fa fa-circle text-info" style="left: 32px;top: 32px;"></i>
                                            {elseif $sell.status == 1}
                                                <i class="fa fa-circle text-success" style="left: 32px;top: 32px;"></i>
                                            {elseif $sell.status == 2}
                                                <i class="fa fa-circle text-warning" style="left: 32px;top: 32px;"></i>
                                            {elseif $sell.status == 3}
                                                <i class="fa fa-circle text-danger" style="left: 32px;top: 32px;"></i>
                                            {/if}
                                            <small>
                                                {$item_status[$sell.status]}
                                                {if $sell.status == 1}
                                                    {$ajax_buy_shop_for}: {$.php.number_format($.php.floatval($.php.number_format($sell.earned_money, 2, ".", "")))} {$payment_system.short_name_valute} <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="{$comission_notify}">?</span>
                                                {elseif $sell.status == 0}
                                                    {$ajax_buy_shop_for}: {$.php.number_format($.php.floatval($.php.number_format($sell.price, 2, ".", "")))} {$payment_system.short_name_valute}
                                                {/if}
                                            </small>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                    <p>{$creation_date} {$item.update.shop.data_create}</p>
                </div>
            </li>
            {/foreach}
        </ul>
    </div>
</div>