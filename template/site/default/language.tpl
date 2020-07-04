<div class="langs">
    <div class="lang__link lang__link_select">
        <img class="lang__img lang__img_select" src="{$.site.dir_site}/images/lang/lang__{$_LANG}.png" alt="{$_LANG}">
        <span class="lang__name lang__name_select">( {$_LANG} )</span>
    </div>
    <div class="lang__list">
        {foreach $language_list as $lang_key => $lang_title}
            {if $_LANG == $lang_key}{continue}{/if}
            <a href="{$.php.set_url($lang_key,true,false)}" class="lang__link lang__link_sub">
                <img class="lang__img" src="{$.site.dir_site}/images/lang/lang__{$lang_key}.png" alt="{$lang_title}">
                <span class="lang__name">{$lang_title}</span>
            </a>
        {/foreach}
    </div>
</div>