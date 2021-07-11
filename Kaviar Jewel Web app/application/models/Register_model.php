<?php
class Register_model extends  CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

    public function insert($data){
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }
    public function verify_email($key){
        $this->db->where('verification_key',$key);
        $this->db->where('email_verified','no');
        $query=$this->db->get('user');
        if($query->num_rows()>0){
            $data=array(
                'email_verified'=>'yes'
            );
            $this->db->where('verification_key',$key);
            $this->db->update('user',$data);

            foreach($query->result() as $row){
                $id_u=$row->id_user;
                $path=FCPATH."upload/"."user_".$id_u;
		        if (!is_dir($path)){
                    mkdir($path, 0777, TRUE);
                }
            return true;
            }

        }else{
            return false;
        }
    }

}