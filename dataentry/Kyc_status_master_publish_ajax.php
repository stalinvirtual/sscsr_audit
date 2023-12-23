<?php
require_once("config/db.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("functions.php");
    $id = $_POST['sscsr_db_table_master_id'];
    $iconid_id = $_POST['iconid'];
    // Update user


    try {
        date_default_timezone_set("Asia/Calcutta");
        $updated_time = $date = date("Y-m-d H:i:s");
       /* if ($iconid_id == "red") {
            $sql = "UPDATE public.sscsr_db_table_city_tier_master SET  status='1',updated_on = '$updated_time' WHERE id='$id'";
        } else {
            $sql = "UPDATE public.sscsr_db_table_city_tier_master SET  status='0',updated_on = '$updated_time' WHERE id='$id'";
        }


        $stmt = $pdo->prepare($sql);
        $stmt->execute();*/

       // Assuming $iconid_id, $id, and $updated_time are properly validated and sanitized

// Prepare the SQL statement with placeholders
$sql = "UPDATE public.sscsr_db_table_city_tier_master SET status = :status, updated_on = :updated_time WHERE id = :id";

// Set the value of status based on $iconid_id
$status = ($iconid_id == "red") ? 1 : 0;

// Prepare the parameters for binding
$params = array('status' => $status, 'updated_time' => $updated_time, 'id' => $id);

// Prepare and execute the statement
$stmt = $pdo->prepare($sql);
$stmt->execute($params);


        
        $message = array(
            'response' => array(
                'status' => 'success',
                'code' => '1',
                // whatever you want
                'message' => 'Know Your City  Published Successfully.',
                'title' => "Success"
            )
        );
    } catch (Exception $e) {


        $message = array(
            'response' => array(
                'status' => 'error',
                'code' => '0',
                // whatever you want
                'message' => $e->getMessage(),
                'title' => 'Error'
            )
        );
    }






    echo json_encode($message);
} else {
    header("Location: index.php");
    exit();
}
