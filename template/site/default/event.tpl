{if $iblock.tpl?}
    {foreach $iblock.content as $element}
        <div class="event events__event" title="Date: {$element.date}">
            <a href="{$element.url}" class="event__link"></a>
            <!-- Картинка к новости любого размера -->
            <div class="event__img" style="background-image: url({$element.img});">
            </div>
            <div class="event__title">
                {$element.title}
            </div>
            <div class="event__content">
                {$element.body}
            </div>
        </div>
        <!-- END event -->
    {/foreach}
{/if}