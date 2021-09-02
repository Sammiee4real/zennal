<?php
	require_once('../../config/functions.php');
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT * FROM users, insurers, insurance_packages, vehicle_insurance where users.unique_id = vehicle_insurance.user_id and insurers.unique_id = vehicle_insurance.insurer_id and insurance_packages.unique_id = vehicle_insurance.package_plan_id 
    and (vehicle_insurance.datetime between '$start_date' and '$end_date')
    ";

    $query = mysqli_query($dbc, $sql);

    $today = date('Y-m-d H:i:s');

    $user_name = '';
    $email = '';
    $phone = '';
    $make_of_vehicle = '';
    $other_make_of_vehicle = '';
    $vehicle_type = '';
    $vehicle_reg_no = '';
    $vehicle_model = '';
    $year_of_make = '';
    $risk_location = '';
    $insured_name = '';
    $insured_type = '';
    $sum_insured = '';
    $insurer_name = ''; 
    $engine_number = ''; 
    $chasis_no = '';
    $package_name = '';
    $payment_method = '';
    $amount_due = '';
    $datetime = '';

    $output = '
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vehicle Make</th>
            <th>Other Vehicle Make</th>
            <th>Vehicle Type</th>
            <th>Registration Number</th>
            <th>Vehicle Model</th>
            <th>Make Year</th>
            <th>Risk Location</th>
            <th>Insured Name</th>
            <th>Insured Type</th>
            <th>Sum Insured</th>
            <th>Insurer</th>
            <th>Engine Number</th>
            <th>Chassis Number</th>
            <th>Package Plan</th>
            <th>Payment Method</th>
            <th>Amount Due</th>
            <th>Phone</th>
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
        $make_of_vehicle = $row['make_of_vehicle'];
        $other_make_of_vehicle = $row['other_make_of_vehicle'];
        $vehicle_type = $row['vehicle_type'];
        $vehicle_reg_no = $row['vehicle_reg_no'];
        $vehicle_model = $row['vehicle_model'];
        $year_of_make = $row['year_of_make'];
        $risk_location = $row['risk_location'];
        $insured_name = $row['insured_name'];
        $insured_type = $row['insured_type'];
        $sum_insured = $row['sum_insured'];
        $insurer_name = $row['name']; 
        $engine_number = $row['engine_number']; 
        $chasis_no = $row['chassis_number'];
        $package_name = $row['package_name'];
        $payment_method = $row['payment_method'];
        $amount_due = $row['amount_due'];
        $datetime = $row['datetime'];

        $sub_output .= '<td>'.$i++.'</td>';
        $sub_output .= '<td>'.$user_name.'</td>';
        $sub_output .= '<td>'.$email.'</td>';
        $sub_output .= '<td>'.$phone.'</td>';
        $sub_output .= '<td>'.$make_of_vehicle.'</td>';
        $sub_output .= '<td>'.$other_make_of_vehicle.'</td>';
        $sub_output .= '<td>'.$vehicle_type.'</td>';
        $sub_output .= '<td>'.$vehicle_reg_no.'</td>';
        $sub_output .= '<td>'.$vehicle_model.'</td>';
        $sub_output .= '<td>'.$year_of_make.'</td>';
        $sub_output .= '<td>'.$risk_location.'</td>';
        $sub_output .= '<td>'.$insured_name.'</td>';
        $sub_output .= '<td>'.$insured_type.'</td>';
        $sub_output .= '<td>'.$sum_insured.'</td>';
        $sub_output .= '<td>'.$insurer_name.'</td>';
        $sub_output .= '<td>'.$engine_number.'</td>';
        $sub_output .= '<td>'.$chasis_no.'</td>';
        $sub_output .= '<td>'.$package_name.'</td>';
        $sub_output .= '<td>'.$payment_method.'</td>';
        $sub_output .= '<td>'.$amount_due.'</td>';
        $sub_output .= '<td>'.$datetime.'</td>';


        $sub_output .= '</tr>';
        // }

        $output .= $sub_output;
    }
    $output .= '</tbody>';

    echo $output;
?>