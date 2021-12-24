<?php

namespace EditorBox;

class ProcessForms {
	public function process_post() {
		if ( isset( $_POST['editor_box_publish'] )
		     && current_user_can( "edit_posts" )
		     && wp_verify_nonce( $_POST['_wpnonce'], 'editor_box_nonce' ) ) {
			if ( !empty( trim( $_POST['editor_box_content'] ) ) ) {
				$post_title = ! empty( $_POST['editor_box_title'] ) ?
					sanitize_text_field( $_POST['editor_box_title'] ) :
					wp_trim_words( sanitize_text_field( $_POST['editor_box_content'] ), 5, '...' );
				$post_args = [
					'post_content' => wp_kses( $_POST['editor_box_content'], 'post' ),
					'post_title' => $post_title,
					'post_status' => 'publish'
				];
				if ( !empty( $_POST['editor_box_categories'] ) && is_numeric( $_POST['editor_box_categories'] ) ) {
					$post_args['post_category'] = [ $_POST['editor_box_categories'] ];
				}
				if ( !empty( $_POST['editor_box_tags'] ) ) {
					$tags = explode(',', sanitize_text_field( $_POST['editor_box_tags'] ) );
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

	public function save_editor_box_file() {
		if ( ! empty( $_FILES[ IMGINPUT ]['name'] )
		     && ! empty( $_FILES[ IMGINPUT ]['tmp_name'] )
		     && $this->is_image_filetype( $_FILES[ IMGINPUT ]['type'] )
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

	private function is_image_filetype( $type ) : bool {
		$needle = 'image/';
		return 0 === \strncmp( $type, $needle, \strlen( $needle ) );
	}
}