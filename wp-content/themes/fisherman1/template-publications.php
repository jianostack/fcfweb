<?php
/**
 * Template Name: publications
 */
get_header(); ?>

	<div class="col-md-12">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>

		<h3 class="entry-title"><?php the_title(); ?></h3>
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<h4>Fishers</h4>
		<div class="row">
		<ul class="magazines">
			<?php
			$args = array(
			    'category__in' => array( 4 )
			);
			$query = new WP_Query($args); ?>
			<?php if( $query->have_posts() ): ?>
			    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			        <li class="col-md-2">
			            <a href="http://www.fishersmagazine.net/" target="_blank">
			            	<?php if ( has_post_thumbnail() ) { $content = apply_filters('the_content',the_post_thumbnail('full',array('class' => 'page-feat'))); } ?>
			           	</a>
			            <p>&nbsp;</p>
			        </li>
			    <?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
		</div>
      	<div class="clearfix"></div>
		<hr />
		<p>&nbsp;</p>
		<h4>Behold</h4>
		<div class="row">
		<ul class="magazines">
			<?php
			$args = array(
			    'category__in' => array( 5 )
			);
			$query = new WP_Query($args); ?>
			<?php if( $query->have_posts() ): ?>
			    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			        <li class="col-md-2">
			            <a href="http://fishermanofchrist.org/" target="_blank">
			            	<?php if ( has_post_thumbnail() ) { $content = apply_filters('the_content',the_post_thumbnail('full',array('class' => 'page-feat'))); } ?>
			           	</a>
			            <p>&nbsp;</p>
			        </li>
			    <?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->


<?php get_footer(); ?>