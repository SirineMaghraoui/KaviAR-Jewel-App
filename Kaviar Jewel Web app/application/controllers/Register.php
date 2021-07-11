<?php
class Register extends CI_Controller{
	public function __construct()
	{
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('register_model');
        if($this->session->userdata('username')){
		redirect(base_url().'Projects');
	}
    }
    
function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

    public function signup(){
        $this->load->view('signup');
    }
    public function  signup_validation(){
        $this->form_validation->set_rules(
            'username','Username', 
            'required|is_unique[user.username]',
             array(
            'required'      => 'Username is required',
            'is_unique'     => 'Username already exists'
        )
        );

		$this->form_validation->set_rules(
            'email','Email',
            'required|valid_email|is_unique[user.email]',
            array(
            'required'      => 'Email is required',
            'is_unique'     => 'Email already exists',
            'valid_email'   => 'Email invalid'
        )
        );
        if($this->input->post('type_list')!=null){
         if($this->form_validation->run()){
             $verification_key =md5($this->random_str(32));
             $encrypted_password=password_hash($this->input->post('password'), PASSWORD_DEFAULT);
             $data= array(
                 'username'=>$this->input->post('username'),
                 'email'=>$this->input->post('email'),
                 'password'=>$encrypted_password,
                 'verification_key'=>$verification_key,
                 'email_verified'=>'no',
                 'phone'=>$this->input->post('phone'),
                 'picture_path'=>'',
                 'role'=>'user'
             );
             $this->register_model->insert($data);
                 $subject="Verify your email address";
                 $message="
                 <p> Hi ".$this->input->post('username').",</p>
                 <p> Thanks for registering for an account on Kaviar[Jewel] ! 
                 Before we get started, we just need to confirm that this is you. </p>
                 <p> Click below to verify your email address: <br>
                 <a href='".base_url()."register/verify_email/".$verification_key."'> link</a>.</p>
                 <br>
                 <p> Thanks,</p>
                 <p> Need additional help? Contact Kaviar[Jewel] Customer Support. </p>
                 <br>
                 <p> Kaviar[Jewel] team </p>
                 ";
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
                 $this->email->to($this->input->post('email'));
                 $this->email->subject($subject);
                 $this->email->message($message);
                 if($this->email->send()){
                     $this->session->set_flashdata('message','Check in your email for email verification mail');
                    redirect('/Register/signup');
                 }
         }else{
             $this->signup();
         }
        }else{
            $this->session->set_flashdata('error','Select account type');
            redirect('/Register/signup');
         }
    }

    public function verify_email(){
        if($this->uri->segment(3)){
            $verification_key=$this->uri->segment(3);
            
            if($this->register_model->verify_email($verification_key)!=''){
                $this->session->set_flashdata('message','Your Email has been successfuly verified');
            }else{
                $this->session->set_flashdata('error','Invalid Link');
            }
            redirect('/Auth/login');
        }
    }

}