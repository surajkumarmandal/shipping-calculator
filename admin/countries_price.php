<?php

 // Content for Countries page
 global $wpdb;
 $table_name = $wpdb->prefix . 'countries_price_chart';
 $edit = false;
 
 // Check if form is submitted
 if(isset($_POST['submit'])) {
    $edit = false;
     // Sample data
    $destination_countries = sanitize_text_field($_POST['destination_countries']);
    $air_cost_per_pound = sanitize_text_field($_POST['air_cost_per_pound']);
    $air_minimum_permitted_pound = sanitize_text_field($_POST['air_minimum_permitted_pound']);
    $air_maximum_permitted_pound = sanitize_text_field($_POST['air_maximum_permitted_pound']);
    $air_maximum_price = sanitize_text_field($_POST['air_maximum_price']);
    $air_processing_fee = sanitize_text_field($_POST['air_processing_fee']);
    $air_duty = sanitize_text_field($_POST['air_duty']);
    $maritime_cost_per_pound = sanitize_text_field($_POST['maritime_cost_per_pound']);
    $maritime_minimum_permitted_pound = sanitize_text_field($_POST['maritime_minimum_permitted_pound']);
    $maritime_maximum_permitted_pound = sanitize_text_field($_POST['maritime_maximum_permitted_pound']);
    $maritime_maximum_price = sanitize_text_field($_POST['maritime_maximum_price']);
    $maritime_processing_fee = sanitize_text_field($_POST['maritime_processing_fee']);
    $maritime_duty = sanitize_text_field($_POST['maritime_duty']);
    $service_type = isset($_POST['service_type']) ? $_POST['service_type'] : [];
    $service_type_data = implode(', ', $service_type);
    $wpdb->insert(
        $table_name,
        array(
            'destination_countries' => $destination_countries,
            'air_cost_per_pound' => $air_cost_per_pound,
            'air_minimum_permitted_pound' => $air_minimum_permitted_pound,
            'air_maximum_permitted_pound' => $air_maximum_permitted_pound,
            'air_maximum_price' => $air_maximum_price,
            'air_processing_fee' => $air_processing_fee,
            'air_duty' => $air_duty,
            'maritime_cost_per_pound' => $maritime_cost_per_pound,
            'maritime_minimum_permitted_pound' => $maritime_minimum_permitted_pound,
            'maritime_maximum_permitted_pound' => $maritime_maximum_permitted_pound,
            'maritime_maximum_price' => $maritime_maximum_price,
            'maritime_processing_fee' => $maritime_processing_fee,
            'maritime_duty' => $maritime_duty,
            'service_type' => $service_type_data
        )
    );
    echo '<div class="notice notice-success"><p>Country added successfully!</p></div>';
     
     
 } else if(isset($_POST['edit'])) {
    $edit = true;
    $country_id = sanitize_text_field($_POST['country_id']);
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $country_id", ARRAY_A);
    
    
    if ($result) {
        // Access data from the result object
        $country_data = $result[0];
        echo '<div class="notice notice-success"><p>Fetch Country data successfully!</p></div>';
    } else {
        echo '<div class="notice notice-warning"><p>No data found with the given ID.</p></div>';
    }
 } else if (isset($_POST['update'])) {
    $country_id = sanitize_text_field($_POST['country_id']);
    $destination_countries = sanitize_text_field($_POST['destination_countries']);
    $air_cost_per_pound = sanitize_text_field($_POST['air_cost_per_pound']);
    $air_minimum_permitted_pound = sanitize_text_field($_POST['air_minimum_permitted_pound']);
    $air_maximum_permitted_pound = sanitize_text_field($_POST['air_maximum_permitted_pound']);
    $air_maximum_price = sanitize_text_field($_POST['air_maximum_price']);
    $air_processing_fee = sanitize_text_field($_POST['air_processing_fee']);
    $air_duty = sanitize_text_field($_POST['air_duty']);
    $maritime_cost_per_pound = sanitize_text_field($_POST['maritime_cost_per_pound']);
    $maritime_minimum_permitted_pound = sanitize_text_field($_POST['maritime_minimum_permitted_pound']);
    $maritime_maximum_permitted_pound = sanitize_text_field($_POST['maritime_maximum_permitted_pound']);
    $maritime_maximum_price = sanitize_text_field($_POST['maritime_maximum_price']);
    $maritime_processing_fee = sanitize_text_field($_POST['maritime_processing_fee']);
    $maritime_duty = sanitize_text_field($_POST['maritime_duty']);
    $service_type = isset($_POST['service_type']) ? $_POST['service_type'] : [];
    $service_type_data = implode(', ', $service_type);
    // print_r($_POST['service_type']);echo $service_type_data;exit;
    $wpdb->update($table_name, array(
        'destination_countries' => $destination_countries,
        'air_cost_per_pound' => $air_cost_per_pound,
        'air_minimum_permitted_pound' => $air_minimum_permitted_pound,
        'air_maximum_permitted_pound' => $air_maximum_permitted_pound,
        'air_maximum_price' => $air_maximum_price,
        'air_processing_fee' => $air_processing_fee,
        'air_duty' => $air_duty,
        'maritime_cost_per_pound' => $maritime_cost_per_pound,
        'maritime_minimum_permitted_pound' => $maritime_minimum_permitted_pound,
        'maritime_maximum_permitted_pound' => $maritime_maximum_permitted_pound,
        'maritime_maximum_price' => $maritime_maximum_price,
        'maritime_processing_fee' => $maritime_processing_fee,
        'maritime_duty' => $maritime_duty,
        'service_type' => $service_type_data 
    ), array(
        'id' => $country_id
    ));
    $edit = false;
    echo '<div class="notice notice-success"><p>Country update successfully!</p></div>';
 } else if (isset($_POST['delete'])) {
    $country_id = sanitize_text_field($_POST['country_id']);
    $wpdb->delete($table_name, array(
        'id' => $country_id
    ));
    echo '<div class="notice notice-success"><p>Country data deleted successfully!</p></div>';
 } else if (isset($_POST['import_file'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_info = pathinfo($_FILES['csv_file']['name']);
        if (strtolower($file_info['extension']) == 'csv') {
            $file_path = $_FILES['csv_file']['tmp_name'];
            
            // Process CSV data
            $csv_data = array_map('str_getcsv', file($file_path));
            $data_count = 0;
            // Iterate through each row and extract necessary data
            foreach ($csv_data as $row) {
               if ($data_count > 0) {
                
                $destination_country = sanitize_text_field($row[0]);
                $air_cost_per_pound = sanitize_text_field($row[1]);
                $air_minimum_permitted_pound = sanitize_text_field($row[2]);
                $air_maximum_permitted_pound = sanitize_text_field($row[3]);
                $air_maximum_price = sanitize_text_field($row[4]);
                $air_processing_fee = sanitize_text_field($row[5]);
                $air_duty = sanitize_text_field($row[6]);
                $maritime_cost_per_pound = sanitize_text_field($row[7]);
                $maritime_minimum_permitted_pound = sanitize_text_field($row[8]);
                $maritime_maximum_permitted_pound = sanitize_text_field($row[9]);
                $maritime_maximum_price = sanitize_text_field($row[10]);
                $maritime_processing_fee = sanitize_text_field($row[11]);
                $maritime_duty = sanitize_text_field($row[12]);
                $service_type_data = sanitize_text_field($row[13]);
                
                $errors = validateInput($destination_country, $service_type_data);
                if (empty($errors)) {
                    $wpdb->insert($table_name, array(
                        'destination_countries' => $destination_country,
                        'air_cost_per_pound' => $air_cost_per_pound,
                        'air_minimum_permitted_pound' => $air_minimum_permitted_pound,
                        'air_maximum_permitted_pound' => $air_maximum_permitted_pound,
                        'air_maximum_price' => $air_maximum_price,
                        'air_processing_fee' => $air_processing_fee,
                        'air_duty' => $air_duty,
                        'maritime_cost_per_pound' => $maritime_cost_per_pound,
                        'maritime_minimum_permitted_pound' => $maritime_minimum_permitted_pound,
                        'maritime_maximum_permitted_pound' => $maritime_maximum_permitted_pound,
                        'maritime_maximum_price' => $maritime_maximum_price,
                        'maritime_processing_fee' => $maritime_processing_fee,
                        'maritime_duty' => $maritime_duty,
                        'service_type' => $service_type_data 
                    ));
                    echo '<div class="notice notice-success"><p> '. $destination_country.' CSV data inserted successfully </p></div>';
                } else {
                    // There are validation errors, handle them accordingly
                    $error_message = '';
                    foreach ($errors as $error) {
                        $error_message .=  $error . '<br>';
                    }
                    echo '<div class="notice notice-error"><p>'. $error_message .'</p></div>';break;
                }
               }
               $data_count++;
               
            }
            if($error_message) {
                echo '<div class="notice notice-error"><p> Invalid file. Please upload a CSV file. </p></div>';
            } else {
                echo '<div class="notice notice-success"><p> CSV file imported successfully </p></div>';
            }
           
        } else {
            echo '<div class="notice notice-notice"><p> Invalid file type. Please upload a CSV file. </p></div>';
        }
    }
 }

 function validateInput($destination_country, $service_type) {
    $errors = [];

    // Check if $destination_country is set and not empty
    if (empty($destination_country)) {
        $errors[] = 'Destination country is required.';
    }

    // Check if $service_type is set and not empty
    if (empty($service_type)) {
        $errors[] = 'Service type is required.' . ' for Country '. $destination_country ;
    } else if (!in_array($service_type, ['AIR','GROUND','MARITIME'])) {
        $errors[] = 'Invalid Service type' . ' for Country '. $destination_country ;
    }

    // Return errors array, empty if no errors
    return $errors;
}



 // Fetch all countries from the database
 $countries = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

 // Display the form to add a country
 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <div class="wrap">
    <h2>Import Country</h2>
    <form method="post" enctype="multipart/form-data" action="<?php esc_url( admin_url( 'admin.php?page=shipping-calculator-countries' ) ) ?>">
        
        <div class="row">
            <div class="col-md-12">
                <input type="file" name="csv_file" accept=".csv" required />
                <input type="submit" value="Import" name="import_file" class="btn btn-primary float-right">
            </div>
            <div class="col-md-12">
            <?php 
                $file_path = plugin_dir_path(__FILE__) . 'assets/demo_csv/example_country_data.csv';
                $file_url = plugins_url('assets/demo_csv/example_country_data.csv', __FILE__);
            
                if (file_exists($file_path)) {
                    echo '<a href="' . esc_url($file_url) . '" download>Example csv file Download</a>';
                } else {
                    echo 'File not found.';
                }
            ?>
            </div>
        </div>
       
    </form>
     <h1><?= $edit ? 'Edit' : 'Add' ?> Country </h1>
     <form method="post" action="<?php esc_url( admin_url( 'admin.php?page=shipping-calculator-countries' ) ) ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="destination_countries">Destination Countries</label>
                    <input type="text" required class="form-control" value="<?= $country_data['destination_countries'] ?>" id="destination_countries" name="destination_countries" placeholder="Enter destination countries">
                </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_per_pound"> AIR Cost per Pound</label>
                        <input type="number" step="any" class="form-control" id="air_cost_per_pound" value="<?= $country_data['air_cost_per_pound'] ?>" name="air_cost_per_pound" placeholder="Enter cost per pound">
                    </div>
                    <div class="form-group">
                        <label for="minimum_permitted_pound"> AIR Minimum Permitted Pound</label>
                        <input type="number" step="any" class="form-control" value="<?= $country_data['air_minimum_permitted_pound'] ?>" id="air_minimum_permitted_pound" name="air_minimum_permitted_pound" placeholder="Enter  permitted pound">
                    </div>
                    <div class="form-group">
                        <label for="maximum_permitted_pound"> AIR Maximum Permitted Pound</label>
                        <input type="number" step="any" class="form-control" value="<?= $country_data['air_maximum_permitted_pound'] ?>" id="air_maximum_permitted_pound" name="air_maximum_permitted_pound" placeholder="Enter maximum permitted pound">
                    </div>
                    <div class="form-group">
                        <label for="maximum_permitted_pound"> AIR Minimum $</label>
                        <input type="number" step="any" class="form-control" id="air_maximum_price" value="<?= $country_data['air_maximum_price'] ?>" name="air_maximum_price" placeholder="Enter minimum  price">
                    </div>
                    <div class="form-group">
                        <label for="processing_fee"> AIR Processing Fee</label>
                        <input type="number" step="any" class="form-control" id="air_processing_fee" value="<?= $country_data['air_processing_fee'] ?>" name="air_processing_fee" placeholder="Enter processing fee">
                    </div>
                    <div class="form-group">
                        <label for="duty"> AIR Duty</label>
                        <input type="number" step="any" class="form-control" id="air_duty" value="<?= $country_data['air_duty'] ?>" name="air_duty" placeholder="Enter duty">
                       
                    </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_per_pound"> Maritime Cost per Pound</label>
                        <input type="number" step="any" class="form-control" id="maritime_cost_per_pound" value="<?= $country_data['maritime_cost_per_pound'] ?>" name="maritime_cost_per_pound" placeholder="Enter cost per pound">
                    </div>
                    <div class="form-group">
                        <label for="minimum_permitted_pound"> Maritime Minimum Permitted Pound</label>
                        <input type="number" step="any" class="form-control" value="<?= $country_data['maritime_minimum_permitted_pound'] ?>" id="maritime_minimum_permitted_pound" name="maritime_minimum_permitted_pound" placeholder="Enter  permitted pound">
                    </div>
                    <div class="form-group">
                        <label for="maximum_permitted_pound"> Maritime Maximum Permitted Pound</label>
                        <input type="number" step="any" class="form-control" value="<?= $country_data['maritime_maximum_permitted_pound'] ?>" id="maritime_maximum_permitted_pound" name="maritime_maximum_permitted_pound" placeholder="Enter maximum permitted pound">
                    </div>
                    <div class="form-group">
                        <label for="maximum_permitted_pound"> Maritime Minimum $</label>
                        <input type="number" step="any" class="form-control" id="maritime_maximum_price" value="<?= $country_data['maritime_maximum_price'] ?>" name="maritime_maximum_price" placeholder="Enter minimum  price">
                    </div>
                    <div class="form-group">
                        <label for="processing_fee"> Maritime Processing Fee</label>
                        <input type="number" step="any" class="form-control" id="maritime_processing_fee" value="<?= $country_data['maritime_processing_fee'] ?>" name="maritime_processing_fee" placeholder="Enter processing fee">
                    </div>
                    <div class="form-group">
                        <label for="duty"> Maritime Duty</label>
                        <input type="number" step="any" class="form-control" id="maritime_duty" value="<?= $country_data['maritime_duty'] ?>" name="maritime_duty" placeholder="Enter duty">
                        <input type="hidden" id="country_id" value="<?= $country_data['id'] ?>" name="country_id">
                    </div>
                    <div class="form-group">
                        <label  class="form-label">  Service Type </label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="chk_air" name="service_type[]"  value="AIR" <?= str_contains($country_data['service_type'], 'AIR') ? 'checked="true"' : '' ?>>
                            <label class="form-check-label" for="chk_air">AIR</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="chk_maritime" name="service_type[]"  value="MARITIME" <?= str_contains($country_data['service_type'], 'MARITIME') ? 'checked="true"' : '' ?>>
                            <label class="form-check-label" for="chk_maritime">MARITIME</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="chk_ground" name="service_type[]"  value="GROUND" <?= str_contains($country_data['service_type'], 'GROUND') ? 'checked="true"' : '' ?>>
                            <label class="form-check-label" for="chk_ground">GROUND</label>
                        </div>
                        <div class="alert alert-danger" id="service_type_err" style="display:none">
                            <strong>Required!</strong> Each destination country should have a minimum of 1 service type assigned.
                        </div>
                        
                    </div>
                    
                    <?php if ($edit) { ?>
                        <input type="submit" value="Update" id="submit_form" name="update" class="btn btn-primary float-right">
                    <?php } else { ?>
                        <input type="submit" value="Submit" id="submit_form" name="submit" class="btn btn-primary float-right">
                    <?php } ?>
            </div>
            </div>
     </form>

     <h2>Country List</h2>
     <?php if (!empty($countries)) : ?>
         <table class="wp-list-table widefat striped">
             <thead>
                 <tr>
                     <th> SL No </th>
                     <th> Destination Countries </th>
                     <th> Cost Per Pound </th>
                     <th> Minimum Permitted Pound </th>
                     <th> Maximum Permitted Pound </th>
                     <th> Maximum Price </th>
                     <th> Processing fee </th>
                     <th> Duty </th>
                     <th> Service Type </th>
                     <th> Action </th>
                 </tr>
             </thead>
             <tbody>
                <?php  $itemNo = 1 ?>
                 <?php foreach ($countries as $country) : ?>
                     <tr>
                         <td><?= $itemNo ?></td>
                         <td>
                            <?php echo esc_html($country['destination_countries']); ?>
                        </td>
                         <td>
                            Air: <?php echo esc_html($country['air_cost_per_pound']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_cost_per_pound']); ?>
                        </td>
                        <td>
                            Air: <?php echo esc_html($country['air_minimum_permitted_pound']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_minimum_permitted_pound']); ?> 
                        </td>
                         <td> 
                            Air: <?php echo esc_html($country['air_maximum_permitted_pound']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_maximum_permitted_pound']); ?>
                        </td>
                        <td> 
                            Air: <?php echo esc_html($country['air_maximum_price']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_maximum_price']); ?>
                        </td>
                        <td> 
                            Air: <?php echo esc_html($country['air_processing_fee']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_processing_fee']); ?>
                        </td>
                        <td>
                            Air: <?php echo esc_html($country['air_duty']); ?><br>
                            Maritime: <?php echo esc_html($country['maritime_duty']); ?>
                        </td>
                        <td><?php echo str_replace(',', '<br />', $country['service_type']);?></td>
                        <td>
                         <form method="post" action="<?php esc_url( admin_url( 'admin.php?page=shipping-calculator-countries' ) ) ?>">
                            <input type="submit" value="Edit" name="edit"  class="btn btn-primary">
                            <input type="submit" value="Delete" name="delete"  class="btn btn-danger">
                            <input type="hidden" name="country_id" value="<?= $country['id'] ?>">
                         </form>
                        </td>
                     </tr>
                     <?php  $itemNo++ ?>
                 <?php endforeach; ?>
             </tbody>
         </table>
     <?php else : ?>
         <p>No countries found.</p>
     <?php endif; ?>
 </div>

 <script>
    jQuery(document).ready(function($) {
        $('#submit_form').click(function(event) {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    $('#service_type_err').show();
                    setTimeout( function() { 
                        $('#service_type_err').hide();
                    }, 3000);
                    event.preventDefault();
                    return false;
                }
                
                
        });
    });
 </script>

 


