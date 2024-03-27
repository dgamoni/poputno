<?php get_header(); ?>
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
<?php get_footer(); ?>