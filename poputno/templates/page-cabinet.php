<?php
	/*
	* Template Name: Кабинет
	*/


	if ( ! is_user_logged_in() ) {
		wp_redirect( '/' );
	}


	global $current_user, $post;
	get_currentuserinfo();
	$author_id = get_the_author_meta( 'ID', $current_user->id );

?>

<?php get_header(); ?>

<section class="main" id="main">

	<div class="wrap cf">

		<div class="calendar-content cabinet">
			<div class="user-block cf">
				<div class="user">
					<?php /*
                    <a href="<?php the_permalink(); ?>" class="img-cont">
                        <?php //echo get_avatar($current_user->ID, 50, '', $current_user->display_name); ?>
                    </a>
*/
					?>
					<div class="username">
						<h3 style="padding-bottom: 0px; padding-top: 12px;"><a href="<?php the_permalink(); ?>">
								<?php echo esc_attr( $current_user->display_name ); ?>
							</a></h3>
                            <span class="user_time_full" style="padding-top: 10px;">Дата регистрации: <time>
		                            <?php
			                            echo date( 'd', strtotime( $current_user->user_registered ) ) . ' ';
			                            echo month_full_name_ru( date( 'n', strtotime( $current_user->user_registered ) ) ) . ' ';
			                            echo date( 'Y', strtotime( $current_user->user_registered ) ) . ' в ';
			                            echo date( 'h:m', strtotime( $current_user->user_registered ) );
		                            ?>
	                            </time>
                            </span>
							<span class="user_time_short">Регистрация: <time>
									<?php
										echo date( 'd', strtotime( $current_user->user_registered ) ) . '.';
										echo date( 'm', strtotime( $current_user->user_registered ) ) . '.';
										echo date( 'Y', strtotime( $current_user->user_registered ) ) . ' в ';
										echo date( 'h:m', strtotime( $current_user->user_registered ) );
									?>
								</time>
							</span>
					</div>
				</div>
				<a href="<?php echo wp_logout_url( '/' ); ?>" class="red-btn" style="margin-left: 40px;">Выход</a>
				<a href="/profile" class="red-btn">Профиль</a>
			</div>

			<div class="vac-head cf">
				<p class="lefter">Мои события</p>
				<a href="<?php echo tribe_community_events_add_event_link(); ?>"
				   class="add_vacancy">Добавить событие</a>
			</div>

			<div style="clear:both"></div>

			<?php

				if ( get_current_user_id() == 76837 ) {
					//				if ( get_current_user_id () == 76837 ) {
					$args = array(
						'posts_per_page' => 10,
						'orderby'        => 'post_date',
						'order'          => 'DESC',
						'post_type'      => 'tribe_events',
						'post_status'    => 'any'
					);

					//				}
				} else {
					$args = array(
						'posts_per_page' => 10,
						'orderby'        => 'post_date',
						'order'          => 'DESC',
						'author'         => $current_user->ID,
						'post_type'      => 'tribe_events',
						'post_status'    => 'any',
						//'eventDisplay' => 'upcoming',
						//'tribeHideRecurrence' => FALSE,
					);

				}


				//$args = apply_filters('tribe_ce_my_events_query', $args);

				$events = new WP_Query( $args );

				$temp_post = $post;
				if ( $events->have_posts() ) {
					while ( $events->have_posts() ) {
						$events->the_post();
						$post = $events->post;
						get_template_part( 'templates/cabinet/content', 'events' );
					}
				} else {
					?>
					<?php /* <li class="vac-item"> */ ?>
					<div class="">
						<div class="empty event">
							Нет событий
						</div>

					</div>
				<?php
				}
				$post = $temp_post;
				wp_reset_query();

			?>
			<div class="vac-head cf">
				<p class="lefter">Мои вакансии</p>
				<a href="/jobs/add-job" class="add_vacancy">Добавить вакансию</a>
			</div>
			<ul class="vacancies-list ">
				<?php
					if ( get_current_user_id() == 76837 ) {
						$args = array(
							'posts_per_page' => 10,
							'orderby'        => 'post_date',
							'order'          => 'DESC',
							'post_type'      => 'univac_vacancy',
							'post_status'    => 'any',
						);
					} else {
						$args = array(
							'posts_per_page' => 10,
							'orderby'        => 'post_date',
							'order'          => 'DESC',
							'author'         => $current_user->ID,
							'post_type'      => 'univac_vacancy',
							'post_status'    => 'any',
						);
					}
					$temp_post = $post;
					$vacancy   = new WP_Query( $args );
					if ( $vacancy->have_posts() ) {
						while ( $vacancy->have_posts() ) {
							$vacancy->the_post();
							$post = $vacancy->post;
							get_template_part( 'templates/cabinet/content', 'vacancy' );
						}
					} else {
						?>
						<?php /* <li class="vac-item"> */ ?>
						<li class="">
							<div class="empty">
								Нет вакансий
							</div>

						</li>
					<?php } ?>
			</ul>
			<?php
				/*ajax_pagination_v2($custom_query = $vacancy, array(
					'inner_class' => '.vacancies-list',
					'posts_per_page' => 10,
					'ajax_action' => 'pagination_vacancy_in_cabinet',
					'post_type' => 'univac_vacancy',
					//'author' => $current_user->ID
				));*/
				wp_reset_query();
				$post = $temp_post;

			?>
			<div class="post_ads">
				<div id='div-gpt-ad-1348523472889-0' style='width:728px; height:90px;'>
					<script type='text/javascript'>
						googletag.cmd.push(function () {
							googletag.display('div-gpt-ad-1348523472889-0');
						});
					</script>
				</div>
			</div>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer();


?>
