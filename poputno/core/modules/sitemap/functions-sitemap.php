<?php

	function get_sitemap_archives_year() {


		global $wpdb;


		$query = "SELECT post_status, post_date, DATE_FORMAT(post_date, '%Y') as year FROM $wpdb->posts ";

		$where = " WHERE 1=1 AND post_status = 'publish' ";


		if ( $post_type_custom = get_param_custom_category() ) {
			$where .= " AND post_type = '$post_type_custom' ";
		} elseif ( $cat_slug = get_param_category() ) {

			$where .= " AND post_type = 'post' ";

			//        $where .= " AND ID IN (SELECT object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id
			//                   IN (SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = $cat) ";


		} else {
			$where .= " AND post_type IN ('post','tribe_events','univac_vacancy') ";

		}

		$order = " GROUP BY Year(post_date) ORDER BY Year(post_date) ASC ";

		$posts = $wpdb->get_results( $query . ' ' . $where . ' ' . $order );

		$years = array();
		foreach ( $posts as $item ) {
			$years[ $item->year ] = 1;
		}
		ksort( $years );
		foreach ( $years as $year => $val ) {
			if ( get_param_year() == $year ) {
				echo '<span>' . $year . '&nbsp;&nbsp;</span>';
			} else {
				echo '<a href="' . get_bloginfo( 'url' ) . '/sitemap/' . ( get_param_category() ? get_param_category() . '/' : '' ) . $year . '">' . $year . '</a>&nbsp;&nbsp;';
			}
		}

	}

	function get_sitemap_archives_month() {

		global $wpdb;


		$query = "SELECT post_status, post_date, DATE_FORMAT(post_date, '%m') as month FROM $wpdb->posts ";

		$where = " WHERE 1=1 AND post_status = 'publish' ";


		if ( $post_type_custom = get_param_custom_category() ) {
			$where .= " AND post_type = '$post_type_custom' ";
		} elseif ( $cat_slug = get_param_category() ) {

			$where .= " AND post_type = 'post' ";

			//        $where .= " AND ID IN (SELECT object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id
			//                   IN (SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = $cat) ";


		} else {
			$where .= " AND post_type IN ('post','tribe_events','univac_vacancy') ";

		}

		$order = " GROUP BY Month(post_date) ORDER BY Month(post_date) ASC ";

		$posts = $wpdb->get_results( $query . ' ' . $where . ' ' . $order );

		$months = array();
		foreach ( $posts as $item ) {
			$months[ $item->month ] = 1;
		}
		//wp_reset_postdata();
		ksort( $months );
		foreach ( $months as $month => $val ) {
			if ( get_param_month() == $month ) {
				echo '<span>' . sitemap_get_month_name( $month ) . '&nbsp;&nbsp;</span>';
			} else {
				echo '<a href="' . get_bloginfo( 'url' ) . '/sitemap/' . ( get_param_category() ? get_param_category() . '/' : '' ) . get_param_year() . '/' . $month . '">' . sitemap_get_month_name( $month ) . '</a>&nbsp;&nbsp;';
			}
		}
	}


	function get_custom_category() {

		$cats = array( 'Работа' => 'jobs', 'События' => 'events' );
		foreach ( $cats as $name => $val ) {
			if ( get_param_category() == $val ) {
				echo '<span>' . $name . '&nbsp;&nbsp;</span>';
			} else {
				echo '<a href="' . get_bloginfo( 'url' ) . '/sitemap/' . $val . '">' . $name . '</a>&nbsp;&nbsp;';
			}
		}
	}

	function get_list_category() {

		$terms = get_terms( 'category' );
		//$href = $_SERVER[''];
		foreach ( $terms as $item ) {
			//$link = add_query_arg('orderby', 'date');
			if ( get_param_category() == $item->slug ) {
				echo '<span>' . $item->name . '&nbsp;&nbsp;</span>';
			} else {
				echo '<a href="' . get_bloginfo( 'url' ) . '/sitemap/' . $item->slug . '">' . $item->name . '</a>&nbsp;&nbsp;';
			}
		}
	}


	function sitemap_pagination( $wp_query = '', $paged = 1, $range = 4 ) {

		$showitems = ( $range * 2 ) + 1;


		$pages = $wp_query->max_num_pages;

		if ( 1 != $pages ) {
			echo '<br>';
			echo '<div style="width: 200px;margin: 0 auto;">';
			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					echo ( $paged == $i ) ? '&nbsp;&nbsp;<span>' . $i . '</span>&nbsp;&nbsp;' : '&nbsp;&nbsp;<a href="' . get_pagenum_link( $i ) . '" ><span>' . $i . '</a>&nbsp;&nbsp;';
				}
			}
			echo '</div>';
		}
	}

	function sitemap_get_month_name( $n ) {

		$n = intval( $n );

		$month = array(
			'1'  => 'Январь',
			'2'  => 'Февраль',
			'3'  => 'Март',
			'4'  => 'Апрель',
			'5'  => 'Май',
			'6'  => 'Июнь',
			'7'  => 'Июль',
			'8'  => 'Август',
			'9'  => 'Сентябрь',
			'10' => 'Октябрь',
			'11' => 'Ноябрь',
			'12' => 'Декабрь',
		);

		return strtr( $n, $month );
	}

	function get_param_sitemap() {

		$param = explode( '/', $_SERVER['REQUEST_URI'] );
		$param = array_diff( $param, array( '' ) );

		return $param;
	}

	// главная страница сайтмапа
	function is_sitemap_home() {

		if ( count( get_param_sitemap() ) == 1 ) {
			return true;
		}

		return false;
	}

	// получим из передаваемых параметров категорию или событие или работу
	function get_param_category() {

		$param = get_param_sitemap();
		if ( $param[2] ) {
			if ( ! intval( $param[2] ) ) {
				return $param[2];

			}
		}
	}

	function get_param_custom_category() {

		$category = get_param_category();
		if ( $category ) {
			if ( $category == 'jobs' ) {
				return 'univac_vacancy';
			} elseif ( $category == 'events' ) {
				return 'tribe_events';
			}

		}
	}


	function get_param_year() {

		$param = get_param_sitemap();
		if ( $param[2] ) {
			if ( intval( $param[2] ) && strlen( $param[2] ) == 4 ) {
				return $param[2];
			} elseif ( intval( $param[3] ) && strlen( $param[3] ) == 4 ) {
				return $param[3];
			}
		}

		return date( 'Y' );
	}

	function get_param_month() {

		$param = get_param_sitemap();
		if ( intval( $param[3] ) && strlen( $param[3] ) == 2 ) {
			return $param[3];
		} elseif ( intval( $param[4] ) && strlen( $param[4] ) == 2 ) {
			return $param[4];
		}
	}

	/*
	параметры в строке браузера
	 Array
	(
		[1] => sitemap - корень сайтмапа
		[2] => gov - категория или кастомный постайп (Работа, Событие)
		[3] => 2014 (Год архива)
		[4] => 08 - месяц архива
		[5] => page - пагинация страницы
		[6] => 1 - текущая страница пагинации
	)

	 * */

	function get_param_paged() {

		$param = get_param_sitemap();
		if ( $param[3] == 'page' ) {
			return $param[4];
		} elseif ( $param[4] == 'page' ) {
			return $param[5];
		} elseif ( $param[5] == 'page' ) {
			return $param[6];
		}

		return 1;
	}