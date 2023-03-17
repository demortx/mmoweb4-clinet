<div class="history__box">
    {foreach $items as $date => $item_list}
        <div class="history__date-box">
            <span class="history__date">{$date|replace:"item":""}</span>
        </div>
        <div class="history__list">
            {foreach $item_list as $i}
                <div class="history__hitem hitem">
                    <div class="hitem__pic pic-style-0">
                        <img src="{$i.img}" class="hitem__img">
                    </div>
                    <div class="hitem__container">
                        <div class="hitem__title">{$i.name}</div>
                        <div class="hitem__desc">{if $i.desc?}{$i.desc}{else}There is no description{/if}</div>
                        <div class="hitem__info">
                            {if $i.count > 1}<div class="hitem__rate">x{$i.count}</div>{/if}
                            {if $i.enc > 0}<div class="hitem__type">+{$i.enc}</div>{/if}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    {/foreach}
</div>