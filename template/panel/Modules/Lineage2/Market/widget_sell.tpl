{$.site._SEO->addTegHTML('head', 'nestable2', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/assets/js/plugins/nestable2/jquery.nestable.min.css'])}
{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}
{$.site._SEO->addTegHTML('footer', 'wizard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js?ver=0.1'])}
{$.site._SEO->addTegHTML('footer', 'wizard_sell', 'script', ['src'=> $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/widget_sell.js?ver=0.52'])}


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
        <input type="hidden" id="input_section" name="section" value="{$.php.current($section_status)}">
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
                            {if $.php.in_array('armor', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active btn-section" data-type="armor" >
                                <img src="/template/panel/assets/media/market/armor.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Броня <br><small>Защита мягких тканей</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['armor']?}{$count_section['armor']}{else}0{/if}</span>
                            </button>
                            {/if}
                            {if $.php.in_array('weapon', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="weapon" >
                                <img src="/template/panel/assets/media/market/sword.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Оружие <br><small>Острое и опасное</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['weapon']?}{$count_section['weapon']}{else}0{/if}</span>

                            </button>
                            {/if}
                            {if $.php.in_array('jewelry', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="jewelry" >
                                <img src="/template/panel/assets/media/market/jewelry.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Бижутерия <br><small>Шик, блеск и красота</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['jewelry']?}{$count_section['jewelry']}{else}0{/if}</span>
                            </button>
                            {/if}
                            {if $.php.in_array('consumables', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="consumables" >
                                <img src="/template/panel/assets/media/market/miscellaneous.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Расходники <br><small>Выпил, закусил</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['consumables']?}{$count_section['consumables']}{else}0{/if}</span>
                            </button>
                            {/if}
                            {if $.php.in_array('coin', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="coin" >
                                <img src="/template/panel/assets/media/market/money.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Адена <br><small>Много не бывает</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['coin']?}{$count_section['coin']}{else}0{/if}</span>
                            </button>
                            {/if}
                            {if $.php.in_array('etc', $section_status)}
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="etc" >
                                <img src="/template/panel/assets/media/market/shelf.png" width="32" width="32" class="mr-15">
                                <span class="mr-auto">Другое <br><small>Свалка помойка</small></span>
                                <span class="badge badge-pill badge-secondary">{if $count_section['etc']?}{$count_section['etc']}{else}0{/if}</span>
                            </button>
                            {/if}
                        </div>
                    </div>
                </div>


            </div>
            <!-- END Step 1 -->

            <!-- Step 2 -->
            <div class="tab-pane" id="wizard-item" role="tabpanel">
                <div class="row gutters-tiny">
                    <div class="col-6 col-md-2">
                        <h6 class="text-center">Выберите персонажа</h6>
                        <div class="js-nestable-connected-icons dd">
                            <ol class="dd-list">
                                {if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                                    {foreach $.site.session->session.user_data.account as $login => $info first=$first index=$index}
                                        <li class="dd-item">
                                            <div class="dd-handle">
                                                <i class="fa fa-caret-down"></i> {$login}
                                            </div>
                                            <ol class="dd-list">
                                                {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}
                                                    {foreach $info.char_list as $char_key => $char first=$first2}
                                                        <li class="dd-item check_char_market" data-id="{$char.id}" data-account="{$login}" data-name="{$char.name}">
                                                            <div class="dd-handle">
                                                                {$char.name} <span class="pull-right">Lv.{$char.level}</span>
                                                            </div>
                                                        </li>
                                                    {/foreach}
                                                {/if}
                                            </ol>
                                        </li>
                                    {/foreach}
                                {else}
                                    <li class="dd-item" data-id="11">
                                        <div class="dd-handle">
                                            <i class="fa fa-briefcase mr-5"></i> Нет аккаунтов
                                        </div>
                                    </li>
                                {/if}
                            </ol>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <h6 class="text-center">Выберите предмет</h6>
                        <div id="inventory_list">

                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <h6 class="text-center">Укажите цену</h6>

                        <div class="form-group row">
                            <label class="col-12">Вариант продажи</label>
                            <div class="col-12">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="type" id="example-radio1" value="2" checked="">
                                    <label class="custom-control-label" for="example-radio1">Продажа в розницу</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="type" id="example-radio2" value="1">
                                    <label class="custom-control-label" for="example-radio2">Продажа оптом</label>
                                </div>

                            </div>
                        </div>


                        <table class="table table-bordered table-striped table-vcenter"  style="font-size: 85%;">
                            <thead>
                            <tr>
                                <th style="width: 32px;padding-top: 3px;padding-bottom: 3px;text-align: center;">#</th>
                                <th style="width: 35%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Название</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Цена</th>
                                <th style="width: 35%;padding-top: 3px;padding-bottom: 3px;text-align: center;">Кол-во</th>
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