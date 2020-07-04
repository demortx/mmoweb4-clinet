<style>
    .nav-users a {
        position: relative;
        padding: 4px 4px 4px 32px;
        display: block;
        min-height: 50px;
        font-weight: 600;
        border-bottom: 1px solid #f0f2f5;
    }
    .nav-users a > span {
        position: absolute;
        left: 4px;
        top: 7px;
        padding: 3px 5px;
    }
</style>

<div class="js-chat-container content content-full invisible" data-toggle="appear" data-chat-height="auto">
    <!-- Multiple Chat (auto height) -->
    <div class="block mb-0 js-tab-support">
        <ul class="js-chat-head nav nav-tabs nav-tabs-alt bg-body-light" data-toggle="tabs" role="tablist">

            <li class="nav-item">
                <a class="nav-link active" href="#ticket-list">
                    <i class="fa fa-ticket"></i> {$tabs_all_ticket}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#new-ticket">
                    <i class="fa fa-stack-exchange"></i> {$tabs_create_ticket}
                </a>
            </li>
        </ul>
        <div class="tab-content overflow-hidden">

            <!-- People -->
            <div class="tab-pane fade fade-right show active" id="ticket-list" role="tabpanel">

                <div class="js-ticket-list block-content block-content-full overflow-y-auto bg-pattern" style="background-image: url('{$.site.dir_panel}/assets/media/various/bg-pattern-inverse.png');">
                    <div class="row">
                        <div class="col-md-4">

                            <a class="block block-link-pop text-right bg-primary new-ticket-btn" data-category="0" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="si si-bar-chart fa-3x text-primary-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-white" >{$btn_create_ticket_1}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-white-op">{$btn_create_ticket_2}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">

                            <a class="block block-link-pop text-right bg-earth new-ticket-btn" data-category="8" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-bank fa-3x text-earth-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-white">{$btn_create_donate_1}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-white-op">{$btn_create_donate_2}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">

                            <a class="block block-link-pop text-right bg-corporate new-ticket-btn" data-category="6" href="javascript:void(0)">
                                <div class="block-content block-content-full clearfix border-black-op-b border-3x">
                                    <div class="float-left mt-10 d-none d-sm-block">
                                        <i class="fa fa-suitcase fa-3x text-corporate-light"></i>
                                    </div>
                                    <div class="font-size-h3 font-w600 text-white" >{$btn_create_lost_1}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-white-op">{$btn_create_lost_2}</div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="row mb-0" id="ticket-list-all">
                        {$content_ticket_list}
                    </div>



                </div>
            </div>
            <!-- END People -->
            <!-- People -->
            <div class="tab-pane fade fade-right show" id="new-ticket" role="tabpanel">

                <div class="js-new-ticket block-content block-content-full overflow-y-auto bg-pattern" style="background-image: url('{$.site.dir_panel}/assets/media/various/bg-pattern-inverse.png');">
                    <div class="text-center">
                        <h3>
                            <strong>{$title_create_ticket}</strong>
                        </h3>
                    </div>
                    <div id="content-new-ticket">
                    {$new_ticket_form}
                    </div>
                </div>
            </div>
            <!-- END People -->

        </div>
    </div>
    <!-- END Multiple Chat (auto height) -->
</div>
<!-- END Page Content -->

<script>
    document.addEventListener("DOMContentLoaded", function (event) {

/* Helper variables*/
        let lWindow, lHeader, lFooter, cContainer, cHeight, cHead, cTalk, cTicketList, cTicketNew, cform, cTimeout;

/* Message Classes*/
        let classesMsgBase      = 'rounded font-w600 p-10 mb-10 animated fadeIn',
            classesMsgSelf      = 'bg-primary-lighter text-primary-darker ml-auto',
            classesMsgOther     = 'bg-body-light mr-auto',
            classesMsgHeader    = 'font-size-sm font-italic text-muted text-center mt-20 mb-10';

        class BeCompChat {
            /*
             * Init chat
             *
             */
            static initChat() {
                let self = this;

               /*  Set variables*/
                lWindow    = jQuery(window);
                lHeader    = jQuery('#page-header');
                lFooter    = jQuery('#page-footer');
                cContainer = jQuery('.js-chat-container');
                cHeight    = cContainer.data('chat-height');
                cHead      = jQuery('.js-chat-head');
                cTalk      = jQuery('.js-chat-talk');
                cTicketList    = jQuery('.js-ticket-list');
                cTicketNew    = jQuery('.js-new-ticket');
                cform      = jQuery('.js-chat-form');

                /* Chat height mode ('auto' for full height, number for specific height in pixels)*/
                switch (cHeight) {
                    case 'auto':
                        /* Init chat windows' height to full available (also on browser resize or orientation change)*/
                        jQuery(window).on('resize.cb.chat orientationchange.cb.chat', e => {
                            clearTimeout(cTimeout);

                            cTimeout = setTimeout(e => {
                                self.initChatWindows();
                            }, 150);
                        }).triggerHandler('resize.cb.chat');
                        break;
                    default:
                        /* Init chat windows' height with a specific height*/
                        self.initChatWindows(cHeight);
                }

                /* Enable scroll lock to chat talk and people window*/
                cTalk.scrollLock('enable');

                if (cTicketList.length) {
                    cTicketList.scrollLock('enable');
                }

            }

            /*
             * Init chat windows' height
             *
             */
            static initChatWindows(customHeight) {
                let cHeightFinal;

                /* If height is specified*/
                if (customHeight) {
                    cHeightFinal = parseInt(customHeight);
                } else {
                    /* Calculate height*/
                    cHeightFinal = lWindow.height() -
                        (lHeader.length ? lHeader.outerHeight() : 0) -
                        (lFooter.length ? lFooter.outerHeight() : 0) -
                        (parseInt(cContainer.css('padding-top')) + parseInt(cContainer.css('padding-bottom'))) -
                        cHead.outerHeight();
                }
                cHeightFinal = cHeightFinal - 48;


                /* Add a minimum height*/
                if (cHeightFinal < 200) {
                    cHeightFinal = 200;
                }

                let cHeightcform = cform.outerHeight() < 1 ? 60 : cform.outerHeight();

                /* Set height to chat windows (+ people window if exists)*/
                cTalk.css('height', cHeightFinal - cHeightcform);

                if (cTicketList.length) {
                    cTicketList.css('height', cHeightFinal);
                }
            }

            /*
             * Add a header message to a chat window
             *
             */
            static chatAddHeader(chatId, chatMsg) {
                /* Get chat window*/
                let chatWindow = jQuery('.js-chat-talk[data-chat-id="' + chatId + '"]');

                /* If time header and chat window exists*/
                if (chatMsg && chatWindow.length) {
                    chatWindow.append('<div class="' + classesMsgHeader + '">'
                        + jQuery('<div />').text(chatMsg).html()
                        + '</div>');

                    /* Scroll the message list to the bottom*/
                    chatWindow.animate({ scrollTop: chatWindow[0].scrollHeight }, 150);
                }
            }

            /*
             * Add a message to a chat window
             *
             */
            static chatAddMessage(chatId, chatMsg,date_create,reviewed, chatMsgLevel, chatInput) {

                /* Get chat window*/
                let chatWindow = jQuery('.js-chat-talk[data-chat-id="' + chatId + '"]');

                /* If message and chat window exists*/
                if (chatMsg && chatWindow.length) {
                    /* Post it to its related window (if message level is 'self', make it stand out)*/
                    chatWindow.append('<div class="' + classesMsgBase + ' ' + ((chatMsgLevel == '0') ? classesMsgSelf : classesMsgOther) + '" style="width: max-content;max-width: 75%;white-space: pre-line;">'
                        + chatMsg/*.replace(/\n/g, '<br>')*/
                        + '</div>'
                        + '<div class="font-w400 font-size-xs text-muted ' + ((chatMsgLevel == '0') ? 'text-right' : 'text-left') + '">'+date_create
                        +((chatMsgLevel == '0') ? ((reviewed == '1') ? ' <i class="fa fa-check" title="Read"></i>' : '') : '')
                        +'</div>'
                        + '</div>');

                    /* Scroll the message list to the bottom*/
                    chatWindow.animate({ scrollTop: chatWindow[0].scrollHeight }, 0);

                    /* If input is set, reset it*/
                    if (chatInput) {
                        chatInput.val('');
                    }
                }
            }

            /*
             * Init functionality
             *
             */
            static init() {
                this.initChat();
            }

            /*
             * Add time header
             *
             */
            static addHeader(chatId, chatMsg) {
                this.chatAddHeader(chatId, chatMsg);
            }

            /*
             * Add message
             *
             */
            static addMessage(chatId, chatMsg,date_create,reviewed, chatMsgLevel, chatInput) {
                this.chatAddMessage(chatId, chatMsg,date_create,reviewed, chatMsgLevel, chatInput);
            }
        }


        jQuery(() => {
            BeCompChat.init();
            window.BeCompChat = BeCompChat;
        });
        $('.js-ticket-list').on('click', '.new-ticket-btn', function () {
            var category = $(this).data('category');
            send_ajax('{http_build_query(['module_form' => "Modules\Plugins\Support\Support",'module' => "change_ticket_type"])}&category='+category, true);
            $('.nav-tabs a[href="#new-ticket"]').tab('show');
        });



        var tabs = $('.js-tab-support').bootstrapDynamicTabs();
        window.openTicket = function (data) {
            tabs.closeById('chat-window' + data.head.tid);
            var theme = data.head.theme;
            if (theme.length > 15)
                theme = theme.substr(0, 15) + '...';
            tabs.addTab({
                id: 'chat-window' + data.head.tid,
                title: '<img class="img-avatar img-avatar16" src="/template/panel/assets/media/avatars/avatar.png" alt=""><span class="ml-5">' + theme + '</span>',
                html: '<div class="js-chat-talk block-content block-content-full text-wrap-break-word overflow-y-auto" data-chat-id="' + data.head.tid + '" style="height: 140px;"></div>' +
                    '<div class="js-chat-form block-content block-content-full block-content-sm bg-body-light"><form action="/input" method="post" onsubmit="return false;">{$.php.form_hide_input("Modules\\\Plugins\\\Support\\\Support", "send_msg")}<input type="hidden" name="ticket_id" value="' + data.head.tid + '"><div class="input-group input-group-lg"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-comment text-primary"></i></span></div>   <textarea class="form-control js-chat-input"  name="message" data-in-id="' + data.head.tid + '" rows="2" placeholder="..."></textarea><div class="input-group-append"><button type="button" class="btn btn-secondary submit-btn"><i class="fa fa-send text-primary"></i></button></div></div></form></div>',
                closable: true
            });
            BeCompChat.init();
            $.each(data.msg, function (index, ticket) {
                BeCompChat.addMessage(data.head.tid, ticket.text,ticket.date_create,ticket.reviewed, ticket.answer);
            });
        };
        window.sendTicket = function (data) {
            $('textarea[data-in-id='+data.tid+']').val('');
            BeCompChat.addMessage(data.tid, data.text,data.date_create, 0, 0);
        };

        $('#content-new-ticket').on('change', '#support_category', function (e) {
            var category = $(this).val();
            send_ajax('{http_build_query(['module_form' => "Modules\Plugins\Support\Support",'module' => "change_ticket_type"])}&category='+category, true);
        });
        $('#content-new-ticket').on('change click', '.sharing_account', function (e) {
            var sharing = $(this).val();
            if (sharing == 'yes'){
                $('#info_sharing_yes').show();
                $('#info_sharing_no').hide();
            }else{
                $('#info_sharing_yes').hide();
                $('#info_sharing_no').show();
            }
        });
        $('body').on('change', '#account_name', function (e) {
            var char_list = JSON.parse('{json_encode($char_list)}');
            var account_id = $( this ).val();
            if (account_id != '0') {
                $( '#char_id' ).find( 'option' ).remove().end().prop( 'disabled',true );
                if (char_list[account_id].length !== 0){
                    $.each(char_list[account_id],function(char_id,name){
                        $( '#char_id' ).append( '<option value="' + name + '_' + char_id + '">' + name + '</option>' );
                    });
                    $( '#char_id' ).prop( 'disabled', false );
                }else{
                    $('#char_id').append('<option value="0">{$error_account_char_not_found}</option>');
                }
            }
        });

    });
</script>