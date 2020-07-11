<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/iblock/add_save', false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-name">{$IBlock_in_name}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-name" name="name" value="" placeholder="Name">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-ikey">iKey</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-ikey" name="ikey" value="" placeholder="event">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-tpl">TPL</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-tpl" name="tpl" value="" placeholder="event.tpl">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-show">{$IBlock_in_public}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show1" value="1" checked="">
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show2" value="0">
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 mr-auto">
                        <button type="submit" class="btn btn-alt-success ml-10 submit-form"><i class="fa fa-plus mr-5"></i>{$LangEditor_btn_add}</button>
                        <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>