<li>
    <div class="fpost">
        <a href="<?php the_permalink(); ?>">
            <?php
            $img = get_img_post(get_the_ID(), $size = 'ain-post');
            ?>
            <img src="<?php echo $img; ?>" alt="">
            <aside class="cover">
                <aside>
                                  <span><?php
                                      $cat_arr = array();
                                      foreach (get_the_category(get_the_ID()) as $item) {
                                          $cat_arr[] = $item->name;
                                      }
                                      echo implode(',', $cat_arr);
                                      ?></span>

                    <p><?php the_title(); ?></p>
                </aside>
            </aside>
        </a>
    </div>
</li>