{$.site._SEO->addTegHTML('footer', 'wizard', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js?ver=0.1'])}
{$.site._SEO->addTegHTML('footer', 'wizard_sell', 'script', ['src'=> $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/widget_sell.js?ver=0.5'])}

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
    <form action="be_forms_wizard.html" method="post">
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
                        <input type="hidden" id="input_section" name="section" value="armor">


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
                <div class="form-group">
                    <label for="wizard-progress-bio">Bio</label>
                    <textarea class="form-control" id="wizard-progress-bio" name="wizard-progress-bio" rows="9"></textarea>
                </div>
            </div>
            <!-- END Step 2 -->

            <!-- Step 3 -->
            <div class="tab-pane" id="wizard-confirm" role="tabpanel">
                <div class="form-group">
                    <label for="wizard-progress-location">Location</label>
                    <input class="form-control" type="text" id="wizard-progress-location" name="wizard-progress-location">
                </div>
                <div class="form-group">
                    <label for="wizard-progress-skills">Skills</label>
                    <select class="form-control" id="wizard-progress-skills" name="wizard-progress-skills" size="1">
                        <option value="">Please select your best skill</option>
                        <option value="1">Photoshop</option>
                        <option value="2">HTML</option>
                        <option value="3">CSS</option>
                        <option value="4">JavaScript</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="css-control css-control-primary css-switch" for="wizard-progress-terms">
                        <input type="checkbox" class="css-control-input" id="wizard-progress-terms" name="wizard-progress-terms">
                        <span class="css-control-indicator"></span> Agree with the terms
                    </label>
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
                    <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                        <i class="fa fa-check mr-5"></i> Подтвердить
                    </button>
                </div>
            </div>
        </div>
        <!-- END Steps Navigation -->
    </form>
    <!-- END Form -->
</div>
<!-- END Progress Wizard -->