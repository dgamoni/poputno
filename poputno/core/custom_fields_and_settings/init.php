<?php
define('ACF_LITE', true);
define("OPTIONS_ICON", 'dashicons-admin-settings');


include_once('advanced-custom-fields/acf.php');

include "includes/costume_fields.php";


add_action('acf/register_fields', 'register_fields');
function register_fields()
{
    include_once('registered-fields/presets/acf-presets.php');
    include_once('registered-fields/google-font/acf-googlefonts.php');
    include_once('registered-fields/googlemap/acf-googlemap.php');
}


