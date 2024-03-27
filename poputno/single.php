<?php get_header(); ?>
<?php ain_posts_nav(); ?>

	<section class="main" id="main">

	<div class="wrap cf">
	<?php while (have_posts()):
		the_post(); ?>
	<div class="post">
		<div class="post_height">
			<?php if ( ! get_field( 'paid_post_disable_ads', get_the_ID() ) ) { ?>
				<div class="post_ads_full">
					<?php
						$cat = get_the_category();
						//print_r($cat);
						echo category_description( $cat[0]->term_id );
					?>
				</div>
			<?php } ?>

			<h1><?php the_title(); ?></h1>

			<aside class="post_meta">
				<?php
					$authorID = get_the_author_meta( 'ID' );
					//$avatar = get_avatar($authorID, 15, '');
				?>
				<a href="<?php echo get_author_posts_url( $authorID ); ?>"
				   rel="author"><?php //echo $avatar; ?><?php echo get_the_author_meta( 'display_name' ); ?></a>

				<time datetime="<?php the_time( 'd-m-Y' ) ?>"><?php the_time( 'd' ); ?>
					<?php echo month_full_name_ru( get_the_time( 'n' ) ); ?> <?php the_time( 'Y' ); ?></time>
                            <span title="Просмотры" class="post_views"><?php $res = get_soc_votes( get_the_ID() );
		                            echo $res['view']; ?></span>

				<?php if ( get_field( 'paid_post', get_the_ID() ) ) { ?>
					<span class="pr_post">PR</span>
				<?php } ?>


				<div class="post_likes">
					<?php content_soc_likes(); ?>
				</div>
			</aside>

			<?php the_content(); ?>


			<hr />

			<?php if ( get_post_status() == 'publish' ) : ?>

				<div class="alignleft widget_like">

					<?php footer_soc_likes(); ?>

				</div>



			<?php endif; ?>

			<div class="tag_list">
				<?php the_tags( ' ', '' ); ?>
			</div>




			<?php if ( ! get_field( 'paid_post_disable_ads', get_the_ID() ) ) { ?>
				<div class="post_ads">
					<!-- AIN_728x90 -->
					<div id='div-gpt-ad-1348523472889-0' style='width:728px; height:90px;'>
						<script type='text/javascript'>
							googletag.cmd.push(function () {
								googletag.display('div-gpt-ad-1348523472889-0');
							});
						</script>
					</div>
				</div>
			<?php } ?>

		</div>
		<div class="related_posts">
			<h3>Читайте также</h3>

			<div class="postRow">
				<?php
					$tags = wp_get_post_tags( get_the_ID() );
					if ( $tags ) {
						$tags_ids = array();
						foreach ( $tags as $each_tag ) {
							if ( $each_tag->term_id == 1239 ) {
								continue;
							}
							$tags_ids[] = $each_tag->term_id;
						}
						$args = array(
							'tag__in'        => $tags_ids,
							'post__not_in'   => array( get_the_ID() ),
							// 'posts_per_page' => 6,
							'posts_per_page' => 4,
							//'ignore_sticky_posts' => 1
						);

						$query = new WP_Query( $args );
						if ( ! $query->have_posts() ) {
							$cat   = get_the_category();
							$args  = array(
								'post__not_in'   => array( get_the_ID() ),
								// 'posts_per_page' => 6,
								'posts_per_page' => 4,
								//'ignore_sticky_posts' => 1,
								'cat'            => $cat[0]->term_id
							);
							$query = new WP_Query( $args );
						}

						if ( $query->have_posts() ) {
							while ( $query->have_posts() ): $query->the_post();
								?>
								<div class="smallPostItem cat-<?php echo $cat[0]->term_id; ?>">

									<a href="<?php the_permalink(); ?>">
										<img width="180"
										     src="<?php echo get_img_post( get_the_ID(), 'ain-related-post' ); ?>"
										     alt="" /></a>

									<h3>
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>

									<div class="postMetaBox">
										<a class="postAuthor"
										   href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"
										   title="">
											<?php the_author(); ?></a>

										<?php $res = get_soc_votes( get_the_ID() ); ?>
										<div class="clear"></div>
										<a class="postComment" href="<?php the_permalink(); ?>/#comments-box"
										   data-disqus-identifier="#" title="<?php echo $res['cn']; ?>">
											<?php
												echo $res['cn'];?>

										</a>
									</div>
								</div>
							<?php
							endwhile;
						}
						wp_reset_postdata();
					}
				?>
				<div class="clear"></div>
			</div>

		</div>

		<section class="comment_box wrap cf" id="comments-box">
			<!-- <div class="comment_list column_c23" onclick="return false;"> -->
			<div class="comment_list " onclick="return false;">
<!-- 				<div class="widget_orphus" onclick="return false;">

					<div class="orfus">
                        <span class="orf">
                            Заметили ошибку? Выделите ее и нажмите Ctrl+Enter, чтобы сообщить нам.
                        </span>

						<div style="display:none;">
							<script type="text/javascript" src="/orphus/orphus.js"></script>
							<a href="http://orphus.ru" id="orphus" target="_blank">
								<img alt="Система Orphus"
								     src="/orphus/orphus.gif" border="0"
								     width="257" height="48" /></a>
						</div>

					</div>
				</div> -->

				<?php if ( get_post_status() == 'publish' ) : ?>
					<noindex><?php comments_template( '', true ); ?></noindex>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'footer' ); ?>

		</section>


		<?php endwhile; ?>
	</div>
	<?php global $brending_page_id;
		if ( get_field( 'brending_pages_enable_sidebar', $brending_page_id ) ) {
			?>
			<div class="sidebar" id="sidebar">
				<?php
					if ( is_active_sidebar( 'brending_page_sidebar_' . get_field( 'brending_pages_tag_slug', $brending_page_id ) ) ) :
						dynamic_sidebar( 'brending_page_sidebar_' . get_field( 'brending_pages_tag_slug', $brending_page_id ) );
					endif;
				?>
			</div>
		<?php
		} else {
			get_sidebar();
		}
	?>
	</section>
<?php get_footer(); ?>
<?php //var_dump( get_tags() ); ?>