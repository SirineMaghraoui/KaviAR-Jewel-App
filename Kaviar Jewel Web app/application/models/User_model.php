<?php
class user_model extends  CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

    public function getUserByUsername($username){
        $this->db->where("username",$username);
        $query=$this->db->get("user");
        return $query;
    }
        public function all_users(){
        $this->db->from('user');
        $query=$this->db->get();
        return $query;
    }

    public function getUserByEmail($email){
        $this->db->where("email",$email);
        $query=$this->db->get("user");
        return $query;
    }

    public function updateUser($data){
        $this->db->where("id_user",$this->session->userdata('id_user'));
        $this->db->update('user', $data);
    }

    public function updatePassword($id_user,$new_password){
        $this->db->set('password',$new_password);
        $this->db->where("id_user",$id_user);
        $this->db->update('user');
    }

    public function deleteUser($id_user){
        $this->db->where('id_user',$id_user);
        $this->db->delete('user');
    }

    public function getUserById($id_user){
        $this->db->where('id_user',$id_user);
        $this->db->from('user');
        $query=$this->db->get();
        return $query;
    }

    
    public function projectsNumber($id_user){
        $this->load->model('project_model');
        $query=$this->project_model->fetch_projects($id_user);
        return $query->num_rows();
    }
    
    public function getUserByProjectId($id_project){
        $this->db->where('id_project',$id_project);
        $this->db->from('user_project');
        return $this->db->get();
    }

    public function totalRequests(){
        $this->db->where('state','Pending');
        $this->db->from('project');
        $query=$this->db->get();
        return $query->num_rows();
    }

    public function totalEmails(){
        $this->db->from('email');
        $query=$this->db->get();
        return $query->num_rows();
    }
    
    public function totalProjects(){
        $this->db->from('project');
        $query=$this->db->get();
        return $query->num_rows();
    }    
    
    public function totalUsers(){
        $this->db->from('user');
        $query=$this->db->get();
        return $query->num_rows();
    }
    public function search_users($search_var){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->like('id_user',$search_var);
        $this->db->or_like('username',$search_var);
        $this->db->or_like('phone',$search_var);
        $this->db->or_like('email',$search_var);
        $this->db->order_by('id_user','asc');
        $query=$this->db->get();
        return $query;
    }

}