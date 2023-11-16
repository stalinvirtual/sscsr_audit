<?php
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
//$csrfToken = bin2hex(random_bytes(32));
//$_SESSION['csrf_token'] = $csrfToken;
if (!isset($_SESSION)) {
    session_start();
}

$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
$base_url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<section class="buttons">
	<div class="container">
		<div class="row breadcrumbruler">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="<?php echo $this->base_url; ?>" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
					<li><a href="<?php echo $this->base_url; ?>IndexController/candidateCorner" class="bread"> Candidate Corner</a><i class="icon-angle-right"></i></li>
					<li> Know Your Application Status<i class="icon-angle-right"></i></li>
				</ul>
			</div>
		</div>
	</div>
	<p style="text-align:center"> ( cgle 2022 /  10000092576  /  04-06-1990 )  </p>
	<div class="container" id="main">
		<div class="row">
			<div class="col-lg-1">
			</div>
			<div class="col-lg-10">
				<div style="margin-bottom:50px">
					<div class="row">
						  <div class="wrapper">
						              <?php
										if (isset($errorMsg) && !empty($errorMsg)) {
										  echo '<div class="alert alert-danger errormsg">';
										  echo $errorMsg;
										  echo '</div>';
										  //unset($errorMsg);
										}
										$route = new Route();
										//$loadcaptcha = $route->site_url("Api/loadcaptcha");
										?>
							<form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" id="know_your_status_form" style="max-width:585px !important;" rel = "noopener noreferrer" target="_blank">       
							  <h2 class="form-signin-heading">Know Your Application Status</h2>
							  <div class="form-group row">
									<div class="col-lg-10">
							     <label for="exampleInputEmail1">Select Exam Name </label>
							  <select name="table_name" id="examname" required="true" class="form-control" placeholder="Select Exam Name" title="Please Select  Any Exam Name">
									<option value="" selected="selected">Select Exam Name</option>		
								</select>
									</div>
							  </div>
							  <div class="form-group row">
									<div class="col-lg-6">
										<label for="ex3">Registration Number </label>
										<input class="form-control" name="register_number" id="username" maxlength="11" value="" type="text" placeholder="Registration Number" autocomplete="off" onkeypress="return isNumber(event)" required>
									</div>
							 </div>
							  <div class="form-group row">
									<div class="col-lg-4">
										<label for="dob">Date of Birth</label>
										<input class="form-control placeholder_font_size" name="dob" id="dob" value="" readonly type="text" required>
									</div>
									<input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
							 </div>
							  <button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit" name="kyas">Know your Application Status</button>   
							</form>
						  </div>
					</div>	
				</div>
			</div>
			<div class="col-lg-1">
			</div>
		</div>
	</div>
</section>
<?php include "footer2.php";?>
<style>
	.form-control{
    height: 39px !important;
	}
.select2-selection__rendered {
    line-height: 31px !important;
	white-space: inherit !important; 
}
.select2-container .select2-selection--single {
	height: 83px !important;

	white-space: inherit !important; 
}
.select2-selection__arrow {
    height: 56px !important;
}
#hidden-panel-app-no {
	display: none;
}
#hidden-panel-app-name {
	display: none;
}
.placeholder_font_size{
	font-size: 13px !important;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    color: black !important;
}
.ui-datepicker-trigger{
	position: relative;
    margin-left: 155px;
	margin-top: -30px;
    height: 20px;
}
#examname-error {
   /* Adjust the value as needed */
  display: block;
  color: red;
}
.error{
	color: red;
}
#dob-error {
   white-space: nowrap;
}
 </style>
<<<<<<< Updated upstream
 <!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" > </script>  -->
 <script src="js/jquery.min.js"></script> 
=======
 <!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" > </script>   -->
>>>>>>> Stashed changes
<script>
    $(document).ready(function() {
		var select2Dropdown = $("#examname");
// Custom error message for invalid selection
var errorMessage = 'Please select any exam  option from the list.';
// When the button is clicked, check if the select2 dropdown is invalid
$('.btn-block').on('click', function() {
  if (select2Dropdown[0].validity.valueMissing) {
	// Set the custom error message for "required" validation
	select2Dropdown[0].setCustomValidity(errorMessage);
  } else {
	// Reset the custom error message if the select is valid
	select2Dropdown[0].setCustomValidity('');
  }
});
    }); 
	$(document).ready(function() {
		$("#know_your_status_form").validate({
			rules: {
				table_name: {
					required: true,
				},
				register_number: {
					required: true,
					maxlength: 11,
					digits:true
				},
				dob: {
          			required: true,
          			//isBeforeCurrentDate: true
        		}
			},
			messages: {
				table_name: {
					required: "Please select a exam name",
				},
				register_number: {
					required: "Please enter your register number",
					maxlength: "Your register No must be maximum 11 characters long",
					digits: "Please enter digits only"
				},
				dob: {
          			required: "Please enter your date of birth"
        		}
			},
			errorPlacement: function(error, element) {
                if (element.attr("name") === "dob") {
				// Place the error message after the image tag
				error.insertAfter(element.next("img.ui-datepicker-trigger"));
				} else if (element.attr("name") === "table_name") {
					// Place the error message after the Select2 element
					error.insertAfter(element.next("span.select2"));
				} else {
					// Use the default error placement for other fields
					error.insertAfter(element);
				}
            },
			submitHandler: function(form) {
				form.submit();
			}
		});
    });
</script>
<?php echo $this->get_footer(); ?>