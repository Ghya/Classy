var View = {

    listenEvent: function () {

        $('.lessson_panel_block').mouseover( function () {
            $(this).find('.lessson_btn_panel').addClass('opacity_top')
        });
        
        $('.lessson_panel_block').mouseout( function () {
            $(this).find('.lessson_btn_panel').removeClass('opacity_top')
        });
    }
}