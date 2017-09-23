<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="container hfeed site">
		<div class="row">
			<div class="col-xs-12 visible-xs langSelect-xs">
				<?php //icl_post_languages(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<nav id="main-navigation" class="pull-right visible-lg visible-md visible-sm" role="navigation">
						<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
						<?php wp_nav_menu( array('theme_location' => 'main', 'menu_id'=>'menu-main','menu_class' => 'menu' )); ?>

					</nav>
					<nav id="main-navigation" class="navbar navbar-default visible-xs" role="navigation">
						<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<div class="navbar-brand col-xs-9">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/fcf_logo.jpg" class="img-responsive logo" /></a>
							</div>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<?php wp_nav_menu( array('menu' => 'header', 'menu_class' => 'nav navbar' )); ?>
						</div>
					</nav>
				</div>
				<div class="row">
					<header id="masthead" class="col-md-12 site-header" role="banner">
						<div class="pull-left col-xs-10 hidden-xs">
							<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php bloginfo( 'template_url' ); ?>/images/fcf_logo.jpg" class="logo" />
							</a>
						</div>
						<div class="pull-right hidden-xs langSelect">
							<?php //icl_post_languages(); ?>
						</div>
						<div class="clearfix"></div>

						<?php if ( ! dynamic_sidebar( 'header-verse' ) ) : endif; // widget area ?>

						<div class="clearfix"></div>
					</header>

					<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" class="img-responsive" alt="fcf church" />

				</div>
				<div id="main" class="row">
