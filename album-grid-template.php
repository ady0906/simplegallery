<?php
  /* Template Name: Grid Layout */

get_header();

$args = array ( 'post_type' => 'post',  'posts_per_page' => -1);  

 $my_query = new WP_Query ($args);?>
 <ul class="grid-album-container js-grid">
<?php		
	while ( $my_query->have_posts() ) : $my_query->the_post(); 
		 ?>     
		 <li class="grid-album-item js-grid-item js-init-single-overlay" 
         data-image-src="<?php the_post_thumbnail_url('full')?>"  
         data-title="<?php the_title(); ?>" 	
         data-caption="<?php    the_content(); ?>" >
         <?php the_post_thumbnail('medium'); ?> 
		<h2>  <?php the_title(); ?></h2>
        </li>
        <?php endwhile;  ?>

</ul>
<?php get_footer(); ?>
    <script src="<?php echo get_bloginfo('template_url'); ?>/scripts/album-grid-template.js"></script>
  </body>
</html>

