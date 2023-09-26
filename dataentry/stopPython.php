<?php
require_once("config/db.php");
require_once("functions.php");
define('OS', 'windows');
$sql = "SELECT tracker_value FROM  excel_upload_tracker WHERE tracker_name = 'process_id'";
$result = executeSQlAll($sql, []);
if( $result[0]->tracker_value != "" ){

    $oldProcessId = $result[0]->tracker_value;
    terminateProcess($oldProcessId);
    // / reset the entries in tracker table
    // $updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name  IN ('total', 'processed', 'success', 'error')";
    // $stmt = $pdo->prepare($updateSql);
    // $stmt->execute( [0]);
    $updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name = 'process-status'";
    $stmt = $pdo->prepare($updateSql);
    $stmt->execute( ['stopped']);
}


function terminateProcess($pid){
	if(OS == 'windows'){
		$command = "taskkill /PID $pid /F";
	} else {
		$command = "kill -9 $pid";
	}
   
	
	system($command);
}
