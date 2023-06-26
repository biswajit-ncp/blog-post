<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Admin_blog/user_blog_list';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['sign-in'] = 'Auth/login';
$route['sign-up'] = 'Auth/registration';
$route['log-out'] = 'Auth/userLogout';
$route['user-login-submit'] 	   = 'Auth/loginValidation';
$route['user-registration-submit'] = 'Auth/userRegistartion';
$route['admin/blog-list']   	   = 'Admin_blog/dashboard_blog_list';
$route['admin/blog-create'] 	   = 'Admin_blog/dashboard_blog_create';
$route['admin/blog/delete/(:any)'] = 'Admin_blog/dashboard_blog_delete/$1';
$route['blog-create-submit']       = 'Admin_blog/dashboard_blog_submit';
$route['admin/blog/edit/(:any)']   = 'Admin_blog/dashboard_blog_edit/$1';
$route['admin/blog/comment/(:any)']   = 'Admin_blog/dashboard_blog_comments/$1';
$route['blog-update-submit']       = 'Admin_blog/dashboard_blog_edit_submit';
$route['blog/(:any)']       	   = 'Admin_blog/user_blog_details/$1';
$route['comment-post']       	   = 'Admin_blog/user_blog_comment_post';
$route['delete-comment']       	   = 'Admin_blog/blog_comment_delete';
