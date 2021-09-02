<?php
	require_once('../../config/functions.php');
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT * FROM users, vehicles, vehicle_models, vehicle_permit, `renew_vehicle_particulars` where users.unique_id = renew_vehicle_particulars.user_id and vehicles.unique_id = renew_vehicle_particulars.vehicle_type and vehicle_models.unique_id = renew_vehicle_particulars.vehicle_model 
    and (renew_vehicle_particulars.datetime between '$start_date' and '$end_date')
    ";

    $query = mysqli_query($dbc, $sql);

    $today = date('Y-m-d H:i:s');

    $user_name = '';
    $phone = '';
    $email = '';
    $address = '';
    $id_type = '';
    $employment_status = '';
    $occupation = '';
    $vehicle_type = '';
    $model_name = '';
    $vehicle_make = '';
    $year_of_make = '';
    $plate_no = '';
    $engine_no = '';
    $chasis_no = '';
    $vehicle_license = '';
    $vehicle_color = '';
    $license_expiry = '';
    $insurance_expiry = '';
    $road_worthiness_expiry = '';
    $hackney_permit_expiry = '';
    $heavy_duty_permit_expiry = '';
    $datetime = '';

    $output = '
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>ID Type</th>
            <th>Employment Status</th>
            <th>Occupation</th>
            <th>Vehicle Type</th>
            <th>Model Name</th>
            <th>Vehicle Make</th>
            <th>Year of Make</th>
            <th>Number Plate</th>
            <th>Engine Number</th>
            <th>Chasis Number</th>
            <th>Vehicle License</th>
            <th>Vehicle Color</th>
            <th>Licence Expiry</th>
            <th>Insurance Expiry</th>
            <th>Road Worthiness Expiry</th>
            <th>Hackney Permit Expiry</th>
            <th>Heavy Duty Permit Expiry</th>
            <th>Date</th>
        </thead>
        <tbody>
    ';


    
    $i = 1;
    while($row = mysqli_fetch_array($query)){

        // $sub_output = '';
        $sub_output = '<tr>';

        $user_name = $row['title']. ' ' .$row['first_name']. ' ' . $row['last_name']. ' ' . $row['other_names'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];
        $id_type = ucwords($row['id_type']);
        $employment_status = $row['employment_status'];
        $occupation = $row['occupation'];
        $vehicle_type = $row['vehicle_type'];
        $model_name = $row['model_name'];
        $vehicle_make = $row['vehicle_make'];
        $year_of_make = $row['year_of_make'];
        $plate_no = $row['plate_no'];
        $engine_no = $row['engine_no'];
        $chasis_no = $row['chassis_no'];
        $vehicle_license = $row['vehicle_license'];
        $vehicle_color = $row['vehicle_color'];
        $license_expiry = $row['license_expiry'];
        $insurance_expiry = $row['insurance_expiry'];
        $road_worthiness_expiry = $row['road_worthiness_expiry'];
        $hackney_permit_expiry = $row['hackney_permit_expiry'];
        $heavy_duty_permit_expiry = $row['heavy_duty_permit_expiry'];
        $datetime = $row['datetime'];

        $sub_output .= '<td>'.$i++.'</td>';
        $sub_output .= '<td>'.$user_name.'</td>';
        $sub_output .= '<td>'.$email.'</td>';
        $sub_output .= '<td>'.$phone.'</td>';
        $sub_output .= '<td>'.$address.'</td>';
        $sub_output .= '<td>'.$id_type.'</td>';
        $sub_output .= '<td>'.$employment_status.'</td>';
        $sub_output .= '<td>'.$occupation.'</td>';
        $sub_output .= '<td>'.$vehicle_type.'</td>';
        $sub_output .= '<td>'.$model_name.'</td>';
        $sub_output .= '<td>'.$vehicle_make.'</td>';
        $sub_output .= '<td>'.$year_of_make.'</td>';
        $sub_output .= '<td>'.$plate_no.'</td>';
        $sub_output .= '<td>'.$engine_no.'</td>';
        $sub_output .= '<td>'.$chasis_no.'</td>';
        $sub_output .= '<td>'.$vehicle_license.'</td>';
        $sub_output .= '<td>'.$vehicle_color.'</td>';
        $sub_output .= '<td>'.$license_expiry.'</td>';
        $sub_output .= '<td>'.$insurance_expiry.'</td>';
        $sub_output .= '<td>'.$road_worthiness_expiry.'</td>';
        $sub_output .= '<td>'.$hackney_permit_expiry.'</td>';
        $sub_output .= '<td>'.$heavy_duty_permit_expiry.'</td>';
        $sub_output .= '<td>'.$datetime.'</td>';


        $sub_output .= '</tr>';
        // }

        $output .= $sub_output;
    }
    $output .= '</tbody>';

    echo $output;
?>