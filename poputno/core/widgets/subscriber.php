<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly

	add_action( 'widgets_init', 'subscription_widget_init', 20 );
	function subscription_widget_init() {

		register_widget( 'subscription_widget' );
	}

	class subscription_widget extends WP_Widget {

		var $widget_cssclass;
		var $widget_description;
		var $widget_idbase;
		var $widget_name;

		/**
		 * constructor
		 *
		 * @access public
		 * @return void
		 */
		function subscription_widget() {

			/* Widget variable settings. */
			$this->widget_cssclass    = 'widget_subscription box_padding';
			$this->widget_description = 'Форма подписки';
			$this->widget_idbase      = 'widget_subscription';
			$this->widget_name        = 'Подписаться на новости';

			/* Widget settings. */
			$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

			/* Create the widget. */
			$this->WP_Widget( 'subscription_widget', $this->widget_name, $widget_ops );

			add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		}

		/**
		 * widget function.
		 *
		 * @see    WP_Widget
		 * @access public
		 *
		 * @param array $args
		 * @param array $instance
		 *
		 * @return void
		 */
		function widget( $args, $instance ) {

			extract( $args );
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'Подписаться на новости' : $instance['title'], $instance, $this->id_base );
			$link  = ( isset( $instance['link'] ) ? $instance['link'] : 'http://ain.us1.list-manage1.com/subscribe/post?u=fc9c889691f02cbcfcc5843c5&id=379ab22b67' );
			$descr = $instance['descr'];


			$count = get_transient( 'mailchimp_followers_count' );
			if ( empty( $count ) ) {
				mailchimp_followers_count();
				$count = get_transient( 'mailchimp_followers_count' );
			}
			?>

			<div
				class="join_sub"><?php echo str_replace( '#COUNT', number_format( $count, 0, ',', ',' ) . ' ' . declension( $count, array(
						'человеку',
						'людей',
						'людям'
					) ), $descr ); ?>
			</div>
			<div class="widget">
				<div class="subs">
					<form action="<?php echo $link; ?>" method="post">
						<span class="sub_head">Email рассылка</span>
						<input class="inp_sub" type="email" name="MERGE0" placeholder="Ваш email">
						<span class="text_sub">Можете отписаться в любое время</span>
						<button type="submit">Подписаться</button>
					</form>
				</div>
			</div>
		<?php
		}

		/**
		 * update function.
		 *
		 * @see    WP_Widget->update
		 * @access public
		 *
		 * @param array $new_instance
		 * @param array $old_instance
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {

			$instance               = $old_instance;
			$instance['title']      = strip_tags( $new_instance['title'] );
			$instance['link']       = $new_instance['link'];
			$instance['descr']      = $new_instance['descr'];
			$instance['only_admin'] = $new_instance['only_admin'];

			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset( $alloptions['widget_subscription'] ) ) {
				delete_option( 'widget_subscription' );
			}

			return $instance;
		}

		/**
		 * flush_widget_cache function.
		 *
		 * @access public
		 * @return void
		 */
		function flush_widget_cache() {

			wp_cache_delete( 'widget_subscription', 'widget' );
		}

		/**
		 * form function.
		 *
		 * @see    WP_Widget->form
		 * @access public
		 *
		 * @param array $instance
		 *
		 * @return void
		 */
		function form( $instance ) {

			$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Подписаться на новости';
			$link       = isset( $instance['link'] ) ? $instance['link'] : 'http://ain.us1.list-manage1.com/subscribe/post?u=fc9c889691f02cbcfcc5843c5&id=379ab22b67';
			$descr      = isset( $instance['descr'] ) ? esc_attr( $instance['descr'] ) : 'Присоединяйтесь к более чем #COUNT других людей, которые получают наши новости по электронной почте!';
			$only_admin = isset( $instance['only_admin'] ) ? esc_attr( $instance['only_admin'] ) : 0;
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				       value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'link' ); ?>">Ссылка для формы отправки</label>
				<textarea style="min-height: 148px;" class="widefat"
				          id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
				          name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>"
					><?php echo esc_attr( $link ); ?></textarea></p>

			<p><label for="<?php echo $this->get_field_id( 'descr' ); ?>">Текст в форме</label>
				<textarea style="min-height: 148px;" class="widefat"
				          id="<?php echo esc_attr( $this->get_field_id( 'descr' ) ); ?>"
				          name="<?php echo esc_attr( $this->get_field_name( 'descr' ) ); ?>"
					><?php echo esc_attr( $descr ); ?></textarea>
				Теги: #COUNT - кол-во подписчиков
			</p>
			<p>
				<label
					for="<?php echo $this->get_field_id( 'only_admin' ); ?>"><?php echo __( 'Показать только Администратору' ) ?></label>
				<input class="widefat" type="checkbox" id="<?php echo $this->get_field_id( 'only_admin' ); ?>"
				       name="<?php echo $this->get_field_name( 'only_admin' ); ?>"
				       value="1"
					<?php checked( $only_admin, 1 ); ?> >
			</p>
		<?php
		}
	}
