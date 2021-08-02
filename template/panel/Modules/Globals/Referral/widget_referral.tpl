{$.site._SEO->addTegHTML('footer', 'clipboard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/clipboard/clipboard.min.js'])}
<div class="block invisible" data-toggle="appear">
    <div class="block-content block-content-full animated fadeIn ribbon ribbon-bookmark ribbon-primary ribbon-right">
        <a class="ribbon-box" href="{$info_url}" target="_blank">
            <i class="fa fa-info"></i>
        </a>
        <div class="py-20 text-center">
            <div class="mb-20">
                <i class="si si-users fa-4x text-info"></i>
            </div>
            {if $.site.config.referral['sale'] OR $.site.config.referral['commission']}
            <div class="row ">
                {if $.site.config.referral['sale']}
                <div class="{if $.site.config.referral['commission']}col-6{else}col-12{/if} text-right border-r" data-toggle="tooltip" data-placement="top" title="" data-original-title="{$info_sale}">
                    <div class="animated fadeInLeft" data-toggle="appear" data-class="animated fadeInLeft">
                        <div class="font-size-h3 font-w600 text-info">{$.php.intval($.site.session->session.user_data.referral.sale)}%</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$title_sale}</div>
                    </div>
                </div>
                {/if}
                {if $.site.config.referral['commission']}
                <div class="{if $.site.config.referral['sale']}col-6{else}col-12{/if}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{$info_commission}">
                    <div class="animated fadeInRight" data-toggle="appear" data-class="animated fadeInRight">
                        <div class="font-size-h3 font-w600 text-success">{$.php.intval($.site.session->session.user_data.referral.commission)}%</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$title_commission}</div>
                    </div>
                </div>
                {/if}
            </div>
            {/if}

            <div class="font-size-h4 font-w600 py-10">{$.php.intval($.site.session->session.user_data.referral.referrals)} {$count_referral}</div>
            <div class="text-muted">{$desc}
            </div>
            <div class="pt-20">
                <button class="btn btn-rounded btn-alt-info clipboard" data-clipboard-text="{$.php.set_url('/sign-up?referral='~$.site.session->session.master_account.mid)}">
                    <i class="fa fa-link mr-5 animated bounce"></i> {$invite_btn}
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        var clipboard = new ClipboardJS('.clipboard');

        clipboard.on('success', function(e) {
            jQuery.notify({
                icon: 'fa fa-copy',
                message: '{$noti_success}',
                url: '{$.php.set_url('/sign-up?referral='~$.site.session->session.master_account.mid)}'
            }, {
                element: 'body',
                type: 'info',
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: 20,
                spacing: 10,
                z_index: 10000,
                delay: 5000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOutDown'
                }
            });
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            jQuery.notify({
                icon: 'fa fa-copy',
                message: '{$noti_error}',
                url: '{$.php.set_url('/sign-up?referral='~$.site.session->session.master_account.mid)}'
            }, {
                element: 'body',
                type: 'danger',
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                offset: 20,
                spacing: 10,
                z_index: 10000,
                delay: 5000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOutDown'
                }
            });
        });
    });
</script>
