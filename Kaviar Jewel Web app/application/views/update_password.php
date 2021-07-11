<!DOCTYPE html>
<html lang="en">

<head>
	 <style>
      .tableFixHead {
        overflow-y: auto;
        height:400px;
      }
      .tableFixHead thead tr td {
        position: sticky;
        top: 0;
      }
      table {
        border-collapse: collapse;
        width: 100%;
      }

      thead tr td {
        background: #eee;
	  }
	a.button:hover{
		background-color:red;
	}
.mybtn2:hover{
	background-color:rgba(125,0,156,0.3);

}
.mybtn2{
	background-color:rgba(256,256,256,256,0);
	transition: all 0.2s;
}

    </style>
	<title>My Profile </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/css/main.css">
	<script type="text/javascript" src="<?php echo base_url();?>assets/user_template/vendor/jquery/jquery-3.2.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/css/mystyle.css">
	<!--===============================================================================================-->
		<link rel="stylesheet"href="<?php echo base_url(); ?>assets/admin_template/assets/vendors/mdi/css/materialdesignicons.min.css">
</head>

<body style="background-repeat: no-repeat; background-position: center; background-size: cover; background-image: url('<?php echo base_url(); ?>assets/user_template/images/bg-01.jpg');">
		<header> 
   				<a href="#"> <img class="logo" src="<?php echo base_url(); ?>assets/user_template/images/icons/kaviar-jewel_logo_white.png" width="125" height="110"></a>
       				<ul class="navlinks" style="margin-left:60px;">
				   	<?php if($this->session->userdata('role')=='admin'){
						?>
					<li style="font-size:17px;"> <a  href="<?php echo base_url().'Projects/all'?>">DASHBOARD</a></li>
                    <?php   }
						?>
					<li style="font-size:17px;"> <a  href="<?php echo base_url().'Projects'?>">MY PROJECTS</a></li>
					<li style="font-size:17px;"> <a href="<?php echo base_url().'User/contactUs'?>">CONTACT US</a></li>
				</ul>
				<div class="">
				 <ul style="margin:30px;  margin-right:40px; "class="abc">
					<li> 
						<img style="object-fit: cover;margin-right:10px; border-radius: 50%;" 
						<?php if($this->session->userdata('picture_path')==''){ ?>
						 src="<?php echo base_url(); ?>assets/user_template/images/icons/user_icon_white.png"
						<?php }else{?>
						src="<?php echo base_url().$this->session->userdata('picture_path');?>"
						<?php } ?>
						
						width="35" height="35">
						
						<?php echo'<span href="#" style="font-size:20px;"> Hi '.$this->session->userdata('username').'</span>';?>
						<ul  style="text-align:right;">
						<li><?php echo '<a href="'.base_url().'Auth/logout">Logout</a>';?></li>
						<li><?php echo '<a style="color:#7d009c; font-weight:600" href="'.base_url().'User/profile">My Profile</a>';?></li>
						</ul>
					</li>
				</ul>
				</div>
		</header>

                	<div class="wrap-login200 p-l-45 p-r-45 p-t-30 p-b-30" style="width:400px;margin-top:-20px;margin-left:auto; z-index:10; margin-right:auto;">
                    <div style="font-size:18px;font-weight:700;margin-left:70px; color:#9300b8;">Update Password</div>

                    <div class="p-l-20 p-r-20 p-t-20 p-b-30"style="text-align:center;font-size:20px; font-weight:700;"> 
        
                </div>
                	<form style="margin-top:-20px;"class="login100-form validate-form" method="post" action="<?php echo base_url();?>User/updatePassword_verification">
					<div class="row">
						<div class="col-12">
							<div class="wrap-input100 validate-input m-b-23" data-validate="Old Password is required">
								<span class="label-input100">Old Password</span>
								<input class="input100" type="password" name="old_password" placeholder="Type your old password"
								value="">
								<span class="focus-input100" data-symbol="&#xf190;"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="wrap-input100 validate-input m-b-23" data-validate="New Password is required">
								<span class="label-input100">New Password</span>
								<input class="input100" type="password" name="new_password" placeholder="Type your new password"
								value="">
								<span class="focus-input100" data-symbol="&#xf190;"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="wrap-input100 validate-input m-b-23" data-validate="Confirm Password is required">
								<span class="label-input100">Confirm Password</span>
								<input class="input100" type="password" name="confirm_password" placeholder="Type your confirm password"
								value="">
								<span class="focus-input100" data-symbol="&#xf190;"></span>
							</div>
						</div>
					</div>
					<div class="text-center">
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
							<?php
								if($this->session->flashdata("nothing")){
									echo '
									<div class="alert alert-info">
										'.$this->session->flashdata("nothing").'
									</div>';
								}
							?>
					</div>
				<div class="" style="width:100%;">
					<button class="login100-form-btn mybtn2"style="border-radius:25px 25px; border: 2px solid #7d009c;">
						<span style="color:#7d009c;font-weight:700">UPDATE PASSWORD</span>
					</button>
				</div>
				</form>

			</div> 
		

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