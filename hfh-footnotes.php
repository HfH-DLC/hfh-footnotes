<?php

/**
 * Plugin Name:     HfH Footnotes
 * Description:     Adds Footnote button to the WP Editor
 * Author:          Matthias Nötzli
 * Author URI:      https://github.com/matthias-noetzli
 * Text Domain:     hfh-footnotes
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         HfH_Footnotes
 */

namespace HfH\Footnotes;

if (!defined('ABSPATH')) {
    return;
}

if (!defined('HFH_FOOTNOTES_DIR')) {
    define('HFH_FOOTNOTES_DIR', plugin_dir_path(__FILE__));
}

if (!defined('HFH_FOOTNOTES_URL')) {
    define('HFH_FOOTNOTES_URL', plugin_dir_url(__FILE__));
}

require_once("inc/class-hfh-footnotes.php");
