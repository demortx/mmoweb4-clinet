
<div class="list-group push">
    {if $.php.in_array('armor', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/armor')}">
        <img src="/template/panel/assets/media/market/armor.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$armor} <br><small>{$armor_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['armor']?}{$count_section['armor']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('weapon', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/weapon')}">
        <img src="/template/panel/assets/media/market/sword.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$weapon} <br><small>{$weapon_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['weapon']?}{$count_section['weapon']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('jewelry', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/jewelry')}">
        <img src="/template/panel/assets/media/market/jewelry.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$jewelry} <br><small>{$jewelry_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['jewelry']?}{$count_section['jewelry']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('consumables', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/consumables')}">
        <img src="/template/panel/assets/media/market/miscellaneous.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$consumables} <br><small>{$consumables_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['consumables']?}{$count_section['consumables']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('coin', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/coin')}">
        <img src="/template/panel/assets/media/market/money.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$coin} <br><small>{$coin_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['coin']?}{$count_section['coin']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('character', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/character')}">
        <img src="/template/panel/assets/media/market/wizard.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$character} <br><small>{$character_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['character']?}{$count_section['character']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('etc', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/etc')}">
        <img src="/template/panel/assets/media/market/shelf.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$etc} <br><small>{$etc_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['etc']?}{$count_section['etc']}{else}0{/if}</span>
    </a>
    {/if}
</div>


<a class="btn btn-block btn-hero btn-noborder btn-rounded btn-success mb-10" href="{$.php.set_url('/panel/market/sell')}"><i class="fa fa-gavel mr-5"></i> {$sell_items}</a>
{if $.php.in_array('character', $section_status)}
<a class="btn btn-block btn-hero btn-noborder btn-rounded btn-primary mb-10" href="{$.php.set_url('/panel/market/sell-character')}"><i class="fa fa-female mr-5"></i> {$sell_character}</a>
{/if}
<p class="text-center">
    <a class="text-muted" href="{$.php.set_url('/panel/market/rules')}">{$rules}</a>
    <br>
    <a class="text-muted" href="{$.php.set_url('/panel/market/help')}">{$help}</a>
    <br>
    <a class="text-muted" href="{$.php.set_url('/panel/market/withdrawal')}">{$request}</a>
</p>
