<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
    {
        parent::__construct();   
        $this->load->model('auth_model');        
    }

	public function login()
	{
		$pageData['title'] = "Admin | Login";
		$this->load->view('auth/include/header',$pageData);
		$this->load->view('auth/auth-body');
		$this->load->view('auth/include/footer');
	}

	public function registration()
	{
		$pageData['title'] = "Admin | Sign Up";
		$this->load->view('auth/include/header',$pageData);
		$this->load->view('auth/registration');
		$this->load->view('auth/include/footer');
	}

	public function loginValidation(){

        $email          = $this->input->post('email');
        $password       = $this->input->post('password');
        $form_data['email']         = $email;
        $form_data['password']      = $password;
        $login_process = $this->auth_model->loginAccess($form_data);
        echo json_encode($login_process);
    }

    public function userLogout()
    {
    	$this->session->unset_userdata('user_id');
    	$this->session->unset_userdata('uname');
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function userRegistartion(){

    	$uname          = $this->input->post('uname');
        $email          = $this->input->post('email');
        $password       = $this->input->post('password');

    	$array = array(
    		'uname'    => ucwords($uname),
    		'password' => md5($password),
    		'email'    => strtolower($email),
    	);
    	$res = $this->auth_model->registrationQa($array);
    	if($res == TRUE){
    		$response = array('status' => 1 , 'mesage' => 'Your registration successfully completed.');
    		echo json_encode($response);
    	} else {
    		$response = array('status' => 0 , 'mesage' => 'Somethings is went wrong to complete your registration. Please try again');
    		echo json_encode($response);
    	}	
    }

    


	
}
