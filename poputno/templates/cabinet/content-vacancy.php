<?php
	$images = get_children( array(
		                        'post_parent'    => get_the_ID(),
		                        'post_type'      => 'attachment',
		                        'post_mime_type' => 'image',
		                        'orderby'        => 'menu_order',
		                        'order'          => 'ASC',
		                        'numberposts'    => 1
	                        ) );
	$sImage = '';
	if ( $images ) {
		foreach ( $images as $image ) {
			$image_src = wp_get_attachment_image_src( $image->ID, 'univac-randlogo' );
			//        $sImage = '<img width="50" src="' . $image_src[0] . '" alt="' . get_post_meta($post->ID, 'univac_company_name', true) . '" />';
		}
		$img = $image_src[0];
	}


?>
<li class="vac-item my_vac vacancy_item_id_<?php echo get_the_ID(); ?>">
	<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="comp-logo">
		<img width="50" src="<?php echo $img; ?>" alt="" />
	</a>

	<div class="comp-txt cf">
		<div class="company" style="width: 40%; padding-left: 20px;">
			<!-- <a class="edit_vacancy" href="/jobs/edit-vacancy?vacancy_id=<?php echo get_the_ID(); ?>" title="Редактировать вакансию"></a> -->
			<h4>
				<a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php the_title(); ?></a>
			</h4>
			<?php if ( $post->post_status == 'draft' ) { ?>
				<span
					class="red" style="color:#FFF;" title="">Срок публикации вакансии истек</span>
			<?php } else { ?>
				<span
					class="comp-name"><?php echo esc_attr( get_post_meta( get_the_ID(), 'univac_company_name', true ) ); ?></span>
			<?php } ?>
		</div>
		<div class="about">
			<?php $terms = get_the_terms( get_the_ID(), 'univac_city' ); ?>
			<?php if ( count( $terms ) > 0 ) { ?>
				<?php
				if ( $terms && ! is_wp_error( $terms ) ) :
					$works_links = array();
					foreach ( $terms as $term ) {
						?>
						<a href="<?php echo get_term_link( $term->slug, 'univac_city' ); ?>">
							<address style="width: auto;max-width: none;" class="address-marker">
								<?php echo $term->name; ?>
							</address>
						</a>
					<?php
					}
				endif; ?>
			<?php } ?>

			<time style="width: auto;max-width: none;"
			      datetime="<?php echo date( 'd.m.Y H:i', strtotime( $post->post_date ) ); ?>"><?php echo date( 'd.m.Y H:i', strtotime( $post->post_date ) ); ?></time>
			<ul class="cat-list ">
				<?php
					$terms = get_the_terms( get_the_ID(), 'univac_cat' );
					if ( $terms && ! is_wp_error( $terms ) ) :
						$works_links = array();
						foreach ( $terms as $term ) {
							?>
							<li class="cat">
								<a href="<?php echo get_term_link( $term, 'univac_cat' ); ?>"
								   class="<?php echo get_vacancy_cat_color( $term->term_id ); ?>"><?php echo $term->name; ?></a>
							</li>
						<?php
						}
					endif; ?>


				<?php
					if ( $post->post_status == 'publish' ) {
						?>
						<li class="cat">
							<a href="#" class="green">Опубликована</a>
						</li>
					<?php } ?>
			</ul>

			<!-- <span class="del_vacancy" title="Удалить вакансию" onclick="Vacancy.del(this, <?php echo get_the_ID(); ?>)"></span> -->
		</div>
	</div>
</li>