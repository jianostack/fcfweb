
	<h5 class="dailyVerses"><?php echo get_cat_name(1); ?></h5>
	<?php
	$args = array(
		'category__in' => array( 1 ),
		'posts_per_page' => 1
		);
		$query = new WP_Query($args); ?>
		<?php if( $query->have_posts() ): ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php the_content(); ?>
				<div style="text-align:right;font-weight:bold"><em><?php the_title(); ?></em></div>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

	<div style="height:50px"></div>
	<?php if ( ! dynamic_sidebar( 'sidebar-links' ) ) : endif; // widget area ?>
