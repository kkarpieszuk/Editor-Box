<?php

namespace EditorBox;

use EditorBox\FrontEnd\TinyMce;
use EditorBox\FrontEnd\Box;

class Hooks {
	public function register_hooks() {
		add_action( 'loop_start', [ new TinyMce(), 'place_box' ], 10, 1);
		add_action( 'init', [ new ProcessForms(), 'process_post' ], 10, 0 );
		add_action( 'init', [ new Internationalization(), 'load_text_domain' ] );
		add_action( 'wp_enqueue_scripts', [ new Enqueues, 'enqueue_editor_stuff' ] );
		add_filter( 'wp_kses_allowed_html', [ new ProcessForms(), 'kses_allowed_html_filter' ], 10, 2 );
		add_action( 'wp_ajax_nopriv_editor_box_file', [ new ProcessForms(), 'save_editor_box_file' ] );
		add_action( 'wp_ajax_editor_box_file', [ new ProcessForms(), 'save_editor_box_file' ] );
	}

}