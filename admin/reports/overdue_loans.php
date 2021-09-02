<?php
	require_once('../../config/functions.php');
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT * FROM personal_loan_application, users 
    where users.unique_id = personal_loan_application.user_id 
    and 
    personal_loan_application.approval_date between '$start_date' and '$end_date'
    ";

    $query = mysqli_query($dbc, $sql);

    $today = date('Y-m-d H:i:s');

    $user_name = '';
    $phone = '';
    $email = '';
    $loan_purpose = '';
    $requested_amount = '';
    $approved_amount = '';
    $approval_date = '';
    $loan_months = '';
    $repay_date = '';

    $output = '
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Loan Purpose</th>
            <th>Requested Amount</th>
            <th>Approved Amount</th>
            <th>Approval Date</th>
            <th>Loan Months</th>
            <th>Expected Repayment Date</th>
        </thead>
        <tbody>
    ';


    
    $i = 1;
    while($row = mysqli_fetch_array($query)){
        $approval_date = $row['approval_date'];
        $loan_months = $row['repayment_months'];

        $due_date = date('Y-m-d', strtotime($approval_date.' +'.$loan_months.' months'));

        $sub_output = '';
        


        if(strtotime($today) > strtotime($due_date)){
            $sub_output .= '<tr>';

            $user_name = $row['title']. ' ' .$row['first_name']. ' ' . $row['last_name']. ' ' . $row['other_names'];
            $email = $row['email'];
            $phone = $row['phone'];
            $loan_purpose = $row['loan_purpose'];
            $requested_amount = $row['user_selection_amount'];
            $approved_amount = $row['user_approved_amount'];
            $approval_date = $row['approval_date'];
            $loan_months = $row['repayment_months'];
            $repay_date = $due_date;

            $sub_output .= '<td>'.$i++.'</td>';
            $sub_output .= '<td>'.$user_name.'</td>';
            $sub_output .= '<td>'.$email.'</td>';
            $sub_output .= '<td>'.$phone.'</td>';
            $sub_output .= '<td>'.$loan_purpose.'</td>';
            $sub_output .= '<td>'.$requested_amount.'</td>';
            $sub_output .= '<td>'.$approved_amount.'</td>';
            $sub_output .= '<td>'.$approval_date.'</td>';
            $sub_output .= '<td>'.$loan_months.'</td>';
            $sub_output .= '<td>'.$repay_date.'</td>';


            $sub_output .= '</tr>';
        }

        $output .= $sub_output;
    }
    $output .= '</tbody>';

    echo $output;
?>