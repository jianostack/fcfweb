<?php get_header(); ?>
	<div class="col-md-12">
		<div class="entry-content">
		<?php if ( have_posts() ) : ?>
			<header class="entry-header">
				<h3 class="entry-title"><?php printf( single_cat_title( ) ); ?></h3>
				
				<?php if ( category_description() ) : // Show an optional category description ?>
					<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header>
			<hr>
			<div class="entry-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="row">
					<div class="col-md-12">
						<h4 class="entry-title"><?php the_title(); ?></h4>
						<p>&nbsp;</p>
						<?php global $more; $more = 1; the_content(); ?>
						<p>&nbsp;</p>
						<hr>
						<p>&nbsp;</p>
					</div>
					
				</div>
			<?php endwhile; ?>
			</div>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div>
	</div>
<?php get_footer(); ?>