document.addEventListener('DOMContentLoaded', function () {
    let   title_field    = document.getElementById('editor_box_title');
    let   tags_field     = document.getElementById('editor_box_tags');
    let   cats_field     = document.getElementById('editor_box_categories');
    const publish_button = document.getElementById('editor_box_publish');
    const save_draft     = document.getElementById('editor_box_save_draft');
    const mode_field     = document.getElementById( 'editor_box_publishing_mode' );
    let   ajax_errors    = document.getElementById( 'editor-box-ajax-errors' );
    const mode_switcher  = document.getElementById('editor_box_mode_switcher');

    // when "add image' button is clicked, delegate this click to the image input field
    document
        .getElementById('ebox_trigger_image_upload')
        .addEventListener('click', function( ev ) {
            ajax_errors.style.display = 'none';
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

        let notification = document.getElementById('editor-box-img-upload-notification');
        notification.style.display = 'block';

        var data = new FormData( this );
        data.append( 'action', 'editor_box_file' );
        const request = new XMLHttpRequest();
        request.open( 'POST', editor_box_int.ajaxurl, true );
        request.onload = function() {
            if ( this.status >= 200 && this.status < 400 ) {
                var resp = JSON.parse( this.response );
                if ( resp.imghtml !== undefined ) { // if url has been returned
                    const textarea = document.getElementById('editor_box_content');
                    textarea.value = ( textarea.value + resp.imghtml );
                } else if ( resp.error !== undefined ) { // if error has been returned
                    ajax_errors.style.display = 'block';
                    ajax_errors.innerText = resp.error;
                }
                notification.style.display = 'none';
            } else {
                console.log( 'Error while sending image to the server, error code ' + request.status );

            }
        }
        request.send( data );
    } );

    // unhide title field when user typed at least 5 words in post content textarea
    document.getElementById('editor_box_content').addEventListener('input', function() {
        let words = this.value.split(/[ ,]+/);
        if (words.length > 5) {
            title_field.classList.add('pullup');
            title_field.classList.remove('hidden');
            tags_field.classList.add('pulldown');
            tags_field.classList.remove('hidden');
            cats_field.classList.add('pulldown');
            cats_field.classList.remove('hidden');
        }
        // autoscale textarea
        this.style.height = "50px";
        this.style.height = (50+this.scrollHeight)+"px";
    })

    mode_switcher.addEventListener('click', function(ev) {
        ev.preventDefault();
        flipPublishingMode();
    });


    function flipPublishingMode() {
        mode_field.value === 'publish' ? mode_field.value = 'draft' : mode_field.value = 'publish';

        if ( mode_field.value === 'publish' ) {
            publish_button.classList.remove('display_none');
            publish_button.classList.add('flip-vertical');
            save_draft.classList.add('display_none');
        } else {
            publish_button.classList.add('display_none');
            save_draft.classList.remove('display_none');
            save_draft.classList.add('flip-vertical');
        }
    }


}, false);