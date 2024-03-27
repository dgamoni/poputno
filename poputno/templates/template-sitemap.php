<?php
/**
 * Template Name: Sitemap
 */
//include get_template_directory() . '/core/modules/sitemap/templates/index.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>AIN.UA: Карта сайта</title>
    <?php if (!is_sitemap_home()) { ?>
        <meta name="robots" content="noindex, follow, noarchive"/>
    <?php } ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'PTC', sans-serif;
            color: #272c2f;
            line-height: 1.35;
        }

        ul {
            display: table;
            margin: 0px;
            padding: 0
        }

        ul li {
            width: 300px;
            list-style: none;
            float: left;
            margin-left: 10px;
        }
    </style>
</head>
<body>


<a href="<?php bloginfo('url'); ?>/sitemap/">Карта сайта</a> <br><br>
Категории &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
<?php get_custom_category(); ?> <?php get_list_category(); ?>
<br><br>
Архив по годам &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| <?php get_sitemap_archives_year(); ?>
<br><br>
Архив по месяцам &nbsp;| <?php get_sitemap_archives_month(); ?>
<?php if (!is_sitemap_home()) { ?>
    <hr>
    <br><br>

    <?php

    $paged = get_param_paged();

    $is_category = false;
    $is_custom_category = false;

    $args['post_type'] = array('post', 'tribe_events', 'univac_vacancy');

    if ($post_type_custom = get_param_custom_category()) {
        $args['post_type'] = $post_type_custom;
        $is_custom_category = true;
    } elseif ($cat_slug = get_param_category()) {
        $is_category = true;
        $args['post_type'] = 'post';
        $args['tax_query'] = array(
            array('taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $cat_slug
            )
        );
    }

    if ($month = get_param_month()) {
        $args['year'] = get_param_year();
        $args['monthnum'] = $month;
    } else {
        $args['year'] = get_param_year();
    }

    $args['post_status'] = 'publish';


    $args['posts_per_page'] = 30;
    $args['paged'] = $paged;
    $args['orderby'] = 'post_type';
    $args['order'] = 'DESC';

    //add_action('pre_get_posts', 'function($query){$query->set("meta_query","")}', 999);
    //add_filter('posts_where', 'function(){return "";}', 999);
    //add_filter('posts_join', 'function(){return "";}', 999);

    $posts = new WP_Query($args);
    //print_r($posts);
    $date = '';
    echo '<ul>';
    while ($posts->have_posts()) {
        $posts->the_post();

        //echo $post->post_name;
        if ($date != get_the_time('Ym')) {
            $date = get_the_time('Ym');
            echo '</ul>';
            if (!$is_category) {
                if ($posts->post->post_type == 'univac_vacancy') {

                    echo 'Работа, ';
                } elseif ($posts->post->post_type == 'tribe_events') {

                    echo 'События, ';
                } else {
                    $category = get_the_category(get_the_ID());
                    echo $category[0]->cat_name . ', ';
                }
            }
            echo sitemap_get_month_name(get_the_time('m')) . ' ' . get_the_time('Y');
            echo '<hr>';
            echo '<ul>';
        }

        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a><br><br></li>';

    }
    echo '</ul>';

    sitemap_pagination($posts, $paged);
    ?>

    <pre>
<?php

/*print_r($wp_query->query_vars);

print_r($_SERVER);*/
//$param = explode('/', $_SERVER['REQUEST_URI']);
//$param = array_diff($param, array(''));
//print_r($param);

//get_param_category();

?>

</pre>
<?php } ?>
</body>
</html>