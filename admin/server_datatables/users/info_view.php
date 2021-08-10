<?php
    global $dbc;
	require_once('../../../config/functions.php');

    $get_users = get_rows_from_one_table('users','registered_on');
    $req = $_POST;
    // $req = array(
    //     'start' =>  0,
    //     'length'    =>  5,
    //     'draw'  =>  1
    // );
    $sn = 1;
    $query = '';
    $cols = 'unique_id, first_name, last_name, other_names, dob, email, phone, gender, marital_status, employment_status, registered_on';
    $cols = explode(', ', $cols);
    $output = array();
    $query .= "SELECT * FROM users ";
    $totalrow = mysqli_num_rows(mysqli_query($dbc, $query));
    if(isset($req["search"]["value"]))
    {
        for($i=0; $i<=(count($cols)-1); $i++) :
            if($i == 0) : 
                $query .= 'WHERE '.$cols[$i].' LIKE "%'.$req["search"]["value"].'%" ';
            else : 
                $query .= 'OR '.$cols[$i].' LIKE "%'.$req["search"]["value"].'%" ';
            endif;
        endfor;
    }

    if(isset($req["order"]))
    {
        $query .= 'ORDER BY '.$req['order']['0']['column'].' '.$req['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY registered_on DESC ';
    }

    if($req["length"] != -1)
    {
        $query .= 'LIMIT ' . $req['start'] . ', ' . $req['length'];
    }
    $statement = mysqli_query($dbc, $query);
    // $result = mysqli_fetch_array($statement);
    $data = array();
    $filtered_rows = mysqli_num_rows($statement);
    while($row = mysqli_fetch_array($statement))
    {
        $sub_array = array();
        
        $sub_array[] = $sn++;

        $sub_array[] = $row['unique_id'];
        $sub_array[] = $row['first_name'].' '.$row['last_name'].' '.$row['other_names'];
        $sub_array[] = $row['dob'];
        $sub_array[] = $row['email'];
        $sub_array[] = $row['phone'];
        $sub_array[] = $row['gender'];
        $sub_array[] = $row['marital_status'];
        $sub_array[] = $row['employment_status'];
        $sub_array[] = $row['registered_on'];

        $sub_array[] = '
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-eye"></i> View Details
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="view_employment_details.php?user_id='.$row["unique_id"].'">Employment Details</a>
                <a class="dropdown-item" href="view_financial_details.php?user_id='.$row["unique_id"].'">Financial Details</a>
            </div>
        </div>
        ';

        if($row['status'] == 1){
            $sub_array[] = '<button class="btn btn-danger btn-sm disable_user_modal" type="button" id="'.$row["unique_id"].'">Disable</button>';
        } else if($row['status'] == 0){
            $sub_array[] = '<button class="btn btn-primary btn-sm enable_user_modal" type="button" id="'.$row["unique_id"].'">Enable</button>';
        }

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