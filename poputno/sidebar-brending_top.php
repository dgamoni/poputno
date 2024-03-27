<?php
	global $brending_pages_tag_id;
	if ( isset( $_GET['debug'] ) ) {
		echo $brending_pages_tag_id;
	}
	if ( is_active_sidebar( 'brending_sidebar_' . $brending_pages_tag_id ) ) :
		dynamic_sidebar( 'brending_sidebar_' . $brending_pages_tag_id );
	endif;

