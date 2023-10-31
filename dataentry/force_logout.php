<?php
// Include necessary files, initialize sessions, database connections, etc.
require_once("config/db.php");
require_once("functions.php");
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    if (isset($_SESSION['sess_user'])) {
        // Retrieve the username from the session
        $user = $_SESSION['sess_user'];

        // Update the loginflag to 0 for the user in the database
        $updateSql = "UPDATE public.erp_login_details SET loginflag = 0 WHERE u_name = :u_name";
        $stmtUpdate = $pdo->prepare($updateSql);
        $stmtUpdate->execute(['u_name' => $user]);

        // Unset or destroy the session to log the user out
        $_SESSION = array();
        session_destroy();
        
        // Redirect the user to a specific page after log-out
        header("Location: index.php"); // Redirect to the login page or any other suitable page
        exit;
    } else {
        // Handle if the user is not logged in
        header("HTTP/1.1 405 Method Not Allowed");
       // header("Location: index.php"); // Redirect to the login page if not logged in
        exit;
    }
} else {
    // Handle if it's not a POST request (optional)
    header("Location: index.php"); // Redirect to a relevant page
    exit;
}
?>
