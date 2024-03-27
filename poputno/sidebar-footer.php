<?php
if (!is_active_sidebar('right-footer-widget-area'))
    return;

?>



<?php if (is_active_sidebar('right-footer-widget-area')) : ?>
    <div class="column_c13"><?php dynamic_sidebar('right-footer-widget-area'); ?></div>
<?php endif; ?>
