<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly

	add_action( 'widgets_init', 'banners_widget_init', 20 );
	function banners_widget_init() {

		register_widget( 'banners_widget' );
	}

	class banners_widget extends WP_Widget {

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
		function banners_widget() {

			/* Widget variable settings. */
			$this->widget_cssclass    = 'widget_banners';
			$this->widget_description = 'Для банеров без фона';
			$this->widget_idbase      = 'widget_banners';
			$this->widget_name        = 'Блок банера';

			/* Widget settings. */
			$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

			/* Create the widget. */
			$this->WP_Widget( 'banners_widget', $this->widget_name, $widget_ops );

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
			$code = $instance['code'];
			if ( is_disable_ads_paid_post() ) {
				?>
				<div class="widget_banners widget_list">
					<div class="textwidget banner_widget">
						<?php echo $code; ?>
					</div>
				</div>
			<?php
			}
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

			$instance         = $old_instance;
			$instance['code'] = $new_instance['code'];

			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset( $alloptions['widget_banners'] ) ) {
				delete_option( 'widget_banners' );
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

			wp_cache_delete( 'widget_banners', 'widget' );
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

			$code = $instance['code'];
			?>
			<p><label for="<?php echo $this->get_field_id( 'code' ); ?>">Код банера</label>
				<textarea style="height: 200px;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"
				          name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>"
					><?php echo $code; ?></textarea>
			</p>
		<?php
		}
	}
