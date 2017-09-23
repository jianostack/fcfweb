<?php get_header(); ?>

	<div class="col-md-3 sidebar">
		<?php get_sidebar('bible'); ?>
    <div style="height:50px"></div>
    <?php if ( ! dynamic_sidebar( 'sidebar-links' ) ) : endif; // widget area ?>
	</div>

	<div class="homeContent col-md-6">
		<?php
		query_posts( 'page_id=2' );
		while ( have_posts() ) : the_post(); ?>
		<h3 class="entry-title"><?php the_title(); ?></h3>
		<?php the_content(); ?>
		<?php endwhile; wp_reset_query();?>


		<?php
		global $more;    // Declare global $more (before the loop).
		$more = 0;
		$args = array(
		    'category__in' => array( 3 ),
		    'posts_per_page' => 4
		);
		$query = new WP_Query($args); ?>
		<?php if( $query->have_posts() ): ?>
		    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
		        <strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong><br />
		        <?php the_content(""); ?>
		    <?php endwhile; ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<div class="sidebar col-md-3">
		<h4 class="sbTitle"><?php echo get_cat_name(6); ?></h4>
		<ul class="magazines">
			<?php
			$args = array(
			    'category__in' => array( 4 ),
			    'posts_per_page' => 1
			);
			$query = new WP_Query($args); ?>
			<?php if( $query->have_posts() ): ?>
			    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			        <li>
			            <a href="http://www.fishersmagazine.net/" target="_blank"><?php if ( has_post_thumbnail() ) { $content = apply_filters('the_content',the_post_thumbnail('full',array('class' => 'page-feat'))); } ?></a>
			            <p></p>
			        </li>
			    <?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			<?php
			$args = array(
			    'category__in' => array( 5 ),
			    'posts_per_page' => 1
			);
			$query = new WP_Query($args); ?>
			<?php if( $query->have_posts() ): ?>
			    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			        <li>
			            <a href="http://fishermanofchrist.org/?q=behold" target="_blank"><?php if ( has_post_thumbnail() ) { $content = apply_filters('the_content',the_post_thumbnail('full',array('class' => 'page-feat'))); } ?></a>
			        </li>
			    <?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</ul>

		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : endif; // widget area ?>

	</div>

	<?php get_footer(); ?>
