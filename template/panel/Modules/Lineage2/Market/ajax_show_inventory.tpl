<div class="row">
    <div class="col-lg-12 text-center">
        {foreach $inventory as $item}
            <div class="mb-1">{$.php.set_item($item.i_i, false, false, '<div data-item="%id%" style="text-align: left;"><img src="%icon%" width="32px" class="mr-1">%name% %add_name%</div>')}</div>
        {/foreach}
    </div>
</div>