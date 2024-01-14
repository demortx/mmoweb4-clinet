{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}

<h2 class="content-heading">{$widget_new_item_title}</h2>

<div class="block rounded">
    <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
        {foreach $new as $category => $items first=$first}
            <li class="nav-item">
                <a class="nav-link {if $first}active{/if}" href="#{$category}">{$.php.get_translation($category)}</a>
            </li>
        {/foreach}
    </ul>

    <div class="block-content tab-content p-0">
        {foreach $new as $category => $items first=$first}
            <div class="tab-pane {if $first}active{/if}" id="{$category}" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th style="width: 250px;">{$widget_my_sell_title_lot}</th>
                            {if $category == "character"}
                                <th>{$inventory}</th>
                            {/if}
                            {if $category != "coin" && $category != "character"}
                                <th style="width: 50px;" class="text-center">{$grade}</th>
                                {if $category == "weapon" || $category == "armor"}
                                    <th class="text-center">{$attribute}</th>
                                {/if}
                                <th class="text-center">{$quantity}</th>
                            {/if}
                            <th class="text-center" style="width: 180px;">{$price}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {if $items == null}
                            <tr>
                            <td colspan="5" class="text-center">No Items</td>
                        {else}
                            {foreach $items as $item}
                                <tr>
                                    <td>
                                        {if $category == "character"}
                                            <span>
                                                <b>{$item.char_info.name}</b>
                                                <br>
                                                <small>{$.php.get_class_name($item.char_info.class_id)} (Lv. {$item.char_info.level})</small>
                                            </span>
                                        {else}
                                            <div class="item-name">
                                                <img {$.php.get_icon_item($item.icon,$item.icon_panel, $sid)}>
                                                <div>
                                                    <span class="item-name__content">{$item.name} <span class="item-name__additional">{$item.add_name}</span>
                                                    {if $item.enc > 0}
                                                        +{$item.enc}
                                                    {/if}
                                                    </span>
                                                </div>
                                            </div>
                                        {/if}
                                    </td>
                                    {if $category == "character"}
                                        <td>
                                            {foreach 1..5 as $value index=$index}
                                                {$.php.set_item($item.char_inventory[$index].i_i, false, false, '<span data-item="%id%" style="margin: 0 1px;"><img src="%icon%" width="32px"></span>')}
                                            {/foreach}
                                            <button type="submit" class="btn btn-sm btn-outline-primary submit-btn ml-1" {$.php.btn_ajax("Modules\Lineage2\Market\Market", "ajax_show_inventory", ['id' => $item.shop_id])}>{$all_inventory}</button>
                                        </td>
                                    {/if}
                                    {if $category != "coin" && $category != "character"}
                                        <td class="text-center">
                                            {if $item.grade != "" && $item.grade != "none"}
                                                <span class="item-grade">{$item.grade}</span>
                                            {/if}
                                        </td>
                                        {if $category == "armor" || $category == "weapon"}
                                            <td class="text-center">
                                                {if $item.a_att_value > 0}
                                                    {$att_type[$item.a_att_type]} {$item.a_att_value}<br>
                                                {/if}
                                                {if $item.d_att_0 > 0}
                                                    {$att_type[0]} {$item.d_att_0}<br>
                                                {/if}
                                                {if $item.d_att_1 > 0}
                                                    {$att_type[1]} {$item.d_att_1}<br>
                                                {/if}
                                                {if $item.d_att_2 > 0}
                                                    {$att_type[2]} {$item.d_att_2}<br>
                                                {/if}
                                                {if $item.d_att_3 > 0}
                                                    {$att_type[3]} {$item.d_att_3}<br>
                                                {/if}
                                                {if $item.d_att_4 > 0}
                                                    {$att_type[4]} {$item.d_att_4}<br>
                                                {/if}
                                                {if $item.d_att_5 > 0}
                                                    {$att_type[5]} {$item.d_att_5}
                                                {/if}
                                            </td>
                                        {/if}
                                        <td class="text-center">
                                            {$item.count}
                                        </td>
                                    {/if}
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <span class="item-price">{$.php.floatval($item.price)}</span>
                                            <button type="submit" class="btn btn-sm btn-outline-primary submit-btn" {$.php.btn_ajax("Modules\Lineage2\Market\Market", "ajax_buy_shop_popup", ['id' => $item.id])}>{$buy}</button>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        {/foreach}
    </div>
</div>