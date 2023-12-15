<?php
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
$base_url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 $url = basename(parse_url($base_url, PHP_URL_PATH));
 if (!isset($_SESSION)) {
    session_start();
}
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
?>
<section class="buttons">
	<div class="container">
		<div class="row breadcrumbruler">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="<?php echo $this->base_url; ?>" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
					<li><a href="<?php echo $this->base_url; ?>IndexController/candidateCorner" class="bread"> Candidate Corner</a><i class="icon-angle-right"></i></li>
					<li>Know your Date and City of Exam  <i class="icon-angle-right"></i></li>
				</ul>
			</div>
		</div>
	</div>
	<p style="text-align:center"> ( cgle 2019 /  91000299330  /  29-07-1995 )  </p>
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
										  
										}
										$route = new Route();
										?>
							<form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" id="know_your_venue_details_form" method="post" style="max-width:585px !important;" rel = "noopener noreferrer" target="_blank">       
							  <h2 class="form-signin-heading">Know your Date and City of Exam </h2>
							  <div class="form-group row">
									<div class="col-lg-10">
							   <label for="exampleInputEmail1">Select Exam Name</label>
							  <select name="examname" id="city_examname" required="true" class="form-control col-md-3 col-sm-2">
									<option value="" selected="selected">Select Exam Name</option>		
								</select>
									</div>
							  </div>
							  <div class="form-group row">
									<div class="col-lg-6">
										<label for="ex3">Registration Number</label>
										<input class="form-control"  autocomplete="off" name="register_number" id="username" maxlength="11" value="" type="text" placeholder="Registration Number" onkeypress="return isNumber(event)" required>
									</div>
							 </div>
							  <div class="form-group row">
									<div class="col-lg-4">
										<label for="dob">Date of Birth</label>
										<input class="form-control placeholder_font_size" name="dob" id="dob" value="" readonly type="text" required>
									</div>
							 </div>
							  <br>
							  <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
							  <button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit" name="admit_card">Know your Date and City of Exam </button>   
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
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    color: black !important;
}
.placeholder_font_size{
	font-size: 13px !important;
}
.ui-datepicker-trigger{
	position: relative;
    margin-left: 155px;
	margin-top: -30px;
    height: 20px;
}
#city_examname-error{
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
 <script>
	 $(document).ready(function() {
		var select2Dropdown = $("#city_examname");
// Custom error message for invalid selection
var errorMessage = 'Please select any exam  option from the list.';
// When the button is clicked, check if the select2 dropdown is invalid
$('.btn-sscsrthemecolor').on('click', function() {
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
		$("#know_your_venue_details_form").validate({
			rules: {
				examname: {
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
				examname: {
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
						} else if (element.attr("name") === "examname") {
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