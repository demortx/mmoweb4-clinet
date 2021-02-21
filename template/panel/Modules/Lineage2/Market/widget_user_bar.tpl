<div  id="w_user_info">
<div class="block rounded">
    <div class="block-content">
        <h5>
            {$widget_user_profile}
            <small class="float-right text-center"><a href="{$.php.set_url('/panel/market/donations')}" class="text-primary-dark">{$widget_user_balance} {$.php.intval($.site.session->session.user_data.market.balance)}</a>
                <br>
                <a href="{$.php.set_url('/panel/market/donations')}" class="font-size-sm font-w300 link-effect">{$widget_user_bar_balance_up}</a>
            </small>
        </h5>

        <div class="row no-gutters">

            <div class="col-12 col-md-7">

                <table class="table table-borderless table-striped table-hover mb-0">
                    <tbody>
                    <tr>
                        <td>
                            {$widget_user_active}
                        </td>
                        <td class="text-center">
                            <strong class="text-success">{$.php.intval($.site.session->session.user_data.market.active_shop)}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$widget_user_sold}
                        </td>
                        <td class="text-center">
                            <strong class="text-success">{$.php.intval($.site.session->session.user_data.market.sale_shop)}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {$widget_user_comission}
                        </td>
                        <td class="text-center">
                            <strong class="text-success">{$.php.intval($.site.session->session.user_data.market.commision)}%</strong>
                        </td>
                    </tr>

                    </tbody>
                </table>


            </div>
            <div class="col-12 col-md-5 text-center">
                <div class="font-size-h4 font-w600">{$.php.intval($.site.session->session.user_data.market.level)}</div>
                <div class="font-size-sm font-w600 text-uppercase text-muted">{$widget_user_lvl}</div>
                <p class="mt-10">
                    <a href="{$.php.set_url('/panel/market/history')}" class="mr-5" title="Общая история"><i class="si si-book-open fa-2x"></i></a>
                    <a href="javascript:void();" title="{$widget_user_refresh}" class="submit-btn" {$.php.btn_ajax("Modules\Lineage2\Market\Market", "ajax_refresh_info")}><i class="si si-refresh fa-2x"></i></a>
                </p>

            </div>


            <div class="col-12 col-md-12 text-center">
                <a href="{$.php.set_url('/panel/market/withdrawal')}" class="btn btn-block btn-outline-primary  mb-10 mt-10">{$widget_user_withdraw}</a>
            </div>
        </div>
    </div>
</div>
</div>