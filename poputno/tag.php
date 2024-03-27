<?php get_header(); ?>
	
	<!-- Left menu element-->
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
        <?php echo do_shortcode('[ULWPQSF id=161]' );?>
    </nav>

    <!-- dgamoni left block -->
    <div class="po_main_left">

    	<!-- title -->
		<section class="featured_box author" id="featured_box">
		 <div class="wrap cf archive_top_posts">
		  <div id="acontent">
		   <div class="wrap">
		    	<h1 class="archive_top_title"><big><?php single_cat_title(); ?></big></h1>
		   </div>
		  </div>
		 </div>
		</section>

		<?php get_template_part('loop'); ?>

	</div> 
    <!-- enf left -->

    <!-- sidebar -->
    <?php global $brending_page_id;
            if ( get_field( 'brending_pages_enable_sidebar', $brending_page_id ) ) {
                ?>
                <div class="sidebar " id="sidebar">
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

    <div class="cf"></div>
    <!-- end sidebar -->

<?php get_footer(); ?>