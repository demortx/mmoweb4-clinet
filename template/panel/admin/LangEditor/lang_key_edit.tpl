<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading"><img class="img-avatar" src="{$.const.VIEWPATH~'/site/'~$tpl_name~$tpl_info.poster}" alt="{$tpl_name}"> {$tpl_info.name} [{$s_lang}] <small>{$tpl_info.author} &bull; {$tpl_info.html}</small></h2>
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row justify-content-center py-20">
                <div class="col-xl-9">
                    <form action="{$.php.set_url($.const.ADMIN_URL~'/lang/'~$tpl_name~'?lang='~$s_lang~'&save=1', false, false)}" method="post" novalidate="novalidate" onsubmit="return false;">
                        <div class="input_list">
                        {foreach $lang_key as $key => $value}
                            {if is_bool($value)}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-{$key}">{$key}</label>
                                    <div class="col-lg-8">
                                        <div class="custom-control custom-radio custom-control-inline mb-5">
                                            <input class="custom-control-input" type="radio" name="{$key}" id="{$key}1" value="true" {if $value == true}checked=""{/if}>
                                            <label class="custom-control-label" for="{$key}1">True</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline mb-5">
                                            <input class="custom-control-input" type="radio" name="{$key}" id="{$key}2" value="false" {if $value == false}checked=""{/if}>
                                            <label class="custom-control-label" for="{$key}2">False</label>
                                        </div>
                                    </div>
                                </div>
                            {elseif is_array($value)}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-{$key}">{$key} <code>*[array^json]</code></label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="_arr[]" value="{$key}">
                                        <textarea type="text" class="form-control" id="val-{$key}" name="{$key}" rows="{(substr_count($.php.json_encode($value, 128), "\n") + 1)}" placeholder="Укажите значение ключа">{$.php.json_encode($value, 128)}</textarea>
                                    </div>
                                </div>
                            {else}
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-{$key}">{$key}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="val-{$key}" name="{$key}" value="{$value|escape:'html'}" placeholder="Укажите значение ключа">
                                </div>
                            </div>
                            {/if}
                        {/foreach}
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 mr-auto">
                                <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-upload mr-5"></i>{$LangEditor_btn_save}</button>
                                <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>
                                <button type="button" class="btn btn-alt-success ml-10 add_key"><i class="fa fa-plus mr-5"></i>{$LangEditor_btn_add}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('body').on('click', '.add_key', function () {
            var key_name = window.prompt("{$LangEditor_add_key_name}","L_");
            if (key_name.length > 3){
                var html = '<div class="form-group row">\n' +
                    '   <label class="col-lg-4 col-form-label" for="val-'+key_name+'">'+key_name+'</label>\n' +
                    '       <div class="col-lg-8">\n' +
                    '           <input type="text" class="form-control" id="val-'+key_name+'" name="'+key_name+'" value="" placeholder="Укажите значение ключа">\n' +
                    '       </div>\n' +
                    '</div>';
                $('.input_list').append(html);
            }else
                alert('{$LangEditor_add_key_low}');

        });
    });
</script>