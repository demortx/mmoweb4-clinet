{*bg-gd-primary
bg-gd-dusk
bg-gd-cherry
bg-gd-aqua
bg-gd-emerald
bg-gd-sea
bg-gd-leaf
bg-gd-lake
bg-gd-sun
bg-gd-ligh
'class' => 'bg-gd-primary',//для картинок - bg-image bg-image-bottom
'style' => "background-image: url('assets/media/photos/photo34@2x.jpg');",
t*}
{$.site._SEO->addTegHTML('head', 'slick_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick.css'])}
{$.site._SEO->addTegHTML('head', 'slick_theme', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick-theme.css'])}
{$.site._SEO->addTegHTML('head', 'game_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/game/css/style.css?v1'])}
{$.site._SEO->addTegHTML('footer', 'timeradd', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.plugin.min.js'])}
{$.site._SEO->addTegHTML('footer', 'timer_main', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown.min.js'])}
{if $.site._LANG != 'en' AND $.php.file_exists($.const.ROOT_DIR~$.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js')}
    {$.site._SEO->addTegHTML('footer', 'timer_lang', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/jquery.countdown/jquery.countdown-'~$.site._LANG~'.js'])}
{/if}
<style>
    .bg-primary-lighter-op{
        background: linear-gradient(#9dcc6500, #9dcb6640);
    }
    .dw-hr{
        border: 0;
        border-top: 1px solid #e4e7ed1a;
    }
    .prz {
        width: 64px;
        height: 64px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px auto 0 auto;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        z-index: 0;
    }
    .prz__inner {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        width: calc(40px * 2);
        height: calc(40px * 2);
        flex-shrink: 0;
        position: relative;
        z-index: 0;
    }
    .prz__bg {
        background-image: url({$.site.dir_panel}/assets/media/avatars/cases.png);
        background-size: cover;
        background-position: center  center;
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -1;
        filter: blur(3px) brightness(150%);
    }
    .prz__img {
        display: block;
        width: 40px;
        height: 40px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .prz__img:nth-child(4):nth-last-child(1) {
        margin-right: auto;
    }

</style>
<div class="bg-gd-primary box_mw">
    <div class="bg-black-op-25">
        <div class="content content-top content-full text-center">
            <div class="js-slider-daily-rewards text-center mb-15" data-autoplay="false" data-dots="false" data-infinite="false" data-arrows="false" data-slides-to-show="6">
                {set $slide_day = 0}
                {foreach $daily_rewards_list.rewards as $daily}
                    <div class="rounded {if $.site.session->session.user_data.daily_rewards.day == $daily.day AND $.site.session->session.user_data.daily_rewards.today_daily == '1'}bg-primary-lighter-op{/if}">
                        <div class="font-size-sm text-white-op">{$daily_day} {$daily.day}<hr class="dw-hr"></div>

                        <div class="prz img-avatar-thumb" data-tlt>
                            <div class="prz__inner">
                                {foreach $daily.items as $i first=$first}
                                    {if $first}
                                        {$.php.set_item($i.id, false, false, '<div class="prz__bg" style="background-image:url(%icon%);"></div>')}
                                    {/if}
                                    {$.php.set_item($i.id, false, false, '<img src="%icon%" class="prz__img" alt="%name%">')}
                                {/foreach}
                            </div>
                            <div data-tlt-content="" style="display: none;">
                                <div class="tlt">
                                    {foreach $daily.items as $i}
                                        <div class="box__prize prize">
                                            {if $i.count > 1}{set $count_ = '<span class="text-primary-darker">x'~$i.count~'</span>'}{else}{set $count_ = ''}{/if}
                                            {if $i.enc > 0}{set $enc_ = '<span class="text-warning">+'~$i.enc~'</span>'}{else}{set $enc_ = ''}{/if}

                                            {$.php.set_item($i.id, false, false, '<div class="prize__pic pic-style-0"><img src="%icon%" class="prize__img"></div><div class="prize__content">%name% '~$count_~$enc_~'</div>')}
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                        <div class="font-size-sm text-white-op mt-15">
                            {if $.site.session->session.user_data.daily_rewards.day == $daily.day AND $.site.session->session.user_data.daily_rewards.today_daily == '1'}
                                {set $slide_day = $daily.day-1}
                                <span id="button_rewards"><button type="button" class="btn btn-sm btn-outline-success w-100 submit-btn" {$.php.btn_ajax("Modules\Plugins\DailyRewards\DailyRewards", "give_daily_rewards", ['day' => $daily.day])}><i class="fa fa-suitcase mr-5"></i> {$daily_give}</button></span>
                            {elseif $.site.session->session.user_data.daily_rewards.day+1 == $daily.day AND $.site.session->session.user_data.daily_rewards.today_daily == '0'}
                                {set $slide_day = $daily.day-1}
                                <span data-sale-timer-dr="{$.site.session->session.user_data.daily_rewards.next_daily}">00:00:00</span>

                            {elseif $daily.day <= $.site.session->session.user_data.daily_rewards.day}
                                <div class="mt-5"><i class="fa fa-check mr-5"></i>{$daily_received}</div>
                            {/if}
                        </div>
                    </div>
                {/foreach}
            </div>
            <div style="color: rgb(255 255 255 / 45%) !important;">
                {$daily_desc}
            </div>
        </div>
    </div>
</div>
{$.site._SEO->addTegHTML('footer', 'popper.min', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/popper.min.js'])}
{$.site._SEO->addTegHTML('footer', 'tippy-bundle', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/game/libs/tippy/js/tippy-bundle.iife.min.js'])}
{$.site._SEO->addTegHTML('footer', 'slick_js', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/slick/slick.min.js'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('.js-slider-daily-rewards').slick({
            arrows: true,
            dots: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            centerMode: false,
            autoplay: false,
            autoplaySpeed: 3000,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        }).slick('slickGoTo', {$slide_day}, true);
        {ignore}
        $("[data-sale-timer-dr]").each(function(indx, element){
            const __this = $(this);
            let austDay = new Date(__this.attr('data-sale-timer-dr') * 1000);
            let layout = '{hnn}{sep}{mnn}{sep}{snn}';
            __this.countdown({
                until: austDay,
                layout: layout,
            });
        });
        {/ignore}
        (function toolTIP() {
            tippy('[data-tlt]', {
                delay: 0,
                flip: true,
                arrow: false,
                followCursor: true,
                placement: 'right-start',
                theme: 'tlt',
                maxWidth: '250px',
                content(reference) {
                    return $(reference).find('[data-tlt-content]').html() || "";
                }
            });
        })();
    });
</script>