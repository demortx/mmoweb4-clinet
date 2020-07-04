<div class="content">
    <h2 class="h4 font-w300 mt-50">{$title_lang}</h2>
    <div class="row row-deck">
        {foreach $menu_list as $plugins}
            {foreach $plugins as $btn}
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-pop" href="{$btn.url}">
                        <div class="block-content block-content-full text-center">
                            <div class="p-20 mb-5">
                                <i class="{$btn.icon} text-gray"></i>
                            </div>
                            <p class="font-size-lg font-w600 mb-0">
                                {$btn.title}
                            </p>
                            <p class="font-size-sm font-w600 text-muted mb-0">
                                {$btn.desc}
                            </p>
                        </div>
                    </a>
                </div>
            {/foreach}
        {/foreach}
    </div>
</div>