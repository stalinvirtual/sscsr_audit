<?php
 session_start();
 require_once("config/db.php");
try {
    // Update the loginflag column to 0 for this user
    $updateSql = "UPDATE public.erp_login_details SET loginflag = 0 WHERE u_name = :u_name";
    $stmtUpdate = $pdo->prepare($updateSql);
    $user = $_SESSION['sess_user'];
    $stmtUpdate->execute(['u_name' => $user]);
    // Unset and destroy the session
    unset($_SESSION['sess_user']);
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
} catch (PDOException $e) {
    // Handle any database errors here
    die("Database Error: " . $e->getMessage());
}
?>
