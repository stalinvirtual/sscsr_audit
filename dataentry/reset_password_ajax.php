<?php
require_once("config/db.php");
session_start();
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	require_once("functions.php");
	if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
		// Token mismatch, handle the error (e.g., log it or display an error message)
		die("CSRF token verification failed.");
	}
	$username = cleanData($_POST['user']);
	$password = cleanData($_POST['pass']);
	$confirmpassword = cleanData($_POST['cpass']);
	$encpassword = password_hash($confirmpassword, PASSWORD_DEFAULT);
	// $cpass = md5($confirmpassword);
	$sql2 = "SELECT * FROM erp_login_details WHERE  u_name =:u_name ";
	$stmt2 = $pdo->prepare($sql2);
	$stmt2->execute(['u_name' => $username]);
	$row = $stmt2->fetchAll();
	$count = count($row);
	if ($count != 0) {
		$dbusername = $row[0]->u_name;
		// Check the loginflag value for this user
		if ($username == $dbusername) {
			if (session_status() == PHP_SESSION_ACTIVE) {
				session_regenerate_id();
			}
			$_SESSION['sess_user'] = $username;
			// Update the loginflag column to 1 for this user
			$updateSql = "UPDATE public.erp_login_details SET u_pass = :cpass WHERE u_name = :u_name";
			$stmtUpdate = $pdo->prepare($updateSql);
			$stmtUpdate->execute(['cpass' => $encpassword, 'u_name' => $username]);
			//Redirect Browser
			$message = array(
				'response' => array(
					'status' => 'success',
					'code' => '1', // whatever you want
					'message' => 'Success',
					'title' => 'Success'
				)
			);
		} else {
			$message = array(
				'response' => array(
					'status' => 'error',
					'code' => '0', // whatever you want
					'message' => "No such user occurs",
					'title' => 'Error'
				)
			);
		}
	} else {
		$message = array(
			'response' => array(
				'status' => 'error',
				'code' => '0', // whatever you want
				'message' => "Check Your Username",
				'title' => 'Error'
			)
		);
	}
	echo json_encode($message);
} else {
	header("Location: index.php");
	exit();
}
?>