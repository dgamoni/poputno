<?php
add_action('widgets_init', 'new_vacancy_widget_init');

function new_vacancy_widget_init()
{
    unregister_widget('uni_new_vacancy_widget');
    register_widget('new_vacancy');
}

class new_vacancy extends WP_Widget
{


    function new_vacancy()
    {

        $widget_ops = array('classname' => 'uni_new_vacancy_widget', 'description' => 'Кастомный виджет: "Новые вакансии"');

        $this->WP_Widget('uni_new_vacancy_widget', 'Виджет "Новые вакансии"', $widget_ops);
    }

    //те, що наш віджет виводитиме у фронт-енд
    function widget($args, $state)
    {
        extract($args);

        $title = apply_filters('widget_title', $state['title']);
        $posts_num = $state['posts_num'];
        global $post;
        //echo $before_widget;
        echo '<div class="widget job_list">';

        if ($title)
            echo $before_title . $title . $after_title;
        $args = array(
            'post_type' => 'univac_vacancy',
            'post_status' => 'publish',
            'orderby' => 'rand',
            'posts_per_page' => $posts_num
        );
        $my_query = new WP_Query($args);
        echo '<div class="widget_content ">';
        echo '<ul>';
        while ($my_query->have_posts()) : $my_query->the_post();
            $post = $my_query->post;
            $images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 1));
            $sImage = '';
            if ($images) {
                foreach ($images as $image) {
                    $image_src = wp_get_attachment_image_src($image->ID, 'univac-randlogo');
                    $sImage = '<img width="50" src="' . $image_src[0] . '" alt="' . get_post_meta($post->ID, 'univac_company_name', true) . '" />';
                }
            }

            ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <span class="new_vac_wrap"><?php
                    if ($sImage) {
                        echo $sImage;
                    } else {
                        echo '<div class="job_list_no_img">&nbsp;</div>';
                    }
                    ?></span>
                   
                    <strong><?php the_title(); ?></strong>
                     <span><?php echo get_post_meta($post->ID, 'univac_company_name', true) ?></span>
                </a>
            </li>

        <?php
        endwhile;
        echo '</ul>';
        echo '</div>';
        wp_reset_query();


        echo $after_widget;

    }

    //оновлюємо дані віджета
    function update($state_new, $state_old)
    {
        $state = $state_old;

        $state['title'] = strip_tags($state_new['title']);
        $state['posts_num'] = strip_tags($state_new['posts_num']);

        return $state;
    }

    //форма віджета у бек-енд
    function form($state)
    {

        $defaults = array(
            'title' => 'Новые вакансии',
            'posts_num' => '5'
        );

        $state = wp_parse_args((array)$state, $defaults); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Заголовок:' ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $state['title']; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('posts_num'); ?>"><?php echo 'К-во вакансий:' ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('posts_num'); ?>"
                   name="<?php echo $this->get_field_name('posts_num'); ?>" value="<?php echo $state['posts_num']; ?>"/>
        </p>

    <?php
    }
}

?>