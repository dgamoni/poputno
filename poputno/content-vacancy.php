<?php

$images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 1));
$sImage = '';
if ($images) {
    foreach ($images as $image) {
        $image_src = wp_get_attachment_image_src($image->ID, 'univac-randlogo');
        $sImage = '<img width="50" src="' . $image_src[0] . '" alt="' . get_post_meta($post->ID, 'univac_company_name', true) . '" />';
    }
}
?>

<li id="post-<?php the_ID(); ?>" class="vac-item">
    <a class="comp-logo <?php if (!$sImage) echo 'no_thumb'; ?>" href="<?php the_permalink(); ?>">
        <?php echo $sImage; ?>
    </a>

    <div class="comp-txt cf">
        <div class="company">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <a href="<?php the_permalink(); ?>"
               class="comp-name"><?php echo esc_attr(get_post_meta(get_the_ID(), 'univac_company_name', true)); ?>
            </a>
        </div>
        <div class="about">
            <ul class="cat-list">
                <?php
                $terms = get_the_terms(get_the_ID(), 'univac_cat');
                if ($terms && !is_wp_error($terms)) :
                    $works_links = array();
                    foreach ($terms as $term) {
                        ?>
                        <li class="cat">
                            <a href="<?php echo get_term_link($term, 'univac_cat'); ?>"
                               class="<?php echo get_vacancy_cat_color($term->term_id); ?>"><?php echo $term->name; ?></a>
                        </li>
                    <?php
                    }
                endif; ?>
            </ul>

            <?php /*<address class="address-marker">
                <?php if ($terms = get_the_terms(get_the_ID(), 'univac_city')) { ?>
                    <?php
                    if ($terms && !is_wp_error($terms)) :
                        $works_links = array();
                        foreach ($terms as $term) {
                            $works_links[] = '<a href=""'$term->name;
                        }
                        $works = join(", ", $works_links);
                        echo $works;
                    endif; ?>
                <?php }  ?>
                &nbsp;</address> */
            ?>

            <?php $terms = get_the_terms($post->ID, 'univac_city'); ?>
            <?php
            if (count($terms) > 0) {
                if ($terms && !is_wp_error($terms)) {
                    $works_links = array();
                    foreach ($terms as $term) {
                        ?>
                        <a href="<?php echo get_term_link($term->slug, 'univac_city'); ?>">
                            <address class="address-marker">
                                <?php echo $term->name; ?>
                            </address>
                        </a>
                    <?php
                    }
                } else {
                    ?>
                    <address class="address-marker" style="opacity:0;">

                    </address>
                <?php
                }
            } else {
                ?>
                <address class="address-marker" style="opacity:0;">

                </address>

            <?php } ?>
        </div>
</li>