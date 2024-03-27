<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
<!--<![endif]-->
<head>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!-- 	<meta name="google-site-verification" content="A-hUp9rEQcA3HgibJp7JfgvrhqGMOtKs1UIUBfZjdkE">
	<meta name='yandex-verification' content='737bfc48352b21cd' /> -->

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<?php if ( is_search() ) { ?>
		<meta name="robots" content="noindex, nofollow">
	<?php } ?>
	<title><?php
			if ( function_exists( 'is_tag' ) && is_tag() ) {
				single_tag_title();
				echo ' - ';
			} elseif ( is_archive() ) {
				wp_title( '' );
				echo ' - ';
			} elseif ( is_search() ) {
				echo 'Результаты поиска — ' . wp_specialchars( $s ) . ' - ';
			} elseif ( is_single() ) {
				wp_title( '' );
				echo ' - ';
			} elseif ( is_page() ) {
				wp_title( '' );
				echo ' - ';
			} elseif ( is_post_type_archive( 'tribe_events' ) ) {
				// wp_title('');
				echo 'События за этот месяц - ';
			} elseif ( is_singular( 'tribe_events' ) ) {
				the_title( '' );
				echo ' - ';
			} elseif ( is_404() ) {
				echo 'Ничего не найдено - ';
			}
			if ( is_home() ) {
				bloginfo( 'name' );
				echo ' - ';
				bloginfo( 'description' );
			} else {
				bloginfo( 'name' );
			}
			if ( $paged > 1 ) {
				echo ' - страница №' . $paged;
			}
		?>
	</title>
	<?php if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	} ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?28102014">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/assets/css/adaptive.css?ver=28102014">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/assets/css/ain-post-print_style.css?28102014">

	<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo( 'template_directory' ); ?>/favicon.ico?v=3">
	<!-- <link rel="apple-touch-icon" href="<?php bloginfo( 'url' ); ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="http://ain.ua/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="http://ain.ua/images/apple-touch-icon-114x114.png"> -->

	<meta property="fb:app_id" content="101463033303499">
	<meta property="og:type" content="article">
	<meta property="og:site_name" content="<?php bloginfo( 'name' ) ?>">
	<?php if ( is_single() ) { ?>
		<meta property="og:title" content="<?php the_title() ?>">
		<meta property="og:description"
		      content="<?php echo str_replace( '"', "'", strip_tags( get_the_excerpt( $post->ID ) ) ); ?>">
		<meta property="og:type" content="article">
		<meta property="og:image" content="<?php if ( is_single() && get_post_meta( $post->ID, 'uni_watermarked', true ) ) {
			echo get_post_meta( $post->ID, 'uni_watermarked', true );
		} else {
			echo catch_that_image();

		} ?>">

		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@poputno_info">
		<meta name="twitter:url" content="<?php the_permalink() ?>">
		<meta name="twitter:title" content="<?php single_post_title( '' ); ?>">
		<meta name="twitter:image"
		      content="<?php if ( is_single() && get_post_meta( $post->ID, 'uni_watermarked', true ) ) {
			      echo get_post_meta( $post->ID, 'uni_watermarked', true );
		      } else {
			      echo catch_that_image();
		      } ?>">
	<?php } ?>

	<?php if ( is_home() ) { ?>
		<meta property="og:title" content="POPUTNO.INFO">
		<meta property="og:image" content="http://poputno.info/wp-content/themes/poputno/assets/img/logo-po.png">
		<meta property="og:description" content="<?php bloginfo( 'description' ); ?>">
	<?php } ?>
	<meta name="title" content="<?php the_title() ?>" />
	<meta name="description" content="<?php echo str_replace( '"', "'", strip_tags( get_the_excerpt( $post->ID ) ) ); ?>" />
	<link rel="image_src" href="<?php if ( is_single() && get_post_meta( $post->ID, 'uni_watermarked', true ) ) {
		echo get_post_meta( $post->ID, 'uni_watermarked', true );
	} else {
		echo catch_that_image();
	} ?>">

	<script type="text/javascript">
	    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>

	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?> <?php echo $brending; ?>>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/bxSlider.min.js"></script>
<script type="text/javascript"
        src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.hcsticky-min.js"></script>


<header class="header" id="header">

	<div class="logo_po">
		<a href="<?php bloginfo( 'url' ); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-po.png" alt="poputno.info">
		</a>
	</div>

	<div class="wrap">

<!-- 		<h1 class="logo">
			<a href="<?php bloginfo( 'url' ); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-po.png" alt="poputno.info"> 

			</a>
		</h1> -->


<div class="hamburger toggle-menu menu-left push-body">
<!-- <div class="hamburger toggle-menu menu-left"> -->
  <div class="hamburger-inner">
    <div class="bar bar1 hide"></div>
    <div class="bar bar2 cross"></div>
    <div class="bar bar3 cross hidden"></div>
    <div class="bar bar4 hide"></div>
  </div>
  <span>фильтры</span>
</div>






		<nav class="menu">
			<button class="big_trigger"></button>
			<div class="nav_wrap">
				<?php wp_nav_menu( array(
					                   'theme_location'  => 'general',
					                   'container'       => false,
					                   'container_class' => false,
					                   'container_id'    => false,
					                   'menu_class'      => 'first_menu',
					                   'depth'           => 1,
					                   //'link_before'     => '<i></i>',
				                   ) );
				?>
<!-- 				<?php wp_nav_menu( array(
					                   'container'       => '',
					                   'container_class' => '',
					                   'theme_location'  => 'primary',
					                   'items_wrap'      => '<div class="second_wrap"><div class="btn_trigger">Рубрики</div><ul class="second_menu">%3$s</ul></div>',
				                   ) ); ?> -->
			</div>

			<ul class="user_link">
				<li class="<?php
					echo 'login_zone';
				// 	if (is_user_logged_in()) {
				// 	echo 'login_img';
				// } else {
				// 	echo 'login_zone';
				// }
				?>">
					<?php if ( is_user_logged_in() ) { ?>
						<!-- <a style="display: initial;" id="profile-link" href="/cabinet"> -->
						<a href="/cabinet">Личный кабинет</a>
					<?php } else { ?>
						<a href="#" onclick="return false;">Войти</a>

						<div class="login_form_wrap">
							<form class="login_form" action="<?php bloginfo( 'url' ); ?>/wp-login.php?action=register'"
							      method="post">
								<div class="close"></div>
								<label for="name">Имя пользователя</label>
								<input class="inp" type="text" name="log" id="name">
								<label for="pass">Пароль</label>
								<input class="rem" id="rem" type="checkbox" name="rememberme" value="forever">
								<label
									class="ch_label" for="rem"><span></span>Запомнить меня</label>
								<input class="inp" type="password" name="pwd" id="pass">
								<label for="">Войти через</label>
								<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
								<?php echo custom_soc_login(); ?>
								<button type="submit" class="red-btn">Войти</button>
							</form>
						</div>
					<?php } ?>
				</li>
				<li>
                  <span class="searchform">
                      <span class="search-text"></span>
                  </span>
				</li>
			</ul>
		</nav>
	</div> <!-- end wrap -->

<!-- 	<div class="wrap poputno_tag">
		<ul>
		 	<?php //top_tags();?>
		</ul>
	</div> -->

</header>