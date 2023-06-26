<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_blog extends CI_Controller {

	function __construct()
    {
        parent::__construct();   
        $this->load->model('admin_blog_model');        
    }

    public function dashboard_blog_create(){ 

        $auth              = $this->authencation();
        $user_id           = $auth['user_id']; 
        $pageData['title'] = "Admin | Blog Create";
        
        $this->load->view('admin-blog/include/header',$pageData);
        $this->load->view('admin-blog/blog_create');
        $this->load->view('admin-blog/include/footer');
    }

    public function dashboard_blog_list(){

        $auth              = $this->authencation();
        $user_id           = $auth['user_id'];
        $data['blog_list'] = $this->admin_blog_model->blog_list($user_id);
        $pageData['title'] = "Admin | Blog List";

        // echo "<pre>";
        // print_r($data['blog_list'] );exit;

        $this->load->view('admin-blog/include/header',$pageData);
        $this->load->view('admin-blog/blog_list',$data);
        $this->load->view('admin-blog/include/footer');
    }

    public function authencation()
    {   
        $return = array( 'user_id'   => 0, 'user_name' => '' ) ;
        $user_id = $this->session->userdata('user_id');
        if($user_id > 0 && $user_id !="")
        {
            $return = array(
                'user_id'   => $this->session->userdata('user_id'),
                'user_name' => $this->session->userdata('uname')
            ) ;
            return $return;
        } else {
            $this->session->sess_destroy();
            redirect(base_url('sign-in'));
        }
    }
    public function dashboard_blog_submit(){

        $formData['title']   = $this->input->post('title');
        $formData['content'] = $this->input->post('blog_content');
        $formData['url']     = $this->input->post('blog_url'); 
        $formData['image']   = '';
        $check_url = $this->admin_blog_model->checkUrl($formData['url']);
        $formData['created_by']   = $this->session->userdata('user_id');

        if($check_url == TRUE){
            $this->session->set_flashdata('error_message', 'Blog Post dismissed.');
            redirect(base_url('admin/blog-create'));
        } else {

            if($_FILES['filePhoto']['name'] != '')
            {
                $error_upload = array();
                $upload_dir   = FILE_UPLOAD_BASE_PATH.'assets/blog_post/';
                $rand_name    = time()."_";
                $rand_word    = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,10);
                $random_uniq_id = $this->uniqIdMaster(17);

                $generate_rand_name = $rand_name.$rand_word.$random_uniq_id;
                $upload_file  = $upload_dir.$generate_rand_name.basename($_FILES['filePhoto']['name']);
                $actual_path  = 'assets/blog_post/'.$generate_rand_name.basename($_FILES['filePhoto']['name']);

                if (move_uploaded_file($_FILES['filePhoto']['tmp_name'], $upload_file))
                {
                   $formData['image']       = $actual_path;
                }
                else
                { 
                    $error_upload['error_upload'] = 'filePhoto';
                }
            } 
            $insert =  $this->admin_blog_model->insertData($formData,"blogs");
            $uniq_id_gen =  $this->uniqIdMaster(20);
            $uniq_id_array = array(
                'uid' => $insert['id'].$uniq_id_gen
            );
            $this->admin_blog_model->updateMaster( 'blogs' , $uniq_id_array ,  'id' , $insert['id'] );
            $this->session->set_flashdata('success_message', 'Blog Post successfully added.');
            redirect(base_url('admin/blog-create'));

        }
    }

    public function uniqIdMaster($number=7){

        $randomId = '';
        $rand_1 = substr(str_shuffle("qwertyAWEASDuiopasdfKghGERjklzxcvbKLnm"),0,$number);
        $rand_2 = substr(str_shuffle("1234567890214578544120357491542515"),0,$number);
        $rand_3 = substr(str_shuffle("abQcdefghijWERWERklmnopqrstuvADFWERwxzaspoDFKJLdaslkdwXDuiebskaaDFDFGgywetrpXCVDFUFKMKZX"),0,$number);
        $rand_4 = time();
        $randomId =$rand_1.$rand_2.$rand_3.$rand_4;
        return $randomId;
    }



    public function dashboard_blog_delete($uid=0){

        $array = array( 'is_deleted' => '1' );
        $this->admin_blog_model->updateMaster( 'blogs' , $array ,  'uid' , $uid );
        $this->session->set_flashdata('delete_message', 'Blog Deleted successfully.');
        redirect(base_url('admin/blog-list'));
    }

    public function blog_comment_delete(){

        $id = $this->input->post('id');
        $this->admin_blog_model->deleteComment($id);
        $json = array('status'=>1);
        echo json_encode($json);
    }


    public function dashboard_blog_edit($blog_id){ 

        $auth                  = $this->authencation();
        $user_id               = $auth['user_id']; 
        $pageData['title']     = "Admin | Blog Edit";
        $pageData['blog_data'] = $this->admin_blog_model->blogEdit($blog_id);
         
        $this->load->view('admin-blog/include/header',$pageData);
        $this->load->view('admin-blog/blog_edit',$pageData);
        $this->load->view('admin-blog/include/footer');
    }
 
    public function dashboard_blog_comments($blog_uid){ 
 
        $auth                  = $this->authencation();
        $user_id               = $auth['user_id']; 
        $pageData['title']     = "Admin | Blog Comment";
         

        $blog_id =  $this->admin_blog_model->findBlogId($blog_uid);
         

        $pageData['blog_comments'] = $this->admin_blog_model->list_of_blog_comments($blog_id);

         
        $this->load->view('admin-blog/include/header',$pageData);
        $this->load->view('admin-blog/blog_comment',$pageData);
        $this->load->view('admin-blog/include/footer');
    }


    public function dashboard_blog_edit_submit(){

        $formData['title']   = $this->input->post('title');
        $formData['content'] = $this->input->post('blog_content');
        $formData['url']     = $this->input->post('blog_url'); 
        $blog_id    = $this->input->post('blog_id'); 
        

        if($_FILES['filePhoto']['name'] != '')
        {
            $error_upload = array();
            $upload_dir   = FILE_UPLOAD_BASE_PATH.'assets/blog_post/';
            $rand_name    = time()."_";
            $rand_word    = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,10);
            $random_uniq_id = $this->uniqIdMaster(17);

            $generate_rand_name = $rand_name.$rand_word.$random_uniq_id;
            $upload_file  = $upload_dir.$generate_rand_name.basename($_FILES['filePhoto']['name']);
            $actual_path  = 'assets/blog_post/'.$generate_rand_name.basename($_FILES['filePhoto']['name']);

            if (move_uploaded_file($_FILES['filePhoto']['tmp_name'], $upload_file))
            {
               $formData['image']       = $actual_path;
            }
            else
            { 
                $error_upload['error_upload'] = 'filePhoto';
            }
        }
        $this->admin_blog_model->updateMaster( 'blogs' , $formData ,  'uid' , $blog_id );
        $this->session->set_flashdata('success_message', 'Blog Post successfully added.');
        redirect(base_url('admin/blog/edit/'.$blog_id));        
    }



    public function user_blog_list(){ 

        $is_login = 'no';
        $user_id = $this->session->userdata('user_id');
        if($user_id > 0 && $user_id !="")
        {
            $is_login = 'yes';
        } else {
            $is_login = 'no';
        }

        $data['blog_list']    = $this->admin_blog_model->user_blog_list();
        $pageData['title']    = "Blog List";
        $pageData['is_login'] = $is_login;

        $this->load->view('blog_include/header',$pageData);
        $this->load->view('blog_list',$data);
        $this->load->view('blog_include/footer');
    }

    public function user_blog_details($url){ 
    
        $data['blog_data'] = $this->admin_blog_model->user_blog_details($url);
        if($data['blog_data']['response'] == FALSE){

            $this->session->set_flashdata('no_data_message', 'Blog Post Not Found'); 
            redirect(base_url(''));  

        } else {
            $pageData['title'] = "Blog";
            $pageData['blog_data'] =  $data['blog_data']['data'];
            $pageData['blog_comments'] = $this->admin_blog_model->list_of_blog_comments($pageData['blog_data']['id']); 
            $this->load->view('blog_include/header',$pageData);
            $this->load->view('blog_details',$pageData);
            $this->load->view('blog_include/footer');    
        }

    }

    public function user_blog_comment_post()
    {

        $formData['comment_by']   = $this->input->post('comment_by');
        $formData['blog_id']      = $this->input->post('blog_id');
        $blog_url                 = $this->input->post('blog_url');
        $formData['comment']      = $this->input->post('comment');
        $formData['created_date'] = date('Y-m-d H:i:s');
        $re                       = $this->admin_blog_model->insertData($formData,"blog_comment");

        $this->session->set_flashdata('comment_message', 'Blog Comment successfully.');
        redirect(base_url('blog/'.$blog_url));
    }



    


}