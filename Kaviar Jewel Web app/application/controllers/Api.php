<?php
class Api extends  CI_Controller {


	public function login(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
            $this->load->model('auth_model');
	    	$result=$this->auth_model->can_login_app($username,$password);
            echo $result; 
	}
	

}

