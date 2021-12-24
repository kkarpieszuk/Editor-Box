<?php

namespace EditorBox;

class FrontEnd {
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
			       placeholder="<?php _e( 'Add title (optional)', 'editor_box'); ?>" />
			<label for="editor_box_content"><?php _e("What's happening?", "editor_box"); ?></label>
			<textarea name="editor_box_content"
			          id="editor_box_content"
			          placeholder="<?php _e('Start writing', 'editor_box' ); ?>"></textarea>
            <?php $this->no_content_error_message(); ?>
			<div id="editor_box_meta">
                <button id="ebox_trigger_image_upload"><?php _e('Add image', 'editor_box' ); ?></button>
				<label for="editor_box_tags"><?php _e( 'Tags:', 'editor_box' ); ?></label>
				<input type="text"
				       placeholder="<?php _e('Tags (comma separated)', 'editor_box' ) ; ?>"
				       name="editor_box_tags"
				       class="one_third" >
				<?php $this->render_categories(); ?>
				<input type="submit"
				       name="editor_box_publish"
				       value="<?php _e("Publish", "editor_box" ); ?>"
				       class="one_third">
			</div>
		</form>
		<?php
	}

    private function no_content_error_message() {
        if ( isset( $_POST['editor_box_publish'] ) && empty( trim( $_POST['editor_box_content'] ) ) ) {
            ?>
            <div class="editor-box-error editor-box-no-content">
                <?php _e( 'Your post must contain at least the post content.', 'editor-box' ); ?>
            </div>
            <?php
        }
    }

	private function render_add_image() {
		?>
		<form id="editor_box_add_image" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'editor_box_img_nonce' ); ?>
			<input type="file" id="ebox_image_select" name="<?php echo IMGINPUT; ?>" id="<?php echo IMGINPUT; ?>">

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

}