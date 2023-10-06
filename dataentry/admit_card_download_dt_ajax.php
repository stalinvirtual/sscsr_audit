<?php
// ini_set('memory_limit', '100M');
//ini_set('memory_limit', '-1');

require_once("config/db.php");

require_once("functions.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	session_start();
	
	if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
		// Token mismatch, handle the error (e.g., log it or display an error message)
		die("CSRF token verification failed.");
	}
	$table_type = substr(cleanData($_POST['selectedTableFormat']), 3);
	$table_name = cleanData($_POST['examname']) . '_' . cleanData($_POST['exam_year']) . '_' . $table_type;
	$table_name = strtolower($table_name);
	$download_options = trim($_POST['download_options']);
	$selectedtier = trim($_POST['selectedtier']);
	$kyas_table = cleanData($_POST['examname']) . '_' . cleanData($_POST['exam_year']) . '_' . 'kyas';
	// $person = array(
	// 	"table_type" => $table_type,
	// 	"table_name" => $table_name,
	// 	"download_options" => $download_options,
	// 	"selectedtier" => $selectedtier,
	// );
	// 	SELECT kd.*,ted.*,t.tier_name, t.tier_id, ted.*,t.tier_name, 
// t.tier_id,
// CONCAT(kd.present_address,', ',kd.present_district,', ',kd.present_state,', ',substring(kd.present_pincode,1,6)) as candidate_address 
// FROM cgle_2019_kyas kd 
// JOIN cgle_2019_tier ted ON kd.reg_no = ted.reg_no and trim(kd.exam_code) = trim(ted.exam_code) 
	// JOIN tier_master t ON ted.tier_id = cast(t.tier_id as char(255)) 
// where ted.tier_id = '1' and ted.ac_printed = '1' 

	// echo $_POST['examname'];
// echo $_POST['exam_year'];
// echo $table_type;
// die;


	$output = isExists($_POST['examname'], $_POST['exam_year'], $table_type);
	if ($output->count == 1) {


		if ($download_options == '1') {
			$sql = "SELECT kd.reg_no,kd.dob,kd.cand_name,ted.roll_no,ted.updated_on,ted.ipaddress FROM $kyas_table kd 
JOIN $table_name ted ON 
kd.reg_no = ted.reg_no and trim(kd.exam_code) = trim(ted.exam_code) 
JOIN tier_master t ON ted.tier_id = cast(t.tier_id as char(255)) where ted.tier_id = :tier_id and ted.ac_printed = :ac_printed";
			$sql2 = "
SELECT column_name 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE table_name = :kyas_table and column_name in ('cand_name','reg_no','dob')
UNION ALL 
SELECT column_name 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE table_name = :other_table and column_name  in('roll_no','ipaddress' ,'updated_on')";
		} else {
			$sql = "SELECT kd.reg_no,kd.dob,kd.cand_name,ted.roll_no FROM $kyas_table kd 
JOIN $table_name ted ON 
kd.reg_no = ted.reg_no and trim(kd.exam_code) = trim(ted.exam_code) 
JOIN tier_master t ON ted.tier_id = cast(t.tier_id as char(255)) where ted.tier_id = :tier_id and ted.ac_printed = :ac_printed";
			$sql2 = "
SELECT column_name 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE table_name = :kyas_table and column_name in ('cand_name','reg_no','dob')
UNION ALL 
SELECT column_name 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE table_name = :other_table and column_name  in('roll_no')";
		}
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['tier_id' => $selectedtier, 'ac_printed' => $download_options]);
		$getresult = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$count = count($getresult);

		if ($count > 0) {
			$getcol = $pdo->prepare($sql2);
			$getcol->execute(['kyas_table' => $kyas_table, 'other_table' => $table_name]);
			if ($download_options == 1) {
				$filename = $table_name . '_' . $selectedtier . '_downloaded.csv';
			} else {
				$filename = $table_name . '_' . $selectedtier . '_not_downloaded.csv';
			}
			$file = fopen($filename, 'w');
			$headers = array(); // Replace with your actual column names
			$row = $getcol->fetchAll(PDO::FETCH_ASSOC);
			foreach ($row as $val) {
				if ($val['column_name'] == 'updated_on') {
					$val['column_name'] = 'Downloaded On';
				}
				if($val['column_name'] == 'reg_no'){
					$val['column_name'] = 'Reg No';
				}
				if($val['column_name'] == 'dob'){
					$val['column_name'] = 'DOB';
				}
				if($val['column_name'] == 'cand_name'){
					$val['column_name'] = 'Candidate Name';
				}
				if($val['column_name'] == 'roll_no '){
					$val['column_name'] = 'Roll No';
				}
				if($val['column_name'] == 'ipaddress'){
					$val['column_name'] = 'Ipaddress';
				}
				$headers[] = $val['column_name'];
			}
			fputcsv($file, $headers);
			foreach ($getresult as $res) {
				fputcsv($file, $res);
			}
			fclose($file);
			// Provide a download link for the CSV file
			// echo '<a href="' . $filename . '" style="color:white !important"><button class="btn hvr-icon-down col-5" id="download_btn" style="margin: 10px 0px 0px 329px;">
			// Download</button></a>';
			// $reloadTime = 5000; // Reload time in milliseconds (5 seconds)

			// echo '<script type="text/javascript">';
			// echo 'setTimeout(function(){location.reload(); }, '.$reloadTime.');';

			// echo '</script>';

			// $html = '<a href="' . $filename . '" style="color:white !important"><button class="btn hvr-icon-down col-5" id="download_btn" style="margin: 10px 0px 0px 329px;">Download</button></a>';
			// $response = array(
			// 	"html" => $html,
			// 	"message" => "Download button"

			// );
			$target_path = "csv/" . $filename . ".csv";
rename($filename, $target_path);

// Return the unique identifier as a response to the AJAX request
$response = array(
    "html" => $filename,
	'download_option' => $download_options,
	'tableName' => $table_name,
	'selectedtier' =>$selectedtier,
    "message" => "Download button"
);

			echo json_encode(
				array(
					"status" => 0,
					"data" => $response
				)
			);

		} else {
			$response = array(
				"tablename" => $table_name,
				"message" => "No records found"

			);

			echo json_encode(
				array(
					"status" => 1,
					"data" => $response
				)
			);

		}
	} else {

		$response = array(
			"tablename" => $table_name,
			"message" => "Table does not exist"
		);

		echo json_encode(
			array(
				"status" => 2,
				"data" => $response
			)
		);
		
	}
	
} else {

	header("Location: index.php");
	exit();
}
?>