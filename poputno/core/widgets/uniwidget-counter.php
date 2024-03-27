<?php
/*******************************************************
 *
 *    Custom Social Counter Widget
 *    By: Andre Gagnon
 *    http://www.designcirc.us
 *
 *******************************************************/

// Initialize widget
add_action('widgets_init', 'ag_social_widgets');

// Register widget
function ag_social_widgets()
{
    register_widget('AG_Social_Widget');
}

// Widget class
class ag_social_widget extends WP_Widget
{
    /*----------------------------------------------------------*/
    /*	Set up the Widget
    /*----------------------------------------------------------*/
    function AG_Social_Widget()
    {
        /* General widget settings */
        $widget_ops = array('classname' => 'ag_social_widget', 'description' => __('Виджет: "Социальные счетчики"'));
        /* Widget control settings */
        $control_ops = array('width' => 400, 'height' => 350, 'id_base' => 'ag_social_widget');
        /* Create widget */
        $this->WP_Widget('ag_social_widget', __('Виджет: "Социальные счетчики"'), $widget_ops, $control_ops);
    }
    /*----------------------------------------------------------*/
    /*	Display The Widget
    /*----------------------------------------------------------*/
    function widget($args, $instance)
    {
        extract($args);
        /* Variables from settings. */
        $tw = $instance['twitter'];
        $fb = $instance['facebook'];
        $vk = $instance['vk'];
        $gp = $instance['gp'];
        $rss = $instance['rss'];
        $mailchimp = $instance['mailchimp'];
        if ($rss) {
            $rss_count = rss_followers_count($rss);
        }
        if ($fb) {
            $fb_count = fb_followers_count($fb);
        }
        if ($tw) {
            $tw_count = twi_followers_count($tw);
        }
        if ($vk) {
            $vk_count = vk_followers_count($vk);
        }
        if ($gp) {
            $gp_count = gp_followers_count();
        }
        //if($mailchimp){
        $mailchimp_count = mailchimp_followers_count($mailchimp);
        // }
        ?>
        <ul class="social_like cf">
            <li>
                <a target="_blank" href="http://facebook.com/<?php echo $fb; ?>" class="fb_like"><i
                        class="icon-facebook"></i></a>
                <span><?php echo $fb_count; ?></span>
            </li>
            <li>
                <a target="_blank" href="http://twitter.com/<?php echo $tw; ?>" class="tw_like"><i
                        class="icon-twitter"></i></a>
                <span><?php echo $tw_count; ?></span>
            </li>
            <li>
                <a target="_blank" href="https://plus.google.com/u/0/+<?php echo $gp; ?>/posts" class="gp_like"><i
                        class="icon-gplus"></i></a>
                <span><?php echo $gp_count; ?></span>
            </li>
            <li>
                <a target="_blank" href="http://vk.com/<?php echo $vk; ?>" class="vk_like"><i
                        class="icon-vkontakte"></i></a>
                <span><?php echo $vk_count; ?></span>
            </li>
            <li>
                <a target="_blank" href="http://feeds.feedburner.com/<?php echo $rss; ?>" class="rss_like"><i
                        class="icon-rss"></i></a>
                <span><?php echo $rss_count; ?></span>
            </li>
            <li>
                <a href="#" class="mail_like"><i class="icon-mail"></i></a>
                <span><?php echo $mailchimp_count; ?></span>

                <div class="show_form_subscribe">
                    <form
                        action="http://ain.us1.list-manage1.com/subscribe/post?u=fc9c889691f02cbcfcc5843c5&amp;id=379ab22b67"
                        method="post" class="subscribe_form cf">
                        <input type="text" value="Рассылка новостей" name="MERGE0"
                               onfocus="if (this.value == 'Рассылка новостей') {this.value = '';}"
                               onblur="if (this.value == '') {this.value = 'Рассылка новостей';}"/>
                        <button type="submit"></button>
                    </form>
                </div>
            </li>
        </ul>
    <?php
    }
    /*----------------------------------------------------------*/
    /*	Update the Widget
    /*----------------------------------------------------------*/
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        /* Remove HTML: */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['twitter'] = strip_tags($new_instance['twitter']);
        $instance['facebook'] = strip_tags($new_instance['facebook']);
        $instance['rss'] = strip_tags($new_instance['rss']);
        $instance['vk'] = strip_tags($new_instance['vk']);
        $instance['gp'] = strip_tags($new_instance['gp']);
        return $instance;
    }
    /*----------------------------------------------------------*/
    /*	Widget Settings
    /*----------------------------------------------------------*/
    function form($instance)
    {
        /* Default widget settings */
        $defaults = array(
            'facebook' => 'poputno',
            'twitter' => 'poputno',
            'rss' => 'poputno',
            'vk' => 'poputno',
            'gp' => 'poputno',
        );
        $instance = wp_parse_args((array)$instance, $defaults); ?>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>">
                <?php _e('Facebook ID (the end of your custom url):', 'framework') ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>"
                   name="<?php echo $this->get_field_name('facebook'); ?>"
                   value="<?php echo $instance['facebook']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>">
                <?php _e('Twitter ID (without the @):', 'framework'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>"
                   name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $instance['twitter']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('rss'); ?>">
                <?php _e('Feedburn ID (end of your feedburn url):', 'framework'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>"
                   name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $instance['rss']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('vk'); ?>">
                <?php _e('Vk url:', 'framework'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>"
                   name="<?php echo $this->get_field_name('vk'); ?>" value="<?php echo $instance['vk']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('gp'); ?>">
                <?php _e('Google Plus url:', 'framework'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('vk'); ?>"
                   name="<?php echo $this->get_field_name('gp'); ?>" value="<?php echo $instance['gp']; ?>"/>
        </p>
    <?php
    }
}

?>