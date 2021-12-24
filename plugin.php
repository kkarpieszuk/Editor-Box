<?php
/**
 * Plugin name: Editor Box
 * Description: The post editor placed on the front page of the site, inspired by Facebook (or Twitter, or LinkedIn...) status publishing pagelet.
 * Version: 1.0 beta
 * Author: Konrad Karpieszuk
 * Author URI: https://muzungu.pl
 * Plugin URI: https://github.com/kkarpieszuk/Editor-Box
 * License: GPL 3
 * Text Domain: editor_box
 * Domain Path: /languages
 * Requires at least: 4.9
 * Requires PHP: 7.0
 */

use EditorBox\Hooks;

require_once __DIR__ . '/vendor/autoload.php';

const IMGINPUT = 'editor_box_image_upload';
const EDITORBOX_PLUGIN_FILE = __FILE__;

(new Hooks)->register_hooks();