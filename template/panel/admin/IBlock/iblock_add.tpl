<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/iblock/add_save', false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <input type="hidden" name="ib_formbuilder" id="formbuilder_input" value="">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-name">{$IBlock_in_name}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-name" name="ib_name" value="" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-ikey">iKey</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-ikey" name="ib_ikey" value="" placeholder="event">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-tpl">TPL</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-tpl" name="ib_tpl" value="" placeholder="event.tpl">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-show">{$IBlock_in_public}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ib_publish" id="show1" value="1" checked="">
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="ib_publish" id="show2" value="0">
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="fb-editor"></div>
                        <br>
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

{$.site._SEO->addTegHTML('footer', 'jquery-ui', 'script', ['src'=> 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'])}
{$.site._SEO->addTegHTML('footer', 'formbuilder', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/form-builder/form-builder.min.js'])}

<style>
    .form-group input[type="radio"], .form-group input[type="checkbox"] {
        display: block;
    }
</style>

{if $.site._LANG == 'ru'}
    {set $lg_fb = 'ru-RU'}
{else}
    {set $lg_fb = 'en-US'}
{/if}

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        jQuery($ => {
            const fbTemplate = document.getElementById('fb-editor');
            var fb = $(fbTemplate).formBuilder(
                {
                    disableFields: ['autocomplete','paragraph','file','header','button'],
                    i18n: {
                        locale: '{$lg_fb}',
                        location: "/template/panel/assets/js/plugins/form-builder/lang"
                    }
                }
            );
            $('body').on('click', '.save-template', function (e) {

                $('#formbuilder_input').val(fb.actions.getData('json', true));
            });
        });
    });
</script>
