<?php
require_once("config/db.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("functions.php");

    $id = $_POST['sscsr_db_table_master_id'];
    $iconid_id = $_POST['iconid'];

    // Update user
    try {
        date_default_timezone_set("Asia/Calcutta");
        $updated_time = date("Y-m-d H:i:s");
        $statusValue = ($iconid_id == "red") ? 1 : 0;

        // Use prepared statements for better security
        $sql = "UPDATE public.sscsr_db_table_master SET status = ?, updated_on = ? WHERE table_id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $statusValue, PDO::PARAM_INT);
        $stmt->bindParam(2, $updated_time, PDO::PARAM_STR);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);

        $stmt->execute();

        $message = array(
            'response' => array(
                'status' => 'success',
                'code' => '1',
                'message' => 'Know Your Status Published Successfully.',
                'title' => 'Success'
            )
        );
    } catch (Exception $e) {
        // Log the error or use a more user-friendly error message
        $message = array(
            'response' => array(
                'status' => 'error',
                'code' => '0',
                'message' => 'An error occurred: ' . $e->getMessage(),
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
