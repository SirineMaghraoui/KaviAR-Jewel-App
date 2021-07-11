<?php
class Auth extends  CI_Controller {
	public function login(){
$this->load->view("login");	
if($this->session->userdata('username')!=''){
	if($this->session->userdata('role')=="admin"){
		redirect(base_url().'Projects/all');
	}else{
		redirect(base_url().'Projects');
	}
	}
}


	public function login_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','Username', 'required');
		$this->form_validation->set_rules('password','Password', 'required');
		if($this->form_validation->run()){
		$username=$this->input->post('username');
		$password=$this->input->post('password');

		$this->load->model('auth_model');
			 $result=$this->auth_model->can_login($username,$password);
		if($result==''){
				if($this->session->userdata('role')=="admin"){
		redirect(base_url().'Projects/all');
	}else{
		redirect(base_url().'Projects');
	}

		}else{
			$this->session->set_flashdata('error',$result);
			redirect(base_url().'Auth/login');
		}
		}else{
			$this->login();
		}
	}

	public function logout(){
		$data=$this->session->all_userdata();
		foreach($data as $row => $row_value){
			$this->session->unset_userdata($row);
		}
		redirect(base_url().'Auth/login');
	}
}

