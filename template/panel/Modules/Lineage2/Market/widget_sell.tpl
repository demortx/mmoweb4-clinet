{$.site._SEO->addTegHTML('head', 'nestable2', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/assets/js/plugins/nestable2/jquery.nestable.min.css'])}
{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?6'])}
{$.site._SEO->addTegHTML('footer', 'wizard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js?ver=0.1'])}
{$.site._SEO->addTegHTML('footer', 'wizard_sell', 'script', ['src'=> $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/widget_sell.js?ver=0.52'])}


<!-- Progress Wizard -->
<div class="js-wizard-simple block">
    <!-- Step Tabs -->
    <ul class="nav nav-tabs nav-tabs-block nav-fill" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#wizard-section" data-toggle="tab">{$widget_sell_title_1}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#wizard-item" data-toggle="tab">{$widget_sell_title_2}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#wizard-confirm" data-toggle="tab">{$widget_sell_title_3}</a>
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
                                    <span class="mr-auto">{$armor} <br><small>{$armor_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['armor']?}{$count_section['armor']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('weapon', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="weapon" >
                                    <img src="/template/panel/assets/media/market/weapon.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$weapon} <br><small>{$weapon_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['weapon']?}{$count_section['weapon']}{else}0{/if}</span>

                                </button>
                            {/if}
                            {if $.php.in_array('jewelry', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="jewelry" >
                                    <img src="/template/panel/assets/media/market/jewelry.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$jewelry} <br><small>{$jewelry_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['jewelry']?}{$count_section['jewelry']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('rare', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="rare" >
                                    <img src="/template/panel/assets/media/market/rare.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$rare} <br><small>{$rare_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['rare']?}{$count_section['rare']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('consumables', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="consumables" >
                                    <img src="/template/panel/assets/media/market/consumables.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$consumables} <br><small>{$consumables_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['consumables']?}{$count_section['consumables']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('coin', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="coin" >
                                    <img src="/template/panel/assets/media/market/coin.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$coin} <br><small>{$coin_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['coin']?}{$count_section['coin']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('stones', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="stones" >
                                    <img src="/template/panel/assets/media/market/stones.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$stones} <br><small>{$stones_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['stones']?}{$count_section['stones']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('accessory', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="accessory" >
                                    <img src="/template/panel/assets/media/market/accessory.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$accessory} <br><small>{$accessory_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['accessory']?}{$count_section['accessory']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('recipes', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="recipes" >
                                    <img src="/template/panel/assets/media/market/recipes.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$recipes} <br><small>{$recipes_desc}</small></span>
                                    <span class="badge badge-pill badge-secondary">{if $count_section['recipes']?}{$count_section['recipes']}{else}0{/if}</span>
                                </button>
                            {/if}
                            {if $.php.in_array('etc', $section_status)}
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center btn-section" data-type="etc" >
                                    <img src="/template/panel/assets/media/market/etc.png" width="32" width="32" class="mr-15">
                                    <span class="mr-auto">{$etc} <br><small>{$etc_desc}</small></span>
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
                        <h6 class="text-center">{$widget_sell_choose_char}</h6>
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
                                            <i class="fa fa-briefcase mr-5"></i> {$widget_sell_no_accs}
                                        </div>
                                    </li>
                                {/if}
                            </ol>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <h6 class="text-center">{$widget_sell_choose_item}</h6>
                        <div id="inventory_list">

                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <h6 class="text-center">{$widget_sell_set_price}</h6>

                        <div class="form-group row">
                            <label class="col-12">{$widget_sell_sell_type}</label>
                            <div class="col-12">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input sell-type" type="radio" name="type" id="example-radio1" value="2" checked="">
                                    <label class="custom-control-label" for="example-radio1">{$widget_sell_sell_type_2}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input sell-type" type="radio" name="type" id="example-radio2" value="1">
                                    <label class="custom-control-label" for="example-radio2">{$widget_sell_sell_type_1}</label>
                                </div>

                            </div>
                        </div>


                        <table class="table table-bordered table-striped table-vcenter"  style="font-size: 85%;">
                            <thead>
                            <tr>
                                <th style="width: 32px;padding-top: 3px;padding-bottom: 3px;text-align: center;">#</th>
                                <th style="width: 35%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_name}</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_price}</th>
                                <th style="width: 35%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_amount}</th>
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
                                <th style="width: 40%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_name}</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_price}</th>
                                <th style="width: 30%;padding-top: 3px;padding-bottom: 3px;text-align: center;">{$widget_sell_amount}</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <p><b>{$widget_sell_reminder}</b></p>
                                <p>{$widget_sell_reminder_desc} <a href="{$widget_sell_reminder_desc_forum_url}">{$widget_sell_reminder_desc_forum}</a></p>
                                <div class="alert alert-primary">
                                    <b class="alert-heading">{$widget_sell_reminder_alert}</b>
                                    {$widget_sell_reminder_alert_desc}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" style="margin-left: auto; margin-top: auto;">
                                {if $.php.check_pin("pins_market_sell_item")}
                                    <label class="">{$ajax_buy_shop_pin}</label>
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
                                    <label class="custom-control-label" for="market-terms">{$widget_sell_rules} <a href="{$widget_sell_rules_url}">{$widget_sell_rules_rules}</a></label>
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
                        <i class="fa fa-angle-left mr-5"></i> {$widget_sell_back}
                    </button>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                        {$widget_sell_go} <i class="fa fa-angle-right ml-5"></i>
                    </button>
                    <button type="submit" class="btn btn-alt-primary d-none submit-form" data-wizard="finish">
                        <i class="fa fa-check mr-5 "></i> {$widget_sell_send}
                    </button>
                </div>
            </div>
        </div>
        <!-- END Steps Navigation -->
    </form>
    <!-- END Form -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('.sell-type').change(function() {
            var t = $('.sell-type:checked').val();

            $('.list-group-item-action').each(function() {
                if ($(this).data('stackable') == "1") {
                    if (t == 2) {
                        $(this).addClass('not-sell').removeClass("select_item_mr").attr("data-prev-class", "select_item_mr");

                        $("tr." + $(this).data("uid")).remove();
                    }
                    else {
                        $(this).removeClass('not-sell').addClass($(this).data("prev-class"));
                    }
                }
            })
        })

        $('.not-sell').click(function(e) {
            e.preventDefault();
        })
    })

</script>