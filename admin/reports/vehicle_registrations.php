<?php
	require_once('../../config/functions.php');
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT DISTINCT * from vehicle_reg_payment, vehicle_registration, vehicle_models, vehicle_brands, vehicles, users where vehicle_reg_payment.reg_id = vehicle_registration.unique_id and users.unique_id = vehicle_reg_payment.user_id and vehicle_registration.vehicle_model = vehicle_models.unique_id and vehicle_brands.unique_id = vehicle_models.brand_id and vehicles.unique_id = vehicle_registration.vehicle_type 
    and (vehicle_reg_payment.date_created between '$start_date' and '$end_date')
    ";

    $query = mysqli_query($dbc, $sql);

    $today = date('Y-m-d H:i:s');

    $user_name = '';
    $phone = '';
    $email = '';
    $city = '';
    $delivery_address = '';
    $vh_make = '';
    $vh_model = '';
    $vh_brand = '';
    $mk_year = '';
    $vh_color = '';
    $occupation = '';
    $cAddr = '';
    $vh_name = '';
    $tint = '';
    $pl_num_type = '';
    $num_plate = '';
    $total = '';
    $date = '';

    $output = '
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Delivery Address</th>
            <th>Vehicle Make</th>
            <th>Vehicle Model</th>
            <th>Vehicle Brand</th>
            <th>Make Year</th>
            <th>Vehicle Color</th>
            <th>Occupation</th>
            <th>Contact Address</th>
            <th>Name on Vehicle</th>
            <th>Tinted Permit</th>
            <th>Number Plate Type</th>
            <th>Number Plate</th>
            <th>Total</th>
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
        $city = $row['city'];
        $delivery_address = $row['delivery_area'].', '.$row['delivery_address'];
        $vh_make = $row['vehicle_type'];
        $vh_model = $row['model_name'];
        $vh_brand = $row['brand_name'];
        $mk_year = $row['year_of_make'];
        $vh_color = $row['vehicle_color'];
        $occupation = $row['occupation'];
        $cAddr = $row['contact_address'];
        $vh_name = $row['name_on_vehicle'];
        $tint = $row['tinted_permit'];
        $pl_num_type = $row['plate_number_type'];
        $num_plate = $row['number_plate'];
        $total = $row['total'];
        $date = $row['date_created'];

        $sub_output .= '<td>'.$i++.'</td>';
        $sub_output .= '<td>'.$user_name.'</td>';
        $sub_output .= '<td>'.$email.'</td>';
        $sub_output .= '<td>'.$phone.'</td>';
        $sub_output .= '<td>'.$city.'</td>';
        $sub_output .= '<td>'.$delivery_address.'</td>';
        $sub_output .= '<td>'.$vh_make.'</td>';
        $sub_output .= '<td>'.$vh_model.'</td>';
        $sub_output .= '<td>'.$vh_brand.'</td>';
        $sub_output .= '<td>'.$mk_year.'</td>';
        $sub_output .= '<td>'.$vh_color.'</td>';
        $sub_output .= '<td>'.$occupation.'</td>';
        $sub_output .= '<td>'.$cAddr.'</td>';
        $sub_output .= '<td>'.$vh_name.'</td>';
        $sub_output .= '<td>'.$tint.'</td>';
        $sub_output .= '<td>'.$pl_num_type.'</td>';
        $sub_output .= '<td>'.$num_plate.'</td>';
        $sub_output .= '<td>'.$total.'</td>';
        $sub_output .= '<td>'.$date.'</td>';


        $sub_output .= '</tr>';
        // }

        $output .= $sub_output;
    }
    $output .= '</tbody>';

    echo $output;
?>