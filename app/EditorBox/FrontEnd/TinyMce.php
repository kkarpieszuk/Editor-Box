<?php

namespace EditorBox\FrontEnd;

class TinyMce extends Editor {

	protected function get_textarea() {
		?>
		<label for="editor_box_content"><?php _e("What's happening?", "editor_box"); ?></label>

		<?php
		wp_editor( '', 'editor_box_content', [
			'textarea_name' => 'editor_box_content',
			'textarea_rows' => 5,
			'media_buttons' => true,
			'teeny' => false,
			'quicktags' => false,
		] );
	}

}