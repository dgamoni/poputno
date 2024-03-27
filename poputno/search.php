<?php get_header(); ?>
	<section class="featured_box author" id="featured_box">
		<div class="wrap cf archive_top_posts">
			<div id="acontent">
				<div class="wrap">
					<h1 class="archive_top_title">
						<big>
							Результат поиска: <?php echo get_search_query(); ?>
						</big>
					</h1>
				</div>
			</div>
		</div>
	</section>
<?php
$num_posts      = 0;
$all_post_ids   = array ();
$excluded_posts = array ();

if ( have_posts () ):  while ( have_posts () ): the_post ();
	$num_posts ++;
	if ( $num_posts == 1 ) {
		echo '<!-- posts container -->
                <div class="new_posts_container">';
		echo '      <ul class="new_posts new_posts_wrapper">';
	}

	$all_post_ids[] = get_the_ID ();

	get_template_part ( 'content' );

	if ( ( ! is_category () || is_paged () ) && $num_posts == 3 ) {
		?>
		<li class="new_post_item">
			<!-- Premium_300x250 -->
			<div id='div-gpt-ad-1348523403678-0' style='height: 250px;'>
				<script type='text/javascript'>
					googletag.cmd.push(function () {
						googletag.display('div-gpt-ad-1348523403678-0');
					});
				</script>
			</div>
		</li>
		<?php

		$hasBanner = true;

	}

endwhile;endif;

echo '</ul>';
echo '</div>';

?>

<?php ajax_pagination($custom_query = false, $inner_class = '.new_posts', $posts_per_page = 16, $ajax_action = 'ain_ajax_pagination'); ?>


<?php get_footer(); ?>
