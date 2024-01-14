<div  id="w_user_info" class="pb-2">
    <div class="block rounded animated fadeIn">
        <div class="block-content">
            <div class="row">
                <div class="col-1 col-md-1 text-center">
                    <i class="fa fa-bank fa-2x " title="Market"></i>
                </div>
                <div class="col-3 col-md-3 text-center ">
                    <h5 class="pb-0">
                        <a href="{$.php.set_url('/panel/market/donations')}" class="text-primary-dark">Баланс: {$.php.intval($.site.session->session.user_data.market.balance)}</a>
                        <small>
                            <br><a href="javascript:void();" title="{$widget_user_refresh}" class="submit-btn font-size-sm" {$.php.btn_ajax("Modules\Lineage2\Market\Market", "ajax_refresh_info_two")}>Обновить</a>
                        </small>
                    </h5>

                </div>
                <div class="col-4 col-md-4 text-center">
                    <a href="{$.php.set_url('/panel/market/donations')}" class="btn btn-block btn-outline-primary">Пополнить баланс</a>
                </div>

                <div class="col-4 col-md-4 text-center">
                    <a href="{$.php.set_url('/panel/market/withdrawal')}" class="btn btn-block btn-outline-primary">Вывести средства</a>
                </div>
            </div>
        </div>
    </div>
</div>