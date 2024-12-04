<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="<?php echo isset($settings['records'][0]['favicon'])!=''?base_url().'uploads/images/'.$settings['records'][0]['favicon']:asset_url().'images/favicon.ico'; ?>" />
		<title>Sign In</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/bootstrap.min.css" />
		<!-- Icomoon Icons CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/fonts/icomoon/icomoon.css" />
		<!-- Master CSS -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/main.css" />
		<!-- custom style -->
		<link rel="stylesheet" href="<?php echo asset_url(); ?>admin/css/style.css" />
	</head>
	<body>
		<!-- Container start -->
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
					<div class="login-screen">
						<div class="login-box login-frm">
							<a href="#" class="login-logo">
								<img src="<?=asset_url()?>images/logo.png">
							</a>
							<h5 class="msg text-center mb-3 font-weight-bold"></h5>
							<div class="form-group">
								<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name *" value="<?php echo set_value('first_name'); ?>" />
							</div>

							<div class="form-group">
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" value="<?php echo set_value('last_name'); ?>" />
							</div>

							<div class="form-group">
								<input type="text" class="form-control" id="phone" maxlength="10" minlength="10" name="phone" placeholder="Phone *" value="<?php echo set_value('phone'); ?>" />
							</div>

							<div class="form-group">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email *" value="<?php echo set_value('email'); ?>" />
							</div>

							<div class="form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password *" />
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password *" />
							</div>
							<div class="form-group" data-callback="recaptchaCallback" id="recaptcha-container"></div>
							<div class="actions">
								<button type="button" class="btn btn-primary btn-block login-btn" data-url="<?=base_url('auth/store')?>"><span class="icon-log-out"></span> Sign In</button>
								<!-- <a href="">Forgot password?</a> -->
							</div>
							<div class="mt-4">
								<a href="<?php echo base_url('login'); ?>" class="additional-link">Already Registered? <span>Login here</span></a>
							</div>
						</div>

						<div class="login-box otp-frm" style="display: none;">
							<a href="#" class="login-logo">
								<img src="<?=asset_url()?>images/logo.png">
							</a>
							<h5 class="msg text-center mb-3 font-weight-bold"></h5>
							<div class="form-group">
								<input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP *">
							</div>

							<div class="actions">
								<button type="button" class="btn btn-primary btn-block otp-btn" data-url="<?=base_url('auth/checkotp')?>"><span class="icon-log-out"></span> Verify</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Container end -->
		<!-- jQuery JS. -->
		<script src="<?php echo asset_url(); ?>admin/js/jquery.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/bootstrap.min.js"></script>
		<script src="<?php echo asset_url(); ?>admin/js/nifty.min.js"></script>
	</body>
<script type="module">
  // Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-analytics.js";
import { getAuth, signInWithPhoneNumber, RecaptchaVerifier } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";

// change this below credentials with yours
const firebaseConfig = {
    apiKey: "AIzaSyDtvy1YRa9jA7eKf7FQ_dtsZ1fxxBPc-bk",
    authDomain: "zenithzone-24.firebaseapp.com",
    projectId: "zenithzone-24",
    storageBucket: "zenithzone-24.firebasestorage.app",
    messagingSenderId: "672203507403",
    appId: "1:672203507403:web:217600a001d0596eb4fd4e",
    measurementId: "G-TKSS20J1MF"
  };


// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth();
var coderesult;

auth.languageCode = 'en';
window.onload = function(){
  	render();
}
function render(){
	window.recaptchaVerifier = new RecaptchaVerifier('recaptcha-container', {}, auth);
	recaptchaVerifier.render();
}

function phoneAuth() {
	const phoneNumber = "+91"+document.getElementById('phone').value;
	const appVerifier = window.recaptchaVerifier;
	signInWithPhoneNumber(auth, phoneNumber, appVerifier)
    .then((confirmationResult) => {
      // SMS sent. Prompt user to type the code from the message, then sign the
      // user in with confirmationResult.confirm(code).
      window.confirmationResult = confirmationResult;
      coderesult = confirmationResult;
      console.log(coderesult);
    }).catch((error) => {
      // Error; SMS not sent
      console.log(error);
      // recaptcha.reset(window.recaptchaWidgetId);
      recaptchaVerifier.render();

		// Or, if you haven't stored the widget ID:
		// window.recaptchaVerifier.render().then(function(widgetId) {
		// 	grecaptcha.reset(widgetId);
		// });
    });
}

function codeVerify() {
	const code = document.getElementById("otp").value;
	if (coderesult) {
		coderesult.confirm(code).then(function (result) {
			// alert("Registered successfully!");
			var user = result.user;
			console.log(user);
		}).catch((error) => {
	      console.log(error.messager);
	      recaptcha.reset(window.recaptchaWidgetId);
	    });
	}
}
function recaptchaCallback() {
    $('.login-btn').removeAttr('disabled');
    console.log("checked");
};
$(".login-btn").click(function() {
	    var first_name = $("#first_name").val();
	    var last_name = $("#last_name").val();
	    var phone = $("#phone").val();
	    var email = $("#email").val();
	    var password = $("#password").val();
	    var confirm_password = $("#confirm_password").val();
	    var url = $(this).data('url');
	    // console.log(url);
	    $.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: {first_name:first_name,last_name:last_name,phone:phone,email:email,password:password,confirm_password:confirm_password},
	    })
	    .done(function(data) {
	    	console.log("done");
	        if (data.code == '1') {
	        	console.log("1 one");
            	phoneAuth();
                $('.msg').html(data.msg);
                $('.msg').removeClass('text-danger');
                $('.msg').addClass('text-success');
                $('.login-frm').hide();
                $('.otp-frm').show();
            }
            if(data.code == '0'){
	        	console.log("0 Zero");
                $('.msg').html(data.msg);
                $('.msg').removeClass('text-success');
                $('.msg').addClass('text-danger');
            }
	    })
	    .fail(function(data) {
	        console.log("Something went wrong at rizwan.js: "+data.msg);
	    });
	// }else{
 //        $('.msg').removeClass('text-success');
 //        $('.msg').addClass('text-danger');
	// 	$('.msg').html("You must verify recaptcha first.");
	// }
});


$(".otp-btn").click(function() {
    var otp = $("#otp").val();
    var url = $(this).data('url');
    var user = "";
    codeVerify();
    if (user == "") {
	    $.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: {otp:otp},
	    })
	    .done(function(data) {
	        if (data.code == '1') {
	            $('.msg').html(data.msg);
	            $('.msg').removeClass('text-danger');
	            $('.msg').addClass('text-success');
	            window.location.href = data.redirect;
	        }
	        if(data.code == '0'){
	            $('.msg').html(data.msg);
	            $('.msg').removeClass('text-success');
	            $('.msg').addClass('text-danger');
	        }
	    })
	    .fail(function(data) {
	        console.log("Something went wrong at rizwan.js: "+data.msg);
	    });
    }else{
    	$('.msg').html("Invalid OTP!");
        $('.msg').removeClass('text-success');
        $('.msg').addClass('text-danger');
    }
});
</script>
</html>