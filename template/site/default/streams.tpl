<div class="streams">
    <div class="streams__media media">
        <div class="content__heading media__heading heading">
            <div class="heading__content">
                <div class="heading__ico heading__ico_scroll"></div>
                <div class="heading__title">
                    {$L_STREAM_TITLE}
                </div>
            </div>
        </div> <!-- END  heading -->
        {if $stream_exist}
            {foreach $stream_list as $stream first=$first}
                {if $stream.type == 'twitch'}
                    <div class="media__item" data-video-twitch="{$stream.key}" data-video-autoplay="{if $first}true{else}false{/if}"></div>
                {elseif $stream.type == 'youtube'}
                    <div class="media__item" data-video-youtube="{$stream.key}" data-video-autoplay="{if $first}true{else}false{/if}"></div>
                {/if}
            {/foreach}
        {else}
            <div><span class="article__title">Здесь мог быть ваш стрим!</span></div>
        {/if}
    </div>
</div>
<!-- END  forum -->