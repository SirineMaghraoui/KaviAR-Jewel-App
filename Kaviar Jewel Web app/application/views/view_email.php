<!DOCTYPE html>
<html lang="en">

<head>
<style>
.mybtn2:hover{
	background-color:rgba(125,0,156,0.3);

}
.mybtn2{
	background-color:rgba(256,256,256,256,0);
	transition: all 0.2s;
}

</style>
	<title>View Email</title>
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

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/user_template/css/mystyle.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin_template/assets/vendors/mdi/css/materialdesignicons.min.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/user_template/vendor/dropzone/dropzone.min.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>assets/user_template/vendor/dropzone/dropzone.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/user_template/vendor/jquery/jquery-3.2.1.min.js"></script>

</head>

<body style="background-repeat: no-repeat; background-position: center; background-size: cover; background-image: url('<?php echo base_url(); ?>assets/user_template/images/bg-01.jpg');">
	<div class="limiter" >
		<header > 
   				<a href="#"> <img class="logo" src="<?php echo base_url();?>assets/user_template/images/icons/kaviar-jewel_logo_white.png" width="125" height="110"></a>
       			<ul class="navlinks" style="margin-left:60px;">
				   	<?php if($this->session->userdata('role')=='admin'){
						?>
					<li style="font-size:17px;"> <a style="color:#7d009c; font-weight:600" href="<?php echo base_url().'Projects/all'?>">DASHBOARD</a></li>
					<li style="font-size:17px;"> <a  href="<?php echo base_url().'Projects'?>">MY PROJECTS</a></li>
                    <?php   }
						?>
					<li style="font-size:17px;"> <a href="<?php echo base_url().'User/contactUs'?>">CONTACT US</a></li>
				</ul>
				<div >
				 <ul style="margin:30px;  margin-right:40px;"class="abc">
					<li > 
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
						<li><?php echo '<a href="'.base_url().'User/profile">My Profile</a>';?></li>
						</ul>
					</li>
				</ul>
				</div>
		</header>
	
	
   <div class="wrap-login100 p-l-45 p-r-45 p-t-45 p-b-40" style="margin-left:auto;margin-right:auto; margin-top:-20px; width:700px;">
            <form class="login100-form validate-form" method="post" 
            action="<?php echo base_url();?>Email/writeEmail/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>">
					<div class=" m-b-15" data-validate="Subject is required">
                    	<span class="label-input100" style="font-size:17px;font-weight:700;">From : </span>
                        <span class="label-input100" style="font-size:17px;"><?php echo $sender_email; ?></span>
					</div>
	            <div class=" m-b-15" data-validate="Subject is required">   
						<span class="label-input100" style="font-size:17px;font-weight:700;">Subject : </span>
                        <span class="label-input100" style="font-size:17px;">
                        <?php echo $subject_email;
                        ?>
                        </span>
					</div>
	            <div class=" m-b-15" data-validate="Subject is required">   
						<span class="label-input100" style="font-size:17px;font-weight:700;">Message : </span>
                        <br>
                        <br>
                        <div class="label-input100" style="font-size:17px;word-wrap: break-word;">
                        <?php 
                            echo $message_email;
                        ?>
                        </div>

					</div>

						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn" style="width:70%;">							
                            <button class="login100-form-btn mybtn2" style="border-radius:25px 25px; border: 2px solid #7d009c;">
								<span style="color:#7d009c; font-weight:700">	WRITE EMAIL</span>
								</button>
							</div>
						</div>
				</form>
			</div>
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