<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/user_template/images/icons/kaviar-jewel_icon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/css/main.css"/>
	<!--===============================================================================================-->
</head>

<body>
	<div>
	
		<div class="container-login100" style="background-image: url('<?php echo base_url(); ?>assets/user_template/images/bg-01.jpg'); ">
			<div class="wrap-login100 p-l-45 p-r-45 p-t-45 p-b-40" style=" width:500px;">
				<input type="image" src="<?php echo base_url(); ?>assets/user_template/images/icons/kaviar-jewel_logo.png" width="135" height="120"
					style="vertical-align: middle" class="centerimage">
			<form class="login100-form validate-form" method="post" action="<?php echo base_url();?>Auth/login_validation">
					<div class="wrap-input100 validate-input m-b-23" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Type your username">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="text-center p-t-15 p-b-0">
							<?php
								if($this->session->flashdata("error")){
									echo '
									<div class="alert alert-danger">
										'.$this->session->flashdata("error").'
										</div>';
								}
							?>
							<?php
								if($this->session->flashdata("message")){
									echo '
									<div class="alert alert-success">
										'.$this->session->flashdata("message").'
										</div>';
								}
							?>
					</div>
		
						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn">
									Login
								</button>
							</div>
						</div>

					<div class="flex-col-c">
						<br>
						<span class="txt2">Or
						</span>
						<a href="<?php echo base_url(); ?>Register/signup" class="txt2 p-t-10">
							Sign Up
						</a>
					</div>
	
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>assets/user_template/js/main.js"></script>

</body>

</html>