<?php global $post; ?>
<li class="new_post_item">
	<div class="new_img_cont">
		<a href="<?php the_permalink(); ?>">
			<img src="<?php echo get_img_post( get_the_ID(), 'ain-post' ); ?>"
			     alt="<?php the_title(); ?>">
		</a>

		<div class="new_post_likes">
                                    <span class="new_views">
                                        <?php $res = get_soc_votes( get_the_ID() );
	                                        echo $res['view']; ?></span>

            <span class="new_comm"><a href="<?php the_permalink(); ?>/#comments-box"><?php echo $res['cn']; ?></a>
            </span>

			<span class="new_likes"><?php $res = get_soc_votes( get_the_ID() );
					echo $res['sum']; ?></span>
		</div>
	</div>
	<div class="new_post_meta cf">
		<a href="<?php echo get_author_posts_url( $post->post_author, '' ); ?>"
		   class="new_author"><?php $user = get_userdata( $post->post_author );
				echo $user->display_name; ?></a>
		<time class="new_post_date" datetime="<?php the_time( 'd-m-Y' ) ?>">
			<?php if ( get_the_time( 'd-m-Y' ) == date( 'd-m-Y', current_time( 'timestamp' ) ) ) {
				echo 'Сегодня';
			} elseif ( get_the_time( 'd-m-Y' ) == date( 'd-m-Y', strtotime( '-1 days' ) ) ) {
				echo 'Вчера';
			} else {
				the_time( 'd' ); ?> <?php echo month_full_name_ru( get_the_time( 'n' ) ); ?> <?php if ( date( 'Y', current_time( 'timestamp' ) ) > get_the_time( 'Y' ) ) {
					the_time( 'Y' );
				}
			}
			?>
		</time>
	</div>
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</li>