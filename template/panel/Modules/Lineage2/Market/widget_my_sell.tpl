{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}

<div class="block support-grid rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title d-none d-md-block">Список товаров на {$.php.get_sid_name(true, true)}
        </h3>
    </div>
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-striped table-vcenter">
                <thead>
                <tr>
                    <th>Категория</th>
                    <th>Лот</th>
                    <th class="text-center">Количество</th>
                    <th class="text-center">Цена</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {foreach $data as $item}
                    <tr>
                        <td>
                            {$.php.get_translation($item.section)}
                        </td>
                        {if $item.char_info == "0"}
                            <td>
                                <div class="item-name">
                                    <img src="{$.php.check_icon_item($item.icon, $sid)}">
                                    <div>
                                    <span class="item-name__content">{$item.name} <span class="item-name__additional">{$item.add_name}</span>
                                    {if $item.enc > 0}
                                        +{$item.enc}
                                    {/if}
                                    </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {$item.count}
                            </td>
                        {else}
                            <td colspan="2">
                            <span>
                                <b>{$item.char_info.name}</b>
                                <br>
                                <small>{$.php.get_class_name($item.char_info.class_id)} (Lv. {$item.char_info.level})</small>
                            </span>
                            </td>
                        {/if}
                        <td class="text-center">
                            {$item.price}
                        </td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-primary submit-btn">Снять с продажи</button>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>