<div class="sidebar__heading heading">
    <div class="heading__content">
        <div class="heading__ico heading__ico_scroll"></div>
        <div class="heading__title">
            {$L_RATING_TITLE}
        </div>
    </div>
</div> <!-- END  heading -->
<div class="rating-wrp rating-wrp_pos" data-rating-box>
    <div class="rating rating_height" data-rating>
        {foreach $servers as $sid => $srv}
        <!-- Сервер -->
        <div class="rating__tab" data-rating-tab data-sub-rating-box>
            {if $rating[$sid]?}
                <div class="rating rating_height" data-sub-rating>
                    {if $rating[$sid]?}
                        {foreach $rating[$sid] as $type =>  $stat}
                            <!--LINEAGE -->
                            {if $type == 'top_pvp' AND $stat['error'] == 0}
                                {include "site:rating/{$platform}/top_pvp.tpl" stat=$stat["data"] sid=$sid}
                            {/if}
                            {if $type == 'top_pk' AND $stat['error'] == 0}
                                {include "site:rating/{$platform}/top_pk.tpl" stat=$stat["data"] sid=$sid}
                            {/if}
                            <!--LINEAGE + BOI-->
                            {if $type == 'top_clan' AND $stat['error'] == 0}
                                {include "site:rating/{$platform}/top_clan.tpl" stat=$stat["data"] sid=$sid}
                            {/if}
                            <!-- END LINEAGE-->

                            {if $type == 'top_pkw' AND $stat['error'] == 0}
                                {include "site:rating/{$platform}/top_pkw.tpl" stat=$stat["data"] sid=$sid}
                            {/if}
                            {if $type == 'top_rank' AND $stat['error'] == 0}
                                {include "site:rating/{$platform}/top_rank.tpl" stat=$stat["data"] sid=$sid}
                            {/if}
                            <!--END BOI-->

                        {/foreach}
                    {/if}

                </div> <!-- END       rating   -->
                <div class="rating-btns" data-sub-rating-btns>
                    {if $rating[$sid]?}
                        {foreach $rating[$sid] as $type =>  $stat}
                            <!--LINEAGE -->
                            {if $type == 'top_pvp' AND $stat['error'] == 0}
                                <div class="btn btn_type_3 rating-sub-btn">
                                    <span class="btn__content">PvP</span>
                                </div>
                            {/if}
                            {if $type == 'top_pk' AND $stat['error'] == 0}
                                <div class="btn btn_type_3 rating-sub-btn">
                                    <span class="btn__content">Pk</span>
                                </div>
                            {/if}
                            <!--LINEAGE + BOI-->
                            {if $type == 'top_clan' AND $stat['error'] == 0}
                                <div class="btn btn_type_3 rating-sub-btn">
                                    <span class="btn__content">Clan</span>
                                </div>
                            {/if}
                            <!-- END LINEAGE-->
                            {if $type == 'top_pkw' AND $stat['error'] == 0}
                                <div class="btn btn_type_3 rating-sub-btn">
                                    <span class="btn__content">Pk win</span>
                                </div>
                            {/if}
                            {if $type == 'top_rank' AND $stat['error'] == 0}
                                <div class="btn btn_type_3 rating-sub-btn">
                                    <span class="btn__content">Rank</span>
                                </div>
                            {/if}

                            <!--END BOI-->
                        {/foreach}
                    {/if}
                </div> <!-- END       rating-btn  -->
            {else}
                <div style="text-align: center;margin: 25%;">
                    {$L_RATING_EMPTY_RATING}
                </div>
            {/if}
        </div>
            <!-- END      rating__tab   -->
        {/foreach}
    </div> <!-- END      rating   -->
    <div class="rating-btns" data-rating-btns>
        {foreach $servers as $srv}
            <div class="btn btn_type_3 rating-btn">
                <span class="btn__content">{$srv.name}</span>
            </div>
        {/foreach}
    </div> <!-- END       rating-btn  -->
</div>