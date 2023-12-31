<?php

namespace App\Controllers;

use App\System\Route;
use App\Helpers\securityService as securityService;

echo $this->get_header();
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
					<li><a href="index.php" class="breadcrumb_text_color">Home</a><i class="icon-angle-right"></i></li>
					<li><a href="page_not_found.php" class="bread"> Department login</a><i class="icon-angle-right"></i>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container" id="main">
		<div class="row">
			<div class="col-lg-4">
				<div style="margin-bottom:50px">
				</div>
			</div>
			<div class="col-lg-4">
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
							$loadcaptcha = $route->site_url("Api/loadcaptcha");
							$token = $_SESSION['token'];
							?>
							<form class="form-signin" id="dept_login" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
								<h2 class="form-signin-heading">Department Login</h2>
								<label for="exampleInputEmail1">User Name</label>
								<input type="text" class="form-control" placeholder="Username " name="uname" id="username" maxlength="20" oncopy="return false" onpaste="return false" />
								<br>
								<label for="exampleInputEmail1">Password</label>
								<input type="password" class="form-control" placeholder="Password " name="currentword" id="user_pass" oncopy="return false" onpaste="return false" maxlength="20" />
								<span class="toggle-password" id="togglePassword">&#128065;</span>
								<br>
								<!-- Captcha Start-->
								<label for="exampleInputEmail1">Captcha</label>
								<input type="text" name="captcha_code" id="captcha" class="demoInputBox form-control" placeholder="Captcha" required="" autocomplete="off">
								<br>
								<img src="<?php echo $loadcaptcha; ?>" style="width:45%;margin-left: 70px;" id="captcha_code" alt="captcha" />
								<button name="submit" class="btnRefresh" onClick="refreshCaptcha();"><i class="fa fa-refresh" aria-hidden="true"></i></button>
								<br>
								<!-- Captcha End -->
								<?php $antiCSRF = new securityService();
								$antiCSRF->insertHiddenToken();
								?>
								<br>
								<button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit" name="login" id='submit'>Login</button>
								<p class="pt-1 text-danger text-center" id="err_msg"></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div style="margin-bottom:50px">
				</div>
			</div>
		</div>
	</div>
	<!-- Captcha loging -->
	<?php
	$route = new Route();
	//$loadcaptcha = $route->site_url("Api/loadcaptcha");
	$loginUrl = $route->site_url("IndexController/login");
	$redirectPath = $route->site_url("Admin/dashboard/?action=listnominations");
	?>
</section>
<style>
	.error {
		color: red;
	}

	.errormsg {
		margin-left: 171px !important;
	}

	.btnRefresh {
		background-color: #fff;
		border: #fff solid 2px;
		font-size: 33px;
		margin-top: 3px;
		position: absolute;
		margin-left: 13px;
		/* margin-bottom: -49px; */
	}

	.toggle-password {
		position: relative;
		/* right: 144px;
	margin-top: -40px; */
		right: 4px;
		margin-top: -24px;
		float: right;
		font-size: 33px;
		color: #223a7e;
		transform: translateY(-50%);
		cursor: pointer;
	}

	input[type="password"] {
		margin-bottom: 0px !important;
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
	}

	input[type="password"]:focus {
		z-index: 0 !important;
	}

	label {
		display: inline-block;
		max-width: 100%;
		margin-bottom: 0px !important;
		font-weight: 700;
	}
</style>
<?php include "footer2.php"; ?>
<!-- <script src="js/jquery.min.js"></script>  -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script src="assets/datatable/common/Encryption.js"></script>
<script src="js/sweetalert_for_login.js"></script>
<script src="assets/datatable/common/CryptoJS.js"></script>
<script>
	function encryptPwd(strPwd, strSalt) {
		var strNewSalt = new String(strSalt);
		if (strPwd == "" || strSalt == "") {
			return null;
		}
		var strEncPwd;
		var strPwdHash = SHA512(strPwd);
		var strMerged = strNewSalt + strPwdHash;
		var strMerged1 = SHA512(strMerged);
		return strMerged1;
	}

	function refreshCaptcha() {
		var url = '<?php echo $loadcaptcha; ?>';
		$('#captcha_code').attr('src', url);
	}
	$(document).ready(function() {
		$("#togglePassword").click(function() {
			togglePasswordVisibility("user_pass");
		});

		function togglePasswordVisibility(inputId) {
			var inputType = $("#" + inputId).attr("type");
			if (inputType === "password") {
				$("#" + inputId).attr("type", "text");
			} else {
				$("#" + inputId).attr("type", "password");
			}
		}

		function encryptPassword(password) {
			var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef0123456789abcdef0123456789ab");
			var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
			var pass = password;
			var hashValue = CryptoJS.AES.encrypt(pass, key, {
				iv: iv,
				padding: CryptoJS.pad.Pkcs7
			});
			document.getElementById('user_pass').value = hashValue;
			return hashValue.toString(CryptoJS.enc.Base64);
		}
		$("#dept_login").validate({
			rules: {
				uname: {
					required: true,
					maxlength: 15,
					lettersOnly: true
				},
				currentword: {
					required: true,
					minlength: 8, // Minimum length of 8 characters
					//strongPassword: true // Custom rule for strong password
				},
			},
			messages: {
				uname: {
					required: "Please enter your username",
					maxlength: "Username must be maximum 15 characters long",
					lettersOnly: "Username must contain only letters"
				},
				currentword: {
					required: "Please enter your password",
					minlength: "Password mustbe at least 8 characters long.",
					// strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character."
				},
			},
			errorPlacement: function(error, element) {
				if (element.attr("name") === "currentword") {
					// Place the error message after the Select2 element
					error.insertAfter(element.next("span.toggle-password"));
				} else {
					// Use the default error placement for other fields
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) { //submit handler start
				let encryption = new Encryption();
				let nonceValue = 'sscsr';
				let password = $('#user_pass').val();
				var encrypted = encryption.encrypt(password, nonceValue);
				//using salt
				$.ajax({
					type: 'post',
					url: '<?php echo $loginUrl; ?>',
					//data: $('#dept_login').serialize(),
					data: {
						uname: $('#username').val(),
						currentword: encrypted, // Encrypt the password
						captcha_code: $('#captcha').val(),
						eg_csrf_token_label: $('#eg_csrf_token_label').val(),
						//login: $('#submit').val()
					},
					dataType: 'json',
					error: function(jqXHR, textStatus, errorThrown) {
						var responseText = jQuery.parseJSON(jqXHR.responseText);
						if (jqXHR.status == '402') {
							$('#error-message').text(responseText.message);
							$('#username').val('');
							$('#usr_pass').val('');
							refresh();
							$('#message').css('display', '');
						} else if (jqXHR.status == '403') {
							$('#username').val('');
							$('#user_pass').val('');
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Invalid Credentials!',
							});
						} 
						else if (jqXHR.status == '405') {
							$('#username').val('');
							$('#user_pass').val('');
							$('#captcha').val('');
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Captcha is not Correct!',
							});
						} 
						else {
							setTimeout(function() { // wait for 5 secs(2)
								// location.reload(); // then reload the page.(3)
								logout();
							}, 1500);
						}
					},
					success: function(response) {
						if (response.code == 200) {
							var redirectUrl = '<?php echo $redirectPath; ?>';
							window.location.href = redirectUrl;
						}
					},
				});
			} //submit handler start
		});
		// Custom rule for letters only
		$.validator.addMethod("lettersOnly", function(value, element) {
			return this.optional(element) || /^[a-zA-Z]+$/.test(value);
		}, "Username must contain only letters");
		// Custom validation rule for a strong password
		$.validator.addMethod("strongPassword1", function(value) {
			// Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character
			return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
		}, "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.");
	});
</script>
<?php echo $this->get_footer(); ?>