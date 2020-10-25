<div class="content">
    {include '/panel/breadcrumb.tpl'}

    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/pages/edit_save?page='~$page_select, false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <input type="hidden" value="{$page_param.date}">

                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-desc">{$StaticPages_desc_input}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-desc" name="desc" value="{$page_param.desc}" placeholder="Description">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-url">{$StaticPages_url_input}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-url" name="url" value="{$page_param.url}" placeholder="about/server-x10">
                                <div class="form-text text-muted">{$StaticPages_url_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-show">{$StaticPages_show_input}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="show" id="show1" value="true" {if $page_param.show == 'true'}checked=""{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="show" id="show2" value="false" {if $page_param.show == 'false'}checked=""{/if}>
                                    <label class="custom-control-label" for="show2">Hide</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-dis">{$StaticPages_show_template}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="template" id="dis1" value="site" {if $page_param.template == 'site'}checked=""{/if}>
                                    <label class="custom-control-label" for="dis1">{$StaticPages_show_btn_site}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="template" id="dis2" value="panel" {if $page_param.template == 'panel'}checked=""{/if}>
                                    <label class="custom-control-label" for="dis2">{$StaticPages_show_btn_cab}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <input type="text" class="form-control" id="val-title-{$lg}" name="page[{$lg}][title]" value="{if $page_param.page[$lg]['title']?}{$page_param.page[$lg]['title']}{/if}" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea rows="10" name="page[{$lg}][body]" class="form-control textarea">{if $page_param.page[$lg]['body']?}{$page_param.page[$lg]['body']}{/if}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-meta_title">meta:title</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-meta_title" name="page[{$lg}][meta_title]" value="{if $page_param.page[$lg]['meta_title']?}{$page_param.page[$lg]['meta_title']}{/if}" placeholder="MmoWeb Личный кабинет сервер Gracia Final!">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-meta_description">meta:description</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-meta_description" name="page[{$lg}][meta_description]" value="{if $page_param.page[$lg]['meta_description']?}{$page_param.page[$lg]['meta_description']}{/if}" placeholder="Крупнейший классический Lineage 2...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-meta_keywords">meta:keywords</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-meta_keywords" name="page[{$lg}][meta_keywords]" value="{if $page_param.page[$lg]['meta_keywords']?}{$page_param.page[$lg]['meta_keywords']}{/if}" placeholder="mmoweb, mmoweb4">
                                        <div class="form-text text-muted">{$StaticPages_example_input}: interlude, la2, interlude, c6, mmorpg, gameplay, lineage, PvP, craft, x25.</div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
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

{if $.const.TEMPLATE_WYSIWYG}
{$.site._SEO->addTegHTML('footer', 'tiny_mce', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/tiny_mce/tinymce.min.js?v=4'])}
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function (event) {
        tinyMCE.baseURL = '/template/panel/assets/js/plugins/tiny_mce';
        tinyMCE.suffix = '.min';
        tinymce.init({
            selector: '.textarea',
            language : "{$.site._LANG}",
            element_format : 'html',
            width : "100%",
            height : "350",
            theme: "modern",
            relative_urls : false,
            convert_urls : false,
            remove_script_host : false,
            verify_html: false,
            toolbar_items_size: 'small',
            plugins: [
                'advlist autolink lists link image charmap preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking table contextmenu directionality',
                'emoticons paste textcolor colorpicker textpattern imagetools codesample toc',
                'codemirror'
            ],
            toolbar1: "insert | styleselect | fontselect fontsizeselect | table | link unlink | media image |  outdent indent |  codesample | code preview",
            toolbar2: "undo redo | copy paste pastetext | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | subscript superscript | bullist numlist forecolor backcolor spellchecker removeformat",
            image_advtab: true,
            image_caption: true,
            image_dimensions: false,
            formats: {
                bold: { inline: 'b'},
                italic: { inline: 'i'},
                underline: { inline: 'u', exact : true},
                strikethrough: { inline: 's', exact : true}
            },
            codesample_languages: [ { text: 'HTML/JS/CSS', value: 'markup'}],
            spellchecker_language : "ru",
            spellchecker_languages : "Russian=ru,Ukrainian=uk,English=en",
            spellchecker_rpc_url : "https://speller.yandex.net/services/tinyspell",

            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    });
</script>
{/if}