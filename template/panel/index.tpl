<!doctype html>
    {include "/panel/head.tpl"}
    <body>
        {$_SEO_BODY}
        <!-- Page Container-->
            <div id="page-container" class="{$_PAGE_CONTENT_CLASS} {$_PAGE_CONTENT_CLASS_ADD}">
            {$_MENU}
            <!-- Main Container -->
            <main id="main-container">
                {if $_CONTENT?}
                    <div class="content content-full">
                        {$_CONTENT}
                    </div>
                {else}
                    {$_CONTENT_FULL}
                {/if}
            </main>
            <!-- END Main Container -->
                {if $_FOOTER}
                    {include "/panel/footer.tpl"}
                {/if}
                <!-- Pop Out Modal -->
                <div class="modal fade" id="modal-ajax" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-popout" role="document">
                        <div class="modal-content">
                            <form class="modal-ajax-form" action="/input" method="post" onsubmit="return false;">
                                <div class="block block-themed block-transparent mb-0">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title modal-ajax-title"></h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="si si-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content modal-ajax-content"></div>
                                </div>
                                <div class="{*modal-footer*} modal-ajax-footer block-content block-content-sm block-content-full bg-body-light block-settings-save-fix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END Pop Out Modal -->
        </div>
        <!-- END Page Container -->
        <!-- Core JS -->
        {include "/panel/javascript.tpl"}
    </body>
</html>