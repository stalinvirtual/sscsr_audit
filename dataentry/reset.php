<?php
session_start();
if (!isset($_SERVER['HTTP_REFERER']) && empty($_SERVER['HTTP_REFERER']) || !isset($_SESSION['sess_user'])) {
    header("Location: login.php");
} else {
    ?>
    <?php
    include('header.php');
    // Generate a CSRF token and store it in the session
    if (!isset($_SESSION['csrf_token']) || !isset($_POST['submit'])) {
        // Generate a new CSRF token and store it in the session
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf_token = $_SESSION['csrf_token'];
    $username = $_SESSION['sess_user'];
    ?>
    <div class="main-grid">
        <div class="panel panel-widget forms-panel">
            <div class="forms">
                <div class="inline-form widget-shadow">
                    <div class="form-title">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="form-body">
                        <div data-example-id="simple-form-inline">
                            <form class="form-horizontal" action="#" method="post" id="reset_password">
                                <input type="hidden" name="user" value="<?php echo $username; ?>">
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">Password<font style="color:red" ;>*
                                        </font> </label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="pass" id='pass'
                                            placeholder="Password">
                                        <span class="toggle-password" id="togglePassword">&#128065;</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cpassword" class="col-sm-2 control-label">Confirm Password<font
                                            style="color:red" ;>*</font> </label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" name="cpass" id='cpass'
                                            placeholder="Confirm Password">
                                        <span class="toggle-cpassword" id="toggleCPassword">&#128065;</span>
                                    </div>
                                </div>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <button class="btn w3ls-button hvr-icon-down col-5" id="submit"> Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .toggle-password {
            position: absolute;
            right: 21px;
            margin-top: -16px;
            /* width: 3%; */
            font-size: 33px;
            color: #a94442;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .toggle-cpassword {
            position: absolute;
            right: 21px;
            margin-top: -16px;
            /* width: 3%; */
            font-size: 33px;
            color: #a94442;
            transform: translateY(-50%);
            cursor: pointer;
        }
        #overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 25%;
            opacity: .80;
        }
        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .errormsg {
            background: antiquewhite;
            width: 49%;
        }
        i.fa.fa-exclamation-triangle {
            width: inherit;
        }
        .error {
            color: red;
        }
    </style>
    <?php
}
?>
<?php include('footer.php'); ?>
<script src="js/sha512.js"></script>
<script type="text/javascript" language="javascript">
    //Tier Onchange
    $(document).ready(function () {
        // $('#submit').click(function () {
        // 	// var p1 = document.getElementById('usr_pass');
        // 	// p1.id = pass;
        // })
        $("#reset_password").validate({
            rules: {
                pass: {
                    required: true,
                    minlength: 8, // Minimum length of 8 characters
                    strongPassword: true // Custom rule for strong password
                },
                cpass: {
                    required: true,
                    minlength: 8, // Minimum length of 8 characters
                    strongPassword: true, // Custom rule for strong password
                    equalTo: '#pass'
                },
            },
            messages: {
                pass: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 8 characters long.",
                    strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character."
                },
                cpass: {
                    required: "Please enter your Confirm Password",
                    minlength: "Password must be at least 8 characters long.",
                    strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.",
                    equalTo: 'Passwords do not match.'
                }
            }, errorPlacement: function (error, element) {
                if (element.attr("name") === "pass") {
                    // Place the error message after the Select2 element
                    error.insertAfter(element.next("span.toggle-password"));
                } else if (element.attr("name") === "cpass") {
                    // Place the error message after the Select2 element
                    error.insertAfter(element.next("span.toggle-cpassword"));
                } else {
                    // Use the default error placement for other fields
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                var password = $('#pass').val();
                var confirmpassword = $('#cpass ').val();
                if (password != '' && confirmpassword != '') {
                    $('#overlay').fadeIn();
                    $.ajax({
                        url: "reset_password_ajax.php",
                        method: "POST",
                        dataType: "json",
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                    }).done(function (data) {
                        $('#overlay').fadeOut();
                        if (data.response.status == 'success') {
                            swal.fire({
                                showCloseButton: true,
                                title: ' Password Updated Successfully',
                                icon: 'success',
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            swal.fire({
                                showCloseButton: true,
                                icon: 'warning',
                                title: data.response.title,
                                text: data.response.message,
                                icon: data.response.status,
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            }
        });
       
        // Custom validation rule for a strong password
        $.validator.addMethod("strongPassword", function (value) {
            // Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character
            return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?#&])[A-Za-z\d@$!%*?#&]{8,}$/.test(value);
        }, "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.");
        $("#togglePassword").click(function () {
            togglePasswordVisibility("pass");
        });
        $("#toggleCPassword").click(function () {
            togglePasswordVisibility("cpass");
        });
        function togglePasswordVisibility(inputId) {
            var inputType = $("#" + inputId).attr("type");
            if (inputType === "password") {
                $("#" + inputId).attr("type", "text");
            } else {
                $("#" + inputId).attr("type", "password");
            }
        }
    });
</script>