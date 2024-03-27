<?php

function header_hide_breadcrumbs() {
    global $post;
	$separator = " » "; // Simply change the separator to what ever you need e.g. / or >
	
    echo '<div xmlns:v="http://rdf.data-vocabulary.org/#" style="display:none;">';
	if (!is_front_page()) {
		echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a></span>".$separator;
		if ( is_category() || is_single() ) {
			the_category(', ');
			if ( is_single() ) {
				// echo $separator;
				echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_permalink().'#ain">'.get_the_title().'</a></span>';
			}
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a></span>".$separator;
				}
			}
			echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_permalink().'#ain">'.get_the_title().'</a></span>';
		} elseif (is_page()) {
			echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_permalink().'#ain">'.get_the_title().'</a></span>';
		} elseif (is_404()) {
			echo "404";
		}
	} else {
		echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a></span>';
		echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_bloginfo('url').'/jobs">Работа</a></span>';
		echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_bloginfo('url').'/events">События</a></span>';
		echo '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_bloginfo('url').'/top">Топ</a></span>';
	}
	echo '</div>';
}

?>