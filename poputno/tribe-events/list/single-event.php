<?php

/**

 * List View Single Event

 * This file contains one event in the list view

 *

 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php

 *

 * @package TribeEventsCalendar

 * @since  3.0

 * @author Modern Tribe Inc.

 *

 */



if (!defined('ABSPATH')) {

    die('-1');

} ?>



<?php



// Setup an array of venue details for use later in the template

$venue_details = array();



if ($venue_name = tribe_get_meta('tribe_event_venue_name')) {

    $venue_details[] = $venue_name;

}



if ($venue_address = tribe_get_meta('tribe_event_venue_address')) {

    //$venue_details[] = $venue_address;



    $adress = tribe_get_zip($event_id);



    $adress .= tribe_get_country($event_id);



    $adress_city = tribe_get_city($event_id);

    if ($adress && $adress_city)

        $adress .= ', ';



    $adress .= $adress_city;





    $adress_region .= tribe_get_region($event_id);



    if ($adress && $adress_region)

        $adress .= ', ';



    $adress .= $adress_region;





    $adress_addr .= tribe_get_address($event_id);

    if ($adress && $adress_addr)

        $adress .= ', ';



    $adress .= $adress_addr;

}

$address_str = $venue_name;

if ($adress)

    $address_str .= ', ' . $adress;



$start_date = tribe_get_start_date($event, false);

list($d, $m, $y) = explode('.', $start_date);

//$EndFormat = tribe_get_end_date( $event, false, 'Y-m-dTh:i' );

?>









<time datetime="<?php echo $start_date; ?>"><?php echo $d; ?><span>.<?php echo $m; ?></span></time>

<div class="event-content">
<!-- <div class="event-content_po"> -->

    <!-- Event Cost -->

    <?php /*if ( tribe_get_cost() ) : ?>

	<div class="tribe-events-event-cost">

		<span><?php echo tribe_get_cost( null, true ); ?></span>

	</div>

<?php endif;*/

    ?>



    <h3><a href="<?php echo tribe_get_event_link() ?>"><?php the_title() ?></a></h3>

    <?php if ($address_str) { ?>

        <address class="address-marker"><?php echo $address_str; ?></address>

    <?php } ?>

    <div class="txt">

        <?php the_excerpt() ?>

        <a href="<?php echo tribe_get_event_link() ?>" class="more">Подробнее <span>&#8250;</span></a>

    </div>

</div>

