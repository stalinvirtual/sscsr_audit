<?php
require_once("config/db.php");
define('OS', 'windows');
session_start();
// define('OS', 'linux');
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	require_once("functions.php");
	// $sql = "SELECT process-status as pstatus FROM  excel_upload_tracker ";
	//  $result = executeSQlAll($sql, []);
	//  if( $result[0]->pstatus == "" ||  $result[0]->pstatus == "completed"){
	// 	$message = array(
	// 		'response' => array(
	// 			'status' => 'error',
	// 			'code' => '0', // whatever you want
	// 			'message' =>"Process already running",
	// 			'title' => 'Error'
	// 		)
	// 	);
	//  }
	// Python Block
	if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
		// Token mismatch, handle the error (e.g., log it or display an error message)
		die("CSRF token verification failed.");
	}
	$table_type = substr($_POST['selectedTableFormat'], 3);
	$no_of_days = $_POST['no_of_days'];
	$table_name = $_POST['examname'] . '_' . $_POST['exam_year'] . '_' . $table_type;
	$table_name = strtolower($table_name);
	$sql = "SELECT count((1)) as ct  FROM INFORMATION_SCHEMA.TABLES where  table_schema =:table_schema and table_name=:table_name";
	$params = array('table_schema' => "public", "table_name" => $table_name);
	$isExists = executeSQlAll($sql, $params);
	if ($isExists[0]->ct == 0) {
		$message = array(
			'response' => array(
				'status' => 'error',
				'code' => '0', // whatever you want
				'message' => $e->getMessage(),
				'title' => 'Error'
			)
		);
	} else {
		$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = :table_name";
		$params = array("table_name" => $table_name);
		$result = executeSQlAll($sql, $params);
		$i = 1;
		foreach ($result as $row) {
			if ($row->column_name == 'id') {
			} else {
				@$table_columns .= $row->column_name . ",";
				$i++;
			}
		}
		$table_columns = rtrim($table_columns, ',');
		$j = 1;
		foreach ($result as $row) {
			if ($row->column_name == 'id') {
			} else {
				@$table_value .= $row->column_name . ",";
				$j++;
			}
		}
		$table_value = rtrim($table_value, ',');
		if (!empty($_FILES["excel_file_attachment"])) {  //// File attachment Start
			// encypt Checking start
			$exam_name           = $_POST['examname'];
			$exam_year           = $_POST['exam_year'];
			$selectedTableFormat = $_POST['selectedTableFormat'];
			if ($selectedTableFormat  == 'is_kyas') {
				$application = "kyas";
			} else if ($selectedTableFormat  == 'is_tier') {
				$selectedtier = $_POST['selectedtier'];
				$application = "tier" . "_" . $selectedtier;
			} else if ($selectedTableFormat  == 'is_skill') {
				$selectedtier = $_POST['selectedtier'];
				$application = "skill" . "_" . $selectedtier;
			} else if ($selectedTableFormat  == 'is_skill') {
				$selectedtier = $_POST['selectedtier'];
				$application = "skill" . "_" . $selectedtier;
			} else if ($selectedTableFormat  == 'is_dme') {
				$selectedtier = $_POST['selectedtier'];
				$application = "dme" . "_" . $selectedtier;
			} else if ($selectedTableFormat  == 'is_pet') {
				$selectedtier = $_POST['selectedtier'];
				$application = "pet" . "_" . $selectedtier;
			} else if ($selectedTableFormat  == 'is_dv') {
				$selectedtier = $_POST['selectedtier'];
				$application = "dv" . "_" . $selectedtier;
			}
			$exam_select_name = $exam_name . "_" . $exam_year . "_" . $application;
			$totla_ec_value = $_FILES["excel_file_attachment"]["name"];
			$encrypted_array = explode("@", $totla_ec_value);
			$cnt = count($encrypted_array);
			if ($cnt == 1) {
				echo "error_file";
				exit;
			} else {
				$ec_value = $encrypted_array[1];
				$password = '2ss0CSrva23';
				// CBC has an IV and thus needs randomness every time a message is encrypted
				$method = 'aes-256-cbc';
				// Must be exact 32 chars (256 bit)
				// You must store this secret random key in a safe place of your system.
				$key = substr(hash('sha256', $password, true), 0, 32);
				// IV must be exact 16 chars (128 bit)
				$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
				// Encrypted Text
				$encrypted = str_replace('-', '/', $ec_value);
				$decrypted = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);
				//echo 'plaintext=' . $plaintext . "\n";
				//echo 'cipher=' . $method . "\n";
				//echo 'encrypted to: ' . $encrypted . "\n";
				if (trim($exam_select_name) == trim($decrypted)) {
					$strlength =  strlen($decrypted);
					if ($strlength > 0) {
						//echo 'decrypted to: ' . $decrypted . "\n\n";
						$file_extension = $encrypted_array[2];
						$final_file_name = $decrypted . $file_extension;
						$final_file_name_with_out_extension  = $decrypted;
						//Python Module Start
						$tmp_name 		= $_FILES['excel_file_attachment']['tmp_name'];
						$error 			 = $_FILES['excel_file_attachment']['error'];
						$size 			 = $_FILES['excel_file_attachment']['size'];
						$type 			 = $_FILES['excel_file_attachment']['type'];
						$target_dir 	 = 'uploaded_excel_files/';
						$file_name 		 = $final_file_name_with_out_extension;
						$removeExtension = substr($file_name, 0, strrpos($file_name, '.'));
						$final_file 	 =  $target_dir . basename($final_file_name_with_out_extension);
						############ Tier ID Checking Based Exam ###########
						$tier_id = $_POST["selectedtier"];
						if (isset($tier_id) && ($tier_id != 0)) {
							try {
								$exam_year 	= $_POST['exam_year'];
								$id 	   	= $table_name . '_' . $tier_id;
								$str 	   	= $id;
								$array 	   	= explode("_",$str);
								$exam_code 	= $array[0].$array[1];
								$daycount	= $no_of_days;
								$created_on = date('Y-m-d h:i:s');
								$stmt       = $pdo->prepare("insert into sscsr_db_table_tier_master (id,table_name, tier_id, table_exam_year, status,exam_code,no_of_days,stop_status,created_on) values (?,?,?,?,?,?,?,?,?)");
								$stmt->execute([$id, $table_name, $tier_id, $exam_year, '0',$exam_code,$daycount,'1',$created_on]);
								$stmt2      = $pdo->prepare("insert into sscsr_db_table_city_tier_master (id,table_name, tier_id, table_exam_year, status,exam_code,no_of_days,stop_status,created_on) values (?,?,?,?,?,?,?,?,?)");
								$stmt2->execute([$id, $table_name, $tier_id, $exam_year, '0',$exam_code,$daycount,'0',$created_on]);
							} catch (exception $e) {
								//echo "ex: ".$e; 
							}
						}
						$tier_id 					= $_POST["selectedtier"];
						$excel_file_attachment_name = $final_file_name_with_out_extension;
						$exam_code 					= $_POST['examname'] . $_POST['exam_year'];
						$exam_code 				    = trim(strtolower($exam_code));
						if (move_uploaded_file($tmp_name, $final_file)) {
							$filename = "log/sscsr_log.log";
							$file = fopen($filename, "w");
							fclose($file);
							$updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name  IN ('total', 'processed', 'success', 'error')";
							$stmt = $pdo->prepare($updateSql);
							$stmt->execute( [0]);
							$updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name = 'process-status'";
							$stmt = $pdo->prepare($updateSql);
							$stmt->execute( ['']);
								$dt 				= date('Y-m-d h:i:s');
							$dataEntryDirectory 	= dirname(__FILE__);
							$excel_file_attachment_name_path = $dataEntryDirectory . "/uploaded_excel_files/" . $excel_file_attachment_name;
							//echo 'py C:/xampp/htdocs/sscsr/sscsr/dataentry/python/upload_excel_file.py '.$excel_file_attachment_name_path.' '.$table_name.' '.$table_columns.' '.$exam_code.' '.$tier_id.' '.$table_value;
								$haystack        = $_POST['examname'];
								$needle          = 'phase';
							if (strpos($haystack, $needle) !== false) {
								/****
								 * For Selection Post
								 */
								if ($_POST['selectedTableFormat']  == 'is_kyas') {
									// $last_line =  system(' py  ' . $dataEntryDirectory . '/python/upload_excel_file_01.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value . ' &', $retval);
									$command = ' py  ' . $dataEntryDirectory . '/python/upload_excel_file_01.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value ;
								} else if ($_POST['selectedTableFormat']  == 'is_tier') {
									// $last_line =  system(' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_tier_dv.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value . ' &', $retval);
									$command = ' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_tier_dv.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value ;
								} else if ($_POST['selectedTableFormat']  == 'is_skill') {
									// $last_line =  system(' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_skill.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value . ' &', $retval);
									$command = ' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_skill.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value ;
								} else if ($_POST['selectedTableFormat']  == 'is_dme') {
								} else if ($_POST['selectedTableFormat']  == 'is_pet') {
								} else if ($_POST['selectedTableFormat']  == 'is_dv') {
									// $last_line =  system(' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_tier_dv.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value . ' &', $retval);
									$command = ' py  ' . $dataEntryDirectory . '/python/upload_excel_file_sp_tier_dv.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value ;
								}
								/****
								 * For Selection Post
								 */
							} else {
								// $last_line =  system(' py  ' . $dataEntryDirectory . '/python/upload_excel_file_01.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value . ' &', $retval);
								$command = ' py  ' . $dataEntryDirectory . '/python/upload_excel_file_01.py ' . $excel_file_attachment_name_path . ' ' . $table_name . ' ' . $table_columns . ' ' . $exam_code . ' ' . $tier_id . ' ' . $table_value;
							 	 //echo $command;
							 //exit;
							}
						}
						// get the process id from table to kill before start new process
						$sql = "SELECT tracker_value FROM  excel_upload_tracker WHERE tracker_name = 'process_id'";
						$result = executeSQlAll($sql, []);
						if( $result[0]->tracker_value != "" ){
							$oldProcessId = $result[0]->tracker_value;
							terminateProcess($oldProcessId);
							// / reset the entries in tracker table
							$updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name  IN ('total', 'processed', 'success', 'error')";
							$stmt = $pdo->prepare($updateSql);
							$stmt->execute( [0]);
							$updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name = 'process-status'";
							$stmt = $pdo->prepare($updateSql);
							$stmt->execute( ['']);
						}
						$newProcessId = startProcess($command);
						// save the new processid to table 
						$updateSql = "update excel_upload_tracker set tracker_value = ? where tracker_name = 'process_id'";
						$stmt = $pdo->prepare($updateSql);
						$stmt->execute( [$newProcessId]);
						echo "ok";
						//Python Module Start
					}
				} else {
					echo "error_file";;
				}
			}
			// encypt Checking  End
		} // File attachment End
	}
} else {
	header("Location: index.php");
	exit();
}
// process id functions
function startProcess($command)
{
	if (OS == 'windows') {
		$descriptorspec = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w"),
		);
		//proc_open — Execute a command  
		//'start /b' runs command in the background  
		if (is_resource($prog = proc_open("start /b " . $command, $descriptorspec, $pipes, null, NULL))) {
			//Get Parent process Id  
			$ppid = proc_get_status($prog);
			$pid = $ppid['pid'];
		} else {
			echo ("Failed to execute!");
			exit();
		}
		$output = array_filter(explode(" ", shell_exec("wmic process get parentprocessid,processid | find \"$pid\"")));
		array_pop($output);
		$pid = end($output);
		return $pid;
	} else {
		$command .= " > /dev/null 2>&1 & echo $!";
		exec($command, $output, $code);
		return $output[0];
	}
}
function terminateProcess($pid)
{
	if (OS == 'windows') {
		$command = "taskkill /PID $pid /F";
	} else {
		$command = "kill -9 $pid";
	}
	system($command);
}
