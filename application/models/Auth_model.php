<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model
{

	public function loginAccess($array=array()){

		$response = array();
		if($array !=""){
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where('email',$array['email']);
			$re = $this->db->get();
			if($re->num_rows()>0){

				$getEmail 	 = $array['email'];
				$getPassword = $array['password'];

				$row 	   = $re->row();
				$user_id   = $row->id;
				$email     = $row->email; 
				$uname     = $row->uname; 
				$password  = $row->password;

				if(  $getEmail == $email   ){

					if( md5($getPassword) == $password ){

						$response = array(

							'status'  =>'1' ,
							'message' => 'Your login credentials are match! Wait for a moments. We will redirect you to Dashboard.'
						);
			            $this->session->set_userdata('user_id', $user_id );
			            $this->session->set_userdata('uname', $uname);

					} else {
						$response = array(
							'status'  =>'0' ,
							'message' => 'Your login password did  match! Please check before login.',
						);
					}

				} 
			}
			else {

				$response = array(
					'status'  =>'0' ,
					'message' => 'Your login email id did  match! Please check before login.',
				);

			}
		}
		return $response;
	}


	public function registrationQa($array=array()){
    	$re = FALSE;
    	if($array !=""){

    		$this->db->trans_begin();
			$this->db->insert('user',$array);
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			    $re = FALSE;
			}
			else
			{
			    $this->db->trans_commit();
			    $re = TRUE;
			}
    	}
    	return $re;
    }


}
