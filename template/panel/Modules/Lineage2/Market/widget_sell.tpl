{$.site._SEO->addTegHTML('footer', 'wizard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js?ver=0.1'])}
{$.site._SEO->addTegHTML('footer', 'wizard_sell', 'script', ['src'=> $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/widget_sell.js?ver=0.44'])}
<style>
    .not-sell {
        cursor: not-allowed! important;
        background-color: rgba(0,0,0,.03);
    }
    .imgdis {
        filter: grayscale(100%);
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: gray;
        -webkit-filter: grayscale(1);
    }
</style>


<!-- Progress Wizard -->
<div class="js-wizard-simple block">
    <!-- Step Tabs -->
    <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#wizard-section" data-toggle="tab">1. Выберите категорию</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#wizard-item" data-toggle="tab">2. Выберите предмет(ы)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#wizard-confirm" data-toggle="tab">3. Подтвердите действие</a>
        </li>
    </ul>
    <!-- END Step Tabs -->

    <!-- Form -->
    <form action="/input"  method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Lineage2\Market\Market", "ajax_sell_item")}
        <input type="hidden" id="input_section" name="section" value="armor">
        <!-- Wizard Progress Bar -->
        <div class="block-content block-content-sm">
            <div class="progress" data-wizard="progress" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <!-- END Wizard Progress Bar -->

        <!-- Steps Content -->
        <div class="block-content block-content-full tab-content" style="min-height: 265px;">
            <!-- Step 1 -->
            <div class="tab-pane active" id="wizard-section" role="tabpanel">
                <div class="row">
                    <div class="col-12 col-lg-6 offset-lg-3">



                        <div class="list-group push">
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active btn-section" data-type="armor" >
                                <img src="/template/panel/assets/media/market/armor.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Броня <br><small>Защита мягких тканей</small></span>
                                <span class="badge badge-pill badge-secondary">1</span>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="weapon" >
                                <img src="/template/panel/assets/media/market/sword.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Оружие <br><small>Острое и опасное</small></span>
                                <span class="badge badge-pill badge-secondary">7</span>

                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="jewelry" >
                                <img src="/template/panel/assets/media/market/jewelry.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Бижутерия <br><small>Шик, блеск и красота</small></span>
                                <span class="badge badge-pill badge-secondary">3</span>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="consumables" >
                                <img src="/template/panel/assets/media/market/miscellaneous.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Расходники <br><small>Выпил, закусил</small></span>
                                <span class="badge badge-pill badge-secondary">0</span>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="coin" >
                                <img src="/template/panel/assets/media/market/money.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Адена <br><small>Много не бывает</small></span>
                                <span class="badge badge-pill badge-secondary">8</span>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="character" >
                                <img src="/template/panel/assets/media/market/wizard.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Персонажи <br><small>Нигибаторы даром</small></span>
                                <span class="badge badge-pill badge-secondary">1</span>
                            </button>
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="etc" >
                                <img src="/template/panel/assets/media/market/shelf.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Другое <br><small>Свалка помойка</small></span>
                                <span class="badge badge-pill badge-secondary">13</span>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
            <!-- END Step 1 -->

            <!-- Step 2 -->
            <div class="tab-pane" id="wizard-item" role="tabpanel">


                <div class="row gutters-tiny">
                    <div class="col-6 col-md-2">
                        <h6 class="text-center">Выбирите аккаунт</h6>
                        <div class="list-group push"  id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            {if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                                {foreach $.site.session->session.user_data.account as $login => $info first=$first index=$index}
                                    <a class="list-group-item list-group-item-action align-items-center p-1 pl-10 {if $first}active{/if}" id="{$login}-tab" data-idx="{$index}" data-toggle="pill" href="#{$login}" role="tab" aria-controls="{$login}" aria-selected="true">
                                        {$login} {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}<span class="float-right text-right"><i class="fa fa-user-o"></i> {$.php.count($info.char_list)}</span>{/if}
                                    </a>
                                {/foreach}
                            {else}
                                Нет аккаунтов
                            {/if}
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <h6 class="text-center">Выбирите персонажа</h6>
                        <div class="tab-content" id="v-pills-tabContent">
                            {if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                                {foreach $.site.session->session.user_data.account as $login => $info first=$first2}
                                    <div class="tab-pane fade {if $first2}show active{/if}" id="{$login}" role="tabpanel" aria-labelledby="{$login}-tab">
                                        <div class="list-group push">
                                            {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}
                                                {foreach $info.char_list as $char_id => $char}
                                                    <a class="list-group-item list-group-item-action align-items-center check_char_market p-1" data-id="{$char.id}" data-account="{$login}" data-name="{$char.name}" href="javascript:void(0)">
                                                        {$char.name}
                                                        <span class="float-right mr-5 ">Lv.{$char.level}</span>
                                                    </a>
                                                {/foreach}
                                            {else}
                                                <a class="list-group-item list-group-item-action align-items-center text-center p-1" href="javascript:void(0)">
                                                    <i class="fa fa-info-circle ml-1 mr-5"></i> Нет персонажей
                                                </a>
                                            {/if}
                                        </div>
                                    </div>
                                {/foreach}
                            {/if}

                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <h6 class="text-center">Выбирите предмет</h6>
                        <div id="inventory_list">

                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <h6 class="text-center">Укажите цену</h6>

                        <div class="form-group row">
                            <label class="col-12">Вариант продажи</label>
                            <div class="col-12">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="type" id="example-radio1" value="1" checked="">
                                    <label class="custom-control-label" for="example-radio1">Продажа в розницу</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="type" id="example-radio2" value="2">
                                    <label class="custom-control-label" for="example-radio2">Продажа оптом</label>
                                </div>

                            </div>
                        </div>


                        <table class="table table-bordered table-striped table-vcenter"  style="font-size: 85%;">
                            <thead>
                            <tr>
                                <th style="width: 32px;padding-top: 3px;padding-bottom: 3px;text-align: center;">#</th>
                                <th style="width: 40%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Название</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Цена</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Кол-во</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="basket">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- END Step 2 -->

            <!-- Step 3 -->
            <div class="tab-pane" id="wizard-confirm" role="tabpanel">
                <div class="row" style="min-height: 225px;">
                    <div class="col-lg-6">
                        <table id="basket-confirm" class="table table-bordered table-striped table-vcenter">
                            <thead>
                            <tr>
                                <th style="width: 32px;padding-top: 3px;padding-bottom: 3px;text-align: center;">#</th>
                                <th style="width: 40%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Название</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Цена</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Кол-во</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><b>Памятка:</b></p>
                                <p>Выбранные вами товары буду сняты с персонажа. После выставления ваша лавка попадет на модерацию, после чего появится в списках товаров. Вы так же можете вернуть все товары после выставления на рынок, все предметы будут доставлены на персонажа или персонажей, с которых они были изъяты. Подробнее можно ознакомится <a href="#">на форуме</a>
                                <div class="alert alert-primary">
                                    <b class="alert-heading">Внимание!</b>
                                    В момент снятия предметов персонаж должен быть офлайн.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="margin-left: auto; margin-top: auto;">
                                {if $.php.check_pin("pins_market_sell_item")}
                                <label class="">Введите PIN-CODE</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text short_name_icon"><i class="fa fa-expeditedssl"></i></span>
                                        </div>
                                        <input type="number" maxlength="4" name="pin" class="form-control" id="count-in-game" placeholder="PIN">
                                    </div>
                                </div>
                                {/if}
                                <div class="custom-control custom-checkbox text-right">
                                    <input type="checkbox" class="custom-control-input" id="market-terms" name="terms">
                                    <label class="custom-control-label" for="market-terms">Согласен с <a href="#">правилами</a></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Step 3 -->
        </div>
        <!-- END Steps Content -->

        <!-- Steps Navigation -->
        <div class="block-content block-content-sm block-content-full bg-body-light">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                        <i class="fa fa-angle-left mr-5"></i> Назад
                    </button>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                        Вперед <i class="fa fa-angle-right ml-5"></i>
                    </button>
                    <button type="submit" class="btn btn-alt-primary d-none submit-form" data-wizard="finish">
                        <i class="fa fa-check mr-5 "></i> Подтвердить
                    </button>
                </div>
            </div>
        </div>
        <!-- END Steps Navigation -->
    </form>
    <!-- END Form -->
</div>
<!-- END Progress Wizard -->