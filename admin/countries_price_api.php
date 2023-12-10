<?php

// Hook to add the custom API endpoint

add_action('rest_api_init', function () {
    register_rest_route(
        'countries/admin/v1',
        '/countries',
        array(
            'methods' => 'GET',
            'callback' => 'wp_countries_api_get',
            'permission_callback' => '__return_true',
        )
    );
    register_rest_route(
        '/countries/admin/v1',
        '/countries',
        array(
            'methods' => 'POST',
            'callback' => 'wp_countries_api_post',
            'permission_callback' => '__return_true',
        )
    );
});

// Permission callback to restrict access to logged-in admin users
function custom_api_permission_callback() {
    return current_user_can('manage_options');
}

// Get all countries
function wp_countries_api_get() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'countries';
    $data = $wpdb->get_results("SELECT * FROM $table_name");
    return new WP_REST_Response($data, 200); // OK
}
// Callback function for the custom API endpoint
function custom_api_hello($data) {
    $response = array(
        'message' => 'Hello, ' . esc_html($data['name']),
    );

    return rest_ensure_response($response);
}

// Enqueue jQuery in the admin panel
function countries_price_api_enqueue_scripts() {
    if (is_admin()) {
        wp_enqueue_script('jquery');

        // Enqueue custom script for AJAX
        // wp_enqueue_script('custom-api-script', plugin_dir_url(__FILE__) . 'custom-api-script.js', array('jquery'), '1.0', true);

    
    }
}
add_action('admin_enqueue_scripts', 'countries_price_api_enqueue_scripts');