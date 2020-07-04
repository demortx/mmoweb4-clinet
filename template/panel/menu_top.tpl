<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header content-header-fullrow bg-black-op-10">
                <div class="content-header-section text-center align-parent">
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                    <!-- END Close Sidebar -->

                    <!-- Logo -->
                    <div class="content-header-item">
                        <a class="link-effect font-w700" href="{$.php.set_url('/')}">
                            <span class="font-size-xl text-dual-primary-dark">{$.site.config.project.name}</span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side Main Navigation -->
            <div class="content-side content-side-full">

                <ul class="nav-main">
                    {$.php.render_menu_server()}
                    {$.php.render_menu()}
                </ul>
            </div>
            <!-- END Side Main Navigation -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->
<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">

            {if $.php.render_menu_server() == ''}
            <div class="content-header-item">
                <a class="link-effect font-w700 mr-5" href="{$.php.set_url('/')}">
                    <span class="font-size-xl text-dual-primary-dark">{$.site.config.project.name}</span>
                </a>
            </div>
            {/if}
            <div class="content-header-item">

                <ul class="nav-main-header">
                    {$.php.render_menu_server()}
                    <li></li>
                </ul>
            </div>
        </div>
        <!-- END Left Section -->

        <!-- Middle Section -->
        <div class="content-header-section d-none d-lg-block">
            <ul class="nav-main-header">
                {$.php.render_menu()}
            </ul>
            <!-- END Header Navigation -->
        </div>
        <!-- END Middle Section -->

        <!-- Right Section -->
        <div class="content-header-section">


            {if $.site.session->isLogin}
                {set $render_menu_user_dropdown = $.php.render_menu_user_dropdown()}
                {set $render_widget_ma_manager = $.php.render_widget_ma_manager()}
                {if $render_menu_user_dropdown != '' OR $render_widget_ma_manager != ''}
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <i class="fa fa-angle-down ml-5"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(97px, 34px, 0px);">
                            {if $render_menu_user_dropdown != ''}
                                <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">{$.site.session->getName()}</h5>
                                {$render_menu_user_dropdown}
                                <div class="dropdown-divider"></div>
                            {/if}
                            {$render_widget_ma_manager}
                        </div>
                    </div>
                {/if}
                <a href="{$.php.set_url('logout')}" class="btn btn-rounded btn-dual-secondary mr-5">
                    {$login_menu_lang_btn_logout} <i class="si si-logout"></i>
                </a>
            {else}


                <a href="{$.php.set_url('sign-in')}" class="btn btn-dual-secondary mr-5 {if $.site.url_segment[1] == 'sign-in'}active{/if}">
                    <i class="si si-login"></i> {$login_menu_lang_btn_signin}
                </a>
                <a href="{$.php.set_url('sign-up')}" class="btn btn-dual-secondary {if $.site.url_segment[1] == 'sign-up'}active{/if}">
                    <i class="fa fa-user-plus"></i> {$login_menu_lang_btn_signup}
                </a>
            {/if}

            <!-- Toggle Sidebar -->
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

        <!-- Header Loader -->
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header content-header-fullrow text-center">
                <div class="content-header-item">
                    <i class="fa fa-sun-o fa-spin text-white"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->

</header>
<!-- END Header -->