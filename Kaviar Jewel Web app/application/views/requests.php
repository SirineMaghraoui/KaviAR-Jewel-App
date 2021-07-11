<!DOCTYPE html>
<html lang="en">

<head>
	 <style>
      .tableFixHead {
        overflow-y: auto;
        height:330px;
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
		.parent {
  display: flex;
  flex-wrap: wrap;
}

.child {
  flex: 1; /* explanation below */
}
.mybtn:hover{
	background-color:rgba(256,256,256,0.3);
}
.mybtn{
border-radius: 25px 25px;
border: 2px solid white;
background-color:rgba(256,256,256,256,0);
transition: all 0.2s;
}
	  .mybtn4:hover{
		background-color:rgba(44,67,106,0.4);
	  }		

	  .mybtn3:hover{
		background-color:rgba(202,47,62,0.4);
	  }	  
    </style>
	<title>All Projects</title>
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
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet"/>

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
					<li style="font-size:17px;"> <a style="color:#7d009c; font-weight:600"href="<?php echo base_url().'Projects/all'?>">DASHBOARD</a></li>
					<li style="font-size:17px;"> <a  href="<?php echo base_url().'Projects'?>">MY PROJECTS</a></li>
                    <?php   }
						?>
					<li style="font-size:17px;"> <a href="<?php echo base_url().'User/contactUs'?>">CONTACT US</a></li>
				</ul>
				<div >
				 <ul style="margin:30px;  margin-right:40px;"class="abc">
					<li> 
						<img style="object-fit: cover;  margin-right:10px; border-radius: 50%;" 
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

		<?php
		if($fetch_data_requests->num_rows()>0){	
		?>
<div class="parent">
  	<div class="child">		
		  <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:right;">
			<form action="<?php echo base_url(); ?>Projects/all">
				<button class="login100-form-btn mybtn">
					ALL PROJECTS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalProjects();?>)</span>
				</button>
			</form>
		</div>
	</div>
 	<div class="child">		
	 	<div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:center;">
			<form action="<?php echo base_url(); ?>User/all">
				<button class="login100-form-btn mybtn">
					ALL USERS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalUsers();?>)</span>
				</button>
			</form>
		</div>
	</div>
  	<div class="child">		
	   <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;">
			<form action="<?php echo base_url(); ?>Projects/requests">
				<button class="login100-form-btn mybtn"style="background-color:rgba(256,256,256,0.3);">
					REQUESTS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalRequests();?>)</span>
				</button>
			</form>
		</div>
	</div>
  	<div class="child">		
	    <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:left;">
			<form action="<?php echo base_url(); ?>Email/all">
				<button class="login100-form-btn mybtn">
					MAILBOX (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalEmails();?>)</span>
				</button>
			</form>
			</div>
		</div>
	</div>
</div>
		
		<br>

		<div class="wrap-login200 p-l-15 p-r-15 p-t-15 p-b-0" style="margin-left:auto; margin-right:auto; width:1200px;">
			<div class="p-l-15 p-r-15 p-t-15 p-b-30 "style="text-align:center;font-size:18px; font-weight:700;" >
				<form action="<?php echo base_url();?>Projects/searchRequests" method="post">
				 <div class="row">
					<div class="col-lg-12">
   						 <div class="input-group">
      						<input type="text" class="form-control" placeholder="Search for..." name="search_text" id="search_text">
     						 <span class="input-group-btn">
       						 	<button class="btn btn-default">Go!</button>
      						</span>
   						 </div>
  					</div>
  				</div>
				</form>
				<br>
				<?php
				if($fetch_data_requests->num_rows()>4){	
				?>
				<div class="tableFixHead">
				  <?php
				}else{
					?>
				<div class="">
				<?php
					}
					?>	
				<table class="table table-hover" style="border:1px solid #e0e0e0;">
           			 <thead>
              			<tr style="text-align:left; color:grey;">
							<td> Id Project </td>
                			<td >Project</td>
                			<td>Type</td>
							<td>Date</td>
							<td>Status</td>
							<td>Upload Path </td>
							<td>Action </td>
              			</tr>
           			 </thead>
            		<tbody  style="text-align:left;">
			<?php

			foreach($fetch_data_requests->result() as $row){
			?>
		            <tr style="font-size:17px; font-weight:600;">
						<td><?php echo $row->id_project?></td>
                		<td><?php echo $row->project_name ?></td>
                		<td><?php echo $row->type ?></td>
						   <td> <?php echo $row->date ?></td> 
                		<td>
							<label class="badge badge-warning" style="font-size:100%; font-weight:500;background-color:#960096; color:white;">Pending</label>					
						</td>
						<td><?php echo $row->upload_path?> </td>

						<td> 
				 		<a style="color:white;" href="<?php echo base_url();?>Projects/updateStateProject/<?php echo $row->id_project?>"><button type="button"  class="mybtn4 btn btn-circle" style="color:#133e72; border:2px solid #133e72;background-color:#none;margin-right:20px;border-radius:20px; height:40px; width:40px;" ><i class="fa fa-pencil"></i> </button></a>
				 		<!-- <a style="color:white;" href="<?php echo base_url();?>Projects/approveProject/<?php echo $row->id_project?>"><button type="button"  style="color:#54bc05; border:2px solid #54bc05;background-color:none;margin-right:20px;border-radius:20px; height:40px; width:40px;" class="btn btn-circle mybtn5"><i class="fa fa-check"></i> </button></a>-->
				 		<a class="deleteProject" href="<?php echo base_url()?>Projects/rejectProject/<?php echo $row->id_project?>"><button type="button"class="btn btn-circle mybtn3" style="border:2px solid #C82333;color:#C82333;height:40px; width:40px; margin-left:-10px;border-radius:20px;"><i class="fa fa-times"></i></button></a>
						</tr>
			<?php
			}
			?>
			    </tbody>
			  </table>
				</div>
      		</div>
    	</div>
			<?php
		}else{
			?>
		<div class="parent">
  	<div class="child">		
		  <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:right;">
			<form action="<?php echo base_url(); ?>Projects/all">
				<button class="login100-form-btn mybtn">
					ALL PROJECTS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalProjects();?>)</span>
				</button>
			</form>
		</div>
	</div>
 	<div class="child">		
	 	<div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:center;">
			<form action="<?php echo base_url(); ?>User/all">
				<button class="login100-form-btn mybtn">
					ALL USERS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalUsers();?>)</span>
				</button>
			</form>
		</div>
	</div>
  	<div class="child">		
	   <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;">
			<form action="<?php echo base_url(); ?>Projects/requests">
				<button class="login100-form-btn mybtn"style="background-color:rgba(256,256,256,0.3);">
					REQUESTS (<span> <?php $this->load->model('project_model'); 
					echo $this->project_model->totalRequests();?>)</span>
				</button>
			</form>
		</div>
	</div>
  	<div class="child">		
	    <div class="wrap-login100-form-btn" style="width:60%;margin-top:-20px;float:left;">
			<form action="<?php echo base_url(); ?>Email/all">
				<button class="login100-form-btn mybtn">
					MAILBOX (<span><?php $this->load->model('project_model'); 
					echo $this->project_model->totalEmails();?>)</span>
				</button>
			</form>
			</div>
		</div>
	</div>
</div>
		<br>
		<div class="wrap-login200 p-l-30 p-r-30 p-t-30 p-b-40" style="margin-left:auto; z-index:10; margin-right:auto; width:1200px;">
			<?php if($search_found=="no"){?> 
				<form action="<?php echo base_url();?>Projects/searchRequests" method="post">
				 <div class="row">
					<div class="col-lg-12">
   						 <div class="input-group">
      						<input type="text" class="form-control" placeholder="Search for..." name="search_text" id="search_text">
     						 <span class="input-group-btn">
       						 	<button class="btn btn-default">Go!</button>
      						</span>
   						 </div>
  					</div>
  				</div>
				</form>
				<div class="p-l-20 p-r-20 p-t-30 p-b-10"style="text-align:center;font-size:20px; font-weight:700;"> No data search found. </div>
			</div> 
		</div> 
				<?php
			} 
			?>
				<?php if($search_found==''){?>
								<div class="p-l-20 p-r-20 p-t-20 p-b-20"style="text-align:center;font-size:20px; font-weight:700;"> There are no requests. </div> 
								<div class="wrap-login100-form-btn" style="width:50%;">
								<div class="login100-form-bgbtn" style=" background: -webkit-linear-gradient(right, #FF9900, #F23E02, #FF9900, #FF4000);">	
								</div>
								</div>
							</div> 
				</div> 
			<?php
			} 
			?>
				
	
	<?php
		}
		?>
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