<?php

namespace EditorBox\FrontEnd;

abstract class Editor {

	/**
	 * @param WP_Query $wp_query
	 *
	 * @return bool
	 */
	public function place_box( $wp_query ) {

		if ( is_front_page() && current_user_can( "edit_posts" ) ) {
			$this->render_editor();
			$this->render_add_image();
		}

		return true;
	}

	private function render_editor() {
		?>
		<form method="post" id="editor_box">
			<?php wp_nonce_field( 'editor_box_nonce' ); ?>
			<label for="editor_box_title"><?php _e( "The title:", "editor_box" ); ?></label>
			<input type="text"
				name="editor_box_title"
				id="editor_box_title"
				class="hidden"
				placeholder="<?php _e( 'Add title (optional)', 'editor_box'); ?>" />
			<?php
			$this->get_textarea();
			$this->no_content_error_message();
			$this->ajax_errors();
			$this->image_upload_notification();
			?>
			<div id="editor_box_meta">
				<button id="ebox_trigger_image_upload"
					class="secondary"
					title="<?php printf( __( 'Max image size: %s', 'editor_box' ), size_format( wp_max_upload_size() ) ); ?>">
					<?php _e('Add image', 'editor_box' ); ?>
				</button>
				<label for="editor_box_tags"><?php _e( 'Tags:', 'editor_box' ); ?></label>
				<input type="text"
					placeholder="<?php _e('Tags (comma separated)', 'editor_box' ) ; ?>"
					name="editor_box_tags"
					id="editor_box_tags"
					class="one_third hidden" >
				<?php $this->render_categories(); ?>
				<input type="hidden" name="editor_box_publishing_mode" id="editor_box_publishing_mode" value="publish" />
				<input type="submit"
					name="editor_box_publish"
					id="editor_box_publish"
					value="<?php _e("Publish", "editor_box" ); ?>"
					class="one_third">
			</div>
		</form>
		<?php
	}

	private function no_content_error_message() {
		if ( isset( $_POST['editor_box_publish'] ) && empty( trim( wp_kses( $_POST['editor_box_content'], 'post' ) ) ) ) {
			?>
			<div class="editor-box-error editor-box-no-content">
				<?php _e( 'Your post must contain at least the post content.', 'editor_box' ); ?>
			</div>
			<?php
		}
	}

	private function render_add_image() {
		?>
		<form id="editor_box_add_image" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'editor_box_img_nonce' ); ?>
			<input type="file"
				id="ebox_image_select"
				name="<?php echo esc_attr( IMGINPUT ); ?>"
			>
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
		<select name="editor_box_categories" id="editor_box_categories" class="one_third hidden" title="<?php _e( 'Category', 'editor_box' ); ?>">
			<?php foreach ( $categories as $category ) : ?>
				<option value="<?php echo esc_attr( $category->term_id ); ?>">
					<?php echo esc_html($category->name ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	private function image_upload_notification() {
		?>
		<div class="editor-box-notification" id="editor-box-img-upload-notification">
			<?php _e( 'Uploading image...', 'editor_box' ); ?>
		</div>
		<?php
	}

	private function ajax_errors() {
		?>
		<div class="editor-box-error editor-box-ajax-errors" id="editor-box-ajax-errors">
			<?php _e( 'Ajax error', 'editor_box' ); ?>
		</div>
		<?php
	}

}