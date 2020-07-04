{if $.site.session->isLogin}
    <a href="{$.php.set_url('panel')}" class="cp-box__btn btn btn_type_1">
        <span class="cp-box__gwi gwi gwi_user"></span>
        <div class="btn__content cp-box__btn-content">{$.site.session->getName()}</div>
    </a>
{else}
    <a href="{$L_MENU_BTN_CP_URL}" class="cp-box__btn btn btn_type_1">
        <span class="cp-box__gwi gwi gwi_user"></span>
        <div class="btn__content cp-box__btn-content">{$L_MENU_BTN_CP}</div>
    </a>
{/if}