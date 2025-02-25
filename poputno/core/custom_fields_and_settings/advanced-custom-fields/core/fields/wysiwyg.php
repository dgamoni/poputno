<?php

class acf_field_wysiwyg extends acf_field
{
	
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
		$this->name = 'wysiwyg';
		$this->label = __("Wysiwyg Editor",'acf');
		$this->category = __("Content",'acf');
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// filters
    	add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'toolbars'), 1, 1 );
	}
	
	
	/*
	*  toolbars()
	*
	*  This filter allowsyou to customize the WYSIWYG toolbars
	*
	*  @param	$toolbars - an array of toolbars
	*
	*  @return	$toolbars - the modified $toolbars
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*/
	
   	function toolbars( $toolbars )
   	{
   		$editor_id = 'acf_settings';
   		
   		
   		// Full
   		$toolbars['Full'] = array();
   		$toolbars['Full'][1] = apply_filters('mce_buttons', array('bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv' ), $editor_id);
   		$toolbars['Full'][2] = apply_filters('mce_buttons_2', array( 'formatselect', 'underline', 'justifyfull', 'forecolor', 'pastetext', 'pasteword', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help', 'code' ), $editor_id);
   		$toolbars['Full'][3] = apply_filters('mce_buttons_3', array(), $editor_id);
   		$toolbars['Full'][4] = apply_filters('mce_buttons_4', array(), $editor_id);
   		
   		
   		// Basic
   		$toolbars['Basic'] = array();
   		$toolbars['Basic'][1] = apply_filters( 'teeny_mce_buttons', array('bold', 'italic', 'underline', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'justifyleft', 'justifycenter', 'justifyright', 'undo', 'redo', 'link', 'unlink', 'fullscreen'), $editor_id );
   		
   		
   		// Custom - can be added with acf/fields/wysiwyg/toolbars filter
   	
   		
	   	return $toolbars;
   	}
   	
   	
   	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add css and javascript to assist your create_field() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
   	
   	function input_admin_head()
   	{
   		add_action( 'admin_footer', array( $this, 'admin_footer') );
   	}
   	
   	function admin_footer()
   	{
	   	?>
<div style="display:none;">
	<?php wp_editor( '', 'acf_settings' ); ?>
</div>
	   	<?php
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
		global $wp_version;
		
		
		// vars
		$defaults = array(
			'toolbar'		=>	'full',
			'media_upload' 	=>	'yes',
		);
		$field = array_merge($defaults, $field);
		
		$id = 'wysiwyg-' . $field['id'] . '-' . uniqid();
		
		
		?>
		<div id="wp-<?php echo $id; ?>-wrap" class="acf_wysiwyg wp-editor-wrap" data-toolbar="<?php echo $field['toolbar']; ?>" data-upload="<?php echo $field['media_upload']; ?>">
			<?php if($field['media_upload'] == 'yes'): ?>
				<?php if( version_compare($wp_version, '3.3', '<') ): ?>
					<div id="editor-toolbar">
						<div id="media-buttons" class="hide-if-no-js">
							<?php do_action( 'media_buttons' ); ?>
						</div>
					</div>
				<?php else: ?>
					<div id="wp-<?php echo $id; ?>-editor-tools" class="wp-editor-tools">
						<div id="wp-<?php echo $id; ?>-media-buttons" class="hide-if-no-js wp-media-buttons">
							<?php do_action( 'media_buttons' ); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div id="wp-<?php echo $id; ?>-editor-container" class="wp-editor-container">
				<textarea id="<?php echo $id; ?>" class="wp-editor-area" name="<?php echo $field['name']; ?>" ><?php echo wp_richedit_pre($field['value']); ?></textarea>
			</div>
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
		$defaults = array(
			'toolbar'		=>	'full',
			'media_upload' 	=>	'yes',
			'default_value'	=>	'',
		);
		
		$field = array_merge($defaults, $field);
		$key = $field['name'];
		
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value",'acf'); ?></label>
	</td>
	<td>
		<?php 
		do_action('acf/create_field', array(
			'type'	=>	'textarea',
			'name'	=>	'fields['.$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Toolbar",'acf'); ?></label>
	</td>
	<td>
		<?php
		
		$toolbars = apply_filters( 'acf/fields/wysiwyg/toolbars', array() );
		$choices = array();
		
		if( is_array($toolbars) )
		{
			foreach( $toolbars as $k => $v )
			{
				$label = $k;
				$name = sanitize_title( $label );
				$name = str_replace('-', '_', $name);
				
				$choices[ $name ] = $label;
			}
		}
		
		do_action('acf/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][toolbar]',
			'value'	=>	$field['toolbar'],
			'layout'	=>	'horizontal',
			'choices' => $choices
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Show Media Upload Buttons?",'acf'); ?></label>
	</td>
	<td>
		<?php 
		do_action('acf/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][media_upload]',
			'value'	=>	$field['media_upload'],
			'layout'	=>	'horizontal',
			'choices' => array(
				'yes'	=>	__("Yes",'acf'),
				'no'	=>	__("No",'acf'),
			)
		));
		?>
	</td>
</tr>
		<?php
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
		// wp_embed convert urls to videos
		if(	isset($GLOBALS['wp_embed']) )
		{
			$embed = $GLOBALS['wp_embed'];
            $value = $embed->run_shortcode( $value );
            $value = $embed->autoembed( $value );
		}
		
		
		// auto p
		$value = wpautop( $value );
		
		
		// run all normal shortcodes
		$value = do_shortcode( $value );
		
	
		return $value;
	}
	
}

new acf_field_wysiwyg();

?>