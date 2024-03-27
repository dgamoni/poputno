<?php
/*<section class="feature_slider stoparr" id="feature_slider">
   
    <?php

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'meta_query' => array(
            array(
                'key' => 'post_for_footer_slide',
                'value' => 1,
                'type' => 'numeric'
            )
        )
    );


    $the_query = new WP_Query($args);
    $i = 0;
    ?>
    <ul>
        <?php while ($the_query->have_posts()): $the_query->the_post();
            $i++; ?>
            <?php get_template_part('content', 'slider'); ?>
        <?php endwhile; ?>
        <?php
        $limit = 12;
        if ($i < $limit) {
            $limit -= $i;

            $query = get_popular_posts(array(
                'posts_per_page' => $limit,
                'old_days' => 7
            ));

            global $post;
            $temp_post = $post;
            foreach ($query as $item) {
                $post = get_post($item->ID);
                //setup_postdata($post);
                get_template_part('content', 'slider');
            }

            echo $item->post_title;
            $post = $temp_post;
        }

        ?>


    </ul>
</section>*/
?>
<footer class="footer stoparr" id="footer">

    <div class="wrap">

       <!--  <a href="<?php bloginfo('url'); ?>" class="logo_link"></a> -->

        <nav class="foot_navy">
<!--             <ul>
                <li><a href="/about">О проекте</a></li>
                <li><a href="/adv">Реклама</a></li>
                <li><a href="/contacts">Контакты</a></li>
            </ul> -->
            <?php wp_nav_menu( array(
                   'container'       => '',
                   'container_class' => '',
                   'theme_location'  => 'footer',
                   //'items_wrap'      => '<div class="second_wrap"><div class="btn_trigger">Рубрики</div><ul class="second_menu">%3$s</ul></div>',
               ) ); ?> 

        </nav>


        <br/>

        <p class="copyrights">

            <?php
            /* global $sape;
            echo $sape->return_links(); */
            ?>
        </p>

<!--         <div class="copyright">
            <p>&copy; 2015 <a href="<?php bloginfo('url'); ?>"></a></p>

            <p>При использовании материалов сайта обязательным условием является наличие гиперссылки в пределах первого
                абзаца на страницу расположения исходной статьи с указанием </p>
            
            <p class="developer_links">
                <a href="" target="_blank" class="link_creator"></a>
                <a href="" target="_blank" rel="nofollow" class="link_host"></a>
                <a href="" target="_blank" rel="nofollow" class="link_photos"></a>
            </p>
        </div> -->

        <ul class="user_zone cf">
            <li>
<!--                 <form
                    action="http://ain.us1.list-manage1.com/subscribe/post?u=fc9c889691f02cbcfcc5843c5&amp;id=379ab22b67"
                    method="post" class="subscribe_form cf">
                    <input type="text" value="Рассылка новостей" name="MERGE0"
                           onfocus="if (this.value == 'Рассылка новостей') {this.value = '';}"
                           onblur="if (this.value == '') {this.value = 'Рассылка новостей';}"/>
                    <button type="submit"></button>
                </form> -->
            </li>

<!--             <li class="social_link">
                <a target="_blank" href="" class="fb_link"><i
                        class="icon-facebook"></i></a>
                <a target="_blank" href="" class="tw_link"><i class="icon-twitter"></i></a>
                <a target="_blank" href="" class="vk_link"><i class="icon-vkontakte"></i></a>
                <a target="_blank" href="" class="gp_link"><i
                        class="icon-gplus"></i></a>
                <a target="_blank" href="" class="rss_link"><i class="icon-rss"></i></a>
            </li> -->

        </ul>

    </div>

</footer>

<?php if (is_single()) { ?>
    <a href="#" id="go_up" class="go_up"></a>
<?php } ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">

</script>


<!-- VK -->
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?49"></script>
<script type="text/javascript">
    //VK.init({apiId: 2155003, onlyWidgets: true});
</script>


<noscript>
    <!-- <div><img src="//mc.yandex.ru/watch/8145244" style="position:absolute; left:-9999px;" alt=""/></div> -->
</noscript>
<!-- /Yandex.Metrika counter -->

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/social-likes.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/include.js"></script>

<!-- google -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61040125-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- end google -->

<?php dc_form_search_ajax(); ?>

<?php wp_footer(); ?>
</body>
</html>