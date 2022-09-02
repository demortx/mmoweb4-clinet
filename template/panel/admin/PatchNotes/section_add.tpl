<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/'~$type, false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <input type="hidden" name="patchnotes" value="{$.get.patchnotes}">
                {if $content_param.id?}
                    <input type="hidden" name="section" value="{$content_param.id}">
                {/if}
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        {foreach $language_list as $lg => $name_lg first=$first}
                            <li class="nav-item">
                                <a class="nav-link {if $first}active{/if}" href="#btabs-{$lg}">{$name_lg}</a>
                            </li>
                        {/foreach}
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        {foreach $language_list as $lg => $name_lg first=$first}
                            <div class="tab-pane fade {if $first}show active{/if}" id="btabs-{$lg}" role="tabpanel">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-title-{$lg}">{$StaticPages_name_input}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-title-{$lg}" name="name[{$lg}]" value="{if $content_param.name[$lg]?}{$content_param.name[$lg]}{/if}" placeholder="">
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>

                <div class="block block-rounded">
                    <div class="block-content">


                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-show">{$NewsSite_in_public}</label>
                            <div class="col-lg-8">

                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show1" value="1" {if isset($content_param.publish) AND $content_param.publish == '1'}checked=""{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show2" value="0" {if isset($content_param.publish) AND $content_param.publish == '0'}checked=""{/if}>
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-sort">Sort</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" id="val-sort" name="sort" value="{if $content_param.sort?}{$content_param.sort}{/if}" placeholder="Sort">

                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12 mr-auto">
                        <button type="submit" class="btn btn-alt-success ml-10 submit-form"><i class="fa fa-save mr-5"></i>{$LangEditor_btn_save}</button>
                        <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>