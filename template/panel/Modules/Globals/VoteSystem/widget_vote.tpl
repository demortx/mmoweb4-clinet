{if $.site.session->session.vote? AND $.site.session->session.vote.list? AND count($.site.session->session.vote.list) > 0}
<div class="block block-rounded ribbon ribbon-modern ribbon-primary animated fadeIn" data-toggle="appear">
    <div class="block-header">
        <h3 class="block-title">
            {$title_vote}
        </h3>
    </div>
    <form action="/input"  method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Globals\VoteSystem\VoteSystem", "ajax_cast")}
        {foreach $.site.session->session.vote.list as $type => $name}
            <div class="form-group row m-auto">
                <label class="col-md-4 col-form-label text-right border-right" >
                    {$name}
                </label>
                <div class="col-md-8 pt-5">
                    <div class="js-rating" data-score="0" data-type="{$type}" data-star-on="fa fa-fw fa-2x fa-star text-warning" data-star-off="fa fa-fw fa-2x fa-star text-muted"></div>
                </div>
            </div>
        {/foreach}

        {if $.site.session->session.vote.message?}
            <div class="m-20">{$.site.session->session.vote.message}</div>
        {/if}
        <div class="block-content rounded block-content-sm block-content-full bg-body-light text-center mt-20">
            <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-check-square-o mr-5"></i> {$sb_btn}</button>
        </div>
    </form>
</div>
{$.site._SEO->addTegHTML('footer', 'raty', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery-raty/jquery.raty.js'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        jQuery.fn.raty.defaults.starType    = 'i';
        jQuery.fn.raty.defaults.hints       = ['{$like1}', '{$like2}', '{$like3}', '{$like4}', '{$like5}'];
        jQuery('.js-rating').each((index, element) => {
            let el = jQuery(element);
            el.raty({
                score: el.data('score') || 0,
                number: el.data('number') || 5,
                cancel: el.data('cancel') || false,
                target: el.data('target') || false,
                targetScore: el.data('target-score') || false,
                precision: el.data('precision') || false,
                cancelOff: el.data('cancel-off') || 'fa fa-fw fa-times-circle text-danger',
                cancelOn: el.data('cancel-on') || 'fa fa-fw fa-times-circle',
                starHalf: el.data('star-half') || 'fa fa-fw fa-star-half text-warning',
                starOff: el.data('star-off') || 'fa fa-fw fa-star text-muted',
                starOn: el.data('star-on') || 'fa fa-fw fa-star text-warning',
                scoreName: 'vote['+el.data('type')+']'
                /*,click: function(score, evt) { }*/
            });
        });
    });
</script>
{/if}