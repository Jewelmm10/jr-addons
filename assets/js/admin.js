jQuery(document).ready(function($){

    console.log('JR Admin JS Loaded ✅');

    $('.enable-all').on('click', function(e){
        e.preventDefault();
        $('input[type="checkbox"]').prop('checked', true);
    });

    $('.disable-all').on('click', function(e){
        e.preventDefault();
        $('input[type="checkbox"]').prop('checked', false);
    });

    $('.save-widgets').on('click', function(e){

        e.preventDefault();

        let widgets = [];

        $('input[type="checkbox"]:checked').each(function(){
            widgets.push($(this).val());
        });

        console.log('Sending:', widgets);

        $.ajax({
            url: jrAdmin.ajaxurl,
            type: 'POST',
            data: {
                action: 'jr_save_widgets',
                nonce: jrAdmin.nonce,
                widgets: widgets
            },
            success: function(response){
                console.log('Response:', response);

                if(response.success){
                    alert('Settings Saved ✅');
                }
            },
            error: function(error){
                console.log('AJAX Error:', error);
            }
        });

    });

});