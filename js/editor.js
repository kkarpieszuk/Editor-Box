jQuery(document).ready(function($) {
    $('#editor_box_add_image').on('submit', function( event ) {
        event.preventDefault();
        var data = new FormData( this );
        data.append( 'action', 'editor_box_file' );
        console.log(data);
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