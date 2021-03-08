<div class="pagination">
    {if $getPrevUrl?}
        <a href="{$.php.set_url('/?news='~$getPrevUrl)}" class="pagination__arrow pagination__arrow_left {*pagination__arrow_active_false*}"></a>
    {/if}
    {foreach $getPages as $page}
            {if $page.num == '...'}
                <a href="javascript:void(0)" class="pagination__link">{$page.num}</a>
            {else}
                <a href="{$.php.set_url('/?news='~$page.num)}" class="pagination__link {if $page.isCurrent}pagination__link_active{/if}">{$page.num}</a>
            {/if}
    {/foreach}

    {if $getNextUrl?}
        <a href="{$.php.set_url('/?news='~$getNextUrl)}" class="pagination__arrow pagination__arrow_right pagination__arrow_active"></a>
    {/if}
</div>