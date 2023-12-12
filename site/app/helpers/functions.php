<?php

//  $base_url =  "http://" . $_SERVER['SERVER_NAME'];
$base_url = "http://" . $_SERVER['SERVER_NAME'];
$GLOBALS['site_url'] = $base_url;
//$base_url = "http://10.163.2.181:81";
$GLOBALS['local_path'] = $base_url . "/sscsr_audit/dataentry/ftp/";
$GLOBALS['local_path'] = $base_url . "/sscsr_audit/dataentry/ftp/";
$GLOBALS['pdf_header_image_server_path'] = $base_url . "/sscsr_audit/site/exam_assets/";
$GLOBALS['pdf_header_image_server_path'] = $base_url . "/sscsr_audit/site/exam_assets/";
// $headerImg = $GLOBALS['pdf_header_image_server_path'] ."header.png" ;
//$GLOBALS['local_path'] =  "C:\\xampp\htdocs\\rd\\\security_audit\\dataentry\\ftp//";
$GLOBALS['local_instructions_path'] = "C:\\xampp\htdocs\\sscsr_audit\\dataentry\\important_instructions\\";
//$GLOBALS['local_instructions_path'] = "C:\\xampp\htdocs\\rd\\\security_audit\\dataentry\\important_instructions\\";
$local_bulk_mail = "http://localhost/dataentry/bulkemail";
$local_bulk_mail = "http://localhost/dataentry/bulkemail";
/**
 * @author Stalin
 * @value :  Subject
 */
function filterNAValues($value)
{
	return $value !== "NA";
}
function valueAdded($str)
{
	$subject_value = explode('\n', $str);
	$subjectStr = '';
	if (is_array($subject_value)) {
		foreach ($subject_value as $value) {
			$subjectStr .= $value . chr(10);
		}
	} else {
		$subjectStr = $str;
	}
	return $subjectStr;
}
function countSubject($str)
{
	$subject_value = explode('\n', $str);
	return count($subject_value);
}
function getDobFormat($date)
{
	$var_day = substr($date, 0, 2);
	$var_month = substr($date, 2, 2);
	$var_year = substr($date, 4, 4);
	$final_new_date_format = $var_day . "-" . $var_month . "-" . $var_year;
	return $final_new_date_format;
}
function getDateFormate($date)
{
	$date = date("d-m-Y", strtotime($date));
	if ($date == '01-01-1970') {
		$newdate = 'NA';
	} else {
		$newdate = $date;
	}
	return $newdate;
}
function getPresentAddressDetails($str)
{
	$add_array = explode(',', $str);
	if ($add_array[3] == "NA") {
		$add_array[3] = "";
	} else {
		$add_array[3] = $add_array[3];
	}
	if ($add_array[4] == "NA") {
		$add_array[4] = "";
	} else {
		$add_array[4] = $add_array[4];
	}
	if ($add_array[5] == "NA") {
		$add_array[5] = "";
	} else {
		$add_array[5] = $add_array[5];
	}
	if ($add_array[1] == "NA") {
		$add_array[1] = "";
	} else {
		$add_array[1] = $add_array[1];
	}
	if ($add_array[2] == "NA") {
		$add_array[2] = "";
	} else {
		$add_array[2] = $add_array[2];
	}
	if ($add_array[0] == "NA") {
		$add_array[0] = "";
	} else {
		$add_array[0] = $add_array[0];
	}
	$finalOutput = $add_array[3] . "," . $add_array[4] . "," . $add_array[5] . "," . $add_array[1] . "," . $add_array[2] . "," . $add_array[0] . ".";
	return $finalOutput;
}
function photoPath($data)
{
	$haystack = $data['tableName'];
	$needle = 'phase';
	if (strpos($haystack, $needle) !== false) {
		$newarray = explode('_', $haystack);
		$exam_folder_path = $newarray[0] . $newarray[1] . "_" . $newarray[3];
		$local_path = $GLOBALS["local_path"];
		$full_photo_path = $local_path . $exam_folder_path . '/photo/';
	} else {
		$local_path = $GLOBALS["local_path"];
		$exam_shot_name = $data['exam_name']->table_exam_short_name;
		$exam_folder_path = $data['exam_name']->table_exam_short_name . "_" . $data['year_of_exam'];
		$full_photo_path = $local_path . $exam_folder_path . '/photo/';
	}
	return $full_photo_path;
}
function signPath($data)
{
	$haystack = $data['tableName'];
	$needle = 'phase';
	if (strpos($haystack, $needle) !== false) {
		$newarray = explode('_', $haystack);
		$exam_folder_path = $newarray[0] . $newarray[1] . "_" . $newarray[3];
		$local_path = $GLOBALS["local_path"];
		$full_sign_path = $local_path . $exam_folder_path . '/sign/';
	} else {
		$local_path = $GLOBALS["local_path"];
		$exam_shot_name = $data['exam_name']->table_exam_short_name;
		$exam_folder_path = $data['exam_name']->table_exam_short_name . "_" . $data['year_of_exam'];
		$full_sign_path = $local_path . $exam_folder_path . '/sign/';
	}
	return $full_sign_path;
}
function instpath()
{
	global $local_instructions_path;
	return $local_instructions_path;
}
function emailpath()
{
	global $local_bulk_mail;
	return $local_bulk_mail;
}
