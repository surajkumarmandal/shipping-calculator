<?php
// Admin panel configuration

// Add admin menu tab
// Function to create the main admin menu
function create_shipping_calculator_menu() {
    add_menu_page(
        'Shipping Calculator', // Page title
        'Shipping Calculator', // Menu title
        'manage_options', // Capability required to access
        'shipping-calculator', // Menu slug
        'shipping_calculator_page_content', // Function to display content
        'dashicons-cart' // Icon for the menu item
    );

    // Sub-menu items
    add_submenu_page(
        'shipping-calculator',
        'Countries',
        'Countries',
        'manage_options',
        'shipping-calculator-countries',
        'countries_page_content'
    );
    
    add_submenu_page(
        'shipping-calculator', // Parent slug
        'Shipping Type', // Page title
        'Shipping Type', // Menu title
        'manage_options', // Capability required to access
        'shipping-calculator-shipping-type', // Menu slug
        'shipping_type_page_content' // Function to display content
    );

   

    add_submenu_page(
        'shipping-calculator',
        'Zones',
        'Zones',
        'manage_options',
        'shipping-calculator-zones',
        'zones_page_content'
    );

    add_submenu_page(
        'shipping-calculator',
        'Settings',
        'Settings',
        'manage_options',
        'shipping-calculator-settings',
        'settings_page_content'
    );
}

// Hook the function to create the admin menu
add_action('admin_menu', 'create_shipping_calculator_menu');

// Functions to display content for sub-menus
function shipping_type_page_content() {
    // Content for Shipping Type page
}

function countries_page_content() {
    include_once(plugin_dir_path(__FILE__) . 'countries_price.php');
}

function zones_page_content() {
    // Content for Zones page
}

function settings_page_content() {
    // Content for Settings page
}

// Function to display content for Shipping Calculator main menu
function shipping_calculator_page_content() {
    // HTML for settings page (upload form, etc.)
    // Form to upload country, state, zip code data
    ?>
    <div class="wrap">
        <h2>Shipping Calculator Settings</h2>
        <form action="options.php" method="post">
            <!-- Add form fields to upload data -->
            <!-- Example: File upload field for data -->
            <input type="file" name="data_file">
            <input type="submit" name="upload_data" value="Upload Data">
        </form>
    </div>
    <?php
}


// Process data upload
function process_data_upload() {
    if (isset($_POST['upload_data'])) {
        // Process uploaded data file
        // Example: Handle file upload and save data to database
        if ($_FILES['data_file']) {
            // Handle file upload and data processing
            // Save data to database using save_data_to_database() function
        }
    }
}

add_action('admin_init', 'process_data_upload');
