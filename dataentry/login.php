<?php
require_once("config/db.php");
require_once("functions.php");
?>
<!doctype html>
<html>
<title>SSCSR</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="icon" type="image/png" sizes="16x16" href="images/logo/logo.png">
<!-- Include jQuery -->
<script src="js/jquery-3.6.0.min.js"></script>
<!-- Include jQuery Validation plugin -->
<script src="js/jquery.validate.min.js"></script>
<style>
	@import "https://use.fontawesome.com/releases/v5.5.0/css/all.css";
	body {
		margin: 0;
		padding: 0;
		font-family: sans-serif;
		background-size: cover;
	}
	img {
		border-radius: 8px;
		padding: 5px;
		width: 125px;
	}
	.login-box h1 {
		float: center;
		font-size: 40px;
		border-bottom: 6px solid #223a7e;
		padding: 13px 0;
		text-align: center;
		color: #8a6d3b;
	}
	.textbox {
		width: 100%;
		overflow: hidden;
		font-size: 20px;
		padding: 8px 0;
		margin: 8px 0;
	}
	.textbox i {
		width: 26px;
		float: left;
		text-align: center;
	}
	.textbox input {
		color: black;
		font-size: 18px;
		width: 80%;
		float: left;
		margin: 0 10px;
	}
	.btn {
		width: 100%;
		/* background: none; */
		/* border: 2px solid #223a7e; */
		color: #fffbfb;
		padding: 5px;
		font-size: 18px;
		cursor: pointer;
		margin: 12px 0;
		background-color: #223a7e;
	}
	.form-control:focus {
		border-color: #223a7e !important;
		outline: 0;
		box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(34 58 126) !important;
	}
	@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
		/* CSS */
	}
	.col-lg-4.loginbox1 {
		border-top: 2px solid;
		border-left: 2px solid;
		border-right: 2px solid;
	}
	.col-lg-4.loginbox2 {
		border-bottom: 2px solid;
		border-left: 2px solid;
		border-right: 2px solid;
	}
	.err_msg {
		/* border: 1px solid red; */
		color: red;
		font-weight: bold;
		text-align: center
	}
	.message {
		color: red;
		font-weight: bold;
	}
	.error{
		color:red;
		font-size: 13px;
	}
</style>
</head>
<body>
	<div class="container" style="margin-top:10%">
		<div class="row">
			<div class="col-lg-4">
			</div>
			<div class="col-lg-4 loginbox1">
				<img class="logo img-responsive center-block" src="images/logo/logo.png">
				<h4 style="text-align:center">STAFF SELECTION COMMISSION</h4>
				<p style=" text-align:center;font-size: 15px;">Southern Region, Chennai</p>
			</div>
			<div class="col-lg-4">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
			</div>
			<div class="col-lg-4 loginbox2">
				<form action="" method="POST" name="registration" autocomplete="off" id="dataentry_login">
					<div class="textbox">
						<i class="fas fa-user"></i>
						<input type="text" class="form-control" name="user" id="user" placeholder="Username" required="">
						<?php if (isset($code) && $code == 1) {
							echo "class=errorMsg";
						} ?>
					</div>
					<div class="textbox">
						<i class="fas fa-lock"></i>
						<input type="password" class="form-control" name="pass" placeholder="Password" required="">
						<?php if (isset($code) && $code == 3) {
							echo "class=errorMsg";
						} ?>
					</div>
					<input type="text" id="captcha" name="captcha" placeholder="Enter captcha" required style="margin-left: 85px;">
					<div class="containerred">
						<img src="captcha.php" alt="CAPTCHA"><br><br>
					</div>
					<input value="Submit" class="btn" type="submit" name="submit">
				</form>
			</div>
			<div class="col-lg-4">
			</div>
		</div>
	</div>
	<?php
	if (isset($_POST['submit'])) {
		$user = trim($_POST["user"]);
		$user = cleanData($user);
		$pass = trim($_POST["pass"]);
		$pass = cleanData($pass);
		$pass = md5($pass);
		session_start();
		$userEnteredCaptcha = $_POST['captcha'];
		$actualCaptcha = $_SESSION['captcha_code'];
		if ($user == "") {
			$errorMsg = "error :  Enter a User Name.";
			$code = "1";
		} elseif ($pass == "") {
			$errorMsg = "error : Please Enter Password.";
			$code = "2";
		} else {
			if (strcasecmp($userEnteredCaptcha, $actualCaptcha) != 0) {//Captcha not correct
				echo "<p class='err_msg'>CAPTCHA validation failed.</p>";
			}//Captcha not correct
			else{ //Captcha correct
			$sql2 = "SELECT * FROM erp_login_details WHERE  u_name =:u_name AND u_pass =:u_pass ";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute(['u_name' => $user, 'u_pass' => $pass]);
			$number_of_rows = $stmt2->fetchColumn();
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute(['u_name' => $user, 'u_pass' => $pass]);
			$row = $stmt2->fetchAll();
			if ($number_of_rows != 0) {
				$dbusername = $row[0]->u_name;
				$dbpassword = $row[0]->u_pass;
				// Check the loginflag value for this user
				$checkLoginFlagSql = "SELECT loginflag FROM public.erp_login_details WHERE u_name = :u_name";
				$stmtCheckFlag = $pdo->prepare($checkLoginFlagSql);
				$stmtCheckFlag->execute(['u_name' => $user]);
				$loginflag = $stmtCheckFlag->fetchColumn();
				if ($loginflag == 1) { //already logged in
					//$errorMsg = "error : Already Logged in.";
					echo "<p class='message err_msg' style='text-align:center; width: 50%;
					margin-left: 24%;'>This user is already logged in some other system.</p>";
				} //already logged in
				else { // logged in
					if ($user == $dbusername && $pass == $dbpassword) {
						session_start();
						if (session_status() == PHP_SESSION_ACTIVE) {
							session_regenerate_id();
						}
						$_SESSION['sess_user'] = $user;
						// Update the loginflag column to 1 for this user
						$updateSql = "UPDATE public.erp_login_details SET loginflag = 1 WHERE u_name = :u_name";
						$stmtUpdate = $pdo->prepare($updateSql);
						$stmtUpdate->execute(['u_name' => $user]);
						//Redirect Browser
						header("Location:add_exam.php");
					} else {
						$errorMsg = "error : Invalid Username or Password!.";
						$code = "3";
					}
				} //logged in
			} else {
				$errorMsg = "<p class='err_msg'> Invalid Username or Password!.</p>";
	?>
				<br>
				<div class="row">
					<div class="col-lg-4">
					</div>
					<div class="col-lg-4">
						<?php echo $errorMsg; ?>
					</div>
					<div class="col-lg-4">
					</div>
				</div>
	<?php
			}
		}
	   }//captcha 
	}
	?>
</body>
<script type="text/javascript" language="javascript">
 $(document).ready(function (){
		$("#dataentry_login").validate({
			rules: {
				user: {
					required: true,
					maxlength: 15,
					lettersOnly: true
				},
				pass: {
					required: true,
					minlength: 8, // Minimum length of 8 characters
					strongPassword: true // Custom rule for strong password
				},
			},
			messages: {
				user: {
					required: "Please enter your username",
					maxlength: "Username must be maximum 15 characters long",
					lettersOnly: "Username must contain only letters"
				},
				pass: {
					required: "Please enter your password",
					minlength: "Password must be at least 8 characters long.",
					strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character."
				},
			}
			});
			// Custom rule for letters only
		$.validator.addMethod("lettersOnly", function (value, element) {
			return this.optional(element) || /^[a-zA-Z]+$/.test(value);
		}, "Username must contain only letters");
		// Custom validation rule for a strong password
		$.validator.addMethod("strongPassword", function (value) {
			// Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character
			return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
		}, "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.");
	});
</script>
<style>
	.containerred {
 margin-left:26%;
}
.containerred img{
	width: 105px; /* Ensure the image doesn't exceed the container's width */
	margin-left: 27px;/* Ensure the image doesn't exceed the container's height */
}
</style>
</html>