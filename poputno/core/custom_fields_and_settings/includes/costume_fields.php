<?php
/**
 *  Install Add-ons
 *
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *
 *  All fields must be included during the 'acf/register_fields' action.
 *  Other types of Add-ons (like the options page) can be included outside of this action.
 *
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme as outlined in the terms and conditions.
 *  However, they are NOT to be included in a premium / free plugin.
 *  For more information, please read http://www.advancedcustomfields.com/terms-conditions/
 */

// Fields 
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
    include_once('add-ons/acf-repeater/repeater.php');
    //include_once('add-ons/acf-gallery/gallery.php');
    include_once('add-ons/acf-flexible-content/flexible-content.php');
    include_once('add-ons/acf-field-date-time-picker/acf-date_time_picker.php');
}

// Options Page 
include_once('add-ons/acf-options-page/acf-options-page.php');

if (function_exists("register_field_group")) {

    // Автозагрузка библиотек и функций
    $dirs = array(
        CORE_PATH . '/custom_fields_and_settings/custom_fields_init/',
    );

    foreach ($dirs as $dir) {
        $custome_fields_init = array();
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (false !== ($file = readdir($dh))) {
                    if ($file != '.' && $file != '..' && stristr($file, '.php') !== false) {
                        list($nam, $ext) = explode('.', $file);
                        if ($ext == 'php')
                            $custome_fields_init[] = $file;
                    }
                }
                closedir($dh);
            }
        }
        asort($custome_fields_init);
        foreach ($custome_fields_init as $other_init) {
            include_once $dir . $other_init;
        }
    }
}
