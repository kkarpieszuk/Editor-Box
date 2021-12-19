<?php

namespace EditorBox;

class Enqueues {
	public function enqueue_editor_stuff() {
		wp_enqueue_style( 'editor_box_style', plugins_url( 'css/editor.css', EDITORBOX_PLUGIN_FILE ));
		wp_enqueue_script( 'editor_box_script', plugins_url( 'js/editor.js', EDITORBOX_PLUGIN_FILE ), ['jquery'] );
		wp_localize_script('editor_box_script', 'editor_box_ajax', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}

}