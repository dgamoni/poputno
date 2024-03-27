<?php

//THUMBNAILS IN RSS FEED
function rss_post_thumbnail($content)
{
    global $post, $posts, $more, $feed;
    $more = 0;
    /*
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
    */
    if (is_feed() && $feed != 'yandexfeed') {
        if (has_post_thumbnail($post->ID)) {
            $content = /* '<p><a href="' .get_permalink($post->ID) . '">' . get_the_post_thumbnail($post->ID) . '</a></p>' . */
                the_content('Читать далее &rarr;');
            return $content;
        } else {
            $content = the_content('Читать далее &rarr;');
            return $content;
        }
        return $content;
    }
}

add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

// переименовываем фуфло в профайле пользователя
function rename_contactmethods()
{
    return array(
        'aim' => __('Twitter'),
        'yim' => __('Facebook'),
        'jabber' => __('LinkedIN')
    );
}

add_filter('user_contactmethods', 'rename_contactmethods');


// RENAME WP_MAIL NAME AND EMAIL
// add_filter('wp_mail_from', 'new_mail_from');
// function new_mail_from($old)
// {
//     return 'info@ain.ua';
// }

// add_filter('wp_mail_from_name', 'new_mail_from_name');
// function new_mail_from_name($old)
// {
//     return 'AIN.ua';
// }


// изменение текста в футере админки
function remove_footer_admin()
{
    echo "Работает на <a href='http://wordpress.org'>WordPress</a>&nbsp;&nbsp;|&nbsp;&nbsp;Разработка сайта&nbsp;—&nbsp;<a href='http://decollete.com.ua'>Decollete</a>";
}

//add_filter('admin_footer_text', 'remove_footer_admin');



//  Custom login page
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// function my_login_logo_url_title() {
//     return 'AIN.UA';
// }
//add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_stylesheet() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'template_directory' ) . '/assets/css/style-login.css'; ?>" type="text/css" media="all" />
<?php }

add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


// CHANGING THE LOGO URL & TITLE IN WORDPRESS LOGIN PAGE
// function change_wp_login_url()
// {
    // echo bloginfo('url');
// }

// add_filter('login_headerurl', 'change_wp_login_url');

// function change_wp_login_title()
// {
    // echo get_option('blogname');
// }

// add_filter('login_headertitle', 'change_wp_login_title');


//редіректимо після логіну на профіль
function uni_redirect_after_login($redirect_to, $request, $user)
{
    if (!current_user_can('upload_files')) {
        return get_bloginfo('url') . '/cabinet/';
    }
}

add_filter('login_redirect', 'uni_redirect_after_login', 10, 3);

// show admin bar only for admins
if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}
// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
    add_filter('show_admin_bar', '__return_false');
}


// не показывать вакансии на главной
// function exclude_category($query)
// {
//     if ($query->is_home) {
//         $query->set('cat', '-1543 -1151 -1548 -1544 -1547 -1545 -1545, -3068');
//     }
//     return $query;
// }

// add_filter('pre_get_posts', 'exclude_category');


// разрешаем хтмл в описании метки
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('term_description', 'wp_kses_data');


add_filter('get_lastpostmodified', 'spoof_lastpostmodified', 10, 2);

function spoof_lastpostmodified($lastpostmodified, $timezone)
{
    global $wp;
    if (!empty($wp->query_vars['feed'])) {
        $lastpostmodified = date("Y-m-d H:i:s"); // Now
    }
    return $lastpostmodified;
}


// Замена сокращения [...] на ссылку Далее...:
if (!function_exists('custom_excerpt_more')) {
    function custom_excerpt_more($more)
    {
        global $post;
        //return '<br><a class="tag" href="'. get_permalink($post->ID) . '">Читать далее...</a>';
        return '';
    }

    add_filter('excerpt_more', 'custom_excerpt_more');
}


// Изменение количества символов в анонсе (по умолчанию 55):
if (!function_exists('custom_excerpt_length')) {
    function custom_excerpt_length($length)
    {
        return 40; // В анонсе только первые 20 слов
    }

    add_filter('excerpt_length', 'custom_excerpt_length', 999);
}