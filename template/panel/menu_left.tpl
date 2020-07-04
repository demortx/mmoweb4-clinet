<!--
    Helper classes

    Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

    Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
    Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
        - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
-->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">m</span><span class="text-primary">W</span>
                            </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
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
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->


        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            {$.php.render_menu_server()}
            <ul class="nav-main">
                {$.php.render_menu()}
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->

<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
            {if $.site.session->isLogin}
                {$.php.render_menu_bonus_cod()}
            {/if}
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <!-- User Dropdown -->

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


                <a href="{$.php.set_url('sign-in')}" class="btn btn-rounded btn-dual-secondary {if $.site.url_segment[1] == 'sign-in'}active{/if}">
                    <i class="si si-login"></i> {$login_menu_lang_btn_signin}
                </a>
                <a href="{$.php.set_url('sign-up')}" class="btn btn-rounded btn-dual-secondary {if $.site.url_segment[1] == 'sign-up'}active{/if}">
                    <i class="fa fa-user-plus"></i> {$login_menu_lang_btn_signup}
                </a>
            {/if}



        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->


    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <div class="spinner-border text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
