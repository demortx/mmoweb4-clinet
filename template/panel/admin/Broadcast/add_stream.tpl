<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url('admin/broadcast/add_save', false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <div class="block block-rounded">
                    <div class="block-content">


                        <div class="form-group row">
                            <label class="col-lg-4" for="l-version">{$Broadcast_in_platform}</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="l-version" name="platform">
                                    {foreach $stream_type as $ver => $name}
                                        <option value="{$ver}">{$name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-profile">{$Broadcast_profile}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-profile" name="profile">
                                <div class="form-text text-muted">{$Broadcast_profile_desc}</div>
                                <div class="form-text text-muted">Twithc - https://www.twitch.tv/<code>sfory</code></div>
                                <div class="form-text text-muted">YouTube - https://www.youtube.com/channel/<code>UCvfNirFbGeijfIWG88TMb_g</code></div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-enable">{$Broadcast_in_enable}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show1" value="1" checked>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show2" value="0" >
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                                <div class="form-text text-muted">{$Broadcast_in_enable_desc}</div>
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