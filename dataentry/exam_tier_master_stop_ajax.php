<?php
require_once("config/db.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("functions.php");
    $id = sanitize_string_value($_POST['exam_tier_master_id']);
    $iconid_id = sanitize_string_value($_POST['iconid']);
    $title = sanitize_string_value($_POST['title']);
    // Update user

    try {

        date_default_timezone_set("Asia/Calcutta");
        $updated_time = $date = date("Y-m-d H:i:s");
      /*  if ($iconid_id == "green") {
            $sql = "UPDATE public.sscsr_db_table_tier_master SET  status= '1',updated_on = '$updated_time' WHERE id='$id'";
        } else {
            $sql = "UPDATE public.sscsr_db_table_tier_master SET  status= '0',updated_on = '$updated_time' WHERE id='$id'";
        }
        


        $stmt = $pdo->prepare($sql);
        $stmt->execute();*/

$sql = "UPDATE public.sscsr_db_table_tier_master SET status = ?, updated_on = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);

// Assuming you have variables for the values you want to update
$status = ($iconid_id == "green") ? 1 : 0; // Assuming '1' is for 'green' and '0' is for other colors


$stmt->bindParam(1, $status, PDO::PARAM_INT);
$stmt->bindParam(2, $updated_time, PDO::PARAM_STR);
$stmt->bindParam(3, $id, PDO::PARAM_INT);

$stmt->execute();

        
        $message = array(
            'response' => array(
                'status' => 'success',
                'code' => '1',
                // whatever you want
                'message' => $title . " Process Successfully",
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
