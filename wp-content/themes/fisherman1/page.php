<?php get_header(); ?>

	<!--<div class="col-md-3 sidebar hidden-xs">-->
		<?php //get_sidebar(); ?>
	<!--</div>-->

	<div class="col-md-12">
		
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>

	</div>

<?php get_footer(); ?>