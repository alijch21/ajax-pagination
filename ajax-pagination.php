<?php
/*
Plugin Name: AJAX Pagination
Description: A simple plugin to paginate posts using AJAX.
Version: 1.1
Author: Your Name
*/

function ajax_pagination_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('ajax-pagination', plugin_dir_url(__FILE__) . 'ajax-pagination.js', array('jquery'), null, true);

    wp_localize_script('ajax-pagination', 'ajaxpagination', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'ajax_pagination_enqueue_scripts');
/*
test for github
from local host
*/
/*
change on github on website 10:45AM
    */

function ajax_pagination() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 2,
        'paged' => $paged,
    ));

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <div><?php the_excerpt(); ?></div>
        <?php endwhile;
    endif;

    wp_reset_postdata();

    wp_die();
}
add_action('wp_ajax_nopriv_ajax_pagination', 'ajax_pagination');
add_action('wp_ajax_ajax_pagination', 'ajax_pagination');

function ajax_pagination_button() {
    ?>
    <div id="ajax-pagination">
        <div id="posts-container">
            <?php
            $query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 1,
                'paged' => 1,
            ));

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <h2><?php the_title(); ?></h2>
                    <div><?php the_excerpt(); ?></div>
                <?php endwhile;
            endif;

            wp_reset_postdata();
            ?>
        </div>
        <button id="load-more">Load More</button>
    </div>
    <?php
}
add_shortcode('ajax_pagination', 'ajax_pagination_button');
?>
