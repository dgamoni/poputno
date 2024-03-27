<?php
if (!is_active_sidebar('right-top-widget-area'))
    return;

?>



<?php if (is_active_sidebar('right-top-widget-area')) : ?>
    <?php dynamic_sidebar('right-top-widget-area'); ?>
<?php endif; ?>
