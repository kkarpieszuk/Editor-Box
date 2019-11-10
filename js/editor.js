jQuery(document).ready(function($) {
    $('#editor_box_add_image').submit( function( event ) {
        event.preventDefault();
        console.log("editor_box_add_image form send handled");

        var file = document.getElementById('editor_box_image_upload').files[0];
        if ( file ) {
            var reader = new FileReader();
            reader.readAsText( file, 'UTF-8' );
            reader.onload = shipOff;
        } else {
            alert("no file selected");
        }

    } );

    function shipOff(event) {
        var result = event.target.result;
        var fileName = document.getElementById('editor_box_image_upload').files[0].name;

        var data = {
            'action': 'editor_box_file',
            'imgblob': result,
            'fileName': fileName
        };

        jQuery.post( editor_box_ajax.ajaxurl, data, function( response ) {
            alert('done');
        } );


    }

});