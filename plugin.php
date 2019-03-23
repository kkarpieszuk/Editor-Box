<?php
/**
 * Plugin name: Editor Box
 */

add_action( "loop_start", "place_box", 10, 1);

/**
 * @param WP_Query $wp_query
 *
 * @return bool
 */
function place_box( $wp_query ) {

	if ( is_front_page() && current_user_can( "edit_posts" ) ) {
		render_editor();
	}

	return true;
}

function render_editor() {
?>
    <label for="editor_box"><?php _e("What's happening?", "editor_box") ?></label>
    <textarea name="editor_box" id="editor_box"></textarea>
<?php
}