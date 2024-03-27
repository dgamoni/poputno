<?php
	// DRAFT DASHBOARD WIDGET
	add_action('wp_dashboard_setup', 'custom_drafts_widget_add');

	function custom_drafts_widget_add() {
		wp_add_dashboard_widget('custom_drafts_widget', 'Черновики записей', 'custom_drafts_widget');
	}

	function custom_drafts_widget(){
		echo '<ol>';
		$recent = new WP_Query("showposts=20&post_status=draft&post_type=any");
		while($recent->have_posts()) : $recent->the_post();
		
			$post_type = get_post_type();
			
			if ($post_type == 'post') {
				$post_type_name = 'Запись';
			} else if ($post_type == 'univac_vacancy') {
				$post_type_name = 'Вакансия';
			} else if ($post_type == 'tribe_events') {
				$post_type_name = 'Событие';
			} else if ($post_type == 'page') {
				$post_type_name = 'Страница';
			}

			echo '<li>';
			echo '<a href="' . get_bloginfo('home') . '/wp-admin/post.php?post='. get_the_ID() .'&action=edit">';
			echo the_title();
			echo '</a>';
			echo '&nbsp;&nbsp;&nbsp;—&nbsp;&nbsp;&nbsp;' . $post_type_name;
			echo '</li>';
	
		endwhile;
		echo '<ol></ol>';
	}
	
	// DISABLE DEFAULT DASHBOARD WIDGETS
	function disable_default_dashboard_widgets() {
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	//remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	//remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	//remove_meta_box('dashboard_primary', 'dashboard', 'core');
	//remove_meta_box('dashboard_secondary', 'dashboard', 'core');
	}
	add_action('admin_menu', 'disable_default_dashboard_widgets');
?>