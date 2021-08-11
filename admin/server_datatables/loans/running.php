<?php
    global $dbc;
	require_once('../../../config/functions.php');

    $get_loan_applications = get_rows_from_one_table_by_id('personal_loan_application','approval_status', 3 , 'date_created');
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
        personal_loan_application.loan_purpose, 
        personal_loan_application.loan_interest, 
        personal_loan_application.user_approved_amount, 
        personal_loan_application.amount_to_repay, 
        personal_loan_application.date_created
    ';
    $cols = explode(', ', $cols);
    $output = array();
    $query .= "SELECT * FROM personal_loan_application 
    inner join users on users.unique_id = personal_loan_application.user_id 
    where approval_status = 3 ";
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
        $query .= 'ORDER BY date_created DESC ';
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
        $sub_array = array();
        
        $sub_array[] = $sn++;

        $sub_array[] = $row['first_name'].' '.$row['last_name'];
        $sub_array[] = $row['loan_purpose'];
        $sub_array[] = $row['loan_interest'].'%';
        $sub_array[] = '&#8358;'.number_format($row['user_approved_amount'], 2);
        $sub_array[] = '&#8358;'.number_format($row['amount_to_repay'], 2);
        $sub_array[] = $row['date_created'];

        $data[] = $sub_array;
    }

    $output = array(
        "draw"				=>	intval($req["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	$totalrow,
        "data"				=>	$data
    );


    echo json_encode($output);
?>