<?php

class acf_field_relationship extends acf_field
{
	// vars
	var $defaults;
	
	
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'relationship';
		$this->label = __("Relationship",'acf');
		$this->category = __("Relational",'acf');
		$this->defaults = array(
			'post_type'	=>	array('all'),
			'max' 		=>	'',
			'taxonomy' 	=>	array('all'),
			'filters'	=>	array('search'),
			'result_elements' => array('post_title', 'post_type')
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// extra
		add_action('wp_ajax_acf/fields/relationship/query_posts', array($this, 'query_posts'));
		add_action('wp_ajax_nopriv_acf/fields/relationship/query_posts', array($this, 'query_posts'));
	}
	
	
	/*
   	*  posts_where
   	*
   	*  @description: 
   	*  @created: 3/09/12
   	*/
   	
   	function posts_where( $where, &$wp_query )
	{
	    global $wpdb;
	    
	    if ( $title = $wp_query->get('like_title') )
	    {
	        $where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql( like_escape(  $title ) ) . "%'";
	    }
	    
	    return $where;
	}
	
	
	/*
	*  query_posts
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 27/01/13
	*/
	
	function query_posts()
   	{
   		// vars
		$options = array(
			'post_type'	=> 'all',
			'taxonomy' => 'all',
			'posts_per_page' => 10,
			'paged' => 0,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_status' => array('publish', 'private', 'draft', 'inherit', 'future'),
			'suppress_filters' => false,
			's' => '',
			'lang' => false,
			'update_post_meta_cache' => false,
			'field_key' => '',
			'nonce' => ''
		);
		
		$options = array_merge( $options, $_POST );
		
		
		// validate
		if( !wp_verify_nonce($options['nonce'], 'acf_nonce') )
		{
			die(0);
		}
		
		
		// WPML
		if( $options['lang'] )
		{
			global $sitepress;
			
			$sitepress->switch_lang( $options['lang'] );
		}
		
		
		// convert types
		$options['post_type'] = explode(',', $options['post_type']);
		$options['taxonomy'] = explode(',', $options['taxonomy']);
		
		
		// load all post types by default
		if( in_array('all', $options['post_type']) )
		{
			$options['post_type'] = apply_filters('acf/get_post_types', array());
		}
		
		
		// attachment doesn't work if it is the only item in an array???
		if( is_array($options['post_type']) && count($options['post_type']) == 1 )
		{
			$options['post_type'] = $options['post_type'][0];
		}
		
		
		// create tax queries
		if( ! in_array('all', $options['taxonomy']) )
		{
			// vars
			$taxonomies = array();
			$options['tax_query'] = array();
			
			foreach( $options['taxonomy'] as $v )
			{
				
				// find term (find taxonomy!)
				// $term = array( 0 => $taxonomy, 1 => $term_id )
				$term = explode(':', $v); 
				
				
				// validate
				if( !is_array($term) || !isset($term[1]) )
				{
					continue;
				}
				
				
				// add to tax array
				$taxonomies[ $term[0] ][] = $term[1];
				
			}
			
			
			// now create the tax queries
			foreach( $taxonomies as $k => $v )
			{
				$options['tax_query'][] = array(
					'taxonomy' => $k,
					'field' => 'id',
					'terms' => $v,
				);
			}
		}
		
		unset( $options['taxonomy'] );
		
		
		// search
		if( $options['s'] )
		{
			$options['like_title'] = $options['s'];
			
			add_filter( 'posts_where', array($this, 'posts_where'), 10, 2 );
		}
		
		unset( $options['s'] );
		
		
		// load field
		$field = apply_filters('acf/load_field', false, $options['field_key'] );
		$field = array_merge( $this->defaults, $field );
		
		$the_post = get_post( $options['post_id'] );
		
		
		// filters
		$options = apply_filters('acf/fields/relationship/query', $options, $field, $the_post);
		$options = apply_filters('acf/fields/relationship/query/name=' . $field['name'], $options, $field, $the_post );
		$options = apply_filters('acf/fields/relationship/query/key=' . $field['key'], $options, $field, $the_post );
		
		
		$results = '';
		
		
		// load the posts
		$posts = get_posts( $options );
		
		if( $posts )
		{
			foreach( $posts  as $post )
			{
				// right aligned info
				$title = '<span class="relationship-item-info">';
					
					if( in_array('post_type', $field['result_elements']) )
					{
						$title .= $post->post_type;
					}
					
					// WPML
					if( $options['lang'] )
					{
						$title .= ' (' . $options['lang'] . ')';
					}
					
				$title .= '</span>';
				
				
				// featured_image
				if( in_array('featured_image', $field['result_elements']) )
				{
					$image = get_the_post_thumbnail( $the_post->ID, array(21, 21) );
					
					$title .= '<div class="result-thumbnail">' . $image . '</div>';
				}
				
				
				// find title. Could use get_the_title, but that uses get_post(), so I think this uses less Memory
				$title .= apply_filters( 'the_title', $post->post_title, $post->ID );

				// status
				if($post->post_status != "publish")
				{
					$title .= " ($post->post_status)";
				}
				
				// filters
				$title = apply_filters('acf/fields/relationship/result', $title, $post, $field, $the_post);
				$title = apply_filters('acf/fields/relationship/result/name=' . $field['name'] , $title, $post, $field, $the_post);
				$title = apply_filters('acf/fields/relationship/result/key=' . $field['key'], $title, $post, $field, $the_post);
				
				
				$results .= '<li><a href="' . get_permalink($post->ID) . '" data-post_id="' . $post->ID . '">' . $title .  '<span class="acf-button-add"></span></a></li>';
			}
		}
		
		
		echo $results;
		die();
			
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		// vars
		$field = array_merge($this->defaults, $field);


		// no row limit?
		if( !$field['max'] || $field['max'] < 1 )
		{
			$field['max'] = 9999;
		}
		
		
		// validate post_type
		if( !$field['post_type'] || !is_array($field['post_type']) || in_array('', $field['post_type']) )
		{
			$field['post_type'] = array( 'all' );
		}

		
		// validate taxonomy
		if( !$field['taxonomy'] || !is_array($field['taxonomy']) || in_array('', $field['taxonomy']) )
		{
			$field['taxonomy'] = array( 'all' );
		}
		
		
		// class
		$class = '';
		if( $field['filters'] )
		{
			foreach( $field['filters'] as $filter )
			{
				$class .= ' has-' . $filter;
			}
		}
				
		?>
<div class="acf_relationship<?php echo $class; ?>" data-max="<?php echo $field['max']; ?>" data-s="" data-paged="1" data-post_type="<?php echo implode(',', $field['post_type']); ?>" data-taxonomy="<?php echo implode(',', $field['taxonomy']); ?>" <?php if( defined('ICL_LANGUAGE_CODE') ){ echo 'data-lang="' . ICL_LANGUAGE_CODE . '"';} ?> data-field_key="<?php echo $field['key']; ?>">
	
	<!-- Hidden Blank default value -->
	<input type="hidden" name="<?php echo $field['name']; ?>" value="" />
	
	<!-- Template for value -->
	<script type="text/html" class="tmpl-li">
	<li>
		<a href="#" data-post_id="{post_id}">{title}<span class="acf-button-remove"></span></a>
		<input type="hidden" name="<?php echo $field['name']; ?>[]" value="{post_id}" />
	</li>
	</script>
	<!-- / Template for value -->
	
	<!-- Left List -->
	<div class="relationship_left">
		<table class="widefat">
			<thead>
				<?php if(in_array( 'search', $field['filters']) ): ?>
				<tr>
					<th>
						<label class="relationship_label" for="relationship_<?php echo $field['name']; ?>"><?php _e("Search",'acf'); ?>...</label>
						<input class="relationship_search" type="text" id="relationship_<?php echo $field['name']; ?>" />
						<!-- <div class="clear_relationship_search"></div> -->
					</th>
				</tr>
				<?php endif; ?>
				<?php if(in_array( 'post_type', $field['filters']) ): ?>
				<tr>
					<th>
						<?php 
						
						// vars
						$choices = array(
							'all' => 'Filter by post type'
						);
						
						
						if( in_array('all', $field['post_type']) )
						{
							$post_types = apply_filters( 'acf/get_post_types', array() );
							$choices = array_merge( $choices, $post_types);
						}
						else
						{
							foreach( $field['post_type'] as $post_type )
							{
								$choices[ $post_type ] = $post_type;
							}
						}
						
						
						// create field
						do_action('acf/create_field', array(
							'type'	=>	'select',
							'name'	=>	'',
							'class'	=>	'select-post_type',
							'value'	=>	'',
							'choices' => $choices,
						));
						
						?>
					</th>
				</tr>
				<?php endif; ?>
			</thead>
		</table>
		<ul class="bl relationship_list">
			<li class="load-more">
				<div class="acf-loading"></div>
			</li>
		</ul>
	</div>
	<!-- /Left List -->
	
	<!-- Right List -->
	<div class="relationship_right">
		<ul class="bl relationship_list">
		<?php

		if( $field['value'] )
		{
			foreach( $field['value'] as $post )
			{
				// right aligned info
				$title = '<span class="relationship-item-info">';
					
					if( in_array('post_type', $field['result_elements']) )
					{
						$title .= $post->post_type;
					}
					
					// WPML
					if( defined('ICL_LANGUAGE_CODE') )
					{
						$title .= ' (' . ICL_LANGUAGE_CODE . ')';
					}
					
				$title .= '</span>';
				
				
				// featured_image
				if( in_array('featured_image', $field['result_elements']) )
				{
					$image = get_the_post_thumbnail( $post->ID, array(21, 21) );
					
					$title .= '<div class="result-thumbnail">' . $image . '</div>';
				}
				
				
				// find title. Could use get_the_title, but that uses get_post(), so I think this uses less Memory
				$title .= apply_filters( 'the_title', $post->post_title, $post->ID );

				// status
				if($post->post_status != "publish")
				{
					$title .= " ($post->post_status)";
				}

				
				// filters
				$title = apply_filters('acf/fields/relationship/result', $title, $post);
				$title = apply_filters('acf/fields/relationship/result/name=' . $field['name'] , $title, $post);
				$title = apply_filters('acf/fields/relationship/result/key=' . $field['key'], $title, $post);
				
				
				echo '<li>
					<a href="' . get_permalink($post->ID) . '" class="" data-post_id="' . $post->ID . '">' . $title . '<span class="acf-button-remove"></span></a>
					<input type="hidden" name="' . $field['name'] . '[]" value="' . $post->ID . '" />
				</li>';
				
					
			}
		}
			
		?>
		</ul>
	</div>
	<!-- / Right List -->
	
</div>
		<?php
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// vars
		$field = array_merge($this->defaults, $field);
		$key = $field['name'];
		
		
		// validate taxonomy
		if( !is_array($field['taxonomy']) )
		{
			$field['taxonomy'] = array('all');
		}
		
		
		// validate result_elements
		if( !in_array('post_title', $field['result_elements']) )
		{
			$field['result_elements'][] = 'post_title';
		}
		
		
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label for=""><?php _e("Post Type",'acf'); ?></label>
	</td>
	<td>
		<?php 
		
		$choices = array(
			'all'	=>	__("All",'acf')
		);
		$choices = apply_filters('acf/get_post_types', $choices);
		
		
		do_action('acf/create_field', array(
			'type'	=>	'select',
			'name'	=>	'fields['.$key.'][post_type]',
			'value'	=>	$field['post_type'],
			'choices'	=>	$choices,
			'multiple'	=>	1,
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Filter from Taxonomy",'acf'); ?></label>
	</td>
	<td>
		<?php 
		$choices = array(
			'' => array(
				'all' => __("All",'acf')
			)
		);
		$simple_value = false;
		$choices = apply_filters('acf/get_taxonomies_for_select', $choices, $simple_value);
		
		
		do_action('acf/create_field', array(
			'type'	=>	'select',
			'name'	=>	'fields['.$key.'][taxonomy]',
			'value'	=>	$field['taxonomy'],
			'choices' => $choices,
			'multiple'	=>	1,
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Filters",'acf'); ?></label>
	</td>
	<td>
		<?php 
		do_action('acf/create_field', array(
			'type'	=>	'checkbox',
			'name'	=>	'fields['.$key.'][filters]',
			'value'	=>	$field['filters'],
			'choices'	=>	array(
				'search'	=>	'Search',
				'post_type'	=>	'Post Type Select'
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Elements",'acf'); ?></label>
		<p>Selected elements will be displayed in each result</p>
	</td>
	<td>
		<?php 
		do_action('acf/create_field', array(
			'type'	=>	'checkbox',
			'name'	=>	'fields['.$key.'][result_elements]',
			'value'	=>	$field['result_elements'],
			'choices' => array(
				'featured_image' => 'Featured Image',
				'post_title' => 'Post Title',
				'post_type' => 'Post Type'
			),
			'disabled' => array(
				'post_title'
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Maximum posts",'acf'); ?></label>
	</td>
	<td>
		<?php 
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields['.$key.'][max]',
			'value'	=>	$field['max'],
		));
		?>
	</td>
</tr>
		<?php
		
	}
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value( $value, $post_id, $field )
	{
		// empty?
		if( !$value )
		{
			return $value;
		}
		
		
		// Pre 3.3.3, the value is a string coma seperated
		if( !is_array($value) )
		{
			$value = explode(',', $value);
		}
		
		
		// empty?
		if( empty($value) )
		{
			return $value;
		}
		
		
		// find posts (DISTINCT POSTS)
		$posts = get_posts(array(
			'numberposts' => -1,
			'post__in' => $value,
			'post_type'	=>	apply_filters('acf/get_post_types', array()),
			'post_status' => array('publish', 'private', 'draft', 'inherit', 'future'),
		));

		
		$ordered_posts = array();
		foreach( $posts as $post )
		{
			// create array to hold value data
			$ordered_posts[ $post->ID ] = $post;
		}
		
		
		// override value array with attachments
		foreach( $value as $k => $v)
		{
			// check that post exists (my have been trashed)
			if( !isset($ordered_posts[ $v ]) )
			{
				unset( $value[ $k ] );
			}
			else
			{
				$value[ $k ] = $ordered_posts[ $v ];
			}
		}
		
				
		// return value
		return $value;	
	}
	
	
	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field )
	{
		return $this->format_value( $value, $post_id, $field );
	}
	
}

new acf_field_relationship();

?>