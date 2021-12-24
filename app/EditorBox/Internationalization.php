<?php

namespace EditorBox;

class Internationalization {

	/**
	 * Load plugin text_domain.
	 */
	function load_text_domain() {
		load_plugin_textdomain(
			'editor_box',
			false,
			dirname( plugin_basename( EDITORBOX_PLUGIN_FILE ) ) . '/languages'
		);
	}

}