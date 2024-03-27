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


        <!-- <br/> -->

        <p class="copyrights">Использование материалов сайта poputno.info разрешено только при наличии активной ссылки на источник. Все права на тексты принадлежат редакции.</p>
 
        

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

<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ua/stat/?id=31030541&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://bs.yandex.ru/informer/31030541/2_0_FFFFFFFF_EFEFEFFF_1_pageviews"
style="width:80px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры)" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31030541 = new Ya.Metrika({
                    id:31030541,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31030541" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- begin of Top100 code -->

<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?3116489"></script>
<noscript>
<a href="http://top100.rambler.ru/navi/3116489/">
<img src="http://counter.rambler.ru/top100.cnt?3116489" alt="Rambler's Top100" border="0" />
</a>

</noscript>
<!-- end of Top100 code -->

</footer>

<?php if (is_single()) { ?>
    <a href="#" id="go_up" class="go_up"></a>
<?php } ?>




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




                <div style="display:none;">
                    <a href="http://orphus.ru" id="orphus" target="_blank" title="undefined">
                    <img alt="Система Orphus" src="/orphus/orphus.gif" border="0" width="257" height="48"></a>
                </div>

<?php dc_form_search_ajax(); ?>

<?php wp_footer(); ?>
</body>
</html>