{$.site._SEO->addTegHTML('footer', 'wizard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js?ver=0.1'])}
{$.site._SEO->addTegHTML('footer', 'wizard_sell', 'script', ['src'=> $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/widget_sell.js?ver=0.52'])}

<!-- Progress Wizard -->
<div class="js-wizard-simple block">
    <!-- Step Tabs -->
    <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
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
        {$.php.form_hide_input("Modules\Lineage2\Market\Market", "ajax_sell_character")}
        <input type="hidden" id="set_character" name="character" value="0">
        <input type="hidden" id="set_account" name="account" value="0">
        <!-- Wizard Progress Bar -->
        <div class="block-content block-content-sm">
            <div class="progress" data-wizard="progress" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 50%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <!-- END Wizard Progress Bar -->

        <!-- Steps Content -->
        <div class="block-content block-content-full tab-content" style="min-height: 265px;">
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
                                                    <a class="list-group-item list-group-item-action align-items-center  {if $char.ban != 1}check_char_sell_market{/if} p-1" data-id="{$char.id}" data-account="{$login}" data-name="{$char.name}" data-level="{$char.level}" data-pvp="{$char.pvp}" data-pk="{$char.pk}" data-clan-name="{if $.php.is_string($char.clan)}{$char.clan}{else}-/-{/if}" data-class="{$.php.get_class_name($char.class_id)}" data-online="{$char.time}" href="javascript:void(0)">
                                                        {$char.name} {if $char.ban == 1}<code>[BAN]</code>{/if}
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
                    <div class="col-12 col-md-4 offset-md-1">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div id="char-info">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div id="inventory_list">

                        </div>
                    </div>
                </div>

            </div>
            <!-- END Step 2 -->

            <!-- Step 3 -->
            <div class="tab-pane" id="wizard-confirm" role="tabpanel">
                <div class="row" style="min-height: 225px;">
                    <div class="col-lg-6">
                        <div id="char-confirm"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><b>Памятка:</b></p>
                                <p>Выбанный вами персонаж будет заблокирован на вашем аккаунте до его покупки или снятие его с торгов. Подробнее можно ознакомится <a href="#">на форуме</a>
                                <div class="alert alert-primary">
                                    <b class="alert-heading">Внимание!</b>
                                    В момент продажи, персонаж должен быть офлайн.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="margin-left: auto; margin-top: auto;">
                                <label class="">Введите PIN-CODE</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text short_name_icon"><i class="fa fa-expeditedssl"></i></span>
                                        </div>
                                        <input type="number" maxlength="4" name="pin" class="form-control" id="count-in-game" placeholder="PIN">
                                    </div>
                                </div>
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
