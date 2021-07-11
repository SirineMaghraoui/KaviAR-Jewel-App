<?php
class User extends  CI_Controller {
	public function contactUs(){
        if($this->session->userdata('username')!=''){
            $this->load->view("contact_us");	
		}else{
			redirect(base_url().'Auth/login');
		}
    }

    public function deleteLinkedProjects($id_user){
        $this->load->model("project_model");
        $query= $this->project_model->fetch_projects($id_user);
        foreach($query->result() as $row){
        $model_path=$row->upload_path;
        $thumbnail_path=$row->thumbnail_path;
        $this->project_model->deleteProject($row->id_project,$id_user);
        unlink($model_path);
        unlink($thumbnail_path);
        }
    }

    function DeleteFolderUser($path){
        if (is_dir($path) === true){
        $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file){
               $this->DeleteFolderUser(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        }else if (is_file($path) === true){
            return unlink($path);
        }
        return false;
    }

    public function deleteUser(){
       $id_user=$this->uri->segment(3);
        $this->load->model("project_model");
        $this->deleteLinkedProjects($id_user);
        $this->load->model("user_model");
        $query= $this->user_model->getUserById($id_user);

        $this->user_model->deleteUser($id_user);

        $user_folder='./upload/user_'.$id_user;
        $this->DeleteFolderUser($user_folder);
        redirect(base_url().'User/all');
    }
    public function all(){
        if($this->session->userdata('role')=='admin'){
		}else{
			redirect(base_url().'Projects');
		}
            $this->load->model("user_model");	
            $data["fetch_data_users"]=$this->user_model->all_users();
             $data["search_found"]='';
            $this->load->view("allusers",$data);
    }

    public function replyEmail(){
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
        $to='';
        $subject='';
        foreach($query->result() as $row){
            $to=$row->email;
        }
        foreach($query1->result() as $row){
            $subject=$row->subject;
        }
        $message=$this->input->post('message');
         $this->load->library('email');
		        $config=array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.ionos.fr',
					'smtp_port' => 465,
                    'smtp_user' => 'app@jewel.kaviar.app',
                    'smtp_pass' => 'Jewel.KaviAR@2020',
                    'mailtype' =>'html',
					'charset' =>'iso-8859-1',
					'wordwrap' =>TRUE
                 );

				$this->email->initialize($config);
                 $this->email->set_newline("\r\n");
                 $this->email->from('app@jewel.kaviar.app');
                 $this->email->to($to);
                 $this->email->subject($subject);
                 $this->email->message($message);
                 if($this->email->send()){
                     $this->session->set_flashdata('message','Your Email has successfully been sent.');
                   
                 }else{
                    $this->session->set_flashdata('error','A problem occured while sending Email. Try again.');
                 }
                redirect(base_url().'/Email/writeEmail/'.$id_user.'/'.$id_email);
    }

    public function sendEmail(){
        $subject= $this->input->post('subject');
        $message = $this->input->post('message');
        $id_user = $this->session->userdata('id_user');
        $this->load->model('email_model');
        $data_email= array(
                 'id_user'=>$id_user,
                 'subject'=>$subject,
                 'message'=>$message,
                 'date'=>date('y-m-d')
                 );

        $this->email_model->insert($data_email);
        $this->session->set_flashdata('message','Email sent seccussfully');
		redirect(base_url().'User/contactUs');
    }

    public function profile(){
        if($this->session->userdata('username')!=''){
            $this->load->view("profile");	
		}else{
			redirect(base_url().'Auth/login');
		}
    }

    public function updateProfile(){
        if($this->session->userdata('username')!=''){
            $this->load->view("update_profile");	
		}else{
			redirect(base_url().'Auth/login');
		}
    }

    public function updatePassword(){
        if($this->session->userdata('username')!=''){
        $this->load->view("update_password");	
		}else{
			redirect(base_url().'Auth/login');
		}
    }

    public function updatePassword_verification(){
        $this->load->model('user_model');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password=$this->input->post('confirm_password');

        if(password_verify($old_password,$this->session->userdata('hashed_password'))){
           if($confirm_password==$new_password){
            $this->session->set_flashdata('message','Password updated successfully');   
           $encrypted_password=password_hash($new_password, PASSWORD_DEFAULT); 

            $this->user_model->updatePassword($this->session->userdata('id_user'),$encrypted_password);
            $session_data=array(
				'id_user'=> $this->session->userdata('id_user'),
				'username'=>$this->session->userdata('username'),
				'email' =>$this->session->userdata('email'),
				'hashed_password'=>$encrypted_password,
				'phone' => $this->session->userdata('phone')
				);
			$this->session->set_userdata($session_data);
            }else{
            $this->session->set_flashdata('error',"New password and Confirm password don't match");
            }
        }else{
            $this->session->set_flashdata('error','Wrong password');
        }
      redirect(base_url().'User/updatePassword');   
    }

    public function updateProfile_verification(){
        $this->load->model('user_model');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $phone=$this->input->post('phone');    
        $pt=$this->input->post('type_list');    
        $data= $this->user_model->getUserByUsername($username);
        foreach($data->result() as $row){ 
             $myid_user=$row->id_user;  
             $myaccount_type=$row->account_type;
        }

        $data1= $this->user_model->getUserByEmail($email);
        foreach($data1->result() as $row){ 
             $myemail=$row->email;  
        }
        $pic=$_FILES['myimage']['name'];
        $ext = pathinfo($pic, PATHINFO_EXTENSION);

        if($data->num_rows()==0){
           //this is a new username desnt exists in database
            if(!$pic==''){ 
                //pic uploaded
                $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                $config['allowed_types']='jpg|png|jpeg';
                $this->load->library('upload',$config);
                 $this->upload->initialize($config);

                if(!$this->upload->do_upload("myimage")){
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                     redirect(base_url().'User/updateProfile');   
                }else{
                rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);   
                $data_user= array(
                'username'=>$username,
                'email'=>$email,
                'phone'=>$phone,
                'account_type'=>$pt,
                'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                );
                }
            }else{
                //no pic uploaded
                $data_user= array(
                'username'=>$username,
                'email'=>$email,
                'phone'=>$phone,
                'account_type'=>$pt,
                'picture_path'=>$this->session->userdata('picture_path')
                );
            }

            $this->user_model->updateUser($data_user);
            	$session_data=array(
				'id_user'=> $this->session->userdata('id_user'),
				'username'=>$username,
				'email' =>$email,
				'password'=>$this->session->userdata('password'),
				'hased_password'=>$this->session->userdata('hashed_password'),
                'phone' => $phone,
                'account_type'=>$pt,
                'picture_path'=>$this->session->userdata('picture_path')
				);
			$this->session->set_userdata($session_data);
            $this->session->set_flashdata('message','Profile updated successfully');
        }else{
            //username exists
                if($myid_user==$this->session->userdata('id_user')){
                    //this is my username unchaged
                    if($myemail==$this->session->userdata('email')){
                        //this is my email unchaged
                        if($phone==$this->session->userdata('phone')){
                            //this is my phone unchaged
                            if($pt==$myaccount_type){
                                //type unchanged
                                if($pic==''){                                
                                $this->session->set_flashdata('nothing','No changes made');
                                 redirect(base_url().'User/updateProfile');  
                                 }else{
                                //pic is upladed get its path and update
                                $current_pic_path=$this->session->userdata('picture_path');
                                if($current_pic_path==''){
                                    //no initial pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
        
                                    $this->load->library('upload',$config);
                                    $this->upload->initialize($config);

                                      if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                                    }
                                }else{
                                    //i alreary have a pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                    $this->upload->initialize($config);

                                    if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                        $path=$this->session->userdata('picture_path');
                                         if (file_exists($path)){
                                            unlink($path);
                                        }
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext); 
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');    
                                    }                                 
                                }                               
                            }
                            }else{
                                //change type account
                                 if($pic==''){
                                 $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>$this->session->userdata('picture_path')
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>$this->session->userdata('picture_path')
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                            }else{
                                $current_pic_path=$this->session->userdata('picture_path');
                                if($current_pic_path==''){
                                    //no initial pic
                                    $config['upload_path']='/upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);

                                      if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
                                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                                    }
                                }else{
                                    //i alreary have a pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);

                                    if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                        $path=$this->session->userdata('picture_path');
                                         if (file_exists($path)){
                                            unlink($path);
                                        }
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');    
                                    }                                 
                                } 
                            }
                            }

                        }else{//new phone
                            if($pic==''){
                                 $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>$this->session->userdata('picture_path')
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>$this->session->userdata('picture_path')
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                            }else{
                                $current_pic_path=$this->session->userdata('picture_path');
                                if($current_pic_path==''){
                                    //no initial pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);

                                      if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
                                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                                    }
                                }else{
                                    //i alreary have a pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);
                                    if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                        $path=$this->session->userdata('picture_path');
                                         if (file_exists($path)){
                                            unlink($path);
                                        }
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');    
                                    }                                 
                                } 
                            }

                        }
                    }else{
                        if($data1->num_rows()>0){
                            //email exists
                            $this->session->set_flashdata('error','Email already exists');
                        }else{
                            if($pic==''){
                                 $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>$this->session->userdata('picture_path')
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>$this->session->userdata('picture_path')
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                            }else{
                                $current_pic_path=$this->session->userdata('picture_path');
                                if($current_pic_path==''){
                                    //no initial pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);

                                      if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                     rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');
                                    }
                                }else{
                                    //i alreary have a pic
                                    $config['upload_path']='./upload/user_'.$this->session->userdata('id_user').'/';
                                    $config['allowed_types']='jpg|png|jpeg';
                                    $this->load->library('upload',$config);
                                     $this->upload->initialize($config);
                                    if(!$this->upload->do_upload("myimage")){
                                      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                                       redirect(base_url().'User/updateProfile');   
                                    }else{
                                        $path=$this->session->userdata('picture_path');
                                         if (file_exists($path)){
                                            unlink($path);
                                        }
                                    rename('upload/user_'.$this->session->userdata('id_user').'/'.$pic,'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.'.'.$ext);
                                    $data_user= array(
                                    'username'=>$username,
                                    'email'=>$email,
                                    'phone'=>$phone,
                                    'account_type'=>$pt,
                                    'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.$ext
                                     );
                                     $this->user_model->updateUser($data_user);
                                      $session_data=array(
				                     'id_user'=> $this->session->userdata('id_user'),
				                     'username'=>$username,
				                     'email' =>$email,
				                     'password'=>$this->session->userdata('password'),
				                     'hased_password'=>$this->session->userdata('hashed_password'),
                                     'phone' => $phone,
                                     'account_type'=>$pt,
                                     'picture_path'=>'upload/user_'.$this->session->userdata('id_user').'/'.$this->session->userdata('id_user').'_picture'.$ext
				                    );
                                     $this->session->set_userdata($session_data);
                                     $this->session->set_flashdata('message','Profile updated successfully');    
                                    }                                 
                                } 
                            }
                        }              
                    }
                }else{
                    if($myemail==$this->session->userdata('email')){
                        //username exists
                        $this->session->set_flashdata('error','Username already exists');
                    }else{
                        //username email exists
                        $this->session->set_flashdata('error','Username and Email already exists');
                    }
                }
            }
          redirect(base_url().'User/updateProfile');   
    }

    public function search(){
        $this->load->model('user_model');
        $search_var=$this->input->post('search_text');
        if($search_var!=''){
            $data["fetch_data_users"]=$this->user_model->search_users($search_var);
            if( $data["fetch_data_users"]->num_rows()==0){
                $data["search_found"]='no';
            }else{
                $data["search_found"]='yes';
            }
            $this->load->view("allusers",$data);
        }else{
           redirect(base_url()."User/all");
        }
    }






}
