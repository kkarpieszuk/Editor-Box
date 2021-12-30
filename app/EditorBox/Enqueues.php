<?php

namespace EditorBox;

class Enqueues {
	public function enqueue_editor_stuff() {
		wp_enqueue_style( 'editor_box_style', plugins_url( 'css/editor.css', EDITORBOX_PLUGIN_FILE ));
		wp_enqueue_script( 'editor_box_script', plugins_url( 'js/editor.js', EDITORBOX_PLUGIN_FILE ) );
		wp_localize_script('editor_box_script', 'editor_box_int', [
			'ajaxurl'              => admin_url('admin-ajax.php'),
			'publish_button_value' => __( 'Publish', 'editor_box' ),
			'draft_button_value'   => __( 'Save draft', 'editor_box' ),
		] );
	}

}