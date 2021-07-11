<?php
class Email extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('username')!=''){
		}else{
			redirect(base_url().'Auth/login');
		}
    }
    
    public function all(){
                if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $this->load->model("email_model");	
        $data["fetch_data_emails"]=$this->email_model->all_emails();
        $data["search_found"]='';
        $this->load->view("allemails",$data);
    }

    public function view(){
                if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $id_user=$this->uri->segment(3);
        $id_email=$this->uri->segment(4);
        $this->load->model("email_model");	
        $query1= $this->email_model->fetchSingleEmail($id_email);
        $this->load->model('user_model');
        $query= $this->user_model->getUserById($id_user);
        foreach($query->result() as $row){
            $data["sender_email"]=$row->email;
        }
        foreach($query1->result() as $row){
            $data["subject_email"]=$row->subject;
            $data["message_email"]=$row->message;
        }
        $this->load->view("view_email",$data);      
    }

    public function writeEmail(){
                if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $id_user=$this->uri->segment(3);
        $id_email=$this->uri->segment(4);
        $this->load->model("email_model");	
        $query1= $this->email_model->fetchSingleEmail($id_email);
        $this->load->model('user_model');
        $query= $this->user_model->getUserById($id_user);
        foreach($query->result() as $row){
            $data["sender_email"]=$row->email;
        }
        foreach($query1->result() as $row){
            $data["subject_email"]=$row->subject;
        }
        $this->load->view("reply_email",$data);      
    }

    public function deleteEmail(){
       $id_email=$this->uri->segment(3);
        $this->load->model("email_model");
        $this->email_model->deleteEmail($id_email);
         redirect(base_url().'Email/all');
    }


        public function search(){
        $this->load->model('email_model');
        $search_var=$this->input->post('search_text');
        if($search_var!=''){
            $data["fetch_data_emails"]=$this->email_model->search_emails($search_var);
            if( $data["fetch_data_emails"]->num_rows()==0){
                $data["search_found"]='no';
            }else{
                $data["search_found"]='yes';
            }
            $this->load->view("allemails",$data);
        }else{
           redirect(base_url()."Email/all");
        }
    }
    

}