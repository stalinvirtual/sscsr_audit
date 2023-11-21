<?php

namespace App\Controllers;

use App\System\Route;

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
					<li><a href="page_not_found.php" class="bread"> Department login</a><i class="icon-angle-right"></i></li>
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
								<input type="text" class="form-control" placeholder="Username " name="uname" id="username"  oncopy="return false" onpaste="return false"  />
								<br>
								<label for="exampleInputEmail1">Password</label>
								<input type="password" class="form-control" placeholder="Password " name="pwd"  id="password" oncopy="return false" onpaste="return false"/>
								<br>


								<!-- Captcha Start-->

								 <label for="exampleInputEmail1">Captcha</label>
								<input type="text" name="captcha_code" id="captcha" class="demoInputBox form-control" placeholder="Captcha" required="" autocomplete="off">
								<br>
								<img src="<?php echo $loadcaptcha;?>" style="width:100px;border-radius: 22px;margin-left: 70px;"  id="captcha_code" alt="captcha"/>
								<button name="submit" class="btnRefresh" onClick="refreshCaptcha();"><i class="fa fa-refresh" aria-hidden="true"></i></button>
							  <br>
							   <!-- Captcha End -->
							<!-- onClick="return Validate();" -->
							<input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
								<br>
								<button class="btn btn-lg btn-sscsrthemecolor btn-block" type="submit" name="login" >Login</button>
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
	$loadcaptcha = $route->site_url("Api/loadcaptcha");
	?>
</section>

<style>
	.error {
		color: red;
	}
	.errormsg{
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
</style>


<?php include "footer2.php"; ?>

<!-- <script src="js/jquery.min.js"></script>  -->
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.validate.min.js" crossorigin="anonymous"></script>
<script>
	function refreshCaptcha() {
		var url = '<?php echo $loadcaptcha; ?>';
		$('#captcha_code').attr('src', url);
	}
	$(document).ready(function() {
		$("#dept_login").validate({
			rules: {
				uname: {
					required: true,
					maxlength: 15,
					lettersOnly: true

				},
				pwd: {
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
				pwd: {
					required: "Please enter your password",
					minlength: "Password must be at least 8 characters long.",
                   // strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character."
				},

			},
			submitHandler: function(form) {
				var username = $('#username').val();
				var password = $('#password').val();
				if (username == '' || username == undefined) {
					$('#err_msg').text('Enter Username');
					return false;
				} else if (password == '' || password == undefined) {
					$('#err_msg').text('Enter Password');
					return false;
				} else {
					var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
					var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
					var pass = document.getElementById('password').value;
					var hash = CryptoJS.AES.encrypt(pass, key, {
						iv: iv
					});
					document.getElementById('password').value = hash;

					var user_nm = document.getElementById('username').value;
					var user_hash = CryptoJS.AES.encrypt(user_nm, key, {
						iv: iv
					});
					document.getElementById('username').value = user_hash;
					$("#username").attr('type', 'password');
					return true;
				}
			}
		});
		// Custom rule for letters only
		$.validator.addMethod("lettersOnly", function(value, element) {
			return this.optional(element) || /^[a-zA-Z]+$/.test(value);
		}, "Username must contain only letters");

		// Custom validation rule for a strong password
		$.validator.addMethod("strongPassword1", function (value) {
      // Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character
      return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
    }, "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.");
    });
</script>


<?php echo $this->get_footer(); ?>