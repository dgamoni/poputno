<?php
/**
 * Custom RSS2 Feed Template for Yandex.
 *
 * ain.ua
 */

header("Content-Type: application/rss+xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
    xmlns="http://backend.userland.com/rss2"
	xmlns:yandex="http://news.yandex.ru">
    <channel>
        <title><?php bloginfo_rss('name') ?></title>
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <image>
            <url><?php bloginfo('url') ?>/images/logo.gif</url>
            <title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
            <link><?php bloginfo_rss('url') ?></link>
        </image>
        <?php $rss_query = new WP_Query ( array( 'tag' => 'novosti' ) );
        while ( $rss_query->have_posts() ) : $rss_query->the_post(); ?>
        <item>
            <title><?php the_title_rss() ?></title>
            <link><?php the_permalink_rss() ?></link>
            <description><![CDATA[<?php echo get_the_excerpt() ?>]]></description>
            <category><?php $category = get_the_category();
            echo $category[0]->cat_name; ?></category>
            <?php all_attach_for_feed(); ?>
            <pubDate><?php echo mysql2date('D, d M Y H:i:s +0300', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		    <yandex:full-text><![CDATA[<?php echo uni_special_rss() ?>]]></yandex:full-text>
        </item>
        <?php endwhile; ?>
    </channel>
</rss>