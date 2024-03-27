<?php

//THUMBNAILS IN RSS FEED
function rss_post_thumbnail($content)
{
    global $post, $posts, $more, $feed;
    $more = 0;
    /*
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
    */
    if (is_feed() && $feed != 'yandexfeed') {
        if (has_post_thumbnail($post->ID)) {
            $content = /* '<p><a href="' .get_permalink($post->ID) . '">' . get_the_post_thumbnail($post->ID) . '</a></p>' . */
                the_content('Читать далее &rarr;');
            return $content;
        } else {
            $content = the_content('Читать далее &rarr;');
            return $content;
        }
        return $content;
    }
}

add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

// переименовываем фуфло в профайле пользователя
function rename_contactmethods()
{
    return array(
        'aim' => __('Twitter'),
        'yim' => __('Facebook'),
        'jabber' => __('LinkedIN')
    );
}

add_filter('user_contactmethods', 'rename_contactmethods');


// RENAME WP_MAIL NAME AND EMAIL
// add_filter('wp_mail_from', 'new_mail_from');
// function new_mail_from($old)
// {
//     return 'info@ain.ua';
// }

// add_filter('wp_mail_from_name', 'new_mail_from_name');
// function new_mail_from_name($old)
// {
//     return 'AIN.ua';
// }


// изменение текста в футере админки
function remove_footer_admin()
{
    echo "Работает на <a href='http://wordpress.org'>WordPress</a>&nbsp;&nbsp;|&nbsp;&nbsp;Разработка сайта&nbsp;—&nbsp;<a href='http://decollete.com.ua'>Decollete</a>";
}

//add_filter('admin_footer_text', 'remove_footer_admin');



//  Custom login page
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// function my_login_logo_url_title() {
//     return 'AIN.UA';
// }
//add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_stylesheet() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'template_directory' ) . '/assets/css/style-login.css'; ?>" type="text/css" media="all" />
<?php }

add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


// CHANGING THE LOGO URL & TITLE IN WORDPRESS LOGIN PAGE
// function change_wp_login_url()
// {
    // echo bloginfo('url');
// }

// add_filter('login_headerurl', 'change_wp_login_url');

// function change_wp_login_title()
// {
    // echo get_option('blogname');
// }

// add_filter('login_headertitle', 'change_wp_login_title');


//редіректимо після логіну на профіль
function uni_redirect_after_login($redirect_to, $request, $user)
{
    if (!current_user_can('upload_files')) {
        return get_bloginfo('url') . '/cabinet/';
    }
}

//add_filter('login_redirect', 'uni_redirect_after_login', 10, 3);

// show admin bar only for admins
if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}
// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
    add_filter('show_admin_bar', '__return_false');
}


// не показывать вакансии на главной
// function exclude_category($query)
// {
//     if ($query->is_home) {
//         $query->set('cat', '-1543 -1151 -1548 -1544 -1547 -1545 -1545, -3068');
//     }
//     return $query;
// }

// add_filter('pre_get_posts', 'exclude_category');


// разрешаем хтмл в описании метки
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('term_description', 'wp_kses_data');


add_filter('get_lastpostmodified', 'spoof_lastpostmodified', 10, 2);

function spoof_lastpostmodified($lastpostmodified, $timezone)
{
    global $wp;
    if (!empty($wp->query_vars['feed'])) {
        $lastpostmodified = date("Y-m-d H:i:s"); // Now
    }
    return $lastpostmodified;
}


// Замена сокращения [...] на ссылку Далее...:
if (!function_exists('custom_excerpt_more')) {
    function custom_excerpt_more($more)
    {
        global $post;
        //return '<br><a class="moretag" href="'. get_permalink($post->ID) . '">Читать далее...</a>';
        return '...';
    }

    add_filter('excerpt_more', 'custom_excerpt_more');
}


// Изменение количества символов в анонсе (по умолчанию 55):
if (!function_exists('custom_excerpt_length')) {
    function custom_excerpt_length($length)
    {
        return 20; // В анонсе только первые 20 слов
    }

    add_filter('excerpt_length', 'custom_excerpt_length', 999);
}





// poputno





// Ultimate WP Query Search Filter heirarchy in drop downs

// add_filter('uwpqsf_taxonomy_arg', 'custom_term_output','',1);
// function custom_term_output($args){
// $args['parent'] = '0';
// return $args;
// }

//MODIFY TAXFIELD DROPDOWN OUTPUT TO IDENTIFY AND STYLE CHILD CATEGORIES

// add_filter('uwpqsf_tax_field_dropdown','custom_dropdown_output','',12);
// function custom_dropdown_output($html,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass){

// $args = array('hide_empty'=>$hide,'exclude'=>$eid );
// $taxoargs = apply_filters('uwpqsf_taxonomy_arg',$args,$taxname,$formid);
// $terms = get_terms($taxname,$taxoargs); $count = count($terms);

//              if($type == 'dropdown'){
//             $html  = '<div class="'.$defaultclass.' '.$divclass.' tax-select-'.$c.'"><span class="taxolabel-'.$c.'">'.$taxlabel.'</span>';
//             $html .= '<input  type="hidden" name="taxo['.$c.'][name]" value="'.$taxname.'">';
//             $html .= '<input  type="hidden" name="taxo['.$c.'][opt]" value="'.$opt.'">';
//             $html .=  '<select id="tdp-'.$c.'" name="taxo['.$c.'][term]">';
//             if(!empty($taxall)){
//                 $html .= '<option selected value="uwpqsftaxoall">'.$taxall.'</option>';
//             }
//                     if ( $count > 0 ){
//                         foreach ( $terms as $term ) {
//                      $selected = $terms[0]->term_id;
// $html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';

//     $args = array(
//         'hide_empty'    => false,
//         'hierarchical'  => true,
//         'parent'        => $term->term_id
//     );
//     $childterms = get_terms($taxname, $args);

//     foreach ( $childterms as $childterm ) {
//             $selected = $childterms[0]->term_id;

//         $html .= "<option value='".$childterm->slug."'"."> &nbsp;&nbsp; >"  . $childterm->name . '</option>';

//     }}
//             }
//             $html .= '</select>';
//             $html .= '</div>';

//             return  apply_filters( 'custom_dropdown_output', $html,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass);
//         }

// }



// add post count to search drop downs - Ultimate WP Query Search Filter
// http://9-sec.com/support-forum/?mingleforumaction=viewtopic&t=221



// add_filter('uwpqsf_tax_field_dropdown','add_post_Cgg','',12);
// function add_post_Cgg($html ,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass){
// $eid = explode(",", $exc);
//         $args = array('hide_empty'=>$hide,'exclude'=>$eid );
//         $taxoargs = apply_filters('uwpqsf_taxonomy_arg',$args,$taxname,$formid);
//             $terms = get_terms($taxname,$taxoargs); $count = count($terms);

//             $html = '';
//             $html  .= '<div class="'.$defaultclass.' '.$divclass.' tax-select-'.$c.'"><span class="taxolabel-'.$c.'">'.$taxlabel.'</span>';
//             $html .= '<input  type="hidden" name="taxo['.$c.'][name]" value="'.$taxname.'">';
//             $html .= '<input  type="hidden" name="taxo['.$c.'][opt]" value="'.$opt.'">';
//             $html .=  '<select id="tdp-'.$c.'" name="taxo['.$c.'][term]">';
//             if(!empty($taxall)){
//                 $html .= '<option selected value="uwpqsftaxoall">'.$taxall.'</option>';
//             }

//                         foreach ( $terms as $term ) {
//                         $term_obj = get_term( $term->term_id, $taxname );
//                     $html .= '<option value="'.$term->slug.'">'.$term->name.' ('.$term_obj->count.')</option>';}

//             $html .= '</select>';
//             $html .= '</div>';return $html;

// }


// for checkbox

add_filter('uwpqsf_taxonomy_arg', 'custom_term_output','',1);

function custom_term_output($args){
	$args['parent'] = '0';
	return $args;
}

//add_filter('uwpqsf_tax_field_dropdown','custom_dropdown_output','',12);
//add_filter('uwpqsf_tax_field_checkbox','custom_dropdown_output','',12);
add_filter('uwpqsf_tax_field_radio','custom_dropdown_output','',12);

function custom_dropdown_output($html,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass){

	$args = array('hide_empty'=>$hide,'exclude'=>$eid );
	$taxoargs = apply_filters('uwpqsf_taxonomy_arg',$args,$taxname,$formid);
	$terms = get_terms($taxname,$taxoargs); $count = count($terms);

        if($type == 'dropdown'){

            $html  = '<div class="'.$defaultclass.' '.$divclass.' tax-select-'.$c.'"><span class="taxolabel-'.$c.'">'.$taxlabel.'</span>';
            $html .= '<input  type="hidden" name="taxo['.$c.'][name]" value="'.$taxname.'">';
            $html .= '<input  type="hidden" name="taxo['.$c.'][opt]" value="'.$opt.'">';
            

            $html .=  '<select id="tdp-'.$c.'" name="taxo['.$c.'][term]">';
            
            if(!empty($taxall)){
                $html .= '<option selected value="uwpqsftaxoall">'.$taxall.'</option>';
            }

            if ( $count > 0 ){
                foreach ( $terms as $term ) {
             		$selected = $terms[0]->term_id;
					$html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';

				    $args = array(
				        'hide_empty'    => false,
				        'hierarchical'  => true,
				        'parent'        => $term->term_id
				    );

				    $childterms = get_terms($taxname, $args);

				    foreach ( $childterms as $childterm ) {
				            $selected = $childterms[0]->term_id;

				        $html .= "<option class='child' value='".$childterm->slug."'"."> &nbsp;&nbsp; >"  . $childterm->name . '</option>';

				    }
				}

    		}

            $html .= '</select>';
            $html .= '</div>';

			return  apply_filters( 'custom_dropdown_output', $html,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass);
		}

		//if($type == 'checkbox'){
		if($type == 'radio'){
 			if ( $count > 0 ){
				$html  = '<div class="'.$defaultclass.' '.$divclass.' tax-check-'.$c.' togglecheck"><span  class="taxolabel-'.$c.'">'.$taxlabel.'</span >';
				$html .= '<input  type="hidden" name="taxo['.$c.'][name]" value="'.$taxname.'">';
				$html .= '<input  type="hidden" name="taxo['.$c.'][opt]" value="'.$opt.'">';
				
				if(!empty($taxall)){
				$checkall = (isset($_GET['taxo'][$c]['call']) && $_GET['taxo'][$c]['call'] == '1'  ) ? 'checked="checked"' : '';	
				$html .= '<label><input type="checkbox" id="tchkb-'.$c.'" name="taxo['.$c.'][call]" class="chktaxoall" value="1" '.$checkall.'>'.$taxall.'</label>';
				}



				foreach ( $terms as $term ) {
				
					$value = $term->slug;

					$checked = (isset($_GET['taxo'][$c]['term']) && in_array($value, $_GET['taxo'][$c]['term'])) ? 'checked="checked"' : '';
					//$html .= '<span class="tax_parent"><label class=""><input class="" type="checkbox" id="tchkb-'.$c.'" name="taxo['.$c.'][term][]" value="'.$value.'" '.$checked.'>'.$term->name.'</label></span>';
					$html .= '<span class="tax_parent"><label class="">'.$term->name.'</label></span><br>';
					
					//child
					$args = array(
				        'hide_empty'    => false,
				        'hierarchical'  => true,
				        'parent'        => $term->term_id
				    );

				    $childterms = get_terms($taxname, $args);

				    if ($childterms) {$html .= '<div class="tax_child">';}

				    $html .= '<label class="ch_parent"><input class="" type="checkbox" id="tchkb-'.$c.'" name="taxo['.$c.'][term][]" value="'.$value.'" '.$checked.'>'.$term->name.'</label>';
				    
				    foreach ( $childterms as $childterm ) {
				            $selected = $childterms[0]->term_id;

				        
				        $html .= '<label><input type="checkbox" id="tchkb-'.$c.'" name="taxo['.$c.'][term][]" value="'.$childterm->slug.'" '.$checked.'>'.$childterm->name.'</label>';
				    }

				    if ($childterms) {$html .= '</div>';}
				

				}
				$html .= '</div>';
				return  apply_filters( 'custom_dropdown_output', $html ,$type,$exc,$hide,$taxname,$taxlabel,$taxall,$opt,$c,$defaultclass,$formid,$divclass);
			}
 			
		}//end check

}
