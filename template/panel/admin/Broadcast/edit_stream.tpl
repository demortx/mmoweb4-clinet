<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/broadcast/edit_save?id='~$stream_id, false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <div class="block block-rounded">
                    <div class="block-content">


                        <div class="form-group row">
                            <label class="col-lg-4" for="l-version">{$Broadcast_in_platform}</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="l-version" name="platform">
                                    {foreach $stream_type as $ver => $name}
                                        <option value="{$ver}" {if $stream_param.platform == $ver}selected{/if}>{$name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-stream">{$Broadcast_stream}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-stream" value="{$stream_param.stream}" name="stream">
                                <div class="form-text text-muted">{$Broadcast_stream_desc}</div>
                                <div class="form-text text-muted"><strong>Example: </strong></div>
                                <div class="form-text text-muted">Twitch - https://player.twitch.tv/?channel=streamer_name&parent=www.example.com</div>
                                <div class="form-text text-muted">YouTube - https://www.youtube.com/embed/lnPmXTpYAs8</div>
                                <div class="form-text text-muted">Other service - iframe html code</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-name">{$Broadcast_streamer_name}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-name" name="name" value="{$stream_param.name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-title">{$Broadcast_title}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-title" name="title" value="{$stream_param.title}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-avatar">{$Broadcast_avatar}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-avatar" name="avatar" value="{$stream_param.avatar}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-preview">{$Broadcast_preview}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-preview" name="preview" value="{$stream_param.preview}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-position">{$Broadcast_position}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-position" name="position" value="{$stream_param.position}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-enable">{$Broadcast_in_enable}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show1" value="1" {if $stream_param.publish==1}checked{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show2" value="0" {if $stream_param.publish==0}checked{/if}>
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                                <div class="form-text text-muted">{$Broadcast_in_enable_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-enable">{$Broadcast_autoplay}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="autoplay" id="autoplay1" value="1" {if $stream_param.autoplay==1}checked{/if}>
                                    <label class="custom-control-label" for="autoplay1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="autoplay" id="autoplay2" value="0" {if $stream_param.autoplay==0}checked{/if}>
                                    <label class="custom-control-label" for="autoplay2">No</label>
                                </div>
                                <div class="form-text text-muted">{$Broadcast_autoplay_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-enable">{$Broadcast_mute}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="mute" id="mute1" value="1"  {if $stream_param.mute==1}checked{/if}>
                                    <label class="custom-control-label" for="mute1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="mute" id="mute2" value="0" {if $stream_param.mute==0}checked{/if}>
                                    <label class="custom-control-label" for="mute2">No</label>
                                </div>
                                <div class="form-text text-muted">{$Broadcast_mute_desc}</div>
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