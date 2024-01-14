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
                {if $stream.platform == 'twitch'}
                    <iframe src="{$stream.stream}" frameborder="0" allowfullscreen="true" scrolling="no" height="140" width="250"></iframe>
                {elseif $stream.platform == 'youtube'}
                    <iframe id="ytplayer_{$stream.id}" type="text/html" width="250" height="140" src="{$stream.stream}" frameborder="0" allowfullscreen></iframe>
                {elseif $stream.platform == 'trovo'}
                    <iframe type="text/html" width="250" height="140" src="{$stream.stream}" frameborder="0" allowfullscreen>
                {elseif $stream.platform == 'other'}
                    {$stream.stream}
                {/if}



            {/foreach}
        {else}
            <div><span class="article__title">Здесь мог быть ваш стрим!</span></div>
        {/if}
    </div>
</div>
<!-- END  forum -->