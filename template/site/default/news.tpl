<div class="content__heading heading">
    <div class="heading__content">
        <div class="heading__ico heading__ico_scroll"></div>
        <div class="heading__title">
            {$L_NEWS_TITLE}
        </div>
    </div>
</div> <!-- END  heading -->
{if $.php.is_array($news_list) AND $.php.count($news_list)}
{foreach $news_list as $news}
    <div class="content__article article">
        <div class="article__title">
            {$news.title}
        </div>
        <div class="article__content">
            {$news.body}
        </div>
        <div class="article__btns">
            <div class="article__info">
                <span class="article__gwi gwi gwi_clock"></span>
                <span class="article__date"> {$news.date}</span>
            </div>
            {if $news.url != '#'}
                <a href="{$news.url}" target="_blank" class="article__btn btn btn_type_3 article__more">
                    <div class="btn__content">{$L_NEWS_BTN_READ_MORE}</div>
                </a>
            {/if}
        </div>
    </div> <!-- END  article -->
{/foreach}
{else}
    <div class="content__article article">
        <div class="article__title" style="text-align: center">
            {$L_NEWS_TITLE_EMPTY}
        </div>
        <div class="article__content">
        </div>
    </div>
{/if}
<!-- PAGINATION -->
{$PAGINATION}