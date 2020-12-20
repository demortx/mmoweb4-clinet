<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading pt-20">{$ParsFileGame_title}
        <small>
            <button type="button" class="btn btn-sm btn-rounded btn-primary d-md-none float-right ml-5 waves-effect waves-light" data-toggle="class-toggle" data-target=".js-inbox-nav" data-class="d-none d-md-block">Меню</button>
        </small>
    </h2>
    <div class="row"><div class="col-md-5 col-xl-3"><!-- Collapsible Inbox Navigation -->
            <div class="js-inbox-nav d-none d-md-block">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{$ParsFileGame_nav_title}</h3>
                    </div>
                    <div class="block-content">
                        <ul class="nav nav-pills flex-column push">
                            {if $config.project.server_info? AND $.php.is_array($config.project.server_info)}
                                {foreach $config.project.server_info as $platform => $server_list}
                                    {$platform}
                                    <li class="nav-item">
                                        <hr class="my-5">
                                    </li>
                                    {if $.php.is_array($server_list) AND $.php.count($server_list)}
                                        {foreach $server_list as $sid => $server}
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-between" href="{$.php.set_url($.const.ADMIN_URL~'/files?sid='~$sid)}">
                                                    <span><i class="fa fa-fw fa-folder mr-5"></i> {$server.name}</span>
                                                </a>
                                            </li>
                                        {/foreach}
                                    {/if}

                                {/foreach}
                            {else}
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center justify-content-between" href="#">
                                        <span>{$ParsFileGame_empty_server}</span>
                                    </a>
                                </li>
                            {/if}

                        </ul>
                    </div>
                </div>
            </div>
            <!-- END Collapsible Inbox Navigation -->

        </div>
        <div class="col-md-7 col-xl-9">
            {$block_content}

            <!-- END Message List -->
        </div>
    </div>
</div>