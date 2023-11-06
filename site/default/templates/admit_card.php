<?php
namespace App\Controllers;
use App\System\Route;
echo $this->get_header();
$base_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (!isset($_SESSION)) {
	session_start();
}
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
error_reporting(0);
?>
<style>
	.form-control {
		height: 39px !important;
	}
</style>
<section class="buttons">
	<div class="container">
		<div class="row breadcrumbruler">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="<?php echo $this->base_url; ?>" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
					<li><a href="<?php echo $this->base_url; ?>IndexController/candidateCorner" class="bread"> Candidate
							Corner</a><i class="icon-angle-right"></i></li>
					<li>Download Admit Card<i class="icon-angle-right"></i></li>
				</ul>
			</div>
		</div>
	</div>
	<p style="text-align:center">
		( cgle 2022 / 10000092576 / 04-06-1990 )
	</p>
	<?php
	$ins_details   = $data['instructions_details'][0];
	$ins_title     = strtoupper($ins_details->ins_name);
	$ins_content   = $ins_details->ins_content;
	?>
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
							<!-- Modal-->
							<div class="modal" id="instructionModal">
								<div class="modal-content">
									<h4 style="text-align:center"> <?php echo $ins_title; ?></h4>
									<?php echo $ins_content; ?>
									<div>
										<label class="container_checkbox">I have read the above instructions and agree to comply with instructions
											<input type="checkbox" id="ins_checkbox">
											<span class="checkmark"></span>
										</label>
										<div class='errormsg'></div>
										<input type="button" class="btn-dwn btn btn-lg btn-sscsrthemecolor btn-block" name="btn-dwn" id="btn-dwn" value="Proceed to continue">
									</div>
								</div>
							</div>
							<!-- Modal-->
							<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="download_admit_card_from" style="max-width:585px !important;" target="_blank">
								<h2 class="form-signin-heading">Download Admit Card</h2>
								<div class="form-group row">
									<div class="col-lg-10">
										<label for="exampleInputEmail1">Select Exam Name</label>
										<select name="examname" id="admitcard_examname" required="true" class="form-control col-md-3 col-sm-2" placeholder="Select Exam Name">
											<!-- <option value="" selected="selected">Select Exam Name</option> -->
										</select>
									</div>
								</div>
								<!-- Old Design--->
								<!-- <div class="form-group row">
									<div class="col-lg-6">
										<label for="dob">Registration Number<span class="qnsround" data-toggle='tooltip' title='cut,copy,paste is not allowed . Type it Manually'>?</span></label>
										<input class="form-control" placeholder="Registration Number" name="register_number" autocomplete="off" maxlength="11" id="register_number" value="" type="text" onkeypress="return isNumber(event)" required>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<div class='roll_pp_div' style='display:none'>
											<label for="exampleInputEmail1">Roll Number <span class="qnsround" data-toggle='tooltip' title='cut,copy,paste is not allowed . Type it Manually'>?</span></label>
											<input type="text" class="form-control" placeholder="Roll Number" name="roll_number" id="roll_number" value="" autocomplete="off" />
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<div class="post_preference_div_select" style="display: none;">
											<label for="exampleInputEmail1">Post No(s)</label>
											<select class="form-control" name="post_preference_one" id="post_preference_one">
											</select>
										</div>
									</div>
								</div> -->
								<!-- Old Design--->
								<!-- <label for="exampleInputEmail1">Date of Birth</label>
								<input type="date" class="form-control" placeholder="DOB " name="dob" required="" id="password" autocomplete="off" /> -->
								<!-- New Design Starting -->
								<div class="form-group row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-6">
												<label>
													<input type="radio" name="option" onclick="toggleVisibility('registerBox')" checked> Register No
												</label>
											</div>
											<div class="col-lg-6">
												<label>
													<input type="radio" name="option" onclick="toggleVisibility('rollNoBox')"> Roll No
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row" id="registerBox" style="display:block;">
									<div class="col-lg-6">
										<label for="dob">Registration Number<span class="qnsround" data-toggle='tooltip' title='cut,copy,paste is not allowed . Type it Manually'>?</span></label>
										<input class="form-control" placeholder="Registration Number" name="register_number" autocomplete="off" maxlength="11" id="register_number" value="" type="text" onkeypress="return isNumber(event)" required>
									</div>
								</div>
								<div class="form-group row" id="rollNoBox" style="display:none;">
									<div class="col-lg-6">
										<label for="dob">Roll Number<span class="qnsround" data-toggle='tooltip' title='cut,copy,paste is not allowed . Type it Manually'>?</span></label>
										<input class="form-control" placeholder="Roll Number" name="roll_number" autocomplete="off" maxlength="11" id="roll_number" value="" type="text" onkeypress="return isNumber(event)" required>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<label for="dob">Date of Birth</label>
										<input class="form-control placeholder_font_size" name="dob" id="dob" value="" readonly type="text" required>
									</div>
								</div>
								<input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
								<button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit" name="admit_card">Download Admit Card</button>
								<!-- New Design Starting -->
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
<?php include "footer2.php"; ?>
<style>
	.errormsg{
		text-align: left !important;
		color:red;
	}
	.label-spacing {
		margin-right: 20px;
		/* Adjust as needed */
	}
	.placeholder_font_size {
		font-size: 13px;
	}
	.ui-datepicker select.ui-datepicker-month,
	.ui-datepicker select.ui-datepicker-year {
		color: black !important;
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
	.qnsround {
		display: inline-block;
		width: 18px;
		height: 18px;
		text-align: center;
		line-height: 18px;
		background-color: #141313;
		color: #fff;
		margin-top: 2px;
		margin-left: 5px;
		border-radius: 50%;
		cursor: pointer;
	}
	.ui-datepicker-trigger {
		position: relative;
		margin-left: 155px;
		margin-top: -30px;
		height: 20px;
	}
	#admitcard_examname-error {
		/* Adjust the value as needed */
		display: block;
		color: red;
	}
	.error {
		color: red;
	}
	#dob-error {
		white-space: nowrap;
	}
	.container_checkbox {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 22px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	/* Hide the browser's default checkbox */
	.container_checkbox input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		height: 0;
		width: 0;
	}
	/* Create a custom checkbox */
	.checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 25px;
		width: 25px;
		background-color: #eee;
	}
	/* On mouse-over, add a grey background color */
	.container_checkbox:hover input~.checkmark {
		background-color: #ccc;
	}
	/* When the checkbox is checked, add a blue background */
	.container_checkbox input:checked~.checkmark {
		background-color: #a94442;
	}
	/* Create the checkmark/indicator (hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}
	/* Show the checkmark when checked */
	.container_checkbox input:checked~.checkmark:after {
		display: block;
	}
	/* Style the checkmark/indicator */
	.container_checkbox .checkmark:after {
		left: 9px;
		top: 5px;
		width: 5px;
		height: 10px;
		border: solid white;
		border-width: 0 3px 3px 0;
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		transform: rotate(45deg);
	}
</style>
<script>
	// Add an event listener for the "Ok" button in the modal
	var shouldSubmitForm = false;
	$(document).ready(function() {
		var select2Dropdown = $("#admitcard_examname");
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
	let registerValue = "";
	let rollNoValue = "";
	function toggleVisibility(elementId) {
		let element = document.getElementById(elementId);
		if (elementId === 'registerBox') {
			rollNoValue = document.getElementById('roll_number').value;
			document.getElementById('roll_number').value = ""; // Clear Roll No input
		} else {
			registerValue = document.getElementById('register_number').value;
			document.getElementById('register_number').value = ""; // Clear Register input
		}
		let otherElementId = (elementId === 'registerBox') ? 'rollNoBox' : 'registerBox';
		let otherElement = document.getElementById(otherElementId);
		element.style.display = (element.style.display == "none") ? "block" : "none";
		otherElement.style.display = "none";
	}
	// Display the modal when the condition is met
	$(document).ready(function() {
		$("#download_admit_card_from").validate({
			rules: {
				examname: {
					required: true,
				},
				register_number: {
					required: true,
					maxlength: 11,
					digits: true
				},
				roll_number: {
					required: true,
					maxlength: 10,
					digits: true
				},
				post_preference_one: {
					required: true,
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
				roll_number: {
					required: "Please enter your roll number",
					maxlength: "Your register No must be maximum 10 characters long",
					digits: "Please enter digits only"
				},
				post_preference_one: {
					required: "Please select a Post preference",
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
				//form.submit();
				//After Submit
				var baseurl = '<?php echo $this->route->site_url("IndexController/getadmitcardCount"); ?>';
				$.ajax({
					type: 'POST', // Use the appropriate HTTP method (POST or GET)
					url: baseurl, // Specify the URL where you want to send the request
					data: $(form).serialize(), // Serialize the form data
					dataType: 'json', // Specify the expected data type of the response (json, html, text, etc.)
					success: function(response) {
						if (response == '1') {
							var modal = document.getElementById("instructionModal");
							modal.style.display = "block";
							$("#btn-dwn").on("click", function() {
								var isChecked = $('#ins_checkbox').prop('checked');
								if (isChecked) {
									modal.style.display = "none"; // Assuming modal is referenced correctly
									form.submit(); // Submit the form
								} else {
									$(".errormsg").html("Please agree with the Checkbox");
								}
							});
						} else {
							//$(".errormsg").html("Your credentials are NOT correct. Please try with correct credentials");
							form.submit();
						}
						//debugger;
						// Handle the response from the server
						//alert(response);
						console.log('AJAX request successful!', response);
						// Here, you can process the response data as needed
					},
					error: function(xhr, status, error) {
						// Handle errors
						console.error('AJAX request failed:', status, error);
					}
				});
				//After Submit
			}
		});
	});
</script>
<style>
	/* Style for the modal dialog */
	.modal {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
	}
	/* Style for the modal content */
	.modal-content {
		background-color: #fff;
		width: 60%;
		max-width: 600px;
		margin: 15% auto;
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
	}
</style>
<?php echo $this->get_footer(); ?>