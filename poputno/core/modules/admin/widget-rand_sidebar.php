<?php
add_action( 'widgets_init', 'uni_rand_sidebar_widget' );

function uni_rand_sidebar_widget() {
	register_widget( 'rand_sidebar_widget' );
}

class rand_sidebar_widget extends WP_Widget {

	
	function rand_sidebar_widget() {

		$widget_ops = array( 'classname' => 'rand_sidebar_widget', 'description' => 'Вывод рэндомного сайдбара' );

		$this->WP_Widget( 'rand_sidebar_widget', 'Рэндомный сайдбар', $widget_ops );
	}
    //те, що наш віджет виводитиме у фронт-енд
	function widget( $args, $state ) {
		extract( $args );

        $count = $state['count'];

        $aArray = explode(',',$count);
        $sRandKey = array_rand($aArray, 1 );

		if ( ! dynamic_sidebar( 'Рэндом сайдбар ' . $aArray[$sRandKey] ) ) : ?>

        <?php endif;
	}

	//оновлюємо дані віджета
	function update( $state_new, $state_old ) {
		$state = $state_old;

        $state['count'] = $state_new['count'];

		return $state;
	}

	//форма віджета у бек-енд
	function form( $state ) {

		$defaults = array(
            'count' => '1,2,3'
        );

		$state = wp_parse_args( (array) $state, $defaults ); ?>

		<p>
			Рэндомный вывод указаных сайдбаров (номера указывайте через кому).
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php echo __('Номера рэнд. сайдбаров:') ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $state['count']; ?>" />
		</p>

	<?php
	}
}
?>