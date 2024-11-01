<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

require_once 'include/sb-options.php';

// Cleanup saved options
delete_option(SbOptions::OPTIONS);
