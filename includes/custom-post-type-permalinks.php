<?php
function custom_post_type_permalink($permalink, $post) {
    // Replace 'your_custom_post_type' with the name of your custom post type.
    if ($post->post_type == 'location') {
        // Use the post ID as the permalink.
        $permalink = home_url('/location/') . $post->ID . '/';
    }
    return $permalink;
}

// Hook the function into the 'post_type_link' filter.
add_filter('post_type_link', 'custom_post_type_permalink', 10, 2);
