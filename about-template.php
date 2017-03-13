<?php
  /* Template Name: About Page */

  get_header();
?>

<div class="theme-page-wrapper">
  <div class="about-page-wrapper">
 <?php
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
	endwhile; else: ?>
		<p>Content not found.</p>
<?php endif; ?>

  </div>
</div>

<?php get_footer(); ?>
  </body>
</html>