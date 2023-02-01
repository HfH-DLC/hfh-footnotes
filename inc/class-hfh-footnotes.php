<?php

namespace HfH\Footnotes;

class HfH_Footnotes
{
    static $instance = false;

    private $footnotes = array();

    public static function get_instance()
    {
        if (!self::$instance)
            self::$instance = new self;
        return self::$instance;
    }

    public function __construct()
    {
        add_action('init', array($this, 'init'));
        add_filter('the_content', array($this, 'append_footnotes'), 13);
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
        add_shortcode('hfh_footnote', array($this, 'handle_shortcode'));
    }

    public function init()
    {
        load_plugin_textdomain('hfh', false, HFH_FOOTNOTES_DIR . '/languages');
    }

    public function handle_shortcode($atts, $content = '')
    {
        global $id;

        if (!$content) {
            return '';
        }

        if (!isset($this->footnotes[$id])) {
            $this->footnotes[$id] = array();
        }

        $this->footnotes[$id][] = $content;

        $index = count($this->footnotes[$id]);
        $label = "<sup>$index</sup>";
        $aria_label = sprintf(__('Footnote %1s'), $index);

        return "<a href='#footnote-$index' id='return-footnote-$index' aria-label='$aria_label'>$label</a>";
    }

    public function append_footnotes($content)
    {

        global $id;

        if (empty($this->footnotes) || !isset($this->footnotes[$id])) {
            return $content;
        }

        $footnotes = $this->footnotes[$id];
        unset($this->footnotes[$id]);

        if (empty($footnotes)) {
            return $content;
        }

        $content = $content . '<hr><ol>';

        foreach ($footnotes as $key => $footnote) {
            $index = $key + 1;
            $aria_label = sprintf(__('Return to footnote %1s'), $index);
            $content .= "<li id='footnote-$index'>$footnote <a href=#return-footnote-$index aria-label='$aria_label'>&crarr;</a></li>";
        }

        $content = $content . '</ol>';

        return $content;
    }

    public function enqueue_block_editor_assets()
    {
        wp_enqueue_script('hfh-footnotes', HFH_FOOTNOTES_URL . '/build/index.js', array('wp-block-editor', 'wp-i18n'));

        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations('hfh-footnotes', 'hfh-footnotes', HFH_FOOTNOTES_DIR . '/languages');
        }
    }
}

HfH_Footnotes::get_instance();
