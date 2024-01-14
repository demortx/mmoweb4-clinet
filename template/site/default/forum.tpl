<div class="sidebar__heading heading">
    <div class="heading__content">
        <div class="heading__ico heading__ico_scroll"></div>
        <div class="heading__title">
            {$L_FORUM_TITLE}
        </div>
        <div class="heading__btns">
            <a href="{$L_MENU_BTN_FORUM_URL}" target="_blank" class="btn btn_type_3 btn_fs_gilroy">
                <div class="btn__content">{$L_FORUM_GO} <i class="gwi gwi_right-open gwi_arrow"></i> </div>
            </a>
        </div>
    </div>
</div> <!-- END  heading -->
<div class="themes">
    {foreach $posts as $post}
    <div class="themes__theme theme">
        <a href="{$L_MENU_BTN_FORUM_URL}{$post.url}" target="_blank" class="theme__link"></a>
        <div class="theme__ava" style="background-image: url({if $post.avatar?}{$L_MENU_BTN_FORUM_URL}{$post.avatar}{else}{$.site.dir_site}/images/forum/ava-def.jpg{/if});"></div>
        <div class="theme__content">
            <div class="theme__title">
                {$post.title|ereplace:'/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/':'censure'|truncate:40:"..."}
            </div>
            <div class="theme__info">
                <div class="theme__author-box">
                    <!-- {$post.profile} -->
                    {$L_FORUM_AUTHOR}: <span class="theme__author">{$post.last_poster_name}</span>
                </div>
                <div class="theme__date-box">
                    <span class="theme__date">{$post.last_post|date_format:"%d.%m.%Y в %H:%M"}</span>
                </div>
            </div>
        </div>
    </div> <!-- END  theme  -->
    {/foreach}
</div> <!-- END  themes  -->
