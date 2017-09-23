<?php get_header(); ?>

<div class="col-md-12">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h3 class="entry-title"><?php _e( 'Not found', 'twentythirteen' ); ?></h3>
        </header><!-- .entry-header -->

        <div class="entry-content">

        </div>
    </article>

</div>

<?php get_footer(); ?>
