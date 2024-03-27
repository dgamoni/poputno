<?php


	function ain_brending_sidebar_init() {

		global $wpdb;
		$brending_templates = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'brending_pages_tag_slug' " );

		foreach ( $brending_templates as $item ) {
			if ( 'publish' == get_post_status( $item->post_id ) ) {
				$term_slug = get_post_meta( $item->post_id, 'brending_pages_tag_slug', true );
				$term_slug = branding_get_slug_by_name( $term_slug );
				if ( $term_slug ) {

					$term = get_term_by( 'slug', $term_slug, 'post_tag' );
					//$term = get_term($term_id, 'post_tag');

					register_sidebar( array(
						                  'name'          => 'Сайдбар брендинг-страницы тега: ' . $term->name,
						                  'id'            => 'brending_page_sidebar_' . $term_slug,
						                  'description'   => 'Сайдбар брендинг-страницы тега: ' . $term->name,
						                  'before_widget' => '<div id="%1$s" class="widget widget_list">',
						                  'after_widget'  => '</div>',
						                  'before_title'  => '<div class="widget_header"><span>',
						                  'after_title'   => '</span></div>',
					                  ) );
				}
			}
		}
	}

	add_action( 'widgets_init', 'ain_brending_sidebar_init' );