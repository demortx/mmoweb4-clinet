<div class="rating__tab" data-sub-rating-tab>
    <div class="top top_header">
        <div class="top__ico top__ico_header"></div>
        <div class="top__num"></div>
        <div class="top__name top__name_header">
            Player
        </div>
        <div class="top__score top__score_header">
            PK
        </div>
    </div>
    <!-- Конец      top   -->
    {foreach $stat as $player index=$index}
        <div class="top">
            <div class="top__ico"></div>
            <div class="top__num">
                {$index+1}.
            </div>
            <div class="top__name">
                {$.php.get_crest($player.ally_crest_id, $sid)}{$.php.get_crest($player.crest_id, $sid)} {$player.char_name}
            </div>
            <div class="top__score">
                {$player.pk}
            </div>
        </div>
        {if $count < ($index+1)}{break}{/if}
    {/foreach}
    <!-- Конец      top   -->

</div> <!-- END       rating__tab   -->
