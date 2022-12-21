<?php

namespace EditorBox\FrontEnd;

class Box extends Editor {

	protected function get_textarea() {
		?>
		<label for="editor_box_content"><?php _e("What's happening?", "editor_box"); ?></label>
		<textarea name="editor_box_content"
				id="editor_box_content"
				placeholder="<?php _e('Start writing', 'editor_box' ); ?>"></textarea>
		<?php
	}
	
}