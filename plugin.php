<?php
/**
 * Plugin name: Editor Box
 * Description: The post editor placed on the front page of the site, inspired by Facebook (or Twitter, or LinkedIn...) status publishing pagelet.
 * Version: 1.0 beta
 * Author: Konrad Karpieszuk
 * Author URI: http://muzungu.pl
 * Plugin URI: https://github.com/kkarpieszuk/Editor-Box
 * License: GPL 3
 * Text Domain: editor_box
 */

define( 'IMGINPUT', 'editor_box_image_upload' );

add_action( 'loop_start', 'place_box', 10, 1);
add_action( 'init', 'process_post', 10, 0 );
add_action( 'wp_enqueue_scripts', 'enqueue_editor_stuff' );
add_action( 'wp_ajax_nopriv_editor_box_file', 'save_editor_box_file' );
add_action( 'wp_ajax_editor_box_file', 'save_editor_box_file' );

function enqueue_editor_stuff() {
    wp_enqueue_style( 'editor_box_style', plugins_url( 'css/editor.css', __FILE__ ));
    wp_enqueue_script( 'editor_box_script', plugins_url( 'js/editor.js', __FILE__ ), ['jquery'] );
	wp_localize_script('editor_box_script', 'editor_box_ajax', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}

/**
 * @param WP_Query $wp_query
 *
 * @return bool
 */
function place_box( $wp_query ) {

	if ( is_front_page() && current_user_can( "edit_posts" ) ) {
		render_editor();
		render_add_image();
	}

	return true;
}

function render_editor() {
?>
    <form method="post" id="editor_box">
        <?php wp_nonce_field( 'editor_box_nonce' ); ?>
        <label for="editor_box_title"><?php _e( "The title:", "editor_box" ); ?></label>
        <input type="text"
               name="editor_box_title"
               id="editor_box_title"
               placeholder="<?php _e( 'Add title', 'editor_box'); ?>" />
        <label for="editor_box_content"><?php _e("What's happening?", "editor_box"); ?></label>
        <textarea name="editor_box_content"
                  id="editor_box_content"
                  placeholder="<?php _e('Start writing', 'editor_box' ); ?>"></textarea>
        <div id="editor_box_meta">
            <label for="editor_box_tags"><?php _e( 'Tags:', 'editor_box' ); ?></label>
            <input type="text"
                   placeholder="<?php _e('Tags (comma seprated)', 'editor_box' ) ; ?>"
                   name="editor_box_tags"
                   class="one_third" >
            <?php render_categories(); ?>
            <input type="submit"
                   name="editor_box_publish"
                   value="<?php _e("Publish", "editor_box" ); ?>"
                   class="one_third">
        </div>
    </form>
<?php
}

function render_add_image() {
?>
    <form id="editor_box_add_image" method="post" enctype="multipart/form-data">
	    <?php wp_nonce_field( 'editor_box_img_nonce' ); ?>
        <label for="<?php echo IMGINPUT; ?>>"><?php _e( 'Insert image into text', 'editor_box'); ?></label>
        <input type="file" name="<?php echo IMGINPUT; ?>" id="<?php echo IMGINPUT; ?>">
        <input type="submit"
               name="editor_box_image_submit"
               value="<?php _e("Send and insert image", "editor_box" ); ?>">
    </form>
<?php
}

function render_categories() {
	$categories = get_categories( array(
		'hide_empty' => false
	) );
	if ( empty( $categories ) ) return;
    ?>
    <label for="editor_box_categories"><?php _e( 'Category', 'editor_box' ); ?></label>
    <select name="editor_box_categories" class="one_third">
        <?php foreach ( $categories as $category ) : ?>
        <option value="<?php echo $category->term_id; ?>">
            <?php echo esc_html($category->name ); ?>
        </option>
        <?php endforeach; ?>
    </select>
<?php
}

function process_post() {
    if ( isset( $_POST['editor_box_publish'] )
         && current_user_can( "edit_posts" )
         && wp_verify_nonce( $_POST['_wpnonce'], 'editor_box_nonce' ) ) {
        if ( !empty( $_POST['editor_box_title'] )  && !empty( $_POST['editor_box_content'] ) ) {
            $post_args = array(
	            'post_content' => $_POST['editor_box_content'],
	            'post_title' => $_POST['editor_box_title'],
	            'post_status' => 'publish'
            );
            if ( !empty( $_POST['editor_box_categories'] ) && is_numeric( $_POST['editor_box_categories'] ) ) {
                $post_args['post_category'] = array( $_POST['editor_box_categories'] );
            }
	        if ( !empty( $_POST['editor_box_tags'] ) ) {
                $tags = explode(',', $_POST['editor_box_tags'] );
                $tags = array_map( 'esc_html', $tags );
		        $post_args['tags_input'] = $tags;
            }
            $post_id = wp_insert_post( $post_args );
            $redirect_to = is_numeric( $post_id ) ? get_permalink( $post_id ) : get_site_url();
            wp_redirect( $redirect_to );
            exit();
        }
    }
}

function save_editor_box_file() {
    if ( ! empty( $_FILES[ IMGINPUT ]['name'] )
         && ! empty( $_FILES[ IMGINPUT ]['tmp_name'] )
         && is_image_filetype( $_FILES[ IMGINPUT ]['type'] )
         && wp_verify_nonce( $_POST['_wpnonce'], 'editor_box_img_nonce' )
    ) {
        $file = wp_handle_upload( $_FILES[ IMGINPUT ], [ 'action' => 'editor_box_file' ] );
	    if ( ! $file['error'] ) {
		    $url      = $file['url'];
		    $type     = $file['type'];
		    $file     = $file['file'];
		    $filename = wp_basename( $file );
		    $object = array(
			    'post_title'     => $filename,
			    'post_content'   => $url,
			    'post_mime_type' => $type,
			    'guid'           => $url
		    );

		    // Save the data.
		    $id = wp_insert_attachment( $object, $file );

		    // Add the metadata.
		    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $file ) );

            wp_send_json( [ 'url' => $url ] );
        }
    }
}

	function is_image_filetype( $type ) {
        return str_starts_with( $type, 'image/' );
	}