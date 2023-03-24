<?php

global $wp_query;

$total = $total ?? $wp_query->max_num_pages;
$paged = $paged ?? get_query_var('paged');

if ($total <= 1) {
    return;
}

?>
<div class="lp-load-more">
    <div class="lp-loading-display"></div>
    <div class="lp-load-more-btn">
        <?php esc_html_e('Load More', 'learnpress'); ?>
    </div>
</div>

