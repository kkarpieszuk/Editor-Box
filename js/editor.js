document.addEventListener('DOMContentLoaded', function () {
    // when "add image' button is clicked, delegate this click to the image input field
    document
        .getElementById('ebox_trigger_image_upload')
        .addEventListener('click', function( ev ) {
            document.getElementById('ebox_image_select').click();
            ev.preventDefault();
    });

    // when field for image has value added, submit the form automatically
    document.getElementById('ebox_image_select').addEventListener('input', function() {
        document
            .getElementById('editor_box_add_image')
            .dispatchEvent(new Event( 'submit', {
                'bubbles'    : true,
                'cancelable' : true
            }) );
    });

    // send image to the server
    // here real form submission happens
    document.getElementById('editor_box_add_image').addEventListener('submit', function(event) {
        event.preventDefault();
        var data = new FormData( this );
        data.append( 'action', 'editor_box_file' );
        const request = new XMLHttpRequest();
        request.open( 'POST', editor_box_ajax.ajaxurl, true );
        request.onload = function() {
            if ( this.status >= 200 && this.status < 400 ) {
                var resp = JSON.parse( this.response );
                let imageElement = `\n<img src="${resp.url}" />\n`;
                const textarea = document.getElementById('editor_box_content');
                textarea.value = ( textarea.value + imageElement );
            } else {
                console.log( 'Error while sending image to the server, error code ' + request.status );
            }
        }
        request.send( data );
    } );
}, false);