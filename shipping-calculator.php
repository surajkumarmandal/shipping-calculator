<?php
/*
Plugin Name: Shipping Calculator
Description: This plugin is for CASILLERO LATINO, to display a calculator on their website.
Version: 1.0
Author: Suraj Kumar Mandal
*/

// Include necessary files
include_once plugin_dir_path(__FILE__) . "includes/shipping-calculator-functions.php";
include_once plugin_dir_path(__FILE__) . "includes/shipping-calculator-form.php";

include_once plugin_dir_path(__FILE__) . "admin/shipping-calculator-admin.php";
include_once plugin_dir_path(__FILE__) . "admin/countries_price_api.php";

register_activation_hook(__FILE__, "shipping_calculator_activate");
register_deactivation_hook(__FILE__, "shipping_calculator_deactivate");

function shipping_calculator_activate()
{
    // Activation code here
    // Hook the function to plugin activation
    create_countries_table();
}

function shipping_calculator_deactivate()
{
    delete_countries_table();
}

function create_countries_table()
{
    global $wpdb;

    $countries_table_name = $wpdb->prefix . "countries_price_chart";

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $countries_table_name (
                    id INT NOT NULL AUTO_INCREMENT,
                    destination_countries VARCHAR(255) NOT NULL,
                    air_cost_per_pound DECIMAL(10,2) NOT NULL,
                    air_minimum_permitted_pound DECIMAL(10,2) NOT NULL,
                    air_maximum_permitted_pound DECIMAL(10,2) NOT NULL,
                    air_maximum_price DECIMAL(10,2) NOT NULL, 
                    air_processing_fee DECIMAL(10,2) NOT NULL,
                    air_duty DECIMAL(10,2) NOT NULL,
                    maritime_cost_per_pound DECIMAL(10,2) NOT NULL,
                    maritime_minimum_permitted_pound DECIMAL(10,2) NOT NULL,
                    maritime_maximum_permitted_pound DECIMAL(10,2) NOT NULL,
                    maritime_maximum_price DECIMAL(10,2) NOT NULL, 
                    maritime_processing_fee DECIMAL(10,2) NOT NULL,
                    maritime_duty DECIMAL(10,2) NOT NULL,
                    service_type varchar(200) NOT NULL,
                    PRIMARY KEY (id)
                )";

        require_once ABSPATH . "wp-admin/includes/upgrade.php";
        dbDelta($sql);
    }
}

// Function to delete the database table
function delete_countries_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "countries_price_chart";

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

// Enqueue jQuery in the admin panel
function custom_api_enqueue_scripts()
{
    if (is_admin()) {
        wp_enqueue_script("jquery");
    }

    if (is_plugin_active("shipping-calculator/shipping-calculator.php")) {
        // Bootstrap CSS
        wp_enqueue_style(
            "bootstrap",
            "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css",
            [],
            "4.5.0"
        );

        // Bootstrap JavaScript (and Popper.js for dropdowns)
        wp_enqueue_script(
            "popper",
            "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js",
            ["jquery"],
            "1.16.0",
            true
        );
        wp_enqueue_script(
            "bootstrap",
            "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js",
            ["jquery", "popper"],
            "4.5.0",
            true
        );
    }
}
add_action("admin_enqueue_scripts", "custom_api_enqueue_scripts");

// Shortcode to display the form
function calculator_form_shortcode()
{
    ob_start(); // Output buffering to capture the HTML content

    // Include your form HTML here
    include plugin_dir_path(__FILE__) . "includes/calculator-form-template.php";

    return ob_get_clean(); // Return the captured HTML content
}

// Register the shortcode
add_shortcode("calculator_form", "calculator_form_shortcode");

// Enqueue styles for the form
function enqueue_custom_form_styles()
{
    wp_enqueue_style(
        "custom-form-styles",
        plugin_dir_url(__FILE__) . "admin/assets/css/styles.css"
    );
}
add_action("wp_enqueue_scripts", "enqueue_custom_form_styles");
