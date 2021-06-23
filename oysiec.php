<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    ini_set('memory_limit', '1500M');
    require 'excelVendor/autoload.php';
    require 'config/database_functions.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    $lgas = fetch_all_lgas();
    
    if(isset($_POST['submit'])  ){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);
        
        $lga = $_POST['lga'];
        echo $lga.'mee<br>';
        print_r($_POST);
        
        $sheet_data = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($sheet_data->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(TRUE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        
        
        // Parameter - array with excel worksheet data
        function sheetData($row) {
            
            global $rows;
            
            global $lga;
            
            global $banks;
            
            $re="";
            
            $name_col = 0;
            $role_col = 1;
            $account_number_col = 2;
            $bank_name_col = 3;
            $bank_code_col = 4;
            $bvn_col = 5;
            $amount_col = 6;
            $cleared_col = 7;
            
            $name = isset($row[$name_col]) ? $row[$name_col] : '';
            $role = isset($row[$role_col]) ? $row[$role_col] : '';
            $account_number = isset($row[$account_number_col]) ? $row[$account_number_col] : '';
            $account_number = strval($account_number);
            
            $bank_name = isset($row[$bank_name_col]) ? $row[$bank_name_col] : '';
            $bank_code = isset($row[$bank_code_col]) ? $row[$bank_code_col] : '';
            $bvn = isset($row[$bvn_col]) ? $row[$bvn_col] : '';
            $amount = isset($row[$amount_col]) ? $row[$amount_col] : '';
            $cleared = isset($row[$cleared_col]) ? $row[$cleared_col] : '';
            
            $similarity = "NOT MATCHED";
            $percentage = 0;
            $max_percent = 0;
            $verified_account_name = "";
            $verified_bank_name = "";
            
            
            if(strlen($account_number) == 9){
                $account_number = "0".$account_number;
            }else if(strlen($account_number) == 8){
                $account_number = "00".$account_number;
            }
            else if(strlen($account_number) == 7){
                $account_number = "000".$account_number;
            }
            else if(strlen($account_number) == 6){
                $account_number = "0000".$account_number;
            }
            
            $bank_index = array_search($bank_code, array_column($banks, 'code'));
            if($bank_index !== FALSE){
                $bank_code = $banks[$bank_index]['code'];
                try{
                    $acc_verification = resolve_account_number($account_number, $bank_code);
                    $acc_verification = json_decode($acc_verification, true);
                    if(!empty($acc_verification)){
                        if($acc_verification['status']){
                            $verified_account_name = $acc_verification['data']['account_name'];
                            foreach($rows as $person){
                                $person_name = isset($person[$name_col]) ? $person[$name_col] : '';
                                
                                $percentage = similarity($verified_account_name, $name)*100;
                                $sim = similar_text($name, $verified_account_name, $p1);
                                $sim2 = similar_text($verified_account_name, $name, $p2);
                                $max_percent = (int) max($percentage, $p1, $p2);
                                if(check_if_matched($name, $verified_account_name) || $max_percent >= 55){
                                    $role = isset($person[$role_col]) ? $person[$role_col] : '';
                                    $account_number = isset($person[$account_number_col]) ? $person[$account_number_col] : '';
                                    $account_number = strval($account_number);
                                    
                                    $bank_name = isset($person[$bank_name_col]) ? $person[$bank_name_col] : '';
                                    $bank_code = isset($person[$bank_code_col]) ? $person[$bank_code_col] : '';
                                    $bvn = isset($person[$bvn_col]) ? $person[$bvn_col] : '';
                                    $amount = isset($person[$amount_col]) ? $person[$amount_col] : '';
                                    $cleared = isset($person[$cleared_col]) ? $person[$cleared_col] : '';
                                    break;
                                }
                                
                            }
                            
                            insert_into_rectified_accounts($name, $role, $account_number, $bank_name, $bank_code, $bvn, $amount, $cleared, $lga);

                        }
                    }
                }catch(\Exception $e){
                    die($e->getMessage());
                }
            }
            
            $report = $similarity;
            
            
            return $re;     // ends and returns the html table
        }
        
        
        $excel_data = "";
        
        for($i=1; $i<count($rows); $i++){
            $excel_data .= sheetData($rows[$i]) .'<br/>';
        }
    }

?>

<html>
    <head>
        <title>Rectify Account Name and Account Number Mapping</title>
        <style>
            td{
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <form method="post" action="" enctype="multipart/form-data">
            
            <p>
                <div>
                    <label for="lga">Select An LGA</label>
                </div>
                <div>
                    <select name="lga" id="lga" placeholder="Select LGA" required>
                        <?php
                            if(!empty($lgas)){
                                foreach($lgas as $lga){
                                    $lga_name = $lga['lga_name'];
                        ?>
                        <option value="<?php echo $lga_name;?>"><?php echo $lga_name;?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </p>
            
            <p style="">
                <div>
                    <label for="file">Upload Excel File</label>
                </div>
                <div>
                    <input type="file" name="excel_file" id="file" required />
                </div>
                
            </p>
            <p style="">
                <input type="submit" name="submit" value="Submit"/>
            </p>
        </form>
    </body>
</html>







$role = isset($person[$role_col]) ? $person[$role_col] : '';
$account_number = isset($person[$account_number_col]) ? $person[$account_number_col] : '';
$account_number = strval($account_number);

$bank_name = isset($person[$bank_name_col]) ? $person[$bank_name_col] : '';
$bank_code = isset($person[$bank_code_col]) ? $person[$bank_code_col] : '';
$bvn = isset($person[$bvn_col]) ? $person[$bvn_col] : '';
$amount = isset($person[$amount_col]) ? $person[$amount_col] : '';
$cleared = isset($person[$cleared_col]) ? $person[$cleared_col] : '';



<?php
    function insert_into_rectified_accounts($name, $role, $account_number, $bank_name, $bank_code, $bvn, $amount, $cleared, $lga){
	    
	    global $mysqli;
	    
	    $name = mysqli_escape_string($mysqli, $name);
	    $role = mysqli_escape_string($mysqli, $role);
	    $account_number = mysqli_escape_string($mysqli, $account_number);
	    $bank_name = mysqli_escape_string($mysqli, $bank_name);
	    $bank_code = mysqli_escape_string($mysqli, $bank_code);
	    $bvn = mysqli_escape_string($mysqli, $bvn);
	    $amount = mysqli_escape_string($mysqli, $amount);
        $cleared = mysqli_escape_string($mysqli, $cleared);
	    $lga = mysqli_escape_string($mysqli, $lga);
	    
	    $unique_id = unique_id_generator($name.$bank_name);
	    
	    
	    
	    $sql = "SELECT id FROM rectified_accounts
	    WHERE name='$name' AND account_number='$account_number'";
	    
	    $query = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
	    
	    if(mysqli_num_rows($query) > 0){
	        
	        $sql = "UPDATE rectified_accounts SET
	        `name`='$name',
            `role`='$role',
	        `account_number`='$account_number',
	        `bank_name`='$bank_name',
            `bank_code`='$bank_code',
            `bvn`='$bvn',
	        `amount`='$amount',
	        `cleared`='$cleared',
	        `lga`='$lga'
	        WHERE name='$name' AND account_number='$account_number'
	        ";
	    
	        $query = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
	        
	    }else{
	        
	        $sql = "INSERT INTO rectified_accounts SET
	        `unique_id` = '$unique_id',
	        `name`='$name',
            `role`='$role',
	        `account_number`='$account_number',
	        `bank_name`='$bank_name',
            `bank_code`='$bank_code',
            `bvn`='$bvn',
	        `amount`='$amount',
	        `cleared`='$cleared',
	        `lga`='$lga',
	        `date_created`=NOW()
	        ";
	    
	        $query = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
	     
	    }
	    
	    return true;
	    
	}

?>