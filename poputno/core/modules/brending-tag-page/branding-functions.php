<?php
	function branding_init() {

		if ( is_page() || is_single() ) {
			global $post, $brending_page_id, $brending_pages_tag_slug, $brending, $link_brending, $brending_pages_top_margin;


			$brending_page_id = $post->ID;

			$brending_pages_tag_slug = get_field( 'brending_pages_tag_slug', $brending_page_id );


			//Ищем по имени тега его слаг,так как вводится может
			// как слаг брендинга так и имя
			$brending_pages_tag_slug = branding_get_slug_by_name( $brending_pages_tag_slug );

			if ( isset( $_GET['debug'] ) ) {
				//				echo $brending_pages_tag_slug;
			}


			if ( ! $brending_pages_tag_slug && is_single() ) {
				//echo '<div style="display: none;">';
				global $wpdb;
				// Теги на странице поста
				$terms_single = get_the_terms( $brending_page_id, 'post_tag' );


				$tags                     = array();
				$pages_template_brandings = array();
				if ( isset( $_GET['debug'] ) ) {
					//					echo $brending_pages_tag_slug;
				}

				if ( is_array( $terms_single ) ) {
					foreach ( $terms_single as $tag_single ) {

						//Ищем по слагу
						$brending_page = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'brending_pages_tag_slug' AND meta_value = '$tag_single->slug'" );

						// Если не нашли по слагу ищем по имени
						if ( count( $brending_page ) == 0 ) {
							$tag_single_name = branding_get_name_by_slug( $tag_single->slug );

							$brending_page = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'brending_pages_tag_slug' AND meta_value = '$tag_single_name'" );
						}


						if ( $brending_page ) {
							if ( isset( $_GET['debug'] ) ) {
								//								print_r( $brending_page );
							}

							$post_metas[] = $brending_page;
							foreach ( $brending_page as $page_templ ) {
								$publish_post = get_post( $page_templ->post_id );
								if ( $publish_post->post_status == 'publish' ) {
									$posts_ids[]                                   = $publish_post->ID;
									$pages_template_brandings[ $tag_single->slug ] = $publish_post->ID;
									//Добавляем вес тега если тегов брендированных несколько
									$weight_tags[ $tag_single->term_id ] = $tag_single->slug;
								}
							}
						}
					}
					if ( isset( $_GET['debug'] ) ) {
//						print_r( $pages_template_brandings );
					}

				}
				if ( is_array( $weight_tags ) ) {

					if ( isset( $_GET['debug'] ) ) {
						//						print_r( $weight_tags );
					}

					// Сортируем теги по весу от большего к меньшему
					krsort( $weight_tags );
					// Извлекаем самый весомый тег
					$tag_slug = array_shift( $weight_tags );

					if ( isset( $_GET['debug'] ) ) {
						//						print_r( $pages_template_brandings );
					}


					//print_r($tag_slug);
					$brending_pages_tag_slug = $tag_slug;
					$brending_page_id        = $pages_template_brandings[ $tag_slug ];
					if ( isset( $_GET['debug'] ) ) {

						//						print_r( $posts_ids );
						//						echo $brending_page_id;
						//						echo get_field('brending_pages_background_image', $brending_page_id);
					}
					//echo '</div>';
				}
			}

			if ( $brending_pages_tag_slug ) {

				$is_branding               = true;
				$brending_pages_top_margin = get_field( 'brending_pages_top_margin', $brending_page_id );

				$brending                        = 'style="';
				$brending_pages_background_color = get_field( 'brending_pages_background_color', $brending_page_id );
				$brending_pages_background_image = get_field( 'brending_pages_background_image', $brending_page_id );
				if ( $brending_pages_background_color ) {
					$brending .= 'background: ' . $brending_pages_background_color . ' url(' . $brending_pages_background_image . ');';
				} else {
					$brending .= 'background-image: url(' . $brending_pages_background_image . ');';
				}
				if ( get_field( 'brending_pages_background_fixed', $brending_page_id ) ) {
					$brending .= 'background-attachment: fixed;';
				}
				$brending .= 'background-position: 50% 0%;
    background-repeat: no-repeat no-repeat;
    " id="brand_header"
    ';
				$brending_pages_link = get_field( 'brending_pages_link', $brending_page_id );
				if ( $brending_pages_link ) {
					$brending_pages_link_height = get_field( 'brending_pages_link_height', $brending_page_id );
					if ( $brending_pages_link_height ) {
						$height_link = $brending_pages_link_height . 'px';
					} else {
						$height_link = "100%";
					}
					$link_brending = '
    <a href="' . $brending_pages_link . '" target="_blank" style="position: fixed; top: 0px; left: 0px; width: 100%; height: ' . $height_link . ';">&nbsp;</a>
    ';

				}
			}
		}
	}

	//Ищем по имени тега его слаг,так как вводится может
	// как слаг брендинга так и имя

	function branding_get_slug_by_name( $brending_pages_tag_slug ) {

		$term_brending = get_term_by( 'name', trim( $brending_pages_tag_slug ), 'post_tag' );

		$brending_pages_tag_slug = ! is_wp_error( $term_brending ) && $term_brending ? $term_brending->slug : $brending_pages_tag_slug;

		return $brending_pages_tag_slug;
	}

	function branding_get_name_by_slug( $brending_pages_tag_slug ) {

		$term_brending = get_term_by( 'slug', trim( $brending_pages_tag_slug ), 'post_tag' );

		$brending_pages_tag_slug = ! is_wp_error( $term_brending ) && $term_brending ? $term_brending->name : $brending_pages_tag_slug;

		return $brending_pages_tag_slug;
	}
