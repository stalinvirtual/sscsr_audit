<?php
require_once("config/db.php");

require_once("functions.php");
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
	$exam_id =$_REQUEST['exam_id'];
	$exam_name = $_REQUEST['exam_name'];
	if(isset($exam_name) && $exam_name != 'null' )
	{
		
	$exam_name=$_POST['exam_name'];
	$exam_short_name=$_POST['exam_short_name'];

  
	/*$sql = "UPDATE exam_master SET exam_name= '$exam_name',exam_short_name='$exam_short_name' WHERE exam_name = '$exam_id'";
	 $state1 = $pdo->prepare($sql);
	
     $res = $state1->execute();
		*/

		$sql = "UPDATE exam_master SET exam_name = ?, exam_short_name = ? WHERE exam_name = ?";
$state1 = $pdo->prepare($sql);



$state1->bindParam(1, $exam_name, PDO::PARAM_STR);
$state1->bindParam(2, $exam_short_name, PDO::PARAM_STR);
$state1->bindParam(3, $exam_id, PDO::PARAM_STR);

$res = $state1->execute();

	 echo $res;
	 exit;
     if(!empty($res))
		{
		  $message = array(
				'response' => array(
					'status' => 'success',
					'code' => '1',
					'message' => 'Exam Updated Successfully.'
					
				)
			);
			
			echo json_encode($message);
			
		}
}
}
?>
