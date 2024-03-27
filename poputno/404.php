<?php
if ($_SERVER['REQUEST_URI'] != "/404/" && $_SERVER['REQUEST_URI'] != "/404") {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: ' . get_bloginfo('url') . '/404');
    exit();
}
?>
<!doctype html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <title>404 — <?php bloginfo("name"); ?></title>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>"/>
</head>
<body>

<section class="main" id="main">

    <section class="page-404">
        <div class="wrapper">

            <div class="error-code"></div>
            <div class="error-label">Ошибка</div>

            <div class="white-bg">
                <div class="errorMsg">
                    <h1>Увы, такой страницы не существует.</h1>

                    <p>Можете воспользоваться поиском, перейти на <a class="redlink" href="<?php bloginfo('url'); ?>">главную</a>
                        или почитать актуальные материалы:</p>
                </div>

                <div class="sidebar-widget recommended rWidget">
                    <div class="h2-box"><h2>Свежие посты</h2></div>
                    <ul>

                        <?php
                        $recentPosts = new WP_Query();
                        $recentPosts->query('showposts=5');
                        ?>
                        <?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
                            <li>
                                <a class="popular_widget_title"
                                   href="<?php the_permalink() ?>"><?php the_title(); ?></a>

                                <p><span class="meta"><?php the_time('j.m.y') ?></span></p>

                            </li>
                        <?php endwhile; ?>
                    </ul>

                </div>


                <div class="sidebar-widget most-popular first pWidget">
                    <div class="h2-box"><h2>Популярное</h2></div>
                    <ul>
                        <?php
                        global $post;
                        $temp_post = $post;
                        $query = get_popular_posts(array('posts_per_page' => 5));
                        foreach ($query as $item) {
                            $post = $item->ID;
                            ?>

                            <li><a class="popular_widget_title" href="<?php the_permalink(); ?>"
                                   title="<?php printf(esc_attr('%s'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a>

                                <p><span class="meta"><?php the_time('j.m.y') ?></span></p>

                            </li>
                        <?php
                        }
                        wp_reset_query(); ?>
                    </ul>

                </div>
            </div>
        </div>
    </section>
</section>

</body>
</html>