jQuery(document).ready(function($) {
    $('#ebox_trigger_image_upload').on( 'click', function(event) {
        $('#ebox_image_select').trigger('click');
        return false;
    } );

    $('#ebox_image_select').on('input', function() {
        $('#editor_box_add_image').trigger('submit');
    });

    $('#editor_box_add_image').on('submit', function( event ) {
        event.preventDefault();
        var data = new FormData( this );
        data.append( 'action', 'editor_box_file' );
        jQuery.ajax({
            url: editor_box_ajax.ajaxurl,
            type: "POST",
            data: data,
            success: function (msg) {
                if ( msg.url ) {
                    var imageElement = `\n<img src="${msg.url}" />\n`;
                    $('#editor_box_content').val( $('#editor_box_content').val() + imageElement );
                }
            },
            contentType: false,
            cache: false,
            processData: false
        });
    } );

});