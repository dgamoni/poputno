<?php
add_action('widgets_init', 'uni_featured_sidebar_widget');

function uni_featured_sidebar_widget()
{
    register_widget('featured_sidebar_widget');
}

class featured_sidebar_widget extends WP_Widget
{


    function featured_sidebar_widget()
    {

        $widget_ops = array('classname' => 'featured_sidebar_widget', 'description' => 'Вывод важных постов');

        $this->WP_Widget('featured_sidebar_widget', 'Важное', $widget_ops);
    }

    //те, що наш віджет виводитиме у фронт-енд
    function widget($args, $state)
    {
        extract($args);

        $title = apply_filters('widget_title', $state['title']);
        $count = $state['count'];
        $tag_id = $state['tag'];

        if ($state['only_admin']) {
            if (!current_user_can('administrator')) {
                return;
            }
        } elseif (!$tag_id) {
            return;
        }

        echo $before_widget;

        if ($title)
            echo $before_title . $title . $after_title;
        ?>


        <div class="widget_content">
            <ul class="important">

                <?php

                $fwidget_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $count,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_tag',
                            //'field' => 'id',
                            'field' => 'slug',
                            'terms' => $tag_id
                        )
                    ),
                );

                $fwidget_query = new WP_Query($fwidget_args);
                if ($fwidget_query->have_posts()):
                    while ($fwidget_query->have_posts()) : $fwidget_query->the_post();
                        ?>
                        <li class="post-widget-item">
                            <a href="<?php the_permalink() ?>">
                                <img width="240" height="140"
                                     src="<?php echo get_img_post(get_the_ID(), 'ain-thumb-widget-important'); ?>"
                                     alt="">
                                <span><?php the_title(); ?></span>
                            </a>
                        </li>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </ul>
        </div>


        <?php
        echo $after_widget;
    }

    //оновлюємо дані віджета
    function update($state_new, $state_old)
    {
        $state = $state_old;

        $state['title'] = strip_tags($state_new['title']);
        $state['count'] = (int)$state_new['count'];
        $state['tag'] = $state_new['tag'];
        $state['only_admin'] = (int)$state_new['only_admin'];
        return $state;
    }

    //форма віджета у бек-енд
    function form($state)
    {

        $defaults = array(
            'title' => 'Важное',
            'count' => '7'
        );

        $state = wp_parse_args((array)$state, $defaults); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Заголовок:') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $state['title']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo __('К-во постов:') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $state['count']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('tag'); ?>"><?php echo __('Тег:') ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('tag'); ?>"
                   name="<?php echo $this->get_field_name('tag'); ?>" value="<?php echo $state['tag']; ?>"/>
        </p>

        <?php /*
        <p>
            <label for="<?php echo $this->get_field_id('tag'); ?>"><?php echo __('Тег:') ?></label>
            <select id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>"
                    style="width: 100%;">
                <option value="-1">Выбрать ...</option>
                <?php
                foreach (get_tags() as $tag) {

                    ?>
                    <option
                        value="<?php echo $tag->term_id; ?>" <?php selected($state['tag'], $tag->term_id); ?>>
                        <?php echo $tag->name; ?></option>
                <?php

                }
                ?>

            </select>
        </p>
 */
        ?>
        <p>
            <label
                for="<?php echo $this->get_field_id('only_admin'); ?>"><?php echo __('Смертным не показывать') ?></label>
            <input class="widefat" type="checkbox" id="<?php echo $this->get_field_id('only_admin'); ?>"
                   name="<?php echo $this->get_field_name('only_admin'); ?>"
                   value="1"
                <?php checked($state['only_admin'], 1); ?> >
        </p>
    <?php
    }
}

?>