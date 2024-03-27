<?php


add_action('wp_head', 'ain_html5');
function ain_html5()
{
    ?>
    <!-- Load Google HTML5 shim to provide support for <IE9 -->
    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

add_action('wp_enqueue_scripts', 'add_external_stylesheets');
function add_external_stylesheets()
{
   // wp_enqueue_style("main", get_stylesheet_uri(), false, "1.0");
    
    wp_enqueue_style("jPushMenu-css", get_template_directory_uri() . "/assets/js/jPushMenu.css", false, "1.0");

}


add_action('wp_head', 'wpt_register_js');
//add_action( 'init', 'wpt_register_js' );
//add_action('wp_enqueue_scripts', 'wpt_register_js');
function wpt_register_js()
{
    if (!is_admin()) {
        //wp_enqueue_script("jquery-bxslider", get_template_directory_uri() . "/assets/js/bxSlider.min.js", array(), '', TRUE);
        //wp_enqueue_script("jquery-raty", get_template_directory_uri() . "/assets/js/jquery.hcsticky-min.js", array(), '', TRUE);
        wp_enqueue_script("ajax-filters", get_template_directory_uri() . "/assets/js/ajax_filters.js", array(), '', TRUE);

         //wp_enqueue_script("jquery-simplesidebar", get_template_directory_uri() . "/assets/js/bigSlide.js", array(), '', TRUE);
         wp_enqueue_script("jPushMenu", get_template_directory_uri() . "/assets/js/jPushMenu.js", array(), '', TRUE);
    }
}



