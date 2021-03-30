<?php
	include('../config/functions.php');
	$user_approved_amount = $_POST['user_approved_amount'];
	$loan_id = $_POST['loan_id'];
	$user_id = $_SESSION['user']['unique_id'];
	$get_user_details = get_one_row_from_one_table_by_id('user_employment_details','user_id',$user_id, 'date_created');
	$submit_loan_application = submit_loan_application($user_approved_amount, $loan_id);
	$submit_loan_application_decode = json_decode($submit_loan_application, true);
	if($submit_loan_application_decode['status'] == "1"){
		echo "success";
		$total_amount_to_repay = $submit_loan_application_decode['data'];
		$email = $get_user_details['official_email_address'];
		$subject = "Loan Application - Zennal";
		$content = "Hello, your loan application on Zennal was successful and the loan has been disbursed to your bank account<br>. Below is your repayment plan.<br>";
		$content.='<div class="container mt-5">
	            <div class="row justify-content-center">
	                <div class="col-md-8">
	                    <div class="card p-5 mb-5">
	                        <div class="card-header">
	                            Repayment Details
	                        </div>
	                        <div class="card-body">
	                            <h5 class="card-title mt-4">Repayment Details</h5>
	                            <div class="card-text mt-3">
	                                Total Amount to repay: <strong>&#8358;'. number_format($total_amount_to_repay).'</strong><br><br>
	                                No of months: <strong> 1</strong><br><br>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>';
		email_function($email, $subject, $content);
	}else{
		echo $submit_loan_application_decode['msg'];
	}
?>