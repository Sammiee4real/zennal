<?php
    global $dbc;
	require_once('../../../config/functions.php');

    // $get_loan_applications = get_rows_from_one_table_by_id('','approval_status', 3 , 'date_created');

    $req = $_POST;
    // $req = array(
    //     'start' =>  0,
    //     'length'    =>  5,
    //     'draw'  =>  1
    // );
    $sn = 1;
    $query = '';
    $cols = '
        users.first_name, 
        users.last_name, 
        vehicle_reg_installment.total, 
        vehicle_reg_installment.interest_per_month, 
        vehicle_reg_installment.amount_to_repay, 
        vehicle_reg_installment.amount_deducted_per_month, 
        vehicle_reg_installment.current_repayment_month, 
        vehicle_reg_installment.date_created, 
        installment_payment_interest.no_of_month
    ';
    $cols = explode(', ', $cols);
    $output = array();
    $query .= "SELECT * FROM vehicle_reg_installment 
    inner join users on users.unique_id = vehicle_reg_installment.user_id 
    inner join installment_payment_interest 
    on installment_payment_interest.unique_id = vehicle_reg_installment.installment_id 
    where vehicle_reg_installment.approval_status = 3 ";
    $totalrow = mysqli_num_rows(mysqli_query($dbc, $query));
    if(isset($req["search"]["value"]))
    {
        for($i=0; $i<=(count($cols)-1); $i++) :
            if($i == 0) : 
                $query .= ' and ('.$cols[$i].' LIKE "%'.$req["search"]["value"].'%" ';
            else : 
                $query .= 'OR '.$cols[$i].' LIKE "%'.$req["search"]["value"].'%" ';
            endif;
        endfor;
        $query.=')';
    }

    if(isset($req["order"]))
    {
        $query .= 'ORDER BY '.$req['order']['0']['column'].' '.$req['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY vehicle_reg_installment.date_created DESC ';
    }

    if($req["length"] != -1)
    {
        $query .= 'LIMIT ' . $req['start'] . ', ' . $req['length'];
    }
    // exit($query);
    $statement = mysqli_query($dbc, $query);
    // $result = mysqli_fetch_array($statement);
    $data = array();
    $filtered_rows = mysqli_num_rows($statement);
    while($row = mysqli_fetch_array($statement))
    {
        $equity_contribution = (30/100) * $row['total'];
        $interest_per_month = $row['interest_per_month'];
        $total_amount_to_repay = $row['amount_to_repay'];
        $amount_deducted_per_month = $row['amount_deducted_per_month'];
        $amount_to_borrow = $row['total'] - intval($equity_contribution);
        $no_of_repayment = $row['no_of_month'];


        $sub_array = array();
        
        $sub_array[] = $sn++;

        $sub_array[] = $row['first_name'].' '.$row['last_name'];
        $sub_array[] = 'Vehicle Registration';
        $sub_array[] = '&#8358;'.number_format($amount_to_borrow, 2);
        $sub_array[] = '&#8358;'.number_format($interest_per_month, 2);
        $sub_array[] = $no_of_repayment;
        $sub_array[] = $row['current_repayment_month'];
        $sub_array[] = '&#8358;'.number_format($total_amount_to_repay, 2);
        $sub_array[] = '&#8358;'.number_format($amount_deducted_per_month, 2);
        $sub_array[] = $row['date_created'];

        $data[] = $sub_array;
    }

    // exit(print_r($data));

    $output = array(
        "draw"				=>	intval($req["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	$totalrow,
        "data"				=>	$data
    );

    // exit($output)


    echo json_encode($output);
?>