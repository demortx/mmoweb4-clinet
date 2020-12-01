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
    let id = $(this).data('id');
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
            stackable = '';

        var btn = '<div class="input-group">'
            +stackable
            +'<span class="input-group-append float-right">'
            +'<button type="button" data-uid="'+uid+'" class="btn btn-sm btn-secondary  item_remove"><i class="fa fa-times"></i></button>'
            +'</span>'
            +'</div>';
        $('#basket').append(
            '<tr class="'+uid+'">'
            +'<td class="hidden-xs text-center"><img src="'+icon+'" width="22" class="label_img"></td>'
            +'<td class="hidden-xs text-center">'+name+'</td>'
            +'<td class="hidden-xs text-center"><input type="number" min="0" max="30000" name="i['+uid+'][price]" class="form-control form-control-sm" placeholder="Price"></td>'
            +'<td class="text-center" style="width: 120px;">' + btn + '</td></tr>'
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
    var b = $("#basket").clone();

    $(b).children("thead").children("th").children(".action-toggle").toggle();

    var i = $(b).children("tr").children("td").children("input");

    i.replaceWith("<span>" + ($(i).val() == "" ? 0 : $(i).val()) + "</span>");

    $(b).children("tr").children("td").children("div.input-group").remove();

    $("#basket-confirm").children("tbody").html("");
    $("#basket-confirm").append(b);
})