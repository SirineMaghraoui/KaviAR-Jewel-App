<?php

class Projects extends CI_Controller {

 	public function __construct()
	{
		parent::__construct();
    }
    
    public function index(){
            $this->load->model("project_model");	
            $data["fetch_data_projects"]=$this->project_model->fetch_projects($this->session->userdata('id_user'));
             $data["search_found"]='';
            $this->load->view("myprojects",$data);

		if($this->session->userdata('username')!=''){
		}else{
			redirect(base_url().'Auth/login');
		}
    }
    
    public function approveProject(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
        }
        $uploaded_model=$_FILES['mymodel']['name'];
        $ext = pathinfo($uploaded_model, PATHINFO_EXTENSION);
        $id_project=$this->uri->segment(3);
        $this->load->model("user_model");
        $this->load->model("project_model");	
        $id_user="";
        $curren_upload_path="";
        $query=$this->user_model->getUserByProjectId($id_project)->result();
        $query1=$this->project_model->getProjectById($id_project)->result();
        foreach($query as $row){
            $id_user=$row->id_user;
        }
        foreach($query1 as $row2){
            $curren_upload_path=$row2->upload_path;
        }
        if($uploaded_model==""){
            $this->session->set_flashdata('error', "You did not upload an AssetBundle file.");
            redirect(base_url().'Projects/updateStateProject/'.$id_project);   
        }else{
            if($ext!=""){
                $this->session->set_flashdata('error', "The filetype you are attempting to upload is not allowed.");
                redirect(base_url().'Projects/updateStateProject/'.$id_project);  
            }else{
                $config['upload_path']='./upload/user_'.$id_user.'/';
                $config['allowed_types']='*';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if(!$this->upload->do_upload("mymodel")){                  
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                    redirect(base_url().'Projects/updateStateProject/'.$id_project);   
                }else{
                    rename('upload/user_'.$id_user.'/'.$uploaded_model, 'upload/user_'.$id_user.'/'.$id_project."_AB");
                    $path=$curren_upload_path;
                    if(file_exists($path)){
                        unlink($path);
                    }
                    $new_upload_path='upload/user_'.$id_user.'/'.$id_project."_AB";
                    $this->project_model->approveProject($id_project,$new_upload_path);
                    $this->session->set_flashdata('message', 'Project approved seccussfully');
                    redirect(base_url().'Projects/updateStateProject/'.$id_project);   
                }
            }
        }      
    }

    public function rejectProject(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $id_project=$this->uri->segment(3);
        $this->load->model("project_model");	
        $this->project_model->rejectProject($id_project);
        redirect(base_url()."Projects/requests");
    }

    public function all(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
            $this->load->model("project_model");	
            $data["fetch_data_projects"]=$this->project_model->all_projects();
            $data["search_found"]='';
            $this->load->view("allprojects",$data);
    }

    public function requests(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
            $this->load->model("project_model");	
            $data["fetch_data_requests"]=$this->project_model->request_projects();
             $data["search_found"]='';
            $this->load->view("requests",$data);
    }

    public function addProject(){
        if($this->session->userdata('username')!=''){
            $this->load->view("add_project");	
        $this->load->model('project_model');
		}else{
			redirect(base_url().'Auth/login');
		}

    }

    public function deleteMyProject(){
        if($this->session->userdata('username')==''){
        redirect(base_url().'Projects');
		}
        $id_project=$this->uri->segment(3);
        $id_user=$this->session->userdata('id_user');
        $this->load->model("project_model");
        $myproject=$this->project_model->getProjectById($id_project);	
        foreach($myproject->result() as $row){
            $path=$row->upload_path;
            $thumbnail_path=$row->thumbnail_path;
        }
        $this->project_model->deleteProject($id_project,$id_user);
        unlink($path);
        unlink($thumbnail_path);
        redirect(base_url()."Projects");
    }

    public function deleteProject(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $id_project=$this->uri->segment(3);
        $this->load->model("user_model");
        $query=$this->user_model->getUserByProjectId($id_project);
        foreach($query->result() as $row){
            $id_user=$row->id_user;
        }
        $this->load->model("project_model");
        $myproject=$this->project_model->getProjectById($id_project);	
        foreach($myproject->result() as $row){
            $path=$row->upload_path;
            $thumbnail_path=$row->thumbnail_path;
        }	
        $this->project_model->deleteProject($id_project,$id_user);
        unlink($path);
        unlink($thumbnail_path);
        redirect(base_url()."Projects/all");
    }
    public function deleteUserProject(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
        $id_project=$this->uri->segment(3);
        $this->load->model("user_model");
        $query=$this->user_model->getUserByProjectId($id_project);
        foreach($query->result() as $row){
            $id_user=$row->id_user;
        }
        $this->load->model("project_model");	
        $this->project_model->deleteProject($id_project,$id_user);
        redirect(base_url()."Projects/all");
    }

    public function updateProject(){
        $id=$this->uri->segment(3);
        $this->load->model("project_model");	
        $this_is_my_project=$this->project_model->check_user_project_by_projectID($this->session->userdata('id_user'),$id);
        if($this->session->userdata('username')!='' && $this_is_my_project){
            $data['project_data']=$this->project_model->fetchSingleData($id);
            $this->load->view("update_project",$data);
		}else{
			redirect(base_url().'Projects');
		}
        
    }

    public function updateStateProject(){
        $id=$this->uri->segment(3);
        $this->load->model("project_model");
        if($this->session->userdata('role')=='admin'){
            $data['project_data']=$this->project_model->fetchSingleData($id);
            $this->load->view("update_state_project",$data);
		}else{
			redirect(base_url().'Projects');
		}
    }

    public function viewProject(){
        $id=$this->uri->segment(3);
        $this->load->model("project_model");
        if($this->session->userdata('role')=='admin'){
            $data['project_data']=$this->project_model->fetchSingleData($id);
            $this->load->view("view_project",$data);
		}else{
			redirect(base_url().'Projects');
		}
    }

    public function updateProject_validation(){
        $this->load->model('project_model');
        $current_id= $this->uri->segment(3);
        $this_is_my_project=$this->project_model->check_user_project_by_projectID($this->session->userdata('id_user'),$current_id); 
        $data=$this->project_model->fetchSingleData($current_id);
        $un = $this->session->userdata('id_user');
        $pn = $this->input->post('project_name');
        $pt=$this->input->post('type_list');    
        $pstate="";
        $thumbnail=$_FILES['mythumbnail']['name'];
        $ext_th = pathinfo($thumbnail, PATHINFO_EXTENSION);

        foreach($data->result() as $row){ 
            $myproject_name=$row->project_name;  
            $myproject_type=$row->type; 
            $path=$row->upload_path; 
            $thumbnail_path=$row->thumbnail_path;
            $pstate=$row->state;
        }

            $result=$this->project_model->check_user_project($un,$pn);
            if($result=='') {
                if($thumbnail==''){
                $data_project= array(
                    'project_name'=>$pn,
                    'type'=>$pt,
                    'state'=>$pstate,
                    'upload_path'=>$path,
                    'thumbnail_path'=>$thumbnail_path
                );
                $this->project_model->updateProject($current_id,$data_project);
                $this->session->set_flashdata('message','Project '.$pn.' updated seccussfully');
                redirect(base_url().'Projects/updateProject/'. $current_id);
                }else{
                   // new thumbnail //new project name
                    $config2['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                    $config2['allowed_types']='png|jpg|jpeg';
                    $this->load->library('upload',$config2);
                    $this->upload->initialize($config2);
                        if(!$this->upload->do_upload("mythumbnail")){
                            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                            redirect(base_url().'Projects/updateProject/'. $current_id);
                        }else{
                      if(file_exists($thumbnail_path)){
                            unlink($thumbnail_path);
                        }
                        rename('upload/user_'.$this->session->userdata('id_user').'/'.$thumbnail, 'upload/user_'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th);
                        $thumbnail_path='upload/user_id'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th;
                        $data_project= array(
                         'project_name'=>$pn,
                         'type'=>$pt,
                         'state'=>$pstate,
                         'upload_path'=>$path,
                         'thumbnail_path'=>$thumbnail_path
                        );
                        $this->project_model->updateProject($current_id,$data_project);
                        $this->session->set_flashdata('message','Project '.$pn.' updated seccussfully');
                         redirect(base_url().'Projects/updateProject/'. $current_id);
                       }
                }
            }else{
                  if($pn==$myproject_name){
                      if($pt== $myproject_type){ 
                        if($thumbnail==''){
                        $this->session->set_flashdata('nothing','No changed made');
                        redirect(base_url().'Projects/updateProject/'. $current_id);
                        }else{
                            // new thumbnail //new project name
                            $config2['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                            $config2['allowed_types']='png|jpg|jpeg';
                            $this->load->library('upload',$config2);
                            $this->upload->initialize($config2);
                            if(!$this->upload->do_upload("mythumbnail")){
                                 $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                redirect(base_url().'Projects/updateProject/'. $current_id);
                             }else{
                            if(file_exists($thumbnail_path)){
                                unlink($thumbnail_path);
                            }
                            rename('upload/user_'.$this->session->userdata('id_user').'/'.$thumbnail, 'upload/user_'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th);
                            $thumbnail_path='upload/user_'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th;
                            $data_project= array(
                            'project_name'=>$pn,
                            'type'=>$pt,
                            'state'=>$pstate,
                            'upload_path'=>$path,
                             'thumbnail_path'=>$thumbnail_path
                                );
                            $this->project_model->updateProject($current_id,$data_project);
                            $this->session->set_flashdata('message','Project '.$pn.' added seccussfully');
                             redirect(base_url().'Projects/updateProject/'. $current_id);
                            }
                        }                 
                      }else{
                        if($thumbnail==''){
                        $this->session->set_flashdata('nothing','No changed made');
                        redirect(base_url().'Projects/updateProject/'. $current_id);
                        }else{
                            // new thumbnail //new project name
                            $config2['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                            $config2['allowed_types']='png|jpg|jpeg';
                            $this->load->library('upload',$config2);
                            $this->upload->initialize($config2);
                            if(!$this->upload->do_upload("mythumbnail")){
                                 $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                redirect(base_url().'Projects/updateProject/'. $current_id);
                             }else{

                            if(file_exists($thumbnail_path)){
                                unlink($thumbnail_path);
                            }
                            rename('upload/user_'.$this->session->userdata('id_user').'/'.$thumbnail, 'upload/user_'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th);
                            $thumbnail_path='upload/user_'.$this->session->userdata('id_user').'/'.$current_id.'_thumbnail.'.$ext_th;
                             $data_project= array(
                            'project_name'=>$pn,
                            'type'=>$pt,
                            'state'=>$pstate,
                            'upload_path'=>$path,
                            'thumbnail_path'=>$thumbnail_path
                             );                          
                            $this->project_model->updateProject($current_id,$data_project);
                            $this->session->set_flashdata('message','Project '.$pn.' added seccussfully');
                            redirect(base_url().'Projects/UpdateProject');
                            }
                        }  
                      }
                  }else{
                        $this->session->set_flashdata('error','Project already exists');
                        redirect(base_url().'Projects/updateProject/'. $current_id);
                  }
            }
    }

    public function add_validation(){

        // validate if type is selected
        $this->form_validation->set_rules(
            'project_name','Project name', 
            array(
                'required'      => 'Project name is required'
            )
        );
            $un = $this->session->userdata('id_user');
            $pn = $this->input->post('project_name');
            $this->load->model('project_model');
            $uploaded_model=$_FILES['mymodel']['name'];
            $ext = pathinfo($uploaded_model, PATHINFO_EXTENSION);
            $uploaded_thumbnail=$_FILES['thumbnail']['name'];
            $ext_th = pathinfo($uploaded_thumbnail, PATHINFO_EXTENSION);

            if($this->input->post('type_list')!=null){
            $result=$this->project_model->check_user_project($un,$pn);
            if($result=='') {
                $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                $config['allowed_types']='*';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
               if(!$this->upload->do_upload("mymodel")){                  
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                     redirect(base_url().'Projects/addProject');   
                }else{
                    if($ext !='fbx' && $ext!="obj"){
                        //wrong extension
                        $this->session->set_flashdata('error', 'The filetype you are attempting to upload is not allowed.');
                        $mypath="./upload/user_".$this->session->userdata('id_user').'/'.$uploaded_model;
                        if(file_exists($mypath)){
                        unlink($mypath);
                         }
                        redirect(base_url().'Projects/addProject'); 
                    }else{
                        //correct extension 
                    $config2['upload_path']='./upload/user'.$this->session->userdata('id_user').'/';
                    $config2['allowed_types']='png|jpg|jpeg';
                    $this->load->library('upload',$config2);
                     $this->upload->initialize($config);
                     if(!$this->upload->do_upload("thumbnail")){
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                     redirect(base_url().'Projects/addProject'); 
                     }else{
                        $data_project= array(
                         'project_name'=>$this->input->post('project_name'),
                        'type'=>$this->input->post('type_list'),
                         'date'=>date('y-m-d'),
                         'state'=>'Pending',
                         'upload_path'=>'',
                         'thumbnail_path'=>''
                     );
                        $id_project =$this->project_model->insertProject($data_project);
                        rename('upload/user_'.$this->session->userdata('id_user').'/'.$uploaded_model, 'upload/user_'.$this->session->userdata('id_user').'/'.$id_project.'.'.$ext);
                        rename('upload/user_'.$this->session->userdata('id_user').'/'.$uploaded_thumbnail, 'upload/user_'.$this->session->userdata('id_user').'/'.$id_project.'_thumbnail.'.$ext_th);
                        $model_path='upload/user_'.$this->session->userdata('id_user').'/'.$id_project.'.'.$ext;
                        $thumbnail_path='upload/user_'.$this->session->userdata('id_user').'/'.$id_project.'_thumbnail.'.$ext_th;
                        $this->project_model->addModelPath($model_path,$thumbnail_path,$id_project);
                        $this->session->set_flashdata('message','Project '.$pn.' added seccussfully');
                        redirect(base_url().'Projects/addProject');
                     }
                    }
                }	       
            }else{
                $this->session->set_flashdata('error',$result);
		        redirect(base_url().'Projects/addProject');
            }
            }else{
                 $this->session->set_flashdata('error','Select project type');
		        redirect(base_url().'Projects/addProject');
            }
    }


    public function search(){
        if($this->session->userdata('role')=='admin'){
        $this->load->model('project_model');
        $search_var=$this->input->post('search_text');
        if($search_var!=''){
            $data["fetch_data_projects"]=$this->project_model->search_projects($search_var);
            if( $data["fetch_data_projects"]->num_rows()==0){
                $data["search_found"]='no';
            }else{
                $data["search_found"]='yes';
            }
            $this->load->view("allprojects",$data);
        }else{
           redirect(base_url()."Projects/all");
        }
        }
    }


    public function searchMyProjects(){
        $this->load->model('project_model');
        $search_var=$this->input->post('search_text');
        if($search_var!=''){
            $data["fetch_data_projects"]=$this->project_model->search_myprojects($search_var);
            if( $data["fetch_data_projects"]->num_rows()==0){
                $data["search_found"]='no';
            }else{
                $data["search_found"]='yes';
            }
           $this->load->view("myprojects",$data);
        }else{
          redirect(base_url()."Projects");
        }  
    }



    public function searchRequests(){
        $this->load->model('project_model');
        $search_var=$this->input->post('search_text');
        if($search_var!=''){
            $data["fetch_data_requests"]=$this->project_model->search_projects_requests($search_var);
            if( $data["fetch_data_requests"]->num_rows()==0){
                $data["search_found"]='no';
            }else{
                $data["search_found"]='yes';
            }
            $this->load->view("requests",$data);
        }else{
           redirect(base_url()."Projects/requests");
        }
    }



}