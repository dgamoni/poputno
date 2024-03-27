<?php
define('TEXTDOMAIN', 'ain');
define('CORE_PATH', get_template_directory() . '/core');
define('CORE_URL', get_template_directory_uri() . '/core');

require_once 'modules/sitemap/init.php';

include_once('modules/admin/draft-widget.php');

include_once('modules/admin/widget-rand_sidebar.php');
include_once('modules/admin/widget-featured.php');
//include_once('modules/admin/metab.php');

require_once 'theme-settings.php';
require_once 'core-functions.php';
require_once 'core-filters.php';
require_once 'core-actions.php';
require_once 'core-shorcodes.php';

require_once 'images-init.php';
require_once 'register-menus.php';
require_once 'register-js-and-stylesheet.php';
require_once 'ajax.php';
require_once 'modules/cool-search/init.php';
require_once 'custom_fields_and_settings/init.php';
require_once 'modules/brending-tag-page/branding-functions.php';
require_once 'includes/twitter/TwitterAPIExchange.php';
require_once 'modules/abbyy-cloud-ocr/abbyy-cloud-ocr.php';
require_once 'wp_schedule_events.php';
require_once 'includes/header_breadcrumbs.php';
require_once 'includes/timespan.php';

// Автозагрузка библиотек и функций
$dirs = array(
    CORE_PATH . '/widgets/',
    CORE_PATH . '/post_types/',
    CORE_PATH . '/sidebars/',
    CORE_PATH . '/shortcodes/',

);
foreach ($dirs as $dir) {
    $other_inits = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if ($file != '.' && $file != '..' && stristr($file, '.php') !== false) {
                    list($nam, $ext) = explode('.', $file);
                    if ($ext == 'php')
                        $other_inits[] = $file;
                }
            }
            closedir($dh);
        }
    }
    asort($other_inits);
    foreach ($other_inits as $other_init) {
        if (file_exists($dir . $other_init))
            include_once $dir . $other_init;
    }
}



