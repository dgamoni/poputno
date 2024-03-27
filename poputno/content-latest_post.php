<li class="fresh_latest_post">
    <a href="<?php the_permalink(); ?>"
       style="background-image: url(<?php echo get_img_post(get_the_ID(), 'fresh_latest_post'); ?>);">
        <div class="fresh_gradient">
            <p class="fresh_small">
                <?php echo get_time_deails(get_the_ID()); ?>
            </p>

            <h3 class="fresh_big"><?php the_title(); ?></h3>

            <p class="fresh_meta">
                                    <span class="fresh_views_count"><?php $res = get_soc_votes(get_the_ID());
                                        echo $res['view']; ?></span>
                <?php /* <span class="fresh_comments_count"><?php echo $res['cn']; ?></span>*/ ?>
                                    <span class="fresh_favs_count"><?php $res = get_soc_votes(get_the_ID());
                                        echo $res['sum']; ?></span>
            </p>
        </div>
    </a>
</li>
