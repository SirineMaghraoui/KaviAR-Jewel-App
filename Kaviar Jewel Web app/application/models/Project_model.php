<?php
class project_model extends  CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

    public function check_user_project($id_user,$project_name){
        
    $this->db->where('project_name', $project_name);
	$query = $this->db->get('project');   

    if($query->num_rows()>0){
			foreach($query->result() as $row){
                    $this->db->where('id_user', $id_user);
                    $this->db->where('id_project', $row->id_project);
	                $query2 = $this->db->get('user_project');

                if($query2->num_rows()>0){
                    return $project_name.' already exists in your projects';
				}else{
                    return '';
				}
			}
		}else {
			return '';
		}
    }

    public function check_user_project_by_projectID($id_user,$id_project){
         $this->db->where('id_user', $id_user);
         $this->db->where('id_project', $id_project);
	        $query2 = $this->db->get('user_project');
                if($query2->num_rows()>0){
                    return true;
				}else{
                    return false;
				}
			

    }

    public function insertProject($data_project){
        $this->db->insert('project',$data_project);
        $idp=$this->db->insert_id();
        $data_user_project= array(
            'id_user'=>$this->session->userdata('id_user'),
            'id_project'=>$idp
        );
         $this->db->insert('user_project',$data_user_project);
         return $idp;
    }

    public function fetch_projects($id_user){
        $this->db->from('user_project as t1');
        $this->db->where('t1.id_user',$id_user );
        $this->db->join('project as t2','t1.id_project=t2.id_project','LEFT');
        $this->db->order_by('t2.date','asc');
        $query=$this->db->get();
        return $query;
    }

    public function all_projects(){
        $this->db->from('project');
        $this->db->order_by('date','asc');
        $query=$this->db->get();
        return $query;
    }

    public function request_projects(){
        $this->db->where('state','Pending');
        $this->db->from('project');
        $this->db->order_by('date','asc');
        $query=$this->db->get();
        return $query;
    }
    
    public function deleteProject($id_project,$id_user){
        $this->db->where("id_project",$id_project);
        $this->db->where("id_user",$id_user);
        $this->db->delete("user_project");
        $this->db->where("id_project",$id_project);
        $this->db->delete("project");
    }

    public function updateProject($id,$data_project){
        $this->db->where("id_project",$id);
        $this->db->update('project', $data_project);
    }

    public function addModelPath($modelPath,$thumbnail_path,$id_project){
        $this->db->set('upload_path',$modelPath);
        $this->db->set('thumbnail_path',$thumbnail_path);        
        $this->db->where('id_project',$id_project);
        $this->db->update('project');
    }

    public function fetchSingleData($id){
        $this->db->where("id_project",$id);
        $query=$this->db->get("project");
        return $query;
    }

    public function getProjectById($id_project){
        $this->db->where('id_project',$id_project);
        $this->db->from('project');
        return $this->db->get();
    }

    public function approveProject($id_project,$upload_path){
        $this->db->set('state','Approved');
        $this->db->set('upload_path',$upload_path);
        $this->db->where('id_project',$id_project);
        $this->db->update('project');      
    }


    public function rejectProject($id_project){
        $this->db->set('state','Rejected');
        $this->db->where('id_project',$id_project);
        $this->db->update('project');
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

    public function search_myprojects($search_var){
        $id_user=$this->session->userdata('id_user');
        $this->db->from('project as t2');
        $this->db->join('user_project as t1','t1.id_project=t2.id_project','LEFT');
        $this->db->where('t1.id_user',$id_user );
        $this->db->like('t2.type',$search_var);
        $query1=$this->db->get();

        $this->db->from('project as t2');
        $this->db->join('user_project as t1','t1.id_project=t2.id_project','LEFT');
        $this->db->where('t1.id_user',$id_user );
        $this->db->like('t2.project_name',$search_var);
        $query2=$this->db->get();

        $this->db->from('project as t2');
        $this->db->join('user_project as t1','t1.id_project=t2.id_project','LEFT');
        $this->db->where('t1.id_user',$id_user );
        $this->db->like('t2.state',$search_var);
        $query3=$this->db->get();

     if($query1->num_rows()!=0){
            return $query1;
        }else if($query2->num_rows()!=0){
            return $query2;
        }else if($query3->num_rows()!=0){
            return $query3;
        }
            return $query1;
    }
    public function search_projects($search_var){
        $this->db->select('*');
        $this->db->from('project');
        $this->db->like('id_project',$search_var);
        $this->db->or_like('project_name',$search_var);
        $this->db->or_like('type',$search_var);
        $this->db->or_like('state',$search_var);
        $this->db->order_by('id_project','asc');
        $query=$this->db->get();

        if($query->num_rows()==0){
            $this->db->from('user');
            $this->db->where('username',$search_var);
            $query1=$this->db->get();
            foreach ($query1->result() as $row) {
                $id_user=$row->id_user;
            }
            if($query1->num_rows()!=0){
                $query2=$this->fetch_projects($id_user);
            if($query2->num_rows()!=0){
                return $query2;
            }
            }   
        }
        return $query;
    }

    public function search_projects_requests($search_var){
         
        $this->db->from('project');
        $this->db->where('id_project',$search_var);
        $this->db->where('state','Pending');
        $this->db->order_by('id_project','asc');
        $query1=$this->db->get();

        $this->db->from('project');
        $this->db->where('project_name',$search_var);
        $this->db->where('state','Pending');
        $this->db->order_by('id_project','asc');
        $query2=$this->db->get();

        $this->db->from('project');
        $this->db->where('type',$search_var);
        $this->db->where('state','Pending');
        $this->db->order_by('id_project','asc');
        $query3=$this->db->get();
               
        $this->db->from('project');
        $this->db->like('date',$search_var);
        $this->db->where('state','Pending');
        $this->db->order_by('id_project','asc');
        $query4=$this->db->get();

        
        
        if($query1->num_rows()!=0){
            return $query1;
        }else if($query2->num_rows()!=0){
            return $query2;
        }else if($query3->num_rows()!=0){
            return $query3;
        }else if($query4->num_rows()!=0){
            return $query4;
        }

        return $query1;
    }



    public function getUsernameByIdProject($id_project){
        $this->db->from('user as t1');
        $this->db->join('user_project as t2','t1.id_user=t2.id_user','LEFT');
        $this->db->where('t2.id_project',$id_project);
        $query=$this->db->get();
        foreach($query->result() as $row){
            return $row->username;
        }
    }

 
}