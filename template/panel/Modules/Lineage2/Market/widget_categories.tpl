
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
        <img src="/template/panel/assets/media/market/weapon.png" width="32" width="32" class="mr-15">
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
    {if $.php.in_array('rare', $section_status)}
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/rare')}">
            <img src="/template/panel/assets/media/market/rare.png" width="32" width="32" class="mr-15">
            <span class="mr-auto">{$rare} <br><small>{$rare_desc}</small></span>
            <span class="badge badge-pill badge-secondary">{if $count_section['rare']?}{$count_section['rare']}{else}0{/if}</span>
        </a>
    {/if}
    {if $.php.in_array('consumables', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/consumables')}">
        <img src="/template/panel/assets/media/market/consumables.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$consumables} <br><small>{$consumables_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['consumables']?}{$count_section['consumables']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('coin', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/coin')}">
        <img src="/template/panel/assets/media/market/coin.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$coin} <br><small>{$coin_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['coin']?}{$count_section['coin']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('stones', $section_status)}
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/stones')}">
            <img src="/template/panel/assets/media/market/stones.png" width="32" width="32" class="mr-15">
            <span class="mr-auto">{$stones} <br><small>{$stones_desc}</small></span>
            <span class="badge badge-pill badge-secondary">{if $count_section['stones']?}{$count_section['stones']}{else}0{/if}</span>
        </a>
    {/if}
    {if $.php.in_array('accessory', $section_status)}
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/accessory')}">
            <img src="/template/panel/assets/media/market/accessory.png" width="32" width="32" class="mr-15">
            <span class="mr-auto">{$accessory} <br><small>{$accessory_desc}</small></span>
            <span class="badge badge-pill badge-secondary">{if $count_section['accessory']?}{$count_section['accessory']}{else}0{/if}</span>
        </a>
    {/if}
    {if $.php.in_array('recipes', $section_status)}
        <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/recipes')}">
            <img src="/template/panel/assets/media/market/recipes.png" width="32" width="32" class="mr-15">
            <span class="mr-auto">{$recipes} <br><small>{$recipes_desc}</small></span>
            <span class="badge badge-pill badge-secondary">{if $count_section['recipes']?}{$count_section['recipes']}{else}0{/if}</span>
        </a>
    {/if}
    {if $.php.in_array('character', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/character')}">
        <img src="/template/panel/assets/media/market/character.png" width="32" width="32" class="mr-15">
        <span class="mr-auto">{$character} <br><small>{$character_desc}</small></span>
        <span class="badge badge-pill badge-secondary">{if $count_section['character']?}{$count_section['character']}{else}0{/if}</span>
    </a>
    {/if}
    {if $.php.in_array('etc', $section_status)}
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{$.php.set_url('/panel/market/etc')}">
        <img src="/template/panel/assets/media/market/etc.png" width="32" width="32" class="mr-15">
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
