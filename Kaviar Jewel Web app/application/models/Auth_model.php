<?php
class auth_model extends  CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	public function can_login($username,$password){
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				if(password_verify($password, $row->password)){
					if($row->email_verified=='no'){
						return"Please verify Email adress first";
					}else{
					$session_data=array(
						'id_user'=> $row->id_user,
						'username'=>$username,
						'email' =>$row->email,
						'hashed_password'=>$row->password,
						'phone' => $row->phone,
						'picture_path'=>$row->picture_path,
						'role'=>$row->role,
						'account_type'=>$row->account_type
						);
						$this->session->set_userdata($session_data);
						return '';
					}
				}else{
					return 'Wrong Username or Password';
				}
			}
		}else {
			return "Wrong Username or Password";
		}
	}

	public function can_login_app($username,$password){
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				if(password_verify($password, $row->password)){
					if($row->email_verified=='no'){
					$error_json = array(
						'status' => 'error',
						'message' => 'Please verify Email adress first'
						);
						$encode_data = json_encode($error_json);
            			return $encode_data;
					}else{
						//creat json
						$id_user=$this->getUserByUsername($username);
						$temp_my_projects=$this->fetch_approved_projects($id_user)->result();
						$temp_public_projects=$this->fetch_public_approved_projects($id_user)->result();
						$my_projects=array();
						$public_projects=array();
						$public_users=$this->getPublicUsers($id_user)->result();

						foreach($temp_my_projects as $row2){
							$temp_user=$this->getUserByIdProject($row2->id_project);
							foreach($temp_user->result() as $row3){
								$temp_array= array(
								'id_user'=>$row3->id_user,
								'username'=>$row3->username,
     							'id_project'=>$row2->id_project,
								'project_name'=>$row2->project_name,
								'type'=>$row2->type,
    							'thumbnail_path'=>$row2->thumbnail_path,
        						'model_path'=>$row2->upload_path
							);
							}

							$my_projects[]=$temp_array;
						}

						foreach($temp_public_projects as $row2){
							$temp_user=$this->getUserByIdProject($row2->id_project);
							foreach($temp_user->result() as $row3){
								$temp_array= array(
								'id_user'=>$row3->id_user,
								'username'=>$row3->username,
     							'id_project'=>$row2->id_project,
								'project_name'=>$row2->project_name,
								'type'=>$row2->type,
    							'thumbnail_path'=>$row2->thumbnail_path,
        						'model_path'=>$row2->upload_path
							);
							}
							$public_projects []=$temp_array;
						}

						$user_json = array(
						'status'=>'success',
						'id_user' => $row->id_user,
						'username' => $row->username,
						'picture_path'=>$row->picture_path,
						'my_projects'=>$my_projects,
						'public_users'=>$public_users,
						'public_projects'=>$public_projects
						);

					$encode_data = json_encode($user_json);
					return $encode_data;
					}
				}else{
					$error_json = array(
					'status' => 'error',
					'message' => 'Wrong Username or Password'
					);
					$encode_data = json_encode($error_json);
            		return $encode_data;
				}
			}
		}else{
			$error_json = array(
				'status' => 'error',
				'message' => "Wrong Username or Password"
				);
				$encode_data = json_encode($error_json);
            	return $encode_data;			
		}
	}


	public function fetch_approved_projects($id_user){
        $this->db->from('user_project as t1');
        $this->db->where('t1.id_user',$id_user );
        $this->db->join('project as t2','t1.id_project=t2.id_project','LEFT');
        $this->db->where('t2.state','approved');
        $this->db->order_by('t2.date','asc');
        $query=$this->db->get();
        return $query;
	}

	public function fetch_projects($id_user){
        $this->db->from('user_project as t1');
        $this->db->where('t1.id_user',$id_user );
        $this->db->join('project as t2','t1.id_project=t2.id_project','LEFT');
        $this->db->where('t2.state','approved');
        $this->db->order_by('t2.date','asc');
        $query=$this->db->get();
        return $query;
	}
	
	public function fetch_public_approved_projects($id_user){
        $this->db->from('user_project as t1');
		$this->db->where('t1.id_user !=',$id_user );
		$this->db->join('project as t2','t1.id_project=t2.id_project','LEFT');
		$this->db->join('user as t3','t1.id_user=t3.id_user','LEFT');
		$this->db->where('t2.state','approved');
		$this->db->where('t3.account_type','public' );
        $this->db->order_by('t2.date','asc');
        $query=$this->db->get();
        return $query;
	}
	
	public function getUserByIdProject($id_project){
        $this->db->from('user as t1');
        $this->db->join('user_project as t2','t1.id_user=t2.id_user','LEFT');
        $this->db->where('t2.id_project',$id_project);
        $query=$this->db->get();
		return $query;
	}

	public function getUserByUsername($username){
        $this->db->from('user');
        $this->db->where('username',$username);
        $query=$this->db->get();
        foreach($query->result() as $row){
            return $row->id_user;
        }
	}
	
	public function getPublicUsers($id_user){
		$this->db->select('id_user');
		$this->db->select('username');
		$this->db->select('picture_path');
		$this->db->from('user');
		$this->db->where('id_user !=',$id_user);
		$this->db->where('account_type','public');
		$query=$this->db->get();
		return $query;
	}
}
