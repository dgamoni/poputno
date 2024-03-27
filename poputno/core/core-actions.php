<?php

// ------------for filter



add_action('uwpqsf_form_bottom', 'taxonomy_hidden_field');
    function taxonomy_hidden_field($attr){

    if( is_category('events') ){ 
        $html = '';
        //$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        //$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
        {
        $html .= '<input type="hidden" name="taxo[99][name]" value="category">';//taxonomy
        $html .= '<input type="hidden" name="taxo[99][opt]" value="3">';// 1 is IN, 2 is NOT In, 3 is AND
        $html .= '<input type="hidden" name="taxo[99][term]" value="events">';//the term
        }
        echo $html;
    }

    if( is_category('places') ){ 
        $html = '';
        //$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        //$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
        {
        $html .= '<input type="hidden" name="taxo[99][name]" value="category">';//taxonomy
        $html .= '<input type="hidden" name="taxo[99][opt]" value="3">';// 1 is IN, 2 is NOT In, 3 is AND
        $html .= '<input type="hidden" name="taxo[99][term]" value="places">';//the term
        }
        echo $html;
    }

    if( is_category('lajfhaki') ){ 
        $html = '';
        //$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        //$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
        {
        $html .= '<input type="hidden" name="taxo[99][name]" value="category">';//taxonomy
        $html .= '<input type="hidden" name="taxo[99][opt]" value="3">';// 1 is IN, 2 is NOT In, 3 is AND
        $html .= '<input type="hidden" name="taxo[99][term]" value="lajfhaki">';//the term
        }
        echo $html;
    }

    if( is_category('gadgets') ){ 
        $html = '';
        //$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        //$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
        {
        $html .= '<input type="hidden" name="taxo[99][name]" value="category">';//taxonomy
        $html .= '<input type="hidden" name="taxo[99][opt]" value="3">';// 1 is IN, 2 is NOT In, 3 is AND
        $html .= '<input type="hidden" name="taxo[99][term]" value="gadgets">';//the term
        }
        echo $html;
    }


}

//----------------------------
add_action('wp_head', 'fb_like_thumbnails');

function fb_like_thumbnails()
{
    global $posts;
    $default = '/images/logo.png';

    $content = $posts[0]->post_content; // $posts is an array, fetch the first element
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    if ($output > 0) {
        $thumb = $matches[1][0];
    } else {
        $thumb = $default;
    }

    echo "\n\n<!-- Facebook Like Thumbnail -->\n<link rel=\"image_src\" href=\"$thumb\" />\n<!-- End Facebook Like Thumbnail -->\n\n";
}

// разрешаем участникам загружать картинки
if (current_user_can('contributor') && !current_user_can('upload_files')) {
    add_action('admin_init', 'allow_contributor_uploads');
}

function allow_contributor_uploads()
{
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}


//закриваємо доступ до вп-адмін для юзеров ниже контрибутора
add_action('admin_init', 'uni_redirect_nonadmin', 1);
function uni_redirect_nonadmin()
{
    $isAjax = (defined('DOING_AJAX') && true === DOING_AJAX) ? true : false;
    global $current_user;
    get_currentuserinfo();
    $sUserRole = $current_user->roles[0];
    if (!$isAjax) {
        if (($sUserRole == 'subscriber')) {
            wp_safe_redirect(get_bloginfo('url') . '/profile/?profile=edit');
            exit;
        }
    }
}


add_action("gform_pre_submission_2", "format_ecp_event_meta_from_gravity");

function format_ecp_event_meta_from_gravity()
{

    /*  VARIABLES - The following variables should correspond to their respective GF form elements IDs */

    // All day event
    $eventAllDay = 3;

    // Start and end dates (and times if the event is not all day)
    $startDateFormId = 4;
    $startTimeFormId = 5;
    $endDateFormId = 6;
    $endTimeFormId = 7;

    // Event recurrence type
    $recType = 8;

    // Recurrence ends "On" a speceific date or "After" a certain number of occurrences
    $recEndType = 9;

    // End date for event recurrence (if "On" is selected)
    $recEnd = 10;

    // A different "After" multiplier exists for each possible recurrence type (if "After" is selected)
    $recEndCounts = array(
        'Every Day' => 11,
        'Every Week' => 12,
        'Every Month' => 13,
        'Every Year' => 14,
    );

    // Venue details
    $venueName = 18;
    $venueAddress = 19;
    $venueCity = 20;
    $venueCountry = 21;

    // for neither US or Canada, use province text field
    $venueProvince = 22;

    // for US, use state dropdown (two letter values have been added to match ECP meta)
    $venueState = 23;

    // for Canada, use province/territory dropdown
    $venueCaProvince = 24;

    $venueZip = 25;
    $venuePhone = 36;

    // Google Maps
    $showGoogleMapLink = 26;
    $showGoogleMap = 27;

    //Organizer details
    $organizerName = 29;
    $organizerPhone = 30;
    $organizerWebsite = 31;
    $organizerEmail = 32;

    /*  DATE & TIME FORMATTING - Format the date and time from GF to match ECP meta */

    // break the dates into arrays
    $startDate = date_parse($_POST['input_' . $startDateFormId]);
    $endDate = date_parse($_POST['input_' . $endDateFormId]);

    // sql format the result
    $startDateString = $startDate['year'] . '-' . str_pad($startDate['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($startDate['day'], 2, "0", STR_PAD_LEFT);
    $endDateString = $endDate['year'] . '-' . str_pad($endDate['month'], 2, "0", STR_PAD_LEFT) . '-' . str_pad($endDate['day'], 2, "0", STR_PAD_LEFT);

    // get the start/end times
    $startTime = $_POST['input_' . $startTimeFormId];
    $endTime = $_POST['input_' . $endTimeFormId];

    /* SET ECP FORM VALUES - Set the ECP form values to match their respective GF fields */

    $_POST['EventAllDay'] = $_POST['input_' . $eventAllDay];

    $_POST['EventStartDate'] = $startDateString;
    $_POST['EventStartHour'] = str_pad($startTime[0], 2, "0", STR_PAD_LEFT);
    $_POST['EventStartMinute'] = str_pad($startTime[1], 2, "0", STR_PAD_LEFT);
    $_POST['EventStartMeridian'] = $startTime[2];

    $_POST['EventEndDate'] = $endDateString;
    $_POST['EventEndHour'] = str_pad($endTime[0], 2, "0", STR_PAD_LEFT);
    $_POST['EventEndMinute'] = str_pad($endTime[1], 2, "0", STR_PAD_LEFT);
    $_POST['EventEndMeridian'] = $endTime[2];

    $_POST['recurrence']['type'] = $_POST['input_' . $recType];
    $_POST['recurrence']['end-type'] = $_POST['input_' . $recEndType];
    $_POST['recurrence']['end'] = $_POST['input_' . $recEnd];

    // Match the correct recurrence multiplier with the correct recurrence type
    foreach ($recEndCounts as $recTypeName => $recEndCount) {
        if ($_POST['input_' . $recType] == $recTypeName) {
            $_POST['recurrence']['end-count'] = $_POST['input_' . $recEndCount];
        }
    }

    // Check for the existence of the submitted venue and organization by title
    $savedVenue = get_page_by_title($_POST['input_' . $venueName], 'OBJECT', 'tribe_venue');
    $savedOrganizer = get_page_by_title($_POST['input_' . $organizerName], 'OBJECT', 'tribe_organizer');

    // If the venue already exists, pass along the exising venue ID
    if (isset($savedVenue)) {
        $_POST['venue']['VenueID'] = $savedVenue->ID;
        // If the venue doesn't exist, pass the venue meta needed to create a new venue
    } else {
        // Required for venue info to be stored
        $_POST['EventVenue'] = $_POST['input_' . $venueName];
        $_POST['post_title'] = $_POST['input_' . $venueName];

        // Pass remaining venue meta
        $_POST['venue']['Venue'] = $_POST['input_' . $venueName];
        $_POST['venue']['Address'] = $_POST['input_' . $venueAddress];
        $_POST['venue']['City'] = $_POST['input_' . $venueCity];
        $_POST['venue']['Country'] = $_POST['input_' . $venueCountry];
        // Ensure that the correct state or province field is populated
        switch ($_POST['input_' . $venueCountry]) {
            case 'United States':
                $_POST['venue']['State'] = $_POST['input_' . $venueState];
                break;
            case 'Canada':
                $_POST['venue']['Province'] = $_POST['input_' . $venueCaProvince];
                break;
            default:
                $_POST['venue']['Province'] = $_POST['input_' . $venueProvince];
                break;
        }
        $_POST['venue']['Zip'] = $_POST['input_' . $venueZip];
        $_POST['venue']['Phone'] = $_POST['input_' . $venuePhone];
    }

    // Pass google maps meta
    $_POST['EventShowMapLink'] = $_POST['input_' . $showGoogleMapLink];
    $_POST['EventShowMap'] = $_POST['input_' . $showGoogleMap];

    // If the organizer already exists, pass along the exising organizer ID
    if (isset($savedOrganizer)) {
        $_POST['organizer']['OrganizerID'] = $savedOrganizer->ID;
    } else {
        // If the organizer doesn't exist, pass the organizer meta needed to create a new organizer
        $_POST['organizer']['Organizer'] = $_POST['input_' . $organizerName];
        $_POST['organizer']['Phone'] = $_POST['input_' . $organizerPhone];

        //If the user doesn't put in a web address we want to make the website '' instead of 'http://' since that's what Gravity Forms adds by default
        $_POST['organizer']['Website'] = $_POST['input_' . $organizerWebsite] == 'http://' ? '' : $_POST['input_' . $organizerWebsite];

        $_POST['organizer']['Email'] = $_POST['input_' . $organizerEmail];
    }
}


// Store the new form values as ECP metadata when saving
add_action('save_post', 'save_ecp_event_meta_from_gravity', 11, 2);

function save_ecp_event_meta_from_gravity($postId, $post)
{
    if (class_exists('TribeEvents')) {

        // only continue if it's an event post
        if ($post->post_type != TribeEvents::POSTTYPE || defined('DOING_AJAX')) {
            return;
        }

        // don't do anything on autosave or auto-draft either or massupdates
        //if ( wp_is_post_autosave( $postId ) || isset($_GET['bulk_edit']) )
        if (wp_is_post_autosave($postId) || $post->post_status == 'auto-draft' || isset($_GET['bulk_edit']) || $_REQUEST['action'] == 'inline-save') {
            return;
        }

        if (class_exists('TribeEventsAPI')) {
            $_POST['Organizer'] = stripslashes_deep($_POST['organizer']);
            $_POST['Venue'] = stripslashes_deep($_POST['venue']);
            $_POST['Recurrence'] = stripslashes_deep($_POST['recurrence']);

            if (!empty($_POST['Venue']['VenueID'])) {
                $_POST['Venue'] = array('VenueID' => $_POST['Venue']['VenueID']);
            }

            if (!empty($_POST['Organizer']['OrganizerID'])) {
                $_POST['Organizer'] = array('OrganizerID' => $_POST['Organizer']['OrganizerID']);
            }

            TribeEventsAPI::saveEventMeta($postId, $_POST, $post);
        }
    }
}


//лента дял яндекса
function yafeed()
{
    load_template(TEMPLATEPATH . '/feed-yandexfeed.php');
}

add_action('do_feed_yandexfeed', 'yafeed', 10, 1);

function search_url_rewrite()
{
    if (is_search() && !empty($_GET['s'])) {
        wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
        exit();
    }
}

add_action('template_redirect', 'search_url_rewrite');

function sl_dashboard_tweaks_render()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
    $wp_admin_bar->remove_menu('all-in-one-seo-pack');
    $wp_admin_bar->remove_menu('comments'); // optional, delete comments as many websites don't even have those enabled.
}

add_action('wp_before_admin_bar_render', 'sl_dashboard_tweaks_render');


function tag_with_ads_pre_get_posts($query)
{
    if ((is_author() || is_tag()) && $query->is_main_query()) {
        // $query->set('posts_per_page', 16);
        $query->set('posts_per_page', 15);
    }
}

add_action('pre_get_posts', 'tag_with_ads_pre_get_posts');

function excluded_pre_get_posts($query)
{
    if (is_home() && $query->is_main_query() && !is_paged()) {
        // $query->set('posts_per_page', 16);
        $query->set('posts_per_page', 15);
        $excluded = get_excluded_posts_fog_loops();
        //set_query_var( 'post__not_in', $excluded );
        $query->set('post__not_in', $excluded);
    } elseif (is_home() && $query->is_main_query() && is_paged()) {
        $query->set('posts_per_page', 15);
        $excluded = get_excluded_posts_fog_loops(4);
        $query->set('post__not_in', $excluded);
    } elseif (is_category() && $query->is_main_query() && !is_paged()) {
        // $query->set('posts_per_page', 16);
        $query->set('posts_per_page', 15);

        //$excluded = get_excluded_posts_fog_loops (2);
        //$query->set ( 'post__not_in', $excluded );
        $query->set('offset', 2);

    } elseif (is_category() && $query->is_main_query() && is_paged()) {
        $query->set('posts_per_page', 15);

        $page = get_query_var('paged') ? get_query_var('paged') : 1;

        $offset = ($page - 1) * 15 + 3;

        $query->set('offset', $offset);

        //$excluded = get_excluded_posts_fog_loops ( 4 );
        //$query->set ( 'post__not_in', $excluded );
    }
}

//add_action('pre_get_posts', 'excluded_pre_get_posts');



function excluded_pre_get_posts_2($query)
{
    


    if (is_home() && $query->is_main_query() && !is_paged()) {
        $query->set('posts_per_page', 15);
        $excluded = exclude_posts_for_main_query_f();
        $query->set('post__not_in', $excluded);
        $query->set('ignore_sticky_posts', 1);
        

    } elseif (is_home() && $query->is_main_query() && is_paged()) {
        $query->set('posts_per_page', 15);
        $excluded = exclude_posts_for_main_query_f();
        $query->set('post__not_in', $excluded);
        $query->set('ignore_sticky_posts', 1);

    } elseif (is_category() && $query->is_main_query() && !is_paged()) {
        $query->set('posts_per_page', 15);
        $excluded = exclude_posts_for_main_query_f();
        $query->set('post__not_in', $excluded);
        $query->set('ignore_sticky_posts', 1);

    } elseif (is_category() && $query->is_main_query() && is_paged()) {
        $query->set('posts_per_page', 15);
        $excluded = exclude_posts_for_main_query_f();
        $query->set('post__not_in', $excluded);
        $query->set('ignore_sticky_posts', 1);
    } 
}
add_action('pre_get_posts', 'excluded_pre_get_posts_2');
