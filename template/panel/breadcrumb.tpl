<nav class="breadcrumb bg-white push">
    {add $breadcrumb_link = ''}
    {foreach $.php.get_instance()->url->segment_array() as $link last=$last}

        {set $breadcrumb_link = $breadcrumb_link ~ $link ~ '/'}
        {if $last == false}
            <a class="breadcrumb-item" href="{$.php.set_url($breadcrumb_link)}">{$.php.ucfirst($.php.rawurldecode($link|ereplace:'/(.*)[.](\d+)/i':'$1'))}</a>
        {else}
            <span class="breadcrumb-item active">{$.php.ucfirst($.php.rawurldecode($link|ereplace:'/(.*)[.](\d+)/i':'$1'))}</span>
        {/if}

    {/foreach}
</nav>