class BeFormWizard {
    /*
     * Init Wizard defaults
     *
     */
    static initWizardDefaults() {
        jQuery.fn.bootstrapWizard.defaults.tabClass         = 'nav nav-tabs';
        jQuery.fn.bootstrapWizard.defaults.nextSelector     = '[data-wizard="next"]';
        jQuery.fn.bootstrapWizard.defaults.previousSelector = '[data-wizard="prev"]';
        jQuery.fn.bootstrapWizard.defaults.firstSelector    = '[data-wizard="first"]';
        jQuery.fn.bootstrapWizard.defaults.lastSelector     = '[data-wizard="lsat"]';
        jQuery.fn.bootstrapWizard.defaults.finishSelector   = '[data-wizard="finish"]';
        jQuery.fn.bootstrapWizard.defaults.backSelector     = '[data-wizard="back"]';
    }

    /*
     * Init simple wizard, for more examples you can check out https://github.com/VinceG/twitter-bootstrap-wizard
     *
     */
    static initWizardSell() {
        jQuery('.js-wizard-simple').bootstrapWizard({
            onTabShow: (tab, navigation, index) => {
                let percent = ((index + 1) / navigation.find('li').length) * 100;

                // Get progress bar
                let progress = navigation.parents('.block').find('[data-wizard="progress"] > .progress-bar');

                // Update progress bar if there is one
                if (progress.length) {
                    progress.css({ width: percent + 1 + '%' });
                }
            }
        });
    }


    /*
     * Init functionality
     *
     */
    static init() {
        this.initWizardDefaults();
        this.initWizardSell();

    }
}

// Initialize when page loads
jQuery(() => { BeFormWizard.init(); });



$('body').on('click', '.btn-section', function (e) {
    $('.btn-section').removeClass('active');
    let _this = $(this);
    _this.addClass('active');
    $('#input_section').val(_this.data('type'));

});

$('.check_char_market').on('click', function(){
    var id = $(this).data('id');
    let name = $(this).data('name');
    let account = $(this).data('account');

    $('.check_char_market').removeClass('active');
    $(this).addClass('active');
    $('.inv-div').hide();
    if($('#inventory_'+id).length){
        $('#inventory_'+id).show();
    }else{
        $('#inventory_list').append('<div id="inventory_'+id+'" class="inv-div text-center"><button type="button" class="btn btn-outline-primary submit-btn" data-post="module_form=Modules%5CLineage2%5CMarket%5CMarket&amp;module=ajax_loud_inventory&amp;char_id='+id+'&amp;char_name='+name+'&amp;account_name='+account+'" data-action="/input">' +
            '<i class="si si-cloud-download mr-5"></i>Загрузить инвентарь</button>' +
            '</div>');
    }

    if ($("#char-info").length) {
        $("#char-info").children(".block").remove();

        var seconds = parseInt($(this).data("online"), 10);

        var days = Math.floor(seconds / (3600*24));
        seconds  -= days*3600*24;
        var hrs   = Math.floor(seconds / 3600);
        seconds  -= hrs*3600;
        var mnts = Math.floor(seconds / 60);
        seconds  -= mnts*60;

        $("#char-info").append(
            '<div class="block block-link-shadow">'
            +'<div class="block-content block-content-full clearfix bg-body-light">'
            +'<div class="float-left">'
            +'<div class="font-w600 mb-5">' + $(this).data("name") + ' <small>(' + $(this).data("clan-name") + '</small>)</div>'
            +'<div class="font-size-sm text-muted">' + $(this).data("class") + ', Lv. ' + $(this).data("level") + '</div>'
            +'</div>'
            +'</div>'
            +'<div class="block-content text-center" style="border: #f6f7f9 solid 1px; border-top: 0;">'
            +'<div class="row items-push">'
            +'<div class="col-4">'
            +'<div class="mb-5"><b>PvP</b></div>'
            +'<div class="font-size-sm text-muted">' + $(this).data("pvp") + '</div>'
            +'</div>'
            +'<div class="col-4">'
            +'<div class="mb-5"><b>PK</b></div>'
            +'<div class="font-size-sm text-muted">' + $(this).data("pk") + '</div>'
            +'</div>'
            +'<div class="col-4">'
            +'<div class="mb-5"><b>Online</b></div>'
            +'<div class="font-size-sm text-muted">' + days + " d, " + hrs + ' h</div>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>'
        );
    }
});

$('body').on('click', '.select_item_mr', function (e) {
    let uid = $(this).data('uid');
    let count = $(this).data('count');
    let stackable = $(this).data('stackable');
    let name = $(this).data('name');
    let icon = $(this).data('icon');

    if (!$(this).hasClass('active')){
        $(this).addClass('active');


        if(stackable == 1 && count > 1 )
            stackable = '<input type="number" min="1" max="'+count+'" value="'+count+'" name="i['+uid+'][count]" class="form-control form-control-sm" placeholder="Count">';
        else
            stackable = '1';

        $('#basket').append(
            '<tr class="'+uid+'">'
            +'<td class="text-center"><img src="'+icon+'" width="22" class="label_img"></td>'
            +'<td class="text-center">'+name+'</td>'
            +'<td class="text-center"><input type="number" min="0" max="30000" name="i['+uid+'][price]" class="form-control form-control-sm" placeholder="Price"></td>'
            +'<td class="text-center">' + stackable + '</td>'
            +'<td class="text-center" style="width: 120px;"><button type="button" data-uid="'+uid+'" class="btn btn-sm btn-secondary  item_remove"><i class="fa fa-times"></i></button></td></tr>'
        );

    }else{
        $(this).removeClass('active');
        $('.'+uid).remove();
    }
});

$('body').on('click', '.item_remove', function (e) {
    var uid = $(this).data('uid');
    $('#u'+uid).removeClass('active');
    $('.'+uid).remove();
});

$(".btn[data-wizard], .nav-link[href='#wizard-confirm']").click(function(e) {
    if ($("#basket").length) { // items sell
        var b = $("#basket").clone();

        var i = $(b).children("tr").children("td").children("input");

        $(i).each(function() {
            $( this ).replaceWith("<span>" + ($(this).val() == "" ? 0 : $(this).val()) + "</span>");;
        });

        $(b).children("tr").children("td").children("div.input-group").remove();

        $("#basket-confirm").children("tbody").remove();
        $("#basket-confirm").append(b);
    }
    else { //char sell
        var b = $("#char-info").clone();

        $("#char-confirm").children().remove();
        $("#char-confirm").append(b);
    }
})