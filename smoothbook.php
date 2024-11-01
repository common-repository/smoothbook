<?php
/**
  Plugin Name: Smoothbook
  Plugin URI: https://www.smoothbook.co/
  Description: Smoothbook is an award winning appointments management system that embeds directly into your Wordpress website. Suitable for all types of business, works great for groups and classes; Smoothbook has numerous features and is exceptionally easy to set up and use.
  Version: 1.2
  Author: James Drummond
  Author URI: https://www.smoothbook.co/
  License: GPLv3
  Domain Path: smoothbook
*/

require_once 'include/sb-options.php';

class Smoothbook {

    public static $message = '';

    public static $imagesUrl;

    function __construct()
    {
        self::$imagesUrl = plugin_dir_url(__FILE__) . "images/";

        add_action('admin_menu', array($this, 'initAdmin'));

        add_action('init', array($this, 'init'));
    }

    public function init()
    {
        add_shortcode('smoothbook', array($this, 'shortcodeHandler'));
        $this->initMceButtons();
    }

    public function shortcodeHandler($atts)
    {
        $params = shortcode_atts(array('orgId' => SbOptions::getOrgId()), $atts);

        if (!empty($params['orgId'])) {
            wp_enqueue_script('smoothbook-fe-calendar', 'https://app.smoothbook.co/lib/calendar-embed.js');
            $html = file_get_contents(realpath(dirname(__FILE__)) . '/templates/fe.calendar.tpl');
            $html = str_replace('{ORG-ID}', $params['orgId'], $html);
            $html = str_replace('{IMG-URL}', Smoothbook::$imagesUrl, $html);
            return $html;
        }
        return '';
    }

    public function initMceButtons()
    {
        $appPath = str_replace("\\", '/', substr(realpath(dirname(__FILE__)), strlen(ABSPATH)));
        wp_enqueue_style('smoothbook-mce', get_bloginfo('wpurl') . '/' . $appPath . '/css/sb-mce-plugin.css?t='.time());
        wp_enqueue_style('smoothbook-font-awesome', get_bloginfo('wpurl') . '/' . $appPath . '/css/sb-font-awesome.min.css');

        add_filter("mce_external_plugins", array($this, "addMceButtons"));
        add_filter("mce_buttons", array($this, "registerMceButtons"));
    }

    function addMcebuttons($pluginArray)
    {
        $pluginArray['smoothbook_plugin'] = plugin_dir_url(__FILE__) . '/js/sb-mce-plugin.js?t='.time();
        return $pluginArray;
    }

    function registerMceButtons($buttons)
    {
        array_push($buttons, 'smoothbook');
        return $buttons;
    }

    public function initAdmin()
    {
        // Add a new submenu under options
        add_menu_page(
            'Smoothbook',
            'Smoothbook',
            'manage_options',
            'smoothbook',
            array($this, 'adminConfigPage'),
            'dashicons-calendar',
            85
        );

        $appPath = str_replace("\\", '/', substr(realpath(dirname(__FILE__)), strlen(ABSPATH)));
        wp_enqueue_script('smoothbook-options', get_bloginfo('wpurl') . '/' . $appPath . '/js/sb-loadingoverlay.min.js?t='.time());
        wp_enqueue_style('smoothbook-admin-config', get_bloginfo('wpurl') . '/' . $appPath . '/css/sb-admin-config.css?t='.time());
    }

    /**
     * Show Admin page
     */
    public function adminConfigPage()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'smoothbook_update') {
            check_admin_referer('smoothbook-update_options');
            // save admin form
            self::$message = SbOptions::save($_POST);
        }
        require_once 'templates/admin.config.tpl';
    }

    public static function adminOptions()
    {
        require_once 'templates/admin.options.tpl';
    }
}

$sb = new Smoothbook();
