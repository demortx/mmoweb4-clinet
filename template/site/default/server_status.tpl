{foreach $servers as $sid => $info}
    <div class="sidebar__server server">
        <div class="server__progress" data-online="{$info.online.online_multiple}">
            <div class="server__rate">x{$info.rate}</div>
            <div class="server__chorn">{$info.chronicle}</div>
        </div>
        <div class="server__content">
            <div class="server__title">
                {$info.name} <span class="color-orange">x{$info.rate}</span>
            </div>
            <div class="server__online">
                {if $info.online.server? AND $info.online.server == 1}
                {$L_SERVER_ONLINE}
                <span class="server__online-marker" title="Date update: {$info.online.date}, Max online: {$info.online.max_online_multiple}">
                    {$info.online.online_multiple}
                </span>
                {else}
                <span title="Date update: {$info.online.date}, Max online: {$info.online.max_online_multiple}">
                     {$L_SERVER_OFFLINE}
                </span>
                {/if}
            </div>
            <a href="{$info.link}" class="server__link-info">{$L_SERVER_ABOUT_READ}</a>
        </div>
    </div>
{/foreach}

