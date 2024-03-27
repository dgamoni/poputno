<?php

class acf_field_view extends acf_field
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
        $this->name = 'view';
        $this->label = __("View", 'acf');

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

        echo $field['value'];
    }


}

new acf_field_view();
