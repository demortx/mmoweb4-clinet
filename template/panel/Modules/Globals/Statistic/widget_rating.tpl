{if !$.site.session->isLogin}
    {include '/panel/breadcrumb.tpl'}
{/if}

<h2 class="content-heading">Rating {$.php.get_sid_name(true, true)}</h2>

<div class="block block-rounded block-fx-shadow">
{if $.php.is_array($rating) AND $.php.count($rating)}
    <ul class="nav nav-tabs nav-tabs-block align-items-center" data-toggle="tabs" role="tablist">
        {foreach $section as $tab_a first=$first}
        <li class="nav-item">
            <a class="nav-link {if $first}active{/if}" href="#tab-{$tab_a}">
                {if $lang_page[$tab_a]?}{$lang_page[$tab_a]}{else}{$tab_a}{/if}
            </a>
        </li>
        {/foreach}
    </ul>
    <div class="block-content block-content-full tab-content">

        {foreach $rating as $tab_c => $top first=$first2}
        <div class="tab-pane {if $first2}active{/if}  table-responsive" id="tab-{$tab_c}" role="tabpanel">

            {if $top.error == '0'}
                {if $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Globals/Statistic/custom/{$platform}/{$tab_c}.tpl")}
                    {include "/panel/Modules/Globals/Statistic/custom/{$platform}/{$tab_c}.tpl" top_list=$top.data}
                {elseif $.php.file_exists( $.const.ROOT_DIR ~ $.const.VIEWPATH ~ "/panel/Modules/Globals/Statistic/{$platform}/{$tab_c}.tpl")}
                    {include "/panel/Modules/Globals/Statistic/{$platform}/{$tab_c}.tpl" top_list=$top.data}
                {else}
                    No support template {$tab_c}
                {/if}
            {else}
                <pre>{$top.data}</pre>
            {/if}

            {if $top.date?}
                <blockquote class="blockquote text-right mb-0">
                <footer class="blockquote-footer">{$top.date}</footer>
                </blockquote>
            {/if}
        </div>
        {/foreach}
    </div>
{else}
    <p class="p-10 bg-info text-center">{$server_rating_empty}</p>

{/if}
</div>
