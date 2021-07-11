<?php
class email_model extends  CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

    public function insert($data_email){
        $this->db->insert('email',$data_email);
	}

	public function deleteEmail($id_email){
		$this->db->where('id_email',$id_email);
        $this->db->delete('email');
	}

	public function all_emails(){
        $this->db->from('email');
        $this->db->order_by('date','asc');
        $query=$this->db->get();
        return $query;
	}
	
	public function fetchSingleEmail($id_email){
		$this->db->where('id_email',$id_email);
		$this->db->from('email');
		$query=$this->db->get();
		return $query;
	}
    public function getUsername($id_user){
        $this->db->where("id_user",$id_user);
		$query=$this->db->get("user");
		foreach($query->result() as $row){
			return $row->email;
		}
        return '';
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
        public function search_emails($search_var){
        $this->db->select('*');
        $this->db->from('email');
        $this->db->like('id_email',$search_var);
        $this->db->or_like('subject',$search_var);
        $this->db->or_like('date',$search_var);
        $this->db->order_by('id_user','asc');
        $query=$this->db->get();
        return $query;
    }
}
