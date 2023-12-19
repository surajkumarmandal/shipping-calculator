<?php

// Hook to add the custom API endpoint

add_action('rest_api_init', function () {
    register_rest_route(
        '/shipping-calculator/countries/v1',
        '/countries',
        array(
            'methods' => 'GET',
            'callback' => 'wp_countries_api_get',
            'permission_callback' => '__return_true',
        )
    );
    register_rest_route(
        '/shipping-calculator/countries/v1',
        '/countries',
        array(
            'methods' => 'POST',
            'callback' => 'wp_countries_api_post',
            'permission_callback' => '__return_true',
        )
    );
    register_rest_route(
        '/shipping-calculator/countries/v1',
        '/shipping-form',
        array(
            'methods' => 'POST',
            'callback' => 'wp_shipping_calculation_api_post',
            'permission_callback' => '__return_true',
        )
    );
});

// Permission callback to restrict access to logged-in admin users
function custom_api_permission_callback() {
    return current_user_can('manage_options');
}

// Get all countries
function wp_shipping_calculation_api_post(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'countries_price_chart';
    $shippingData = $request->get_body_params();
    $countryId = $shippingData['countriesTo'];
    $countries_price_chart = $wpdb->get_results("SELECT * FROM $table_name WHERE id= $countryId");
    $containerSR = $shippingData['containerSR'];
    $totalCost = 0;
    $priceDetailsObject = [];

    $parcel_file_url = plugins_url('assets/image/parcel_1.png', __FILE__);
    $serviceTypeList = explode(",", $countries_price_chart[0]->service_type);
    $serviceTypeListIsExist = in_array($shippingData['service_type'], $serviceTypeList);
    if($shippingData['itemType'] === 'single') {
        if ( $serviceTypeListIsExist && $shippingData['service_type'] === 'AIR' ) {
            $air_cost_per_pound = $countries_price_chart[0]->air_cost_per_pound;
            $totalCost = $containerSR * $air_cost_per_pound;
            $insurance_cost = $countries_price_chart[0]->insurance_cost;
            $totalCost +=  $insurance_cost > 0 ? ( $totalCost * $insurance_cost)/100 : 0;
            $dutty_tax = $countries_price_chart[0]->dutty_tax;
            $totalCost +=  $dutty_tax > 0 ? ( $totalCost * $dutty_tax)/100 : 0;
            $air_processing_fee = $countries_price_chart[0]->air_processing_fee;
            $totalCost += $air_processing_fee;

            $priceDetailsObject = [[
                'totalCost' => $totalCost,
                'totalWeight' => $containerSR,
                'costPerpound' => $air_cost_per_pound,
                'insurance_cost' => $insurance_cost,
                'dutty_tax' => $dutty_tax,
                'air_processing_fee' => $air_processing_fee,
                'shippingData' => $shippingData,
                'parcel_file_url' => $parcel_file_url
            ]];
        } else {
            $maritime_cost_per_pound = $countries_price_chart[0]->maritime_cost_per_pound;
            $totalCost = $containerSR * $countries_price_chart[0]->maritime_cost_per_pound;
            $insurance_cost = $countries_price_chart[0]->insurance_cost;
            $totalCost +=  $insurance_cost > 0 ? ( $totalCost * $insurance_cost)/100 : 0;
            $dutty_tax = $countries_price_chart[0]->dutty_tax;
            $totalCost +=  $dutty_tax > 0 ? ( $totalCost * $dutty_tax)/100 : 0;
            $maritime_processing_fee = $countries_price_chart[0]->maritime_processing_fee;
            $totalCost += $maritime_processing_fee;
            $priceDetailsObject = [[
                'totalCost' => $totalCost,
                'totalWeight' => $containerSR,
                'costPerpound' => $maritime_cost_per_pound,
                'insurance_cost' => $insurance_cost,
                'dutty_tax' => $dutty_tax,
                'air_processing_fee' => $maritime_processing_fee,
                'shippingData' => $shippingData,
                'parcel_file_url' => $parcel_file_url
            ]];
        }
        
    } else {
        $shippingDetails = $shippingData['shippingDetails'];
        
        for ($i=0; $i < count($shippingDetails); $i++) { 
            $totalCost = 0;
            if ( $serviceTypeListIsExist && $shippingData['service_type'] === 'AIR' ) {
                $air_cost_per_pound = $countries_price_chart[0]->air_cost_per_pound;
                $parcelWeight =  ((float)$shippingDetails[$i]['width'] * (float)$shippingDetails[$i]['height'] * (float)$shippingDetails[$i]['depth']) / 165;
                $totalCost = $parcelWeight * $air_cost_per_pound;
                $insurance_cost = $countries_price_chart[0]->insurance_cost;
                $totalCost +=  $insurance_cost > 0 ? ( $totalCost * $insurance_cost)/100 : 0;
                $dutty_tax = $countries_price_chart[0]->dutty_tax;
                $totalCost +=  $dutty_tax > 0 ? ( $totalCost * $dutty_tax)/100 : 0;
                $air_processing_fee = $countries_price_chart[0]->air_processing_fee;
                $totalCost += $air_processing_fee;
                $shippingData['width'] = $shippingDetails[$i]['width'];
                $shippingData['height'] = $shippingDetails[$i]['height'];
                $shippingData['depth'] = $shippingDetails[$i]['depth'];
                unset($shippingData['shippingDetails']);
                array_push($priceDetailsObject , [
                    'totalCost' => $totalCost,
                    'totalWeight' => $parcelWeight,
                    'costPerpound' => $air_cost_per_pound,
                    'insurance_cost' => $insurance_cost,
                    'dutty_tax' => $dutty_tax,
                    'air_processing_fee' => $air_processing_fee,
                    'shippingData' => $shippingData,
                    'parcel_file_url' => $parcel_file_url
                ]);
            } else {
                $maritime_cost_per_pound = $countries_price_chart[0]->maritime_cost_per_pound;
                $parcelWeight =  ((float)$shippingDetails[$i]['width'] * (float)$shippingDetails[$i]['height'] * (float)$shippingDetails[$i]['depth']) / 165;
                $totalCost = $parcelWeight * $countries_price_chart[0]->maritime_cost_per_pound;
                $insurance_cost = $countries_price_chart[0]->insurance_cost;
                $totalCost +=  $insurance_cost > 0 ? ( $totalCost * $insurance_cost)/100 : 0;
                $dutty_tax = $countries_price_chart[0]->dutty_tax;
                $totalCost +=  $dutty_tax > 0 ? ( $totalCost * $dutty_tax)/100 : 0;
                $maritime_processing_fee = $countries_price_chart[0]->maritime_processing_fee;
                $totalCost += $maritime_processing_fee;
                $shippingData['width'] = $shippingDetails[$i]['width'];
                $shippingData['height'] = $shippingDetails[$i]['height'];
                $shippingData['depth'] = $shippingDetails[$i]['depth'];
                unset($shippingData['shippingDetails']);
                array_push($priceDetailsObject ,  [
                    'totalCost' => $totalCost,
                    'totalWeight' => $parcelWeight,
                    'costPerpound' => $maritime_cost_per_pound,
                    'insurance_cost' => $insurance_cost,
                    'dutty_tax' => $dutty_tax,
                    'air_processing_fee' => $maritime_processing_fee,
                    'shippingData' => $shippingData,
                    'parcel_file_url' => $parcel_file_url
                ]);
            }
        }
    }
    
    return new WP_REST_Response($priceDetailsObject, 200); // OK
}

// Get all countries
function wp_countries_api_get() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'countries_price_chart';
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