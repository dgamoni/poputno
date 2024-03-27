<?php

	global $exclude_posts_for_main_query;


	/* Получаем SRC тамбнейла */
	function get_the_post_thumbnail_src( $img ) {

		return ( preg_match( '~\bsrc="([^"]++)"~', $img, $matches ) ) ? $matches[1] : '';
	}

	/* Функция для идентификации картинки */
	function get_attachment_id_from_src( $image_src ) {

		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id    = $wpdb->get_var( $query );

		return $id;
	}

	// ловим урл первой картинки из поста
	function catch_that_image() {

		global $post, $posts;


		$img_arr   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb_facebook' );
		$first_img = $img_arr[0];

		if ( empty( $first_img ) ) {

			$first_img = '';
			ob_start();
			ob_end_clean();
			$output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
			$first_img = $matches [1] [0];

			// если ее нет — выводим лого
			if ( empty( $first_img ) ) {
				$first_img = "http://ain.ua/images/logo.png";
			}
		}

		return $first_img;
	}

	// ловим урл первой картинки из поста (без альтернативы ввиде лого)
	function catch_that_image_loop( $post_id = 0 ) {

		global $post, $posts;

		if ( $post_id ) {
			$post = get_post( $post_id );
		}

		$first_img = '';
		ob_start();
		ob_end_clean();
		$output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		$first_img = $matches [1] [0];

		return $first_img;
	}

	//
	// GET AUTHOR METADATA FOR SINGLE PAGE TEMPLATE
	function author_single_meta() {

		$authorID     = get_the_author_meta( 'ID' );
		$display_name = get_the_author_meta( 'display_name', $authorID );
		$avatar       = get_avatar( $authorID, 80, '', $display_name );

		$nickname    = get_the_author_meta( 'nickname', $authorID );
		$login       = get_the_author_meta( 'user_login', $authorID );
		$description = get_the_author_meta( 'description', $authorID );
		$url         = get_the_author_meta( 'user_url', $authorID );
		$twitter     = get_the_author_meta( 'aim', $authorID );
		$facebook    = get_the_author_meta( 'yim', $authorID );

		echo '<div class="authorsblock">';
		if ( is_single() ) {
			echo '<script type="text/javascript" src="/orphus/orphus.js"></script><noindex><a rel="nofollow" href="http://orphus.ru" id="orphus" target="_blank">Заметили ошибку? Выделите ее и нажмите Ctrl+Enter, чтобы сообщить нам.</a></noindex>';
		}
		//echo '<a class="fl" href="' . get_author_posts_url( $authorID ) . '">' . $avatar . '</a>';
		echo '<big><a rel="author" href="' . get_author_posts_url( $authorID ) . '">' . $display_name . '</a></big>';
		echo '</div>';
		echo '<div class="clear"></div>';
	}


	//полный текст для рсс
	function uni_special_rss() {

		global $post, $posts, $more, $feed;
		$more = 0;
		$text = $post->post_content;
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( '\]\]\>', ']]&gt;', $text );
		$text = preg_replace( '@<script[^>]*?>.*?</script>@si', '', $text );
		$text = strip_tags( $text, '<p><a><li><ul><strong><b>' );

		return $text;
	}

	//добавляем медиа атачменты к яндекс ленте
	function all_attach_for_feed( $postid = 0 ) {

		if ( $postid < 1 ) {
			$postid = get_the_ID();
		}
		if ( $attaches = get_children( array(
			                               'post_parent'    => $postid,
			                               'post_type'      => 'attachment',
			                               'numberposts'    => - 1,
			                               'post_mime_type' => array( 'image', 'audio', 'video' ),
		                               ) )
		) {
			foreach ( $attaches as $attach ) {
				$attachment_link = wp_get_attachment_url( $attach->ID );
				$attach_mime     = wp_check_filetype( $attachment_link );
				?>
				<enclosure url="<?php echo $attachment_link; ?>" type="<?php echo $attach_mime[ type ]; ?>" /><?php
			}
		}
	}


	function month_full_name_ru( $m ) {

		$month = array(
			"1"  => "Января",
			"2"  => "Февраля",
			"3"  => "Марта",
			"4"  => "апреля",
			"5"  => "Мая",
			"6"  => "Июня",
			"7"  => "Июля",
			"8"  => "Августа",
			"9"  => "Сентября",
			"10" => "Октября",
			"11" => "Ноября",
			"12" => "Декабря"
		);

		return strtr( $m, $month );
	}

	function month_short_name_ru( $m ) {

		$month = array(
			"1"  => "янв",
			"2"  => "фев",
			"3"  => "мар",
			"4"  => "апр",
			"5"  => "мая",
			"6"  => "июня",
			"7"  => "июля",
			"8"  => "авг",
			"9"  => "сен",
			"10" => "окт",
			"11" => "ноя",
			"12" => "дек"
		);

		return strtr( $m, $month );
	}

	function date_to_short_ru( $date ) {

		$month = array(
			"1"  => "янв",
			"2"  => "фев",
			"3"  => "мар",
			"4"  => "апр",
			"5"  => "мая",
			"6"  => "июня",
			"7"  => "июля",
			"8"  => "авг",
			"9"  => "сен",
			"10" => "окт",
			"11" => "ноя",
			"12" => "дек"
		);
		$days  = array(
			"monday"    => "Понедельник",
			"tuesday"   => "Вторник",
			"wednesday" => "Среда",
			"thursday"  => "Четверг",
			"friday"    => "Пятница",
			"saturday"  => "Суббота",
			"sunday"    => "Воскресенье"
		);

		return str_replace( array_merge( array_keys( $month ), array_keys( $days ) ), array_merge( $month, $days ), strtolower( $date ) );
	}

	function ain_posts_nav() {

		$adjacent_post = get_adjacent_post( false, '', true );
		$prev_post_id  = $adjacent_post->ID;
		$adjacent_post = get_adjacent_post( false, '', false );
		$next_post_id  = $adjacent_post->ID;
		?>

		<section class="float-posts-nav" id="float-posts-nav">
			<?php if ( $prev_post_id ) { ?>
				<div class="postNavigation prevPostBox "
				     style="position: fixed; top: 50%; margin-top: -52px; left: 0px; display: block;">
					<a href="<?php echo get_permalink( $prev_post_id ); ?>"></a>
					<span class="nPostTitle prev"><?php echo get_the_title( $prev_post_id ); ?></span>
				</div>
			<?php } ?>
			<?php if ( $next_post_id ) { ?>
				<div class="postNavigation nextPostBox"
				     style="position: fixed; top: 50%; margin-top: -52px; right: 0px; display: block;">

					<span class="nPostTitle next"><?php echo get_the_title( $next_post_id ); ?></span>
					<a href="<?php echo get_permalink( $next_post_id ); ?>"></a>
				</div>
			<?php } ?>
		</section>
	<?php
	}


	
		function get_img_post($post_id, $size = 'ain-post')
		{

			//if (current_user_can('administrator')) {
			//    delete_post_meta($post_id, '_post_thumb_' . $size);
			//}
			if ($img_arr = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size)) {
				return $img_arr[0];
				//} elseif ($img_url = get_post_meta($post_id, '_post_thumb_' . $size, true)) {
				//    return $img_url;
			} else {
				$sizes['ain-post'] = array(300, 190);
				$sizes['fresh_latest_post'] = array(460, 250);
				$sizes['ain-related-post'] = array(180, 120);

				if ($img_url = catch_that_image_loop($post_id)) {

					//Ссылку на изображение разобьем на масив
					$img_arr = explode('/', $img_url);

					//Получим название и расширение файла
					@list($file, $ext) = explode('.', $img_arr[count($img_arr) - 1]);

					//Новый файл с нужным размеров
					$new_img_file = $file . '-' . $sizes[$size][0] . 'x' . $sizes[$size][1] . '.' . $ext;

					$file_img_src = str_replace($img_arr[0] . '/', $_SERVER['DOCUMENT_ROOT'], $img_url);

					//Файл полного изображение с контента
					$full_img_file = $img_arr[count($img_arr) - 1];

					$file_img_src = str_replace($full_img_file, $new_img_file, $file_img_src);

					if (file_exists($file_img_src)) {

						//Меняем полное изображение на нужное изображение
						$img_url = str_replace($full_img_file, $new_img_file, $img_url);

						//Сохраняем в мету для дальнейшего исользования в при выводе постов
						//update_post_meta($post_id, '_post_thumb_' . $size, $img_url);

						return $img_url;

					} else {
						return $img_url;
					}
				} else {
					return get_template_directory_uri() . "/assets/img/no_image_" . $sizes[$size][0] . "_" . $sizes[$size][1] . ".png";
				}
			}

		}
	


	function get_img_post_2( $post_id, $size = 'ain-post' ) {

		$sTransientKey = '_post_thumb_' . $size;
		//delete_transient( $sTransientKey );
		$thumb_img = get_transient( $sTransientKey );

		//Ссылку на изображение разобьем на масив
		$img_arr = explode( '/', $thumb_img );

		//		print_r( $img_arr );

		$url_site = get_bloginfo( 'url' );

		if ( preg_match( '/' . $url_site . '/', $thumb_img, $match ) ) {
			$file_img_src = str_replace( $img_arr[2] . '/', $_SERVER['DOCUMENT_ROOT'], $thumb_img );
		} else {
			$file_img_src = str_replace( $img_arr[0] . '/', $_SERVER['DOCUMENT_ROOT'], $thumb_img );

		}

		//print_r( $file_img_src );

		if ( file_exists( $file_img_src ) && $thumb_img ) {

			return $thumb_img;

		} elseif ( $img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size ) ) {
			$img = $img_arr[0];
			set_transient( $sTransientKey, $img, 60 * 60 * 24 );

			return $img;
		} else {
			if ( $img_url = catch_that_image_loop( $post_id ) ) {
				global $wpdb;
				$file_url_arr   = explode( '/', $img_url );
				$file_img       = $file_url_arr[ count( $file_url_arr ) - 1 ];
				$query          = "SELECT ID FROM {$wpdb->posts} WHERE guid LIKE '%$file_img%'";
				$content_img_id = $wpdb->get_var( $query );
				if ( $img_arr = wp_get_attachment_image_src( $content_img_id, $size ) ) {
					$img = $img_arr[0];
					set_transient( $sTransientKey, $img, 60 * 60 * 24 );

					return $img;
				} else {
					return get_no_image_by_size( $size );
				}
			} else {
				return get_no_image_by_size( $size );
			}
		}

	}


	function get_no_image_by_size( $size ) {

		$sizes['ain-post']          = array( 300, 190 );
		$sizes['fresh_latest_post'] = array( 460, 250 );
		$sizes['ain-related-post']  = array( 180, 120 );
		if ( $sizes[ $size ] ) {
			return get_template_directory_uri() . "/assets/img/no_image_" . $sizes[ $size ][0] . "_" . $sizes[ $size ][1] . ".png";
		} else {
			return get_template_directory_uri() . "/assets/img/no_image_300_190.png";

		}
	}

	function rand_vac_end_event_block( $args = array() ) {

		$defaults = array(
			'vac_post_type'      => 'univac_vacancy',
			'vac_orderby'        => 'rand',
			'vac_posts_per_page' => 5,
			'ev_post_type'       => 'tribe_events',
			'ev_posts_per_page'  => 5,
		);

		$param = wp_parse_args( $args, $defaults );

		?>

		<div class="new_grey_posts_wrapper">
			<div class="job_list">

				<h4>Работа</h4>
				<ul>
					<?php

						$args          = array(
							'post_type'      => 'univac_vacancy',
							'orderby'        => 'rand',
							'posts_per_page' => 30
						);
						$i             = 0;
						$randvac_query = new WP_Query( $args );
						$post_in       = array();
						while ( $randvac_query->have_posts() ) : $randvac_query->the_post();

							$post   = $randvac_query->post;
							$images = get_children( array(
								                        'post_parent'    => $post->ID,
								                        'post_type'      => 'attachment',
								                        'post_mime_type' => 'image',
								                        'orderby'        => 'menu_order',
								                        'order'          => 'ASC',
								                        'numberposts'    => 1
							                        ) );
							if ( $images ) {
								$i ++;
								$post_in[] = get_the_ID();
							}
							if ( $i == 30 ) {
								break;
							}
						endwhile;

						wp_reset_postdata();


						$args          = array(
							'post_type'      => 'univac_vacancy',
							'post__in'       => $post_in,
							'posts_per_page' => 4
						);
						$randvac_query = new WP_Query( $args );

						$i = 0;

						while ( $randvac_query->have_posts() ) : $randvac_query->the_post();
							$is_img = false;
							$post   = $randvac_query->post;
							$images = get_children( array(
								                        'post_parent'    => $post->ID,
								                        'post_type'      => 'attachment',
								                        'post_mime_type' => 'image',
								                        'orderby'        => 'menu_order',
								                        'order'          => 'ASC',
								                        'numberposts'    => 1
							                        ) );
							$sImage = '';
							if ( $images ) {
								$i ++;
								$is_img = true;
								foreach ( $images as $image ) {
									$image_src = wp_get_attachment_image_src( $image->ID, 'univac-randlogo' );
									$sImage    = '<span class="vacc_logo"><img src="' . $image_src[0] . '" alt="' . get_post_meta( $post->ID, 'univac_company_name', true ) . '" /></span>';
								}
							}
							$terms = get_the_terms( $post->ID, 'univac_cat' );
							if ( $terms && ! is_wp_error( $terms ) ) :
								$works_links = array();
								foreach ( $terms as $term ) {
									$sTermName = $term->name;
									$sTermID   = $term->term_id;
								}
							endif;
							?>
							<li>
								<a href="<?php echo get_permalink(); ?>">
									<?php
										if ( $sImage ) {
											echo $sImage;
										} else {
											echo '<div class="job_list_no_img">&nbsp;</div>';
										}
									?>
									<strong><?php echo get_the_title(); ?></strong>
									<span><?php echo get_post_meta( get_the_ID(), 'univac_company_name', true ); ?></span>
								</a>
							</li>
						<?php
						endwhile;
					?>
				</ul>
				<a href="<?php bloginfo( 'url' ); ?>/jobs" class="all_jobs">Все вакансии</a>

			</div>
			<?php

				wp_reset_postdata();

			?>

			<div class="new_ad_300x400">
			<span class="new_adv_box">
				<?php //echo get_field('works_and_events_adv', 'options'); ?>

				<!-- Premium_300x4000 -->
                <div id='div-gpt-ad-1391146793695-0' style='height: 400px;'>
	                <script type='text/javascript'>
		                googletag.cmd.push(function () {
			                googletag.display('div-gpt-ad-1391146793695-0');
		                });
	                </script>
                </div>

			</span>
			</div>


			<div class="event_list">
				<h4>События</h4>
				<ul>
					<?php
						$args = array(
							'post_type'      => 'tribe_events',
							'posts_per_page' => 4,
						);

						$recent_events_query = new WP_Query( $args );

						while ( $recent_events_query->have_posts() ) : $recent_events_query->the_post();
							$post           = $recent_events_query->post;
							$sUnixStartTime = strtotime( get_post_meta( $post->ID, '_EventStartDate', true ) );
							$sStartDay      = date( 'd', $sUnixStartTime );
							$sStartDate     = date( 'm', $sUnixStartTime );
							?>
							<li>
								<a href="<?php echo get_permalink(); ?>">
									<time datetime="<?php echo date( 'd-m-Y ', $sUnixStartTime ); ?>">
										<span><?php echo $sStartDay; ?></span>.<?php echo $sStartDate; ?>
									</time>
									<strong><?php echo get_the_title(); ?></strong>
								</a>
							</li>
						<?php
						endwhile;
						wp_reset_postdata();

					?>
				</ul>
				<a href="<?php bloginfo( 'url' ); ?>/events" class="all_events">Все события</a>
			</div>
		</div>
	<?php

	}

	if ( ! function_exists( 'ajax_pagination' ) ) {
		function ajax_pagination(
			$custom_query = false,
			$inner_class = '',
			$posts_per_page = 0,
			$ajax_action = 'pagination_vacancy',
			$post_type = 'post',
			$exclude_posts = array()
		) {

			global $paged, $post, $wp_query;

			if ( empty( $paged ) ) {
				$paged = 1;
			}

			if ( $custom_query ) {
				$wp_query = $custom_query;
			} else {
				global $wp_query;
			}

			$tax = isset( $wp_query->tax_query->queries[0]['taxonomy'] ) ? $wp_query->tax_query->queries[0]['taxonomy'] : null;
			if ( $tax != null ) {
				$taxonomy = get_taxonomy( $tax );
			}

			if ( $wp_query->max_num_pages > 1 ):
				?>
				<div class="show_more_post"
				     data-post-type="<?php echo $post_type; ?>"
				     data-author-id="<?php if ( is_author() ) {
					     echo get_the_author_meta( 'ID' );
				     } ?>"
				     data-action="<?php echo $ajax_action; ?>"
				     data-posts-per-page="<?php echo $posts_per_page; ?>"
				     data-inner-class="<?php echo $inner_class; ?>"
				     data-taxonomy-name="<?php echo isset( $taxonomy->name ) ? $taxonomy->name : ''; ?>"
				     data-taxonomy-term="<?php echo isset( $wp_query->tax_query->queries[0]['terms'] ) && ! is_home() ? implode( ',', $wp_query->tax_query->queries[0]['terms'] ) : ''; ?>"
				     data-search-string="<?php echo htmlspecialchars( get_query_var( 's' ) ); ?>"
				     data-max-pages="<?php echo $wp_query->max_num_pages; ?>"
				     data-current-page="<?php echo $paged; ?>"
				     data-exclude-posts="<?php echo implode( ',', $exclude_posts ); ?>"
				     data-next-page="<?php echo $paged + 1; ?>">
					<a href="#">Загрузить еще</a>
				</div>
			<?php
			endif;
		}
	}


	if ( ! function_exists( 'ajax_pagination_v2' ) ) {
		function ajax_pagination_v2( $custom_query = false, $args = array() ) {

			global $paged, $post, $wp_query;

			$defaults = array(
				'exclude_posts'  => array(),
				'inner_class'    => '',
				'posts_per_page' => 0,
				'ajax_action'    => '',
				'post_type'      => 'post',
				'author'         => 0
			);

			$args = wp_parse_args( $args, $defaults );


			if ( empty( $paged ) ) {
				$paged = 1;
			}

			if ( $custom_query ) {
				$wp_query = $custom_query;
			} else {
				global $wp_query;
			}

			$tax = isset( $wp_query->tax_query->queries[0]['taxonomy'] ) ? $wp_query->tax_query->queries[0]['taxonomy'] : null;
			if ( $tax != null ) {
				$taxonomy = get_taxonomy( $tax );
			}

			if ( $wp_query->max_num_pages > 1 ):
				?>
				<div class="show_more_post"
				     data-post-type="<?php echo $args['post_type']; ?>"
				     data-author-id="<?php echo $args['author']; ?>"
				     data-action="<?php echo $args['ajax_action']; ?>"
				     data-posts-per-page="<?php echo $args['posts_per_page']; ?>"
				     data-inner-class="<?php echo $args['inner_class']; ?>"
				     data-taxonomy-name="<?php echo isset( $taxonomy->name ) ? $taxonomy->name : ''; ?>"
				     data-taxonomy-term="<?php echo isset( $wp_query->tax_query->queries[0]['terms'] ) && ! is_home() ? implode( ',', $wp_query->tax_query->queries[0]['terms'] ) : ''; ?>"
				     data-search-string="<?php echo htmlspecialchars( get_query_var( 's' ) ); ?>"
				     data-max-pages="<?php echo $wp_query->max_num_pages; ?>"
				     data-current-page="<?php echo $paged; ?>"
				     data-exclude-posts="<?php echo implode( ',', $args['exclude_posts'] ); ?>"
				     data-next-page="<?php echo $paged + 1; ?>">
					<a href="#">Загрузить еще</a>
				</div>
			<?php
			endif;
		}
	}

	function get_soc_votes( $post_id ) {

		global $wpdb;

		$res['fb']   = 0;
		$res['tw']   = 0;
		$res['vk']   = 0;
		$res['gp']   = 0;
		$res['view'] = 0;
		$res['sum']  = 0;

		$soc     = false;
		$de_data = false;

		//		if ( isset( $wpdb->de_statistics ) ) {
		//			$de_data = $wpdb->get_row( "SELECT * FROM $wpdb->de_statistics WHERE post_id = $post_id" );
		//		} else {
		$view = $wpdb->get_row( "SELECT * FROM pr_stats WHERE PostId = $post_id " );
		$soc  = $wpdb->get_row( "SELECT * FROM social_rank WHERE page_id = $post_id " );
		//		}

		$comments = $wpdb->get_row( "SELECT COUNT(*) as comment_counts FROM $wpdb->comments WHERE comment_post_ID = $post_id" );
		//		$res['cn'] = get_comments_number( $post_id );
		$res['cn'] = $comments->comment_counts;
		//$res['cn'] = get_comments(array('comment_post_ID' => $post_id, 'count' => true));

		if ( $soc && is_object( $soc ) ) {
			$res['fb']  = $soc->page_fb_votes;
			$res['tw']  = $soc->page_tw_votes;
			$res['vk']  = $soc->page_vk_votes;
			$res['gp']  = $soc->page_gp_votes;
			$res['sum'] = $soc->page_fb_votes + $soc->page_tw_votes + $soc->page_vk_votes + $res['cn'];
		}

		//else if ( $de_data && is_object( $de_data ) ) {
		//			$res['fb']   = $de_data->fb_counts;
		//			$res['tw']   = $de_data->tw_counts;
		//			$res['vk']   = $de_data->vk_counts;
		//			$res['gp']   = $de_data->gplus_counts;
		//			$res['view'] = $de_data->views_counts;
		//
		//			$res['sum'] = $de_data->fb_counts + $de_data->tw_counts + $de_data->vk_counts + $res['cn'];
		//}

		if ( $view && is_object( $view ) ) {
			$res['view'] = $view->Views;
		}

		//print_r($votes);
		return $res;
	}

	function content_soc_likes() {

		global $wpdb, $post;

		$fb = 0;
		$tw = 0;
		$vk = 0;

		if ( $votes = $wpdb->get_row( "SELECT * FROM social_rank WHERE page_id = $post->ID " ) ) {

			if ( $votes->page_fb_votes >= 1000 ) {
				$fb = round( $votes->page_fb_votes / 1000, 1 ) . 'k';
			} else {
				$fb = $votes->page_fb_votes;
			}

			if ( $votes->page_tw_votes >= 1000 ) {
				$tw = round( $votes->page_tw_votes / 1000, 1 ) . 'k';
			} else {
				$tw = $votes->page_tw_votes;
			}

			if ( $votes->page_vk_votes >= 1000 ) {
				$vk = round( $votes->page_vk_votes / 1000, 1 ) . 'k';
			} else {
				$vk = $votes->page_vk_votes;
			}
		}


		$title   = urlencode( clear_special_sumbols( get_the_title( $post->ID ) ) );
		$url     = urlencode( get_permalink( $post->ID ) );
		$summary = urlencode( clear_special_sumbols( get_the_excerpt( $post->ID ) ) );
		//$image = urlencode(get_thumbnail_img_post($post->ID));
		$image = urlencode( get_img_post( get_the_ID(), $size = 'ain-post' ) );
		if ( empty( $image ) ) {
			$image = urlencode( "http://ain.ua/images/logo.png" );
		}

		?>
		<div class="">
			<div class="facebook soc"
			     onclick="ain_window('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[summary]=<?php echo $summary; ?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image; ?>','Поделиться на Фейсбуке'); return false;"
			     title="Поделиться ссылкой на Фейсбуке">
				<div class="top-soc"><i class="icon-facebook"></i></div>
				<div class="bot-soc">
					<?php echo $fb; ?>
				</div>
			</div>
			<div class="twitter soc"
			     onclick="ain_window('https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php the_permalink(); ?>','Поделиться в Твиттере'); return false;"
			     title="Поделиться ссылкой в Твиттере">
				<div class="top-soc"><i class="icon-twitter"></i></div>
				<div class="bot-soc">
					<?php echo $tw; ?>
				</div>
			</div>
			<div class="vkontakte soc"
			     onclick="ain_window('http://vkontakte.ru/share.php?url=<?php echo get_permalink( $post->ID ); ?>','Поделиться во Вконтакте'); return false;"
			     title="Поделиться ссылкой во Вконтакте">
				<div class="top-soc"><i class="icon-vkontakte"></i></div>
				<div class="bot-soc">
					<?php echo $vk; ?>
				</div>
			</div>

			<div class="pocket soc"
			     onclick="ain_window('https://getpocket.com/edit?url=<?php echo get_permalink( $post->ID ); ?>','Добавить в Pocket'); return false;"
			     title="Добавить в Pocket">
				<div class="top-soc"><i class="icon-pocket"></i></div>
				<div class="bot-soc">
					<?php echo pocket_readers_count(); ?>
				</div>
			</div>

<!-- 						<div class="b-share b-share_type_pocket">
				<div class="b-share__button"
				     onclick="ain_window('https://getpocket.com/edit?url=<?php echo get_permalink( $post->ID ); ?>','Добавить в Pocket'); return false;"
					><i class="icon-pocket"></i>
					<hc id="hc_select_index13" class="hc_select_index"></hc>
					Pocket
				</div>
				<div class="b-share__counter">
            <span class="count"><hc id="hc_select_index14"
                                    class="hc_select_index"></hc><?php echo pocket_readers_count(); ?></span>

					<div class="b-share__counter__triangle"></div>
				</div>
			</div> -->


		</div>
	<?php
	}


	function get_vacancy_cat_color( $term_id ) {

		$colors = array(
			'2872' => 'blue',
			'2870' => 'red',
			'2868' => 'orange',
			'2943' => 'green',
			'2871' => 'yellow'
		);

		return strtr( $term_id, $colors );
	}


	function custom_soc_login() {

		// HOOKABLE:
		do_action( 'wsl_render_login_form_start' );

		GLOBAL $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;

		if ( empty( $social_icon_set ) ) {
			$social_icon_set = "wpzoom/";
		} else {
			$social_icon_set .= "/";
		}

		$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/32x32/' . $social_icon_set;

		// HOOKABLE: allow use of other icon sets
		$assets_base_url = apply_filters( 'wsl_later_hook_assets_base_url', $assets_base_url );

		$wsl_settings_connect_with_label = get_option( 'wsl_settings_connect_with_label' );

		$current_page_url = 'http';
		if ( isset( $_SERVER["HTTPS"] ) && ( $_SERVER["HTTPS"] == "on" ) ) {
			$current_page_url .= "s";
		}
		$current_page_url .= "://";
		if ( $_SERVER["SERVER_PORT"] != "80" ) {
			$current_page_url .= $_SERVER["HTTP_HOST"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$current_page_url .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		}

		$authenticate_base_url = site_url( 'wp-login.php', 'login_post' ) . ( strpos( site_url( 'wp-login.php', 'login_post' ), '?' ) ? '&' : '?' ) . "action=wordpress_social_authenticate&";

		// overwrite endpoint_url if need'd
		if ( get_option( 'wsl_settings_hide_wp_login' ) == 1 ) {
			$authenticate_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . "/services/authenticate.php?";
		}
		?>

		<div class="soc">
			<?php
				$nok = true;

				// display provider icons
				foreach ( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG AS $item ) {
					$provider_id   = @ $item["provider_id"];
					$provider_name = @ $item["provider_name"];

					$authenticate_url = $authenticate_base_url . "provider=" . $provider_id . "&redirect_to=" . urlencode( $current_page_url );

					if ( get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) {
						// HOOKABLE: allow use of other icon sets
						$provider_icon_markup = apply_filters( 'wsl_alter_hook_provider_icon_markup', $provider_id );

						$wsl_settings_use_popup = get_option( 'wsl_settings_use_popup' );

						if ( $provider_icon_markup != $provider_id ) {
							echo $provider_icon_markup;
						} elseif ( $wsl_settings_use_popup == 1 ) {
							?>
							<a rel="nofollow" href="javascript:void(0);" title="Connect with <?php echo $provider_name ?>"
							   class="wsl_connect_with_provider" data-provider="<?php echo $provider_id ?>">
								<?php if ( $provider_id == 'google' ) { ?>
									<span class="gp"></span>
								<?php } elseif ( $provider_id == 'facebook' ) { ?>
									<span class="fb"></span>
								<?php } else { ?>
									<img alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>"
									     src="<?php echo $assets_base_url . strtolower( $provider_id ) . '.png' ?>" />
								<?php } ?>
							</a>
						<?php
						} elseif ( $wsl_settings_use_popup == 2 ) {
							?>
							<a rel="nofollow" href="<?php echo esc_url( $authenticate_url ) ?>"
							   title="Connect with <?php echo $provider_name ?>" class="wsl_connect_with_provider">
								<?php if ( $provider_id == 'google' ) { ?>
									<span class="gp"></span>
								<?php } elseif ( $provider_id == 'facebook' ) { ?>
									<span class="fb"></span>
								<?php } else { ?>
									<img alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>"
									     src="<?php echo $assets_base_url . strtolower( $provider_id ) . '.png' ?>" />
								<?php } ?>
							</a>
						<?php
						}

						$nok = false;
					}
				}

				if ( $nok ) {
					?>
					<p style="background-color: #FFFFE0;border:1px solid #E6DB55;padding:5px;">
						<?php _wsl_e( '<strong style="color:red;">WordPress Social Login is not configured yet!</strong><br />Please visit the <strong>Settings\ WP Social Login</strong> administration page to configure this plugin.<br />For more information please refer to the plugin <a href="http://hybridauth.sourceforge.net/userguide/Plugin_WordPress_Social_Login.html">online user guide</a> or contact us at <a href="http://hybridauth.sourceforge.net/">hybridauth.sourceforge.net</a>', 'wordpress-social-login' ) ?>
					</p>
					<style>
						#wp-social-login-connect-with {
							display: none;
						}
					</style>
				<?php
				}

				// provide popup url for hybridauth callback
				if ( get_option( 'wsl_settings_use_popup' ) == 1 ) {
					?>
					<input id="wsl_popup_base_url" type="hidden" value="<?php echo esc_url( $authenticate_base_url ) ?>" />
					<input type="hidden" id="wsl_login_form_uri"
					       value="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" />
				<?php
				}
			?>
		</div>
		<!-- /wsl_render_login_form -->
		<?php

		// HOOKABLE:
		do_action( 'wsl_render_login_form_end' );
	}


	function footer_soc_likes() {

		global $wpdb, $post;

		$fb = 0;
		$tw = 0;
		$vk = 0;
		$gp = 0;

		if ( $votes = $wpdb->get_row( "SELECT * FROM social_rank WHERE page_id = $post->ID " ) ) {

			if ( $votes->page_fb_votes >= 1000 ) {
				$fb = round( $votes->page_fb_votes / 1000, 1 ) . 'k';
			} else {
				$fb = $votes->page_fb_votes;
			}

			if ( $votes->page_tw_votes >= 1000 ) {
				$tw = round( $votes->page_tw_votes / 1000, 1 ) . 'k';
			} else {
				$tw = $votes->page_tw_votes;
			}

			if ( $votes->page_vk_votes >= 1000 ) {
				$vk = round( $votes->page_vk_votes / 1000, 1 ) . 'k';
			} else {
				$vk = $votes->page_vk_votes;
			}

			if ( $votes->page_gp_votes >= 1000 ) {
				$gp = round( $votes->page_gp_votes / 1000, 1 ) . 'k';
			} else {
				$gp = $votes->page_gp_votes;
			}

		}
		$post_type = get_post_type( $post->ID );

		$title   = urlencode( clear_special_sumbols( get_the_title( $post->ID ) ) );
		$url     = urlencode( get_permalink( $post->ID ) );
		$summary = urlencode( clear_special_sumbols( get_the_excerpt( $post->ID ) ) );


		if ( $image_url = get_img_post( $post->ID, 'facabook_thumb_200_200' ) ) {
			$image = urlencode( $image_url );
		} else {
			$image = "http://ain.ua/images/logo.png";
		}
		?>
		<div class="b-share b-share_type_facebook">
			<div class="b-share__button"
			     onclick="ain_window('http://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[summary]=<?php echo $summary; ?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image; ?>','Поделиться на Фейсбуке'); return false;"
				><i class="icon-facebook"></i>
				<hc id="hc_select_index9" class="hc_select_index"></hc>
				Лайк
			</div>
			<div class="b-share__counter">
				<span class="count"><hc id="hc_select_index10" class="hc_select_index"></hc><?php echo $fb; ?></span>

				<div class="b-share__counter__triangle"></div>
			</div>
		</div>
		<?php
		/*
		$counts = count_chars(get_the_title());
		$total = 0;

		// Count ASCII bytes
		for ($i = 0; $i < 0x80; $i++) {
			$total += $counts[$i];
		}

		// Count multibyte sequence heads
		for ($i = 0xc0; $i < 0xff; $i++) {
			$total += $counts[$i];
		}
		if ($total > 137) {
			$twitt_text = mb_substr(get_the_title(), 0, 137, 'UTF-8') . ' ...';
		} else {

		}*/
		$twitt_text = get_the_title();
		/*  $twitt_text_arr = explode(' ', substr(get_the_title(), 0, 200));
		  $twitt_text_arr[count($twitt_text_arr) - 1] = '';
		  $twitt_text = implode(' ', $twitt_text_arr);
	  */
		?>
		<div class="b-share b-share_type_twitter">
			<div class="b-share__button"
			     onclick="ain_window('https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php the_permalink(); ?>','Поделиться в Твиттере'); return false;"
				><i class="icon-twitter"></i>
				<hc id="hc_select_index11" class="hc_select_index"></hc>
				Твит
			</div>
			<div class="b-share__counter">
				<span class="count"><hc id="hc_select_index12" class="hc_select_index"></hc><?php echo $tw; ?></span>

				<div class="b-share__counter__triangle"></div>
			</div>
		</div>

		<div class="b-share b-share_type_vkontakte">
			<div class="b-share__button"
			     onclick="ain_window('http://vkontakte.ru/share.php?url=<?php echo get_permalink( $post->ID ); ?>','Поделиться во Вконтакте'); return false;"
				><i class="icon-vkontakte"></i>
				<hc id="hc_select_index13" class="hc_select_index"></hc>
				Нравится
			</div>
			<div class="b-share__counter">
				<span class="count"><hc id="hc_select_index14" class="hc_select_index"></hc><?php echo $vk; ?></span>

				<div class="b-share__counter__triangle"></div>
			</div>
		</div>


		<?php /*
    <a data-pocket-label="pocket" data-pocket-count="horizontal" class="pocket-btn"
       data-lang="ru"></a>
    <script type="text/javascript">!function (d, i) {
            if (!d.getElementById(i)) {
                var j = d.createElement("script");
                j.id = i;
                j.src = "<?php echo CORE_URL; ?>/modules/custom_soc_buttons/custom_btn.js?v=1";
                var w = d.getElementById(i);
                d.body.appendChild(j);
            }
        }(document, "pocket-btn-js");
    </script>
<?php } */
		?>

		<?php if ( $post_type == 'post' ) { ?>

			<div class="b-share b-share_type_pocket">
				<div class="b-share__button"
				     onclick="ain_window('https://getpocket.com/edit?url=<?php echo get_permalink( $post->ID ); ?>','Добавить в Pocket'); return false;"
					><i class="icon-pocket"></i>
					<hc id="hc_select_index13" class="hc_select_index"></hc>
					Pocket
				</div>
				<div class="b-share__counter">
            <span class="count"><hc id="hc_select_index14"
                                    class="hc_select_index"></hc><?php echo pocket_readers_count(); ?></span>

					<div class="b-share__counter__triangle"></div>
				</div>
			</div>
		<?php } ?>

		<div class="b-share b-share_type_googleplus">
			<div class="b-share__button"
			     onclick="ain_window('https://plus.google.com/share?url=<?php echo get_permalink( $post->ID ); ?>','Поделиться в Google Plus'); return false;"
				><i class="icon-gplus"></i>
				<hc id="hc_select_index13" class="hc_select_index"></hc>
				+1
			</div>
			<div class="b-share__counter">
				<span class="count"><hc id="hc_select_index14" class="hc_select_index"></hc><?php echo $gp; ?></span>

				<div class="b-share__counter__triangle"></div>
			</div>
		</div>

	<?php
	}


	//social count widget logic
	function fb_followers_count( $sName ) {

		$sTransientKey = 'fb_followers_count_' . $sName;

		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {
			$aResponse = wp_remote_get( "https://graph.facebook.com/{$sName}", array( 'sslverify' => false ) );

			if ( is_wp_error( $aResponse ) ) {
				return get_option( $sTransientKey );
			} else {
				$json            = json_decode( wp_remote_retrieve_body( $aResponse ) );
				$sFollowersCount = $json->likes;

				set_transient( $sTransientKey, $sFollowersCount, 60 * 60 * 24 );
				update_option( $sTransientKey, $sFollowersCount );
				$count = $sFollowersCount;
			}

		}

		//return $sFollowersCount;

		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;

	}


	//social count widget logic
	function gp_followers_count() {

		$sTransientKey   = 'gp_followers_count';
		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {
			//'107840556917305267420', 'AIzaSyCjWXMNg6Wxh4NjSJMWwsXXRN8_cCwUGyA'
			$return = wp_remote_get( 'https://www.googleapis.com/plus/v1/people/112001508431849681214?key=AIzaSyAjGVJlAKL0DTNu89hwS0WJwtwOuuAhBHI', array(
				'sslvarify' => true
			) );
			$json   = json_decode( $return['body'] );
			$count  = $json->plusOneCount;
			set_transient( $sTransientKey, $count, 60 * 60 * 24 * 2 );
		}

		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;
	}


	//RSS count widget logic
	function rss_followers_count( $sName ) {

		$count = get_option( 'rss_followers_count' );
		$count = 3200;
		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;
	}


	//Pocket count widget logic
	function pocket_readers_count( $post_id = 0 ) {

		global $post;
		if ( ! $post_id ) {
			$post_id = $post->ID;
		}

		$sTransientKey   = 'pocket_readers_count_' . $post_id;
		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {

			$url     = get_permalink( $post_id );
			$content = wp_remote_fopen( "https://widgets.getpocket.com/v1/button?align=center&count=horizontal&label=pocket&url=$url" );
			//<em id="cnt">0</em>
			preg_match( '/<em(.*)>(.*)<\/em>/isU', $content, $match );
			//print_r($match);
			$count = (int) $match[2];
			if ( $count ) {
				set_transient( $sTransientKey, $count, 60 * 60 * 24 );
			}

		}


		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;
	}


	//social count widget logic
	function mailchimp_followers_count() {

		$sTransientKey = 'mailchimp_followers_count';

		//delete_transient( $sTransientKey );
		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {


			require_once CORE_PATH . '/includes/mailchimp/MailChimp.php';

			$apikey = 'f877e8e434d0f58154bd4066fced3d16-us1';
			$listId = '379ab22b67';

			$MailChimp = new \Drewm\MailChimp( $apikey );


			$results = $MailChimp->call( "lists/list", array(
				"filters"    => array( // optional,  filters to apply to this query - all are optional
					"list_id" => $listId,
					// optional, return a single list using a known list_id. Accepts multiples separated by commas when not using exact matching
				),
				"sort_field" => "created",
				// optional, "created" (the created date, default) or "web" (the display order in the web app). Invalid values will fall back on "created" - case insensitive.
				"sort_dir"   => "DESC"
				// optional, "DESC" for descending (default), "ASC" for Ascending. Invalid values will fall back on "created" - case insensitive. Note: to get the exact display order as the web app you'd use "web" and "ASC"
			) );
			$count   = 0;
			if ( $results['data'][0]['stats']['member_count'] ) {
				$count = $results['data'][0]['stats']['member_count'];
			}

			set_transient( $sTransientKey, $count, 60 * 60 * 24 );
		}

		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;
	}


	//social count widget logic
	function twi_followers_count( $sName ) {

		$sTransientKey   = 'twi_followers_count_' . $sName;
		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {

			$settings = array(
				'oauth_access_token'        => "21042101-bmMZdSLH6FFRGYQ2xAGPsBprU0KavZoj28po35oqU",
				'oauth_access_token_secret' => "mB8ALibQdxJkrzTlAIsGcFGbk1w00fXAqynHO7G0",
				'consumer_key'              => "kCeMPbUMXgDPQSI6tGdzNA",
				'consumer_secret'           => "AaiVFD0zjhs2CLlbIVJNcQJZIPNcSpGfrFrj37idrU"
			);

			$url           = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield      = '?screen_name=' . $sName;
			$requestMethod = 'GET';
			$twitter       = new TwitterAPIExchange( $settings );
			$follow_count  = $twitter->setGetfield( $getfield )
			                         ->buildOauth( $url, $requestMethod )
			                         ->performRequest();

			$aResponse = json_decode( $follow_count, true );

			if ( ! $aResponse[0]['user']['followers_count'] ) {
				$count = get_option( $sTransientKey );
			} else {
				$sFollowersCount = $aResponse[0]['user']['followers_count'];

				set_transient( $sTransientKey, $sFollowersCount, 60 * 60 * 24 );
				update_option( $sTransientKey, $sFollowersCount );
				$count = $sFollowersCount;
			}

		}

		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;

	}

	//social count widget logic
	function vk_followers_count( $sName ) {

		$sTransientKey = 'vk_followers_count_' . $sName;

		$sFollowersCount = get_transient( $sTransientKey );
		if ( $sFollowersCount !== false ) {
			$count = $sFollowersCount;
		} else {
			$sSlug     = array_pop( explode( "club", trim( $sName, "/" ) ) );
			$aResponse = wp_remote_get( "http://vkontakte.ru/widget_community.php?gid=26115263&mode=1" );

			if ( is_wp_error( $aResponse ) ) {
				$count = get_option( $sTransientKey );
			} else {
				$sContent = preg_match( "/id\=\"members\_count\"[^>]*>(.*?)<\/div/msi", $aResponse['body'], $aMatch );
				if ( $aMatch[1] ) {
					$sFollowersCount = preg_replace( "/[^0-9]+/", "", strip_tags( $aMatch[1] ) );
					set_transient( $sTransientKey, $sFollowersCount, 60 * 60 * 24 );
					update_option( $sTransientKey, $sFollowersCount );
					$count = $sFollowersCount;
				}
			}

		}

		if ( $count >= 1000 ) {
			$count = round( $count / 1000, 1 ) . 'k';
		}

		return $count;
	}


	function declension( $digit, $expr, $onlyword = true ) //склонение слов
	{

		if ( ! is_array( $expr ) ) {
			$expr = array_filter( explode( ' ', $expr ) );
		}
		if ( empty( $expr[2] ) ) {
			$expr[2] = $expr[1];
		}
		$i = preg_replace( '/[^0-9]+/s', '', $digit ) % 100;
		if ( $onlyword ) {
			$digit = '';
		}
		if ( $i >= 5 && $i <= 20 ) {
			$res = $digit . ' ' . $expr[2];
		} else {
			$i %= 10;
			if ( $i == 1 ) {
				$res = $digit . ' ' . $expr[0];
			} elseif ( $i >= 2 && $i <= 4 ) {
				$res = $digit . ' ' . $expr[1];
			} else {
				$res = $digit . ' ' . $expr[2];
			}
		}

		return trim( $res );
	}

	function get_popular_posts( $args ) {

		global $wpdb;

		if ( isset( $_POST['cat'] ) ) {
			$cat = (int) $_POST['cat'];
		}

		$defaults = array(
			'cat'            => '',
			'posts_per_page' => 4,
			'post_type'      => 'post',
			'old_days'       => 14
		);

		$args = wp_parse_args( $args, $defaults );

		$old_days = $args['old_days'];
		$date     = date( 'Y-m-d', strtotime( '-' . $old_days . ' days' ) );
		$cat      = $args['cat'];
		$limit    = $args['posts_per_page'];

		$query = "SELECT post.ID, post.post_date, post.post_status, post.post_type, ";
		$query .= " (SELECT Views FROM pr_stats WHERE pr_stats.PostId = post.ID ) AS Views";
		$query .= " FROM wp_posts post";

		$where = " WHERE post.post_status = 'publish'";
		$where .= " AND post.post_type = 'post'";
		$where .= " AND post.post_date >= '$date'";

		if ( $cat ) {
			$where .= " AND ID IN (SELECT object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id ";
			$where .= "            IN (SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = $cat) ";
			//$where .= "            AND wp_term_relationships.object_id IN (SELECT post_id FROM wp_postmeta ";
			//$where .= " WHERE meta_key = 'uni_slider_on' AND meta_value = 1) ";
			$where .= " )";
		}

		$orderby = " ORDER BY Views DESC LIMIT $limit";

		$query = $wpdb->get_results( $query . $where . $orderby );

		return $query;
	}

	function clear_special_sumbols( $text ) {

		$regs = array(
			'&#187;',
			'&#171;',
			'»',
			'«',
			'”',
			"'",
			'"',
			'“',
			'”',
			':'
		);

		//return str_replace($regs, '', $text);
		return html_entity_decode( $text );
	}



	function top_two_big_posts_and_adv() {

		global $exclude_posts_for_main_query;
		//var_dump($exclude_posts_for_main_query);

		?>

		<!-- two latest posts and advertisement -->
		<ul class="fresh_latest_posts_wrapper cf">
			<?php
				if ( is_category() ) {
					$args['category__in'] = get_query_var( 'cat' );
				}

				//$args['posts_per_page'] = 1;
				$args['posts_per_page'] = 2;

				$args['post__in']            = get_option( 'sticky_posts' );
				$args['ignore_sticky_posts'] = 1;

				ob_start();
				$exclude_top_post = array();
				$the_query        = new WP_Query( $args );
				
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
						get_template_part( 'content', 'latest_post' );
						$exclude_top_post[]             = get_the_ID();
						$exclude_posts_for_main_query[] = get_the_ID();
					endwhile; endif;
				wp_reset_postdata();
				$sticky_post_content = ob_get_clean();

				//var_dump($sticky_post_content);

				// if ( $sticky_post_content ) {
				// 	$args['posts_per_page'] = 1;
				// 	//            $args['ignore_sticky_posts'] = 1;
				// 	$args['post__not_in'] = $exclude_top_post;
				// } else {
				// 	$args['posts_per_page'] = 2;
				// }

				unset( $args['post__in'] );
				unset( $args['ignore_sticky_posts'] );

				//var_dump($sticky_post_content);

				// if ( count($sticky_post_content) == 1 ) {

				// 	$args['posts_per_page'] = 1;
				// 	$args['post__not_in'] = $exclude_top_post;

				// 	$the_query = new WP_Query( $args );

				// 	if ( $the_query->have_posts() ) :
				// 		while ( $the_query->have_posts() ) : $the_query->the_post();
				// 			get_template_part( 'content', 'latest_post' );
				// 			$exclude_top_post[]             = get_the_ID();
				// 			$exclude_posts_for_main_query[] = get_the_ID();
				// 		endwhile; endif;
				// 	wp_reset_postdata();
				// }

				//var_dump($exclude_posts_for_main_query);

				echo $sticky_post_content;

			?>


<!-- 			<li class="fresh_adv_wrapper">
				<div class="fresh_adv"> -->
					<?php// echo get_field('head_adv', 'options'); ?>
					<!-- Premium_300x250 -->
<!-- 					<div id='div-gpt-ad-1348523403678-0' style='height: 250px;'>
						<script type='text/javascript'>
							googletag.cmd.push(function () {
								googletag.display('div-gpt-ad-1348523403678-0');
							});
						</script>
					</div>
				</div>
			</li> -->

		</ul>

	<?php


	}


	function featured_posts_home_page() {

		global $exclude_posts_for_main_query;
		?>
		<!-- featured posts -->
		<div class="fresh_featured_posts_line">
			<div class="fresh_featured_posts_wrapper">
				<?php if ( is_category() ) { ?>
					<div style="width:100%;">
						<div class="spons">
							<?php echo category_description(); ?>
						</div>
						<h4><?php single_cat_title(); ?>. Лучшее</h4>
					</div>
				<?php } else { ?>
					<h4>Лучшее</h4>
				<?php } ?>
				<ul class="fresh_featured_posts cf">
					<?php
						/*********************************************************************************************
						 *
						 * Воу, воу!!! Погоди, не меняй posts_per_page => 6 на 5! Нам нужен шестой пост для адаптивки! ;)
						 *********************************************************************************************/
						if ( is_category() ) {

							$query1             = get_best_posts_in_cat_by_date( '-10 days', 1, 6, 0 );
							$result_count_posts = count( $query1 );

							if ( $result_count_posts < 6 ) {
								$posts_per_page = 6 - $result_count_posts;
								$query2         = get_best_posts_in_cat_by_date( '-2 month', 1, $posts_per_page, $result_count_posts );
								$query          = (object) array_merge( (array) $query1, (array) $query2 );
							} else {
								$query = $query1;
							}

							ob_start();
							foreach ( $query as $post ) {
								$exclude_posts_for_main_query[] = $post->ID;
								?>
								<li class="fresh_featured_post">
									<a href="<?php echo get_permalink( $post->ID ); ?>">
										<p class="fresh_small"><?php echo get_the_time( 'd', $post->ID ); ?> <?php
												echo month_full_name_ru( get_the_time( 'n', $post->ID ) );
											?></p>

										<h3 class="fresh_big"><?php echo get_the_title( $post->ID ); ?></h3>
									</a>
								</li>

							<?php

							}

							$response['html'] = ob_get_contents();
							ob_get_clean();

							echo $response['html'];

						} else {
							$args = array(
								'post_type'      => 'post',
								'meta_key'       => 'uni_slider_on',
								'meta_value'     => 1,
								'posts_per_page' => 6,
								'post__not_in'   => get_two_last_posts_id_for_exclude()
							);

							$the_query = new WP_Query( $args );
							if ( $the_query->have_posts() ) :
								$exclude_posts = array();
								while ( $the_query->have_posts() ) : $the_query->the_post();
									$exclude_posts_for_main_query[] = get_the_ID();
									?>
									<li class="fresh_featured_post">
										<a href="<?php the_permalink(); ?>">
											<p class="fresh_small">
												<?php /* if ( get_the_time( 'd-m-Y' ) == date( 'd-m-Y', current_time( 'timestamp' ) ) ) {
													echo 'Сегодня';
												} elseif ( get_the_time( 'd-m-Y' ) == date( 'd-m-Y', strtotime( '-1 days' ) ) ) {
													echo 'Вчера';
												} else { */
													the_time( 'd' ); ?> <?php echo month_full_name_ru( get_the_time( 'n' ) ); ?> <?php if ( date( 'Y', current_time( 'timestamp' ) ) > get_the_time( 'Y' ) ) {
													the_time( 'Y' );
												}
													/* } */
												?></p>

											<h3 class="fresh_big"><?php the_title(); ?></h3>
										</a>
									</li>
								<?php
								endwhile; endif;

							wp_reset_postdata();
						}
					?>

				</ul>
			</div>
		</div>
	<?php
	}


	function get_best_posts_in_cat_by_date( $period, $period2, $posts_per_page, $count_now_posts ) {

		global $wpdb;

		$cat = (int) get_query_var( 'cat' );

		$date = date( 'Y-m-d', strtotime( $period ) );

		$query = "SELECT post.ID, post.post_date, post.post_status, post.post_type, ";
		$query .= " (SELECT Views FROM pr_stats WHERE pr_stats.PostId = post.ID ) AS Views";
		$query .= " FROM wp_posts post";

		$where = " WHERE post.post_status = 'publish'";
		$where .= " AND post.post_type = 'post'";
		$where .= " AND post.post_date >= '$date'";


		if ( $exclude_two_posts = implode( ',', get_two_last_posts_id_for_exclude( 2 ) ) ) {
			$where .= " AND post.ID NOT IN ($exclude_two_posts)";
		}

		if ( is_category() ) {
			$where .= " AND ID IN (SELECT object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id ";
			$where .= "            IN (SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = $cat) ";
			$where .= " )";
		}


		$orderby = " ORDER BY Views DESC LIMIT $posts_per_page";

		$query = $wpdb->get_results( $query . $where . $orderby );

		//    $result_count_posts = count($query1) + $count_now_posts;

		//    if ($result_count_posts < 6) {
		//        $posts_per_page = 6 - $result_count_posts;
		//        $query2 = get_best_posts_in_cat_by_date('-' . $period2 . ' month', ++$period2, $posts_per_page, $result_count_posts);
		//        $query = (object)array_merge((array)$query1, (array)$query2);
		//    } else {
		//        $query = $query1;
		//    }


		return $query;

	}

	function get_two_last_posts_id_for_exclude() {

		$is_sticky = false;

		if ( is_category() ) {
			$args['category__in'] = get_query_var( 'cat' );
		}

		$args['posts_per_page'] = 1;

		$args['post__in']            = get_option( 'sticky_posts' );
		$args['ignore_sticky_posts'] = 1;

		$exclude_posts = array();
		$the_query     = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$exclude_posts[] = get_the_ID();
				$is_sticky       = true;
			endwhile; endif;
		wp_reset_postdata();

		if ( $is_sticky ) {
			$args['posts_per_page']      = 1;
			$args['ignore_sticky_posts'] = 1;
		} else {
			$args['posts_per_page'] = 2;
		}

		unset( $args['post__in'] );
		unset( $args['ignore_sticky_posts'] );


		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$exclude_posts[] = get_the_ID();
			endwhile; endif;
		wp_reset_postdata();


		return $exclude_posts;
	}

	function get_featured_posts_for_exclude() {

		$exclude_posts = array();
		if ( is_category() ) {

			$query = get_best_posts_in_cat_by_date( '-10 days', 1, 6, 0 );

			foreach ( $query as $post ) {
				$exclude_posts[] = $post->ID;
			}
		} else {
			$args = array(
				'post_type'      => 'post',
				'meta_key'       => 'uni_slider_on',
				'meta_value'     => 1,
				'posts_per_page' => 6,
				'post__not_in'   => get_two_last_posts_id_for_exclude()
			);

			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
				$exclude_posts = array();
				while ( $the_query->have_posts() ) : $the_query->the_post();
					$exclude_posts[] = get_the_ID();
				endwhile; endif;
			wp_reset_query();
		}

		return $exclude_posts;
	}


	function get_excluded_posts_fog_loops( $num_offset = 0 ) {

		$two_last_posts = get_two_last_posts_id_for_exclude();
		$featured_posts = get_featured_posts_for_exclude();

		//$exclude_posts = array_merge( $two_last_posts, $featured_posts );
		// dgamoni fix
		$exclude_posts = $featured_posts;

		$excludeds     = array();
		if ( $num_offset ) {
			$args          = array(
				'posts_per_page' => $num_offset,
				'post__not_in'   => $exclude_posts
			);
			$the_query     = new WP_Query( $args );
			$exclude_posts = array();
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) : $the_query->the_post();
					$excludeds[] = get_the_ID();
				endwhile; endif;
		}

		return array_merge( $excludeds, $exclude_posts );
	}


	function is_disable_ads_paid_post() {

		global $post;

		$id = get_the_ID();

		if ( ! $id ) {
			$id = $post->ID;
		}


		if ( get_field( 'paid_post', $id ) && get_field( 'paid_post_disable_ads', $id ) ) {
			return false;
		}


		// Меняем логику возврата результата что бы не использовать знак НЕ в условии
		return true;
	}

// poputno

if( function_exists('add_interface_taxonomy_order') ){
    add_interface_taxonomy_order ("region");
}
if( function_exists('has_interface_taxonomy_order') ){
    $enable = has_interface_taxonomy_order ("region");
}

function poputno_category($id) {
	
	if( is_category( 'mesta') ){
		$cur_terms =  get_the_terms( $id, 'region' );

			if ($cur_terms) {
				foreach($cur_terms as $cur_term){
					 $catt[] = $cur_term->name ;
				}
				$cat = 	$catt[0];	
			}

	} else if( is_category( 'lajfhaki') || is_category('gadzhety' ) ){
		$cur_terms =  get_the_terms( $id, 'topic' );

			if ($cur_terms) {
				foreach($cur_terms as $cur_term){
					 $catt[] = $cur_term->name ;
				}
				$cat = 	$catt[0];	
			}

	} else {
		$category = get_the_category($id); 
		$cat = $category[0]->cat_name;
	}

	return $cat;
}

// add_option( 'destatistics', 's:24:"O:12:"Destatistics":0:{}";' ); 
// add_option( 'DESTAT_Post_Type', 'a:1:{i:0;s:4:"post";}' ); 
		
function cmp($a, $b) {
	return $a["mid"] - $b["mid"];
}

//сортировка http://stackoverflow.com/questions/96759/how-do-i-sort-a-multidimensional-array-in-php

function make_comparer() {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
        $criteria[$index] = is_array($criterion)
            ? array_pad($criterion, 3, null)
            : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use ($criteria) {
        foreach ($criteria as $criterion) {
            // How will we compare this round?
            list($column, $sortOrder, $projection) = $criterion;
            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

            // If a projection was defined project the values now
            if ($projection) {
                $lhs = call_user_func($projection, $first[$column]);
                $rhs = call_user_func($projection, $second[$column]);
            }
            else {
                $lhs = $first[$column];
                $rhs = $second[$column];
            }

            // Do the actual comparison; do not return if equal
            if ($lhs < $rhs) {
                return -1 * $sortOrder;
            }
            else if ($lhs > $rhs) {
                return 1 * $sortOrder;
            }
        }

        return 0; // tiebreakers exhausted, so $first == $second
    };
}
// end

function top_tags() {
        $tags = get_tags();
        if (empty($tags))
                return;
        $counts = $tag_links = array();
        foreach ( (array) $tags as $key=>$tag ) {
                $counts[$tag->name] = $tag->count;
                $tag_links[$tag->name] = get_tag_link( $tag->term_id );
                $tag_header[$tag->name] = get_field( 'tag_enable', 'post_tag_'.$tag->term_id );

                $arr[$key][name] = $tag->name;
                $arr[$key][count] = intval($tag->count);
                $arr[$key][link] = get_tag_link( $tag->term_id );
                $arr[$key][header] = intval(get_field( 'tag_enable', 'post_tag_'.$tag->term_id ));
                
        }
        //var_dump($arr);

        asort($counts);
        $counts = array_reverse( $counts, true );
        
	
		usort($arr, make_comparer('header','count'));
		$arr = array_reverse( $arr, true );	
		//var_dump($arr);


        $i = 0;
        // foreach ( $counts as $tag => $count ) {
        //         $i++;
        //         $tag_link = clean_url($tag_links[$tag]);
        //         $tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
        //         if($i < 11){
        //                 // print "<li><a href=\"$tag_link\">$tag ($count)</a></li>";
        //         		print "<li><a href=\"$tag_link\">$tag</a></li>";
        //         }
        // }

        foreach ( $arr as $key => $arrs ) {
                $i++;
                $tag_link = clean_url($arrs[link]);
                $name = str_replace(' ', '&nbsp;', wp_specialchars( $arrs[name] ));
                $countt = $arrs[count];
                $hed =  $arrs[header];

                if($i < 11){
                    print "<li><a href=\"$tag_link\">$name</a></li>";
                }
        }
}


	function exclude_posts_for_main_query_f() {

		global $exclude_posts_for_main_query;

				if ( is_category() ) {
					$args['category__in'] = get_query_var( 'cat' );
				}

				$args['posts_per_page'] 	 = 2;
				$args['post__in']            = get_option( 'sticky_posts' );
				$args['ignore_sticky_posts'] = 1;

				ob_start();
				$exclude_top_post = array();
				$the_query        = new WP_Query( $args );
				
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
						get_template_part( 'content', 'latest_post' );
						$exclude_top_post[]             = get_the_ID();
						$exclude_posts_for_main_query[] = get_the_ID();
					endwhile; endif;
				wp_reset_postdata();
				$sticky_post_content = ob_get_clean();

			return $exclude_posts_for_main_query;
	}