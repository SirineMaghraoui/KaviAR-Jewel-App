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
		background-color:green;
	}
.mybtn2:hover{
	background-color:rgba(125,0,156,0.3);

}
.mybtn2{
	background-color:rgba(256,256,256,256,0);
	transition: all 0.2s;
}

.mybtn2{
border-radius: 25px 25px;
border: 2px solid #7D009C;
}
	  
    </style>
	<title>My Profile</title>
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
				 <ul style="margin:30px;  margin-right:40px;" class="abc">
					<li> 
						<img style="object-fit: cover; margin-right:10px; border-radius: 50%;" 
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

                	<div class="wrap-login100 p-l-45 p-r-45 p-t-45 p-b-30" style="width:400px;margin-top:-20px;margin-left:auto; z-index:10; margin-right:auto;">
                    <div style="font-size:18px;font-weight:700;margin-left:110px; color:#9300b8;">My Profile</div>

                    <div class="p-l-20 p-r-20 p-t-20 p-b-30"style="text-align:center;font-size:20px; font-weight:700;"> 
                    
                </div>
					<div class="row p-b-15" >
						<div style="text-align:center;"class="col-12">
                       	 <img style="object-fit: cover; margin-top:-40px; border-radius: 50%;" 
							<?php if($this->session->userdata('picture_path')==''){ ?>
						 src="<?php echo base_url(); ?>assets/user_template/images/icons/user_icon_purple_all.png"
						<?php }else{?>
						src="<?php echo base_url().$this->session->userdata('picture_path');?>"
						<?php } ?>
							width="100" height="100">
						</div>
					</div>
					<div class="row p-b-15">
						<div style="text-align:center;" class="col-12">
								<span style="font-weight:700; font-size:17px;">Username</span>
								<div style="font-size:17px;"> <?php echo $this->session->userdata('username')?></div>
						</div>
					</div>
					<div class="row p-b-15">
						<div style="text-align:center;" class="col-12">
								<span style="font-weight:700; font-size:17px;">Account Type</span>
								<div style="font-size:17px;"> <?php echo $this->session->userdata('account_type')?></div>
						</div>
					</div>
					<div class="row p-b-15">
						<div style="text-align:center;" class="col-12">
								<span style="font-weight:700; font-size:17px;">Email</span>
								<div style="font-size:17px;"> <?php echo $this->session->userdata('email')?></div>
						</div>
					</div>

					<div class="row p-b-15">
						<div style="text-align:center;" class="col-12">
								<span style="font-weight:700; font-size:17px;">Phone</span>
								<div style="font-size:17px;"> <?php echo $this->session->userdata('phone')?></div>
						</div>
					</div>

					<div class="row">
						<div class="col-6">
							<form  method="post" action="<?php echo base_url();?>User/updateProfile">
								<div class="" style="width:100%;">
								<div class="login100-form-bgbtn" style="">	
								</div>
									<button class="login100-form-btn mybtn2" style="color: #7D009C;">
										<span style="font-size:14px; font-weight:700;"> UPDATE INFO </span>
									</button>
								</div>
							</form>
						</div>

						<div class="col-6">
							<form  method="post" action="<?php echo base_url();?>User/updatePassword">
								<div class="" style="width:100%;">
									<button class="login100-form-btn mybtn2" style="color: #7D009C;">
										<span style="font-size:14px; font-weight:700;"> UPDATE PASSWORD </span>
									</button>
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