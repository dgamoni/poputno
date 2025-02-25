<?php

/**

 * Event Submission Form Metabox For Recurrence

 * This is used to add a metabox to the event submission form to allow for choosing or

 * creating recurrences of user submitted events.

 *

 * Override this template in your own theme by creating a file at

 * [your-theme]/tribe-events/community/modules/recurrence.php

 *

 * @package TribeCommunityEvents

 * @since  2.1

 * @author Modern Tribe Inc.

 *

 */



if (!defined('ABSPATH')) {

    die('-1');

}



global $post;

$post_id = isset($post->ID) ? $post->ID : null;



if ($post_id) {

    // convert array to variables that can be used in the view

    extract(TribeEventsRecurrenceMeta::getRecurrenceMeta($post_id));

} else {

    // create variables that can be used in the view

    $recType = 'None';

    $recEndType = '';

    $recEnd = '';

    $recEndCount = '';

    $recCustomType = '';

    $recCustomInterval = '';

    $recCustomTypeText = '';

    $recOccurrenceCountText = '';

    $recCustomWeekDay = array(); //array

    $recCustomMonthNumber = '';

    $recCustomMonthDay = 1;

    $recCustomYearFilter = '';

    $recCustomYearMonthNumber = '';

    $recCustomYearMonthDay = '';

    $recCustomYearMonth = array(); //array



    if (isset($_POST['recurrence']['type']))

        $recType = $_POST['recurrence']['type'];

    if (isset($_POST['recurrence']['end-type']))

        $recEndType = $_POST['recurrence']['end-type'];

    if (isset($_POST['recurrence']['end']))

        $recEnd = $_POST['recurrence']['end'];

    if (isset($_POST['recurrence']['end-count']))

        $recEndCount = $_POST['recurrence']['end-count'];

    if (isset($_POST['recurrence']['custom-type']))

        $recCustomType = $_POST['recurrence']['custom-type'];

    if (isset($_POST['recurrence']['custom-interval']))

        $recCustomInterval = $_POST['recurrence']['custom-interval'];

    if (isset($_POST['recurrence']['custom-type-text']))

        $recCustomTypeText = $_POST['recurrence']['custom-type-text'];

    if (isset($_POST['recurrence']['occurrence-count-text']))

        $recOccurrenceCountText = $_POST['recurrence']['occurrence-count-text'];

    if (isset($_POST['recurrence']['custom-week-day']))

        $recCustomWeekDay = $_POST['recurrence']['custom-week-day']; //array

    if (isset($_POST['recurrence']['custom-month-number']))

        $recCustomMonthNumber = $_POST['recurrence']['custom-month-number'];

    if (isset($_POST['recurrence']['custom-month-day']))

        $recCustomMonthDay = $_POST['recurrence']['custom-month-day'];

    if (isset($_POST['recurrence']['custom-year-filter']))

        $recCustomYearFilter = $_POST['recurrence']['custom-year-filter'];

    if (isset($_POST['recurrence']['custom-year-month-number']))

        $recCustomYearMonthNumber = $_POST['recurrence']['custom-year-month-number'];

    if (isset($_POST['recurrence']['custom-year-month-day']))

        $recCustomYearMonthDay = $_POST['recurrence']['custom-year-month-day'];

    if (isset($_POST['recurrence']['custom-year-month']))

        $recCustomYearMonth = $_POST['recurrence']['custom-year-month']; //array

} ?>



<tr class="recurrence-row">
<!-- 
    <td colspan="2">
        <label><?php _e('Повторение:', 'tribe-events-community'); ?></label>
          <?php $has_recurrences = (count(get_post_meta($post_id, '_EventStartDate')) > 1) ? true : false; ?>

        <input type="hidden" name="is_recurring"

               value="<?php echo (isset($recType) && $recType != "None" && $has_recurrences) ? "true" : "false" ?>"/>

        <input type="hidden" name="recurrence_action" value=""/>



        <select name="recurrence[type]">

            <option data-plural=""

                    value="None" <?php selected($recType, 'None'); ?>><?php _e('Выбрать ...', 'tribe-events-community'); ?></option>

            <option data-single="day" data-plural="days"

                    value="Every Day" <?php selected($recType, 'Every Day'); ?>><?php _e('Каждый день', 'tribe-events-community'); ?></option>

            <option data-single="week" data-plural="weeks"

                    value="Every Week" <?php selected($recType, 'Every Week'); ?>><?php _e('Каждую неделю', 'tribe-events-community'); ?></option>

            <option data-single="month" data-plural="months"

                    value="Every Month" <?php selected($recType, 'Every Month'); ?>><?php _e('Каждый месяц', 'tribe-events-community'); ?></option>

            <option data-single="year" data-plural="years"

                    value="Every Year" <?php selected($recType, 'Every Year'); ?>><?php _e('Каждый год', 'tribe-events-community'); ?></option>

            <option data-single="event" data-plural="events"

                    value="Custom" <?php selected($recType, 'Custom'); ?>><?php _e('Настраиваемое', 'tribe-events-community'); ?></option>

        </select>



        <span id="recurrence-end" style="display: <?php echo !$recType || $recType == 'None' ? 'none' : 'inline' ?>">

           <label for=""> <?php _e(' Окончание', 'tribe-events-community'); ?></label>



            <select name="recurrence[end-type]">

                <option

                    value="On" <?php selected($recEndType, 'None'); ?>><?php _e('На', 'tribe-events-community'); ?></option>

                <option

                    value="After" <?php selected($recEndType, 'After'); ?>><?php _e('После', 'tribe-events-community'); ?></option>

                <option

                    value="Never" <?php selected($recEndType, "Never") ?>><?php _e('Никогда', 'tribe-events-community'); ?></option>

            </select>



            <input autocomplete="off"

                   placeholder="<?php echo TribeDateUtils::dateOnly(date(TribeDateUtils::DBDATEFORMAT)); ?>"

                   type="text" id="recurrence_end" class="datepicker" name="recurrence[end]"

                   value="<?php echo $recEnd; ?>"

                   style="display:<?php echo !$recEndType || $recEndType == 'On' ? 'inline' : 'none'; ?>"/>



            <span id="rec-count" style="display:<?php echo $recEndType == 'After' ? 'inline' : 'none'; ?>">

                <input autocomplete="off" type="text" name="recurrence[end-count]" id="recurrence_end_count"

                       value="<?php echo $recEndCount ? $recEndCount : 1 ?>" style="width: 40px;"/>

                <span id="occurence-count-text">

                    <?php echo isset($recOccurrenceCountText) ? $recOccurrenceCountText : ''; ?>

                </span>

            </span>



            <span id="rec-end-error" class="rec-error">

                <?php _e('You must select a recurrence end date', 'tribe-events-community'); ?>

            </span>



        </span>
    </td>
 -->
  

</tr><!-- .recurrence-row -->



<tr class="recurrence-row" id="custom-recurrence-frequency"

    style="display: <?php echo $recType == 'Custom' ? 'table-row' : 'none' ?>;">

    

    <td colspan="2">

       <label for=""> <?php _e('Периодичность', 'tribe-events-community'); ?></label>

        <select name="recurrence[custom-type]">

            <option value="Daily" data-plural="<?php _e('Дней', 'tribe-events-community'); ?>"

                    data-tablerow="" <?php selected($recCustomType, 'None'); ?>><?php _e('Ежедневно', 'tribe-events-community'); ?></option>

            <option value="Weekly" data-plural="<?php _e('Недель в:', 'tribe-events-community'); ?>"

                    data-tablerow="#custom-recurrence-weeks" <?php selected($recCustomType, 'Weekly'); ?>><?php _e('Еженедельно', 'tribe-events-community'); ?></option>

            <option value="Monthly" data-plural="<?php _e('Месяцев в:', 'tribe-events-community'); ?>"

                    data-tablerow="#custom-recurrence-months" <?php selected($recCustomType, 'Monthly'); ?>><?php _e('Ежемесячно', 'tribe-events-community'); ?></option>

            <option value="Yearly" data-plural="<?php _e('Год в:', 'tribe-events-community'); ?>"

                    data-tablerow="#custom-recurrence-years" <?php selected($recCustomType, 'Yearly'); ?>><?php _e('Ежегодно', 'tribe-events-community'); ?></option>

        </select>



       <label for=""> <?php _e('Каждые', 'tribe-events-community'); ?></label>



        <input type="text" name="recurrence[custom-interval]" value="<?php echo $recCustomInterval; ?>"/> <span

            id="recurrence-interval-type"><?php echo $recCustomTypeText; ?></span>

        <input type="hidden" name="recurrence[custom-type-text]" value="<?php echo esc_attr($recCustomTypeText); ?>"/>

        <input type="hidden" name="recurrence[occurrence-count-text]"

               value="<?php echo esc_attr($recOccurrenceCountText); ?>"/>

    </td>

</tr><!-- .recurrence-row -->



<?php if (!isset($recCustomWeekDay)) $recCustomWeekDay = array(); ?>

<tr id="custom-recurrence-weeks" class="custom-recurrence-row"

    style="display: <?php echo $recType == 'Custom' && $recCustomType == 'Weekly' ? 'table-row' : 'none' ?>;">

    <td></td>

    <td>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="1" <?php checked(in_array('1', $recCustomWeekDay)); ?>/> <?php _e('ВС', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="2" <?php checked(in_array('2', $recCustomWeekDay)); ?>/> <?php _e('ПН', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="3" <?php checked(in_array('3', $recCustomWeekDay)); ?>/> <?php _e('ВТ', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="4" <?php checked(in_array('4', $recCustomWeekDay)); ?>/> <?php _e('СР', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="5" <?php checked(in_array('5', $recCustomWeekDay)); ?>/> <?php _e('ЧТ', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="6" <?php checked(in_array('6', $recCustomWeekDay)); ?>/> <?php _e('ПТ', 'tribe-events-community'); ?>

        </label>

        <label><input type="checkbox" name="recurrence[custom-week-day][]"

                      value="7" <?php checked(in_array('7', $recCustomWeekDay)); ?>/> <?php _e('СБ', 'tribe-events-community'); ?>

        </label>

    </td>

</tr><!-- .custom-recurrence-row -->



<tr id="custom-recurrence-months" class="custom-recurrence-row"

    style="display: <?php echo $recType == 'Custom' && $recCustomType == 'Monthly' ? 'table-row' : 'none' ?>;">

    <td></td>

    <td>

        <div id="recurrence-month-on-the">

            <select name="recurrence[custom-month-number]">

                <option

                    value="First" <?php selected($recCustomMonthNumber, $recCustomMonthNumber ? 'First' : ''); ?>><?php _e('Первый', 'tribe-events-community'); ?></option>

                <option

                    value="Second" <?php selected($recCustomMonthNumber, 'Second'); ?>><?php _e('Второй', 'tribe-events-community'); ?></option>

                <option

                    value="Third" <?php selected($recCustomMonthNumber, 'Third'); ?>><?php _e('Третий', 'tribe-events-community'); ?></option>

                <option

                    value="Fourth" <?php selected($recCustomMonthNumber, 'Fourth'); ?>><?php _e('Четверый', 'tribe-events-community'); ?></option>

                <option

                    value="Last" <?php selected($recCustomMonthNumber, 'Last'); ?>><?php _e('Последний', 'tribe-events-community'); ?></option>

                <option value="">--</option>

                <?php for ($i = 1; $i <= 31; $i++) : ?>

                    <option

                        value="<?php echo $i; ?>" <?php selected($recCustomMonthNumber, $i); ?>><?php echo $i; ?></option>

                <?php endfor; ?>

            </select>

            <select name="recurrence[custom-month-day]"

                    style="display: <?php echo is_numeric($recCustomMonthNumber) ? 'none' : 'inline' ?>">

                <option

                    value="1" <?php selected($recCustomMonthDay, '1'); ?>><?php _e('Понедельник', 'tribe-events-community'); ?></option>

                <option

                    value="2" <?php selected($recCustomMonthDay, '2'); ?>><?php _e('Вторник', 'tribe-events-community'); ?></option>

                <option

                    value="3" <?php selected($recCustomMonthDay, '3'); ?>><?php _e('Среда', 'tribe-events-community'); ?></option>

                <option

                    value="4" <?php selected($recCustomMonthDay, '4'); ?>><?php _e('Четверг', 'tribe-events-community'); ?></option>

                <option

                    value="5" <?php selected($recCustomMonthDay, '5'); ?>><?php _e('Пятница', 'tribe-events-community'); ?></option>

                <option

                    value="6" <?php selected($recCustomMonthDay, '6'); ?>><?php _e('Сцббота', 'tribe-events-community'); ?></option>

                <option

                    value="7" <?php selected($recCustomMonthDay, '7'); ?>><?php _e('Воскресенье', 'tribe-events-community'); ?></option>

                <option value="-" <?php selected($recCustomMonthDay, '-'); ?>>--</option>

                <option

                    value="-1" <?php selected($recCustomMonthDay, '-1'); ?>><?php _e('День', 'tribe-events-community'); ?></option>

            </select>

        </div>

        <!-- #recurrence-month-on-the -->

    </td>

</tr><!-- .custom-recurrence-row -->



<tr id="custom-recurrence-years" class="custom-recurrence-row"

    style="display: <?php echo $recCustomType == 'Yearly' ? 'table-row' : 'none' ?>;">

    <td></td>

    <td>

        <div>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="1" <?php checked(in_array('1', $recCustomYearMonth)); ?>/> <?php _e('ЯНВ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="2" <?php checked(in_array('2', $recCustomYearMonth)); ?>/> <?php _e('ФЕВ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="3" <?php checked(in_array('3', $recCustomYearMonth)); ?>/> <?php _e('МАР', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="4" <?php checked(in_array('4', $recCustomYearMonth)); ?>/> <?php _e('АПР', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="5" <?php checked(in_array('5', $recCustomYearMonth)); ?>/> <?php _e('МАЙ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="6" <?php checked(in_array('6', $recCustomYearMonth)); ?>/> <?php _e('ИЮН', 'tribe-events-community'); ?>

            </label>

        </div>

        <div style="clear:both"></div>

        <div>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="7" <?php checked(in_array('7', $recCustomYearMonth)); ?>/> <?php _e('ИЮЛ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="8" <?php checked(in_array('8', $recCustomYearMonth)); ?>/> <?php _e('АВГ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="9" <?php checked(in_array('9', $recCustomYearMonth)); ?>/> <?php _e('СЕН', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="10" <?php checked(in_array('10', $recCustomYearMonth)); ?>/> <?php _e('ОКТ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="11" <?php checked(in_array('11', $recCustomYearMonth)); ?>/> <?php _e('НОЯ', 'tribe-events-community'); ?>

            </label>

            <label><input type="checkbox" name="recurrence[custom-year-month][]"

                          value="12" <?php checked(in_array('12', $recCustomYearMonth)); ?>/> <?php _e('ДЕК', 'tribe-events-community'); ?>

            </label>

        </div>

        <div style="clear:both"></div>

        <div>

            <input type="checkbox" name="recurrence[custom-year-filter]"

                   value="1" <?php checked($recCustomYearFilter, '1'); ?>/>

            <?php _e('On the:', 'tribe-events-community'); ?>

            <select name="recurrence[custom-year-month-number]">

                <option

                    value="1" <?php selected($recCustomYearMonthNumber, '1'); ?>><?php _e('Первым', 'tribe-events-community'); ?></option>

                <option

                    value="2" <?php selected($recCustomYearMonthNumber, '2'); ?>><?php _e('Вторым', 'tribe-events-community'); ?></option>

                <option

                    value="3" <?php selected($recCustomYearMonthNumber, '3'); ?>><?php _e('Третим', 'tribe-events-community'); ?></option>

                <option

                    value="4" <?php selected($recCustomYearMonthNumber, '4'); ?>><?php _e('Четвертым', 'tribe-events-community'); ?></option>

                <option

                    value="-1" <?php selected($recCustomYearMonthNumber, '-1'); ?>><?php _e('Последним', 'tribe-events-community'); ?></option>

            </select>

            <select name="recurrence[custom-year-month-day]">

                <option

                    value="1"  <?php selected($recCustomYearMonthDay, '1'); ?>><?php _e('Понедельник', 'tribe-events-community'); ?></option>

                <option

                    value="2" <?php selected($recCustomYearMonthDay, '2'); ?>><?php _e('Вторник', 'tribe-events-community'); ?></option>

                <option

                    value="3" <?php selected($recCustomYearMonthDay, '3'); ?>><?php _e('Среда', 'tribe-events-community'); ?></option>

                <option

                    value="4" <?php selected($recCustomYearMonthDay, '4'); ?>><?php _e('Четверг', 'tribe-events-community'); ?></option>

                <option

                    value="5" <?php selected($recCustomYearMonthDay, '5'); ?>><?php _e('Пятница', 'tribe-events-community'); ?></option>

                <option

                    value="6" <?php selected($recCustomYearMonthDay, '6'); ?>><?php _e('Суббота', 'tribe-events-community'); ?></option>

                <option

                    value="7" <?php selected($recCustomYearMonthDay, '7'); ?>><?php _e('Воскресенье', 'tribe-events-community'); ?></option>

                <option value="-" <?php selected($recCustomYearMonthDay, '-'); ?>>--</option>

                <option

                    value="-1" <?php selected($recCustomYearMonthDay, '-1'); ?>><?php _e('День', 'tribe-events-community'); ?></option>

            </select>

        </div>

    </td>

</tr><!-- .custom-recurrence-row -->