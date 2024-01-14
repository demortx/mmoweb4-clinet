<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">{$title_lang} <span>{get_sid_name(true, true)}</span></h3>
        <div class="block-options">
            <button type="button" class="btn-block-option submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "ajax_refresh_warehouse", [0])}>
                <i class="fa fa-refresh"></i>
            </button>
        </div>
    </div>
    <form action="/input" method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Globals\Warehouse\Warehouse", "send_item")}
        <div class="block-content pl-50 pr-50">
            <div class="row">
                <div class="col-4 col-md-4 col-sm-12" >
                    <h6 class="mb-10"><i class="fa fa-arrow-down"></i> {$title_select_wh}</h6>
                    <div class="list-group push">
                        {if count($.site.session->session.user_data.warehouse) > 0}
                            {foreach $.site.session->session.user_data.warehouse as $items}
                                <a class="list-group-item list-group-item-action align-items-center check_box_wh p-1" data-id="{$items.id}" data-give-type="{$items.give_type}" href="javascript:void(0)">
                                    <label class="css-control css-control-sm css-control-secondary css-checkbox ml-1 mr-5">
                                        <input type="checkbox" class="css-control-input check_box_wh_{$items.id}" name="wh_id[]" value="{$items.id}">
                                        <span class="css-control-indicator"></span>
                                    </label>

                                    {$items.name}
                                    <span class="float-right mr-5 ">
                                    {foreach $items.data as $item first=$first}
                                            {$.php.set_item($item.id,false,false,'<span class="badge badge-pill badge-secondary" data-toggle="popover" data-placement="top" data-content="%description%" data-original-title="%name% %add_name% x'~$item.count~'"><img data-item="'~$items.id~'" src="%icon%" class="mr-1" width="17px">x'~$item.count~'</span>')}
                                    {/foreach}
                                    </span>
                                </a>

                            {/foreach}
                        {else}
                            <a class="list-group-item list-group-item-action align-items-center text-center" style="padding: 7px !important;" href="javascript:void(0)">
                                <i class="fa fa-info-circle ml-1 mr-5"></i> {$title_wh_empty}
                            </a>

                        {/if}
                    </div>

                </div>
                {if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
                    <div class="col-4 col-md-4 col-sm-12">
                        <h6 class="mb-10"><i class="fa fa-arrow-down"></i> {$title_select_account}</h6>
                        <div class="list-group push"  id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            {foreach $.site.session->session.user_data.account as $login => $info first=$first index=$index}
                                <a class="list-group-item list-group-item-action align-items-center p-1 pl-10 {if $first}active{/if} check_account_wh" id="tab-{$login}" data-idx="{$index}" data-toggle="pill" href="#w-{$login}" role="tab" aria-controls="w-{$login}" aria-selected="true">
                                    <label class="css-control css-control-sm css-control-secondary css-checkbox ml-1 mr-5">
                                        <input type="radio" class="css-control-input check_account_wh_{$index}" name="wh_account" value="{$login}">
                                        <span class="css-control-indicator"></span>
                                    </label>
                                    {$login}
                                </a>
                            {/foreach}
                                <a class="list-group-item list-group-item-action align-items-center p-1 pl-10" id="char-name-tab" style="display: none;" data-toggle="pill" href="#char-name" role="tab" aria-controls="char-name" aria-selected="true">{$title_tab_char_name}</a>
                        </div>
                    </div>



                    <div class="col-4 col-md-4 col-sm-12">
                        <h6 class="mb-10"><i class="fa fa-arrow-down"></i> {$title_select_char}</h6>
                        <div class="tab-content" id="v-pills-tabContent">

                            {foreach $.site.session->session.user_data.account as $login => $info first=$first2}
                                <div class="tab-pane fade {if $first2}show active{/if}" id="w-{$login}" role="tabpanel" aria-labelledby="tab-{$login}">
                                    <div class="list-group push">
                                    {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}
                                    {foreach $info.char_list as $char_id => $char}

                                        <a class="list-group-item list-group-item-action align-items-center check_char_wh p-1" data-id="{$char.id}" href="javascript:void(0)">
                                            <label class="css-control css-control-sm css-control-secondary css-checkbox ml-1 mr-5">
                                                <input type="radio" class="css-control-input check_char_wh_{$char.id}" name="wh_char_name" value="{$char.name}">
                                                <span class="css-control-indicator"></span>
                                            </label>

                                            {$char.name}
                                            <span class="float-right mr-5 ">lvl.{$char.level}</span>
                                        </a>

                                    {/foreach}
                                    {else}
                                        <a class="list-group-item list-group-item-action align-items-center text-center"  style="padding: 7px !important;" href="javascript:void(0)">
                                            <i class="fa fa-info-circle ml-1 mr-5"></i> {$title_select_char_empty}
                                        </a>
                                    {/if}
                                    </div>
                                </div>
                            {/foreach}

                            <div class="tab-pane fade" id="char-name" role="tabpanel" aria-labelledby="char-name-tab">
                                <div class="list-group push">
                                    {$title_tab_char_name_desc}
                                    <br>
                                    <br>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-male"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="char-name-out" name="wh_char_name_out" placeholder="Nick">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                {else}
                <div class="col-4 col-md-8 col-sm-12 ">
                    <div class="list-group push mt-20">
                        <a class="list-group-item list-group-item-action align-items-center text-center mt-5 submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "create_game_account_open",[0])}  style="padding: 7px !important;" href="javascript:void(0)">
                            <i class="fa fa-info-circle ml-1 mr-5"></i> {$title_select_account_empty}
                        </a>
                    </div>
                </div>
                {/if}

            </div>
        </div>
        <div class="block-content block-content-sm block-content-full bg-body-light text-center mt-20">
            <button type="submit" class="btn btn-alt-primary submit-form">
                <i class="fa fa-mail-forward mr-5"></i> {$title_btn_send_item}
            </button>
        </div>
    </form>
</div>

{$.site._SEO->addTegHTML('footer', 'slimscroll', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        jQuery(function(){ Codebase.helpers(['slimscroll']); });


        $('.check_box_wh').on('click', function(){
            var id = $(this).data('id');

            if($('.check_box_wh_'+id).prop("checked")){
                $('.check_box_wh_'+id).prop("checked", false);
                $(this).removeClass('active');
            }else{
                $('.check_box_wh_'+id).prop("checked", true);
                $(this).addClass('active');
            }

            if ($('[data-give-type=1]').find('input').is(':checked')){
                $('#char-name-tab').hide();
            }else{
                $('#char-name-tab').show();
            }

        });

        $('.check_char_wh').on('click', function(){
            var id = $(this).data('id');
            $('.check_char_wh').removeClass('active');
            $(this).addClass('active');
            $('.check_char_wh_'+id).prop("checked", true);
            $('[name="wh_char_name_out"]').val('');
        });

        $('.check_account_wh').on('click', function(){
            var id = $(this).data('idx');
            $('.check_account_wh_'+id).prop("checked", true);
        });

        $('a#char-name-tab').on('click', function(){
            $('[name="wh_char_name"]').prop("checked", false);
            $('[name="wh_account"]').prop("checked", false);
        });


    });
</script>
