<?php 
include 'config/db.php';

require_once("functions.php");

$dataBasePath = "C:/xampp/htdocs/sscsr/dataentry/data/";



$sql = "SELECT * FROM excel_upload_tracker ";
$result = getAll($sql);
$totalRecords = 0;
$currentRecords = 0;
$procesStatus = "";
$processMessage = "";
foreach($result as $row) {
    if( $row->tracker_name == 'total'){
        $totalRecords = $row->tracker_value ?? 0;
    }
    if( $row->tracker_name == 'processed'){
        $currentRecords = $row->tracker_value ?? 0;
    }
    if( $row->tracker_name == 'process-status'){
        $procesStatus = $row->tracker_value ?? 0;
    }
    if( $row->tracker_name == 'success'){
        $successRecords = $row->tracker_value ?? 0;
    }
    if( $row->tracker_name == 'error'){
        $errorRecords = $row->tracker_value ?? 0;
    }

}


$response = new stdClass();
$response->total = $totalRecords;
$response->processed = $currentRecords;
$response->processing = 1;
if( ($procesStatus ==  'stopped' || $procesStatus ==  'done') && $totalRecords != 0){
    $response->processing = 0;
    $message = "<p style='color:blue'>Total number of records available $totalRecords</p> 
    <p style='color:blue'>Total number of records processed $currentRecords</p><p style='color:green'>Total inserted records $successRecords</p> <p style='color:red'>Total error records $errorRecords</p>";
     if( $procesStatus == 'stopped'){
        $message .= "<br/> <span style='color:red;font-size:11px'>Note: Process Stopped by user</span>";
    }
    $response->message = $message;
    //update total and processed
    // $updateSql = "update excel_upload_tracker set tracker_value = 0 where tracker_name in ('total', 'processed', 'success', 'error')";
   
    // $stmt = $pdo->prepare($updateSql);
    //$stmt->execute();

    // // update total and processed
    // $updateSql = "update excel_upload_tracker set tracker_value = '' where tracker_name in ('process_id')";
   
    // $stmt = $pdo->prepare($updateSql);
    // $stmt->execute();
    //executeSQl($updateSql);
}
exit( json_encode($response) );