<!--[if lte IE 9]><html lang="{$.site._LANG}" class="lt-ie10 lt-ie10-msg no-focus"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="{$.site._LANG}" class="no-focus"> <!--<![endif]-->
<head lang="{$.site._LANG}">
    {$_SEO_HEAD}
    <!-- Stylesheets -->
    {if $.site.session->isLogin}
        {if $.site.visualization.cabinet_layout_login_color != 'default'}
            <link rel="stylesheet" id="css-theme" href="{$.site.dir_panel}/assets/css/themes/{$.site.visualization.cabinet_layout_login_color}.min.css">
        {/if}
    {else}
        {if $.site.visualization.cabinet_layout_no_login_color != 'default'}
            <link rel="stylesheet" id="css-theme" href="{$.site.dir_panel}/assets/css/themes/{$.site.visualization.cabinet_layout_no_login_color}.min.css">
        {/if}
    {/if}
    <!-- END Stylesheets -->
</head>
