<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/advertising/save', false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <div class="block block-rounded">
                    <div class="block-content">
                        <h3 class="text-center">Google Analytics</h3>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-gawpid">{$Advertising_title_gid}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-gawpid" name="gawpid" value="{$advertising_config.gawpid}" placeholder="Exemple: UA-74186324-6">
                                <div class="form-text text-muted">{$Advertising_title_gid_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-ga_anonymize">{$Advertising_title_ganon}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ga_anonymize" id="show1" value="true" {if $advertising_config.ga_anonymize}checked=""{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ga_anonymize" id="show2" value="false" {if $advertising_config.ga_anonymize == false}checked=""{/if}>
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                                <div class="form-text text-muted">{$Advertising_title_ganon_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-gt_manager">{$Advertising_title_gt_manager}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-gt_manager" name="gt_manager" value="{$advertising_config.gt_manager}" placeholder="Exemple: GTM-58QMKT3">
                            </div>
                        </div>

                        <hr>
                        <h3 class="text-center">Yandex Metrika</h3>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-ymid">{$Advertising_title_yam}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-ymid" name="ymid" value="{$advertising_config.ymid}" placeholder="Exemple: 28472078">
                                <div class="form-text text-muted">{$Advertising_title_yam_desc}</div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-ym_webvisor">{$Advertising_title_yamwiz}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ym_webvisor" id="show3" value="true" {if $advertising_config.ym_webvisor}checked=""{/if}>
                                    <label class="custom-control-label" for="show3">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ym_webvisor" id="show4" value="false" {if $advertising_config.ym_webvisor == false}checked=""{/if}>
                                    <label class="custom-control-label" for="show4">No</label>
                                </div>
                                <div class="form-text text-muted">{$Advertising_title_yamwiz_desc}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12 mr-auto">
                        <button type="submit" class="btn btn-alt-primary ml-10 submit-form"><i class="fa fa-upload mr-5"></i>{$LangEditor_btn_save}</button>
                        <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>