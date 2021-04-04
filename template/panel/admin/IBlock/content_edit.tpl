<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/iblock/content_edit_save?iblock='~$iblock_select~'&content='~$content_select, false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">
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



                                {if $.php.is_array($formbuilder) AND $.php.count($formbuilder)}
                                {foreach $formbuilder as $el}
                                    {if $content_param.json[$lg][$el.name]?}
                                        {set $par = $content_param.json[$lg][$el.name]}
                                    {else}
                                        {set $par = false}
                                    {/if}

                                    {set $el.name = "content[{$lg}][{$el.name}]"}

                                    {$.php.render_formbuilder($el, $par)}
                                {/foreach}
                                {else}
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-title-{$lg}">{$StaticPages_name_input}</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="val-title-{$lg}" name="content[{$lg}][title]" value="{if $content_param.json[$lg]['title']?}{$content_param.json[$lg]['title']}{/if}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-title-{$lg}">{$StaticPages_name_input} №2</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="val-title-{$lg}" name="content[{$lg}][title2]" value="{if $content_param.json[$lg]['title2']?}{$content_param.json[$lg]['title2']}{/if}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-img-{$lg}">Image url</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="val-img-{$lg}" name="content[{$lg}][img]" value="{if $content_param.json[$lg]['img']?}{$content_param.json[$lg]['img']}{/if}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-url-{$lg}">URL</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="val-url-{$lg}" name="content[{$lg}][url]" value="{if $content_param.json[$lg]['url']?}{$content_param.json[$lg]['url']}{/if}" placeholder="#">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <textarea rows="10" name="content[{$lg}][body]" class="form-control textarea">{if $content_param.json[$lg]['body']?}{$content_param.json[$lg]['body']}{/if}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <textarea rows="10" name="content[{$lg}][body2]" class="form-control textarea">{if $content_param.json[$lg]['body2']?}{$content_param.json[$lg]['body2']}{/if}</textarea>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                        {/foreach}
                    </div>
                </div>

                <div class="block block-rounded">
                    <div class="block-content">

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-url">{$NewsSite_in_date}</label>
                            <div class="col-lg-8">
                                <input type="datetime-local" class="form-control" id="val-url" name="date" value="{$content_param.date}" placeholder="Date">
                                <div class="form-text text-muted">{$NewsSite_in_date_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-show">{$NewsSite_in_public}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show1" value="1" {if $content_param.publish == '1'}checked=""{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="publish" id="show2" value="0" {if $content_param.publish == '0'}checked=""{/if}>
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
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


{if $.const.TEMPLATE_WYSIWYG}
{$.site._SEO->addTegHTML('footer', 'tiny_mce', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/tiny_mce/tinymce.min.js?v=3'])}
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function (event) {
        tinyMCE.baseURL = '/template/panel/assets/js/plugins/tiny_mce';
        tinyMCE.suffix = '.min';
        tinymce.init({
            selector: '.tinymce',
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
                'paste textcolor colorpicker textpattern imagetools codesample toc',
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