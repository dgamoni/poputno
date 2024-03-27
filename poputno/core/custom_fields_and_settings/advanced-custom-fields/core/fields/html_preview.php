<?php

class acf_field_html_preview extends acf_field
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
        $this->name = 'html_preview';
        $this->label = __("HTML Preview", 'acf');

        // do not delete!
        parent::__construct();


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

    function create_field($field)
    {
        global $post_id;

        $repeater_name = $field['repeater_block'];
        $field_content_name = $field['field_content_html'];

        // Когда поле идет репитером что позволяет добавить массив строк с данными
        if ($repeater_name) {
            $id = explode("[", $field['name']);
            $id = str_replace("]", "", $id[2]);
            $value = get_field($repeater_name, $post_id);
            if (empty($value))
                $value = get_field($repeater_name, 'options');
            $term_id = $value[$id][$field_content_name];
        } else {
            $value = get_field($field_content_name, $post_id);
            if (empty($value))
                $term_id = get_field($field_content_name, 'options');
        }
        if ($term_id) {
            $tag = get_tag($term_id);
            $tag_link = get_term_link($tag);
            echo 'Перейти на страницу тега <a href="' . $tag_link . '" target="_blank">' . $tag->name . '</a>';
        }
    }


}

new acf_field_html_preview();

?>