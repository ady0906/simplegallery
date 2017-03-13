<?php
  /* Template Name: Horizontal */

  get_header();

  $my_query = new WP_Query( 'category_name=home' );
?>

    <div class="horizontal-album-container">
    	<a class="js-horizontal-next horizontal-album-next" href="javascript:void(0)">next</a>
    	<a class="js-horizontal-prev js-is-hidden horizontal-album-prev" href="javascript:void(0)">prev</a>

      <div class="horizontal-album-image-list js-image-list">
      <?php
        while ( $my_query->have_posts() ) : $my_query->the_post();
    		  the_post_thumbnail();
        endwhile;
      ?>
      </div>
    </div>

    <?php get_footer(); ?>
    <script src="<?php echo get_bloginfo('template_url'); ?>/scripts/album-horizontal-template.js"></script>
  </body>
</html>
