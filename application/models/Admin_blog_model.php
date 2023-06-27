<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_blog_model extends CI_Model
{
 

	public function user_blog_list(){
		$response = array();
		$this->db->select('*');
		$this->db->from('blogs');
		$this->db->where('is_deleted','0');
		$this->db->order_by('id','DESC');
		$re = $this->db->get();
		if( $re->num_rows() > 0 ){
			foreach ( $re->result() as $row ) {

				$response[] = array(

					'id' 		   => $row->id,
					'uid' 		   => $row->uid,
					'created_by'   => $row->created_by,
					'content' 	   => $row->content,
					'limit_content' => substr($row->content, 0, 150) . '...' ,
					'title' 	   => $row->title,
					'limit_title'  => substr($row->title, 0, 30) . '...',
					'url' 	       => $row->url,
					'image' 	   => base_url($row->image),
					'created_date' =>  date("Y-m-d",strtotime($row->created_date)) 
				);
			}
		}
		return $response;
	}

	
	public function list_of_blog_comments($id){
		$response = array();
		$this->db->select('*');
		$this->db->from('blog_comment');
		$this->db->where('blog_id',$id);
		$re = $this->db->get();
		if( $re->num_rows() > 0 ){
			foreach ( $re->result() as $row ) {

				$response[] = array(

					'id' 		 => $row->id,
					'comment_by' => $row->comment_by,
					'blog_id'    => $row->blog_id, 
					'comment'    => $row->comment, 
					'created_date' =>  date("Y-m-d",strtotime($row->created_date)) 
				);
			}
		}
		return $response;
	}

	public function blog_list($created_by=0){
		$response = array();
		if($created_by !=""){

			$this->db->select('*');
			$this->db->from('blogs');
			$this->db->where('created_by',$created_by);
			$this->db->where('is_deleted','0');
			$this->db->order_by('id','DESC');
			$re = $this->db->get();
			if( $re->num_rows() > 0 ){
				foreach ( $re->result() as $row ) {

					$response[] = array(

						'id' 		   => $row->id,
						'uid' 		   => $row->uid,
						'created_by'   => $row->created_by,
						'content' 	   => $row->content,
						'limit_content' => substr($row->content, 0, 150) . '...' ,
						'title' 	   => $row->title,
						'limit_title'  => substr($row->title, 0, 30) . '...',
						'url' 	       => $row->url,
						'image' 	   => base_url($row->image),
						'created_date' =>  date("Y-m-d",strtotime($row->created_date)) 
					);
				}
			}
		}
		return $response;
	}

	public function insertData($array="",$table=""){
		$response = array('status' => 0 , 'id'=> 0 );
		if($array !="" && $table !="" ){

			$this->db->insert($table,$array);
			$id = $this->db->insert_id();
			$response = array(
				'status' => 1 , 
				'id'=> $id 
			);
		}
		return $response;
	}

	public function updateMaster($table='' , $update_array= array() , $where_row = '' , $where_id = '' ){
		$response = FALSE;
		if( $table !='' && $update_array != '' && $where_row != '' && $where_id != '' ){

			$this->db->where($where_row , $where_id );
			$this->db->update($table , $update_array );
			if($this->db->affected_rows() >0){
				$response = TRUE;
			}
		}	
		return $response;
	}

	public function blogEdit($blog_id){
		$response = array();
		if($blog_id !=""){

			$this->db->select('*');
			$this->db->from('blogs');
			$this->db->where('uid',$blog_id);
			$re = $this->db->get();
			if( $re->num_rows() > 0 ){
				$row = $re->row(); 
				$response = array(

					'id' 		   => $row->id,
					'uid' 		   => $row->uid,
					'created_by'   => $row->created_by,
					'content' 	   => $row->content,
					'limit_content' => substr($row->content, 0, 150) . '...' ,
					'title' 	   => $row->title,
					'limit_title'  => substr($row->title, 0, 30) . '...',
					'url' 	       => $row->url,
					'image' 	   => base_url($row->image),
					'created_date' =>  date("Y-m-d",strtotime($row->created_date)) 
				);
			}
		}
		return $response;
	}


	public function checkUrl($url){

        $res = FALSE;
        if($url !=""){

            $this->db->select('url');
            $this->db->from('blogs');
            $this->db->where('url',$url);
            $r = $this->db->get();
            if($r->num_rows() > 0 ){
                $res = TRUE;
            }
        }
        return $res;
    }

	public function user_blog_details($url){
		$response = array(
			'response' => FALSE,
			'data' => array()
		);
		$chk = $this->checkUrl($url);

		if($chk == TRUE){

			$this->db->select('blogs.*,user.uname as user_name');
			$this->db->from('blogs');
			$this->db->where('blogs.url',$url);
			$this->db->join( 'user','user.id = blogs.created_by' );
			$re = $this->db->get();
			if( $re->num_rows() > 0 ){
				$row = $re->row(); 
				$res = array(

					'id' 		   => $row->id,
					'uid' 		   => $row->uid,
					'user_name'    => $row->user_name,
					'created_by'   => $row->created_by,
					'content' 	   => $row->content,
					'limit_content' => substr($row->content, 0, 150) . '...' ,
					'title' 	   => $row->title,
					'limit_title'  => substr($row->title, 0, 30) . '...',
					'url' 	       => $row->url,
					'image' 	   => base_url($row->image),
					'created_date' =>  date("Y-m-d",strtotime($row->created_date)) 
				);

				$response = array(
					'response' => TRUE,
					'data'     => $res
				);
			}
		} 
		return $response;
	}

	 public function deleteComment($id){
	 	$this->db->delete('blog_comment', array('id' => $id));
	 	return TRUE;
	 }

	 public function findBlogId($blog_uid){

	 	$response = 0;
	 	$this->db->select('id');
		$this->db->from('blogs');
		$this->db->where('uid',$blog_uid); 
		$re = $this->db->get();
		if( $re->num_rows() > 0 ){
			$row = $re->row(); 
			$response =  $row->id;  	
		}
		return $response;
	 }



}