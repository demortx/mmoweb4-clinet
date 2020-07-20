<!DOCTYPE html>
<html lang="{$_LANG}">
<head>
  {$_SEO_HEAD}
  <script>
    const __config = {
      gFonts: {
        fonts: [
          'Roboto Slab:400,500,700:latin,cyrillic',
        ],
        delay: 500,
      },
      preloader: {
        /* Минимальное время показа прелоадера в секудах */
        timeMin: 0.2,
        /* Максимальное время показа прелоадера в секудах */
        timeMax: .8,
        /* Разрешить скрыть прелоадер кликнув на него */
        hideByClick: true,
      },
      server: {
        progressImg: "{$.site.dir_site}/images/server/progress__load.png",
        maxOnline: {
          "server 1": 5000,
          "server 2": 3000
        }
      },
      /* Таймер обратного отсчета */
      eDate: {
        /* Формат YODHMS: лет, месяцев, дней, часов, минут, секунд */
        format: 'YODHMS',
        year: 2019,
        month: 8,
        day: 31,
        hour: 6,
        minute: 18,
        second: 0,
        timeZone: +3,
        /* Показываем сообщение когда стаймер досчитает до нуля */
        endTimeMSG: '{$L_TIMER_TEXT}'
      },
      streams: {
        /* Задержка показа стримов */
        delay: 300,
      }
    };
  </script>

  <style>
    .preload {
      background-color: #1d1a19;
      position: fixed;
      z-index: 500;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>

</head>

<body class="body">
{$_SEO_BODY}
  <div class="preload">
    <img src="{$.site.dir_site}/images/logo.png" alt="" class="preload__logo">
  </div>

<div class="page">

  <div class="page__section navigation page__navigation">
    <div class="page__container navigation__container">
      <div class="page__inner page__inner_rw navigation__inner">

        <div class="navigation__box navigation__box_left">


          <div class="navigation__logotype-box logotype-box">
            <a href="/" class="navigation__logotype logotype"></a>
          </div>

          <div class="nav navigation__nav">
            <div class="gw-burger navigation__burger">
              <div class="gw-burger__line gw-burger__line_pos_top"></div>
              <div class="gw-burger__line gw-burger__line_pos_middle"></div>
              <div class="gw-burger__line gw-burger__line_pos_bottom"></div>
            </div>
            <div class="navigation__list">
              <a href="{$.php.set_url($L_MENU_BTN_HOME_URL)}" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_HOME}</div>
              </a>
              <a href="{$.php.set_url($L_MENU_BTN_REG_URL)}" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_REG}</div>
              </a>
              <a href="{$.php.set_url($L_MENU_BTN_FILE_URL)}" data-open-window="files" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_FILE}</div>
              </a>
              <a href="{$.php.set_url($L_MENU_BTN_ABOUT_URL)}" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_ABOUT}</div>
              </a>
              <a href="{$.php.set_url($L_MENU_BTN_DONATE_URL)}" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_DONATE}</div>
              </a>
              <a href="{$.php.set_url($L_MENU_BTN_FORUM_URL)}" target="_blank" class="nav__link">
                <div class="nav__name">{$L_MENU_BTN_FORUM}</div>
              </a>
            </div>
          </div> <!-- END nav -->

        </div> <!-- END navigation__box -->

        <div class="navigation__lang-box">
          {language}
          <!-- END  lang  -->
        </div>

        <div class="navigation__box">

          <div class="navigation__cp-box cp-box">
            {include 'site:is_login.tpl'}
          </div> <!-- END  cp-box  -->

        </div> <!-- END navigation__box -->

      </div> <!-- END  page__inner -->
    </div> <!-- END  page__inner -->
  </div> <!-- END  page__section -->

  <header class="page__section header page__header">
    <div class="page__container header__container">
      <div class="page__inner header__inner">
        <div class="header__logotype">
          <a href="/" class="header__logo logo"></a>
        </div>
        <section class="header__content">
          <div class="content__invite invite">
            <div class="invite__desc">{$L_HEADER_TEXT}</div>
            <div class="invite__counter counter counter_js"></div>
          </div>
          <div class="header__btns">
            <a href="javascript:void(0)" data-open-window="files" class="btn btn_type_2">
              <div class="btn__content">{$L_HEADER_BTN_START}</div>
            </a>
          </div>
        </section> <!-- END  header__content -->
      </div> <!-- END  page__inner -->
    </div> <!-- END  page__inner -->
  </header> <!-- END  page__section -->

  <div class="page__section events page__events">
    <div class="page__container events__container">
      <div class="page__inner events__inner">
        {iblock ikey='event' count=3}
      </div>
      <!-- END  page__inner -->
    </div>
    <!-- END  page__inner -->
  </div>
  <!-- END  page__section -->

  <div class="page__section mid page__mid">
    <div class="page__container mid__container">
      <div class="page__inner page__inner_rw mid__inner">

        <div class="mid__item mid__sidebar sidebar">

          <div class="sidebar__container sidebar__servers servers">
            {server count=3}
          </div> <!-- END  servers -->

          <div class="sidebar__container sidebar__forum forum">
            {forum count=5}
          </div> <!-- END  forum  -->

          <div class="content__st st">
            {rating count=10}
          </div> <!-- END  st  -->
        </div> <!-- END  page__section -->

        <div class="mid__item mid__content content">
          {streams count=3}

          <div class="content__box">
            {if $_CONTENT?}
              {$_CONTENT}
            {else}
              {news count=3 page=1}
            {/if}
          </div> <!-- END  content__box -->
        </div> <!-- END  page__section -->

      </div> <!-- END  page__inner -->
    </div> <!-- END  page__inner -->
  </div> <!-- END  page__section -->

  <div class="page__section footer page__footer">
    <div class="page__container footer__container">
      <div class="page__inner page__inner_rw footer__inner">
        <div class="footer__content">
          <div class="footer__logotype">
            <a href="/" class="f-logo"></a>
          </div>
          <div class="footer__desc">
            PLAY ON THE BEST LINEAGE 2 CLASSIC SERVER. TRY THE TASTE OF HARDCORE. COPYRIGHT © 2019 L2ESSENCE.COM
            ALL RIGHTS RESERVED. PLAY ON THE BEST LINEAGE 2 CLASSIC SERVER. TRY THE TASTE OF HARDCORE. COPYRIGHT
            © 2019 L2ESSENCE.COM ALL RIGHTS RESERVED.
          </div>
        </div>

        <div class="footer__nav">
          <div class="f-nav footer__f-nav">
            <div class="f-nav__list">
              <a href="{$.php.set_url($L_MENU_BTN_HOME_URL}" class="f-nav__item">{$L_MENU_BTN_HOME}</a>
              <a href="{$.php.set_url($L_MENU_BTN_REG_URL}" class="f-nav__item">{$L_MENU_BTN_REG}</a>
              <a href="{$.php.set_url($L_MENU_BTN_FILE_URL}" data-open-window="files" class="f-nav__item">{$L_MENU_BTN_FILE}</a>
              <a href="{$.php.set_url($L_MENU_BTN_ABOUT_URL}" class="f-nav__item">{$L_MENU_BTN_ABOUT}</a>
            </div>
          </div>
          <div class="f-nav footer__f-nav">
            <div class="f-nav__list">
              <a href="{$.php.set_url($L_MENU_BTN_SUPPORT_URL)}" class="f-nav__item">{$L_MENU_BTN_SUPPORT}</a>
              <a href="{$.php.set_url($L_MENU_BTN_RULES_URL)}" class="f-nav__item">{$L_MENU_BTN_RULES}</a>
              <a href="{$.php.set_url($L_MENU_BTN_DONATE_URL)}" class="f-nav__item">{$L_MENU_BTN_DONATE}</a>
              <a href="{$.php.set_url($L_MENU_BTN_FORUM_URL)}" class="f-nav__item">{$L_MENU_BTN_FORUM}</a>
            </div>
          </div>
        </div>
        <!-- END  footer__nav -->
        <div class="footer__info">
          <div class="f-scl">
            <a href="#" class="f-scl__item">
              <span class="gwi gwi_skype"></span>
            </a>
            <a href="#" class="f-scl__item">
              <span class="gwi gwi_facebook-squared"></span>
            </a>
            <a href="#" class="f-scl__item">
              <span class="gwi gwi_twitter"></span>
            </a>
            <a href="#" class="f-scl__item">
              <span class="gwi gwi_vkontakte"></span>
            </a>
            <a href="#" class="f-scl__item">
              <span class="gwi gwi_youtube-play"></span>
            </a>
          </div>
          <div class="footer__author author">
            <div class="author__logo">
              <div>Design</div>
              <img src="{$.site.dir_site}/images/copyright__mex-vision.png" alt="">
            </div>
            <div class="author__logo">
              <div>Front-end</div>
              <a href="https://get-web.site/" target="_blank"><img src="{$.site.dir_site}/images/get-web-copyrights.png" alt=""></a>
            </div>
          </div>
        </div>
      </div>
      <!-- END  page__inner -->
    </div>
    <!-- END  page__container -->
  </div> <!-- END  page__section -->

</div>
<!-- Конец page -->
<div style="display: none;">
  <div class="ww ww_animated" id="files">
    <div class="ww__close" data-fancybox-close></div>
    <div class="ww__inner">
      <div class="ww__head">
        <div class="ww__title">Download <span class="color-orange">FILES</span></div>
        <div class="ww__desc">
          To play on our project, you need to <a href="#" class="ww__link">Register</a> and download the
          server files</div>
      </div>
      <div class="ww__content">
        <div class="fl-list">
          <div class="fl fl_mb">
            <div class="fl__desc">Download client Lineage 2 Interlude - <span class="color-orange">3.0
                  Gb</span></div>
            <a href="#" class="fl__link btn btn_type_3">
              <div class="btn__content">
                Download
              </div>
            </a>
          </div> <!-- END fl -->
          <div class="fl fl_mb">
            <div class="fl__desc">Download updater for Interlude x1 - <span class="color-orange">5 MB</span>
            </div>
            <a href="#" class="fl__link btn btn_type_3">
              <div class="btn__content">
                Download
              </div>
            </a>
          </div> <!-- END fl -->
          <div class="fl fl_mb">
            <div class="fl__desc">Download the patch for interlude x1</div>
            <a href="#" class="fl__link btn btn_type_3">
              <div class="btn__content">
                Download
              </div>
            </a>
          </div> <!-- END fl -->
        </div> <!-- END  fl-list -->
        <br>
        <div class="ww__head">
          <div class="ww__title">FAQ</div>
          <div class="ww__desc">Answers to frequently asked questions</div>
        </div>
        <div class="ww__faq faq">
          <a href="#" class="faq__link">[ FAQ ] Проблемы с SmartGuard</a>
          <a href="#" class="faq__link">[ FAQ ] Разрыв соединения при входе в игру</a>
          <a href="#" class="faq__link">[ FAQ ] Can Not Resolve Hostname</a>
          <a href="#" class="faq__link">[ FAQ ] Руководство По Critical Error</a>
          <a href="#" class="faq__link">[ FAQ ] Ошибка при запуске приложения (0xc0000142)</a>
        </div>
      </div> <!-- END  ww__content -->
    </div> <!-- END  ww__inner -->
  </div> <!-- END  ww -->
</div>


{$_SEO_FOOTER}
</body>
</html>
<!-- 
Copyright © Get-Web.Site
Front-End Developer: Get-Web.Site
Back-End Developer: MmoWeb.ru
 -->