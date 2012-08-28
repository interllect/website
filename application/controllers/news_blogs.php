<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_blogs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('email','session','tank_auth'));
		$this->load->helper(array('url','form', 'profile'));
	}
	
	public function index()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			redirect('/news_blogs/blog/');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function blog()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(3, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->order_by('id', 'desc');
			$this->db->limit(5,$limits['offset']);
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->order_by('id', 'asc');
			$data['blogs_count'] = $this->db->get('blogs');
			
			$number_results = $data['blogs_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/blog/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$data['alert_msg'] = "";
			
			$this->load->view('header', $data);
			$this->load->view('news_blogs', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_blog()
	{	
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(4, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['blog_id'] = $this->uri->segment(3);
			
			$this->db->order_by('id', 'desc');
			$this->db->limit(5,$limits['offset']);
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->order_by('id', 'asc');
			$data['blogs_count'] = $this->db->get('blogs');
			
			$number_results = $data['blogs_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/blog/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|prep_for_form');
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				redirect($_SERVER['HTTP_REFERER']);
				$data['alert_msg'] = '<p><strong>There were some errors with your blog:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description')
					);
				$this->db->insert('blogs', $item);
				
				$data['alert_msg'] = '<p><strong>Your blog was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function edit_blog()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(4, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['id']);
			$this->db->limit(5,$limits['offset']);
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->where('id', $data['id']);
			$data['blogs_count'] = $this->db->get('blogs');
			
			$number_results = $data['blogs_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/blogs/'.$data['id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->where('id', $data['id']);
			$this->db->order_by('id', 'desc');
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|prep_for_form');
			
			//currently online
			$this->db->distinct('ip_address');
			$this->db->where('user_data !=', "");
			$data['online'] = $this->db->get('ci_sessions');
			//echo $this->db->last_query();
			
			//last 24 hours
			$date = date('Y-m-d H:i:s');
			$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
			$first_date = date ('Y-m-d H:i:s', $newdate );
			$second_date = date('Y-m-d H:i:s');
			$this->db->where('last_login >=', $first_date);
			$this->db->where('last_login <=', $second_date);
			$data['last_24'] = $this->db->get('users');
			//echo $this->db->last_query();
			
			//newest
			$this->db->order_by('created', 'desc');
			$this->db->limit(1);
			$data['newest'] = $this->db->get('users');
			//echo $this->db->last_query();
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description')
					);
				$this->db->where('id', $data['id']);	
				$this->db->update('blogs', $item);
				
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
			
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function delete_blog()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['id']);		
			$this->db->delete('blogs');
			
			$this->db->where('blog_id', $data['id']);		
			$this->db->delete('blog_comments');
			
			redirect('news_blogs');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function post()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(4);
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['blog_id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['blog_id']);
			$this->db->order_by('id', 'asc');
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->limit(5,$limits['offset']);
			$this->db->order_by('id', 'desc');
			$data['blog_comments'] = $this->db->get('blog_comments');
			
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->order_by('id', 'desc');
			$data['blog_comments_count'] = $this->db->get('blog_comments');
			
			$number_results = $data['blog_comments_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/post/'.$data['blog_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$data['alert_msg'] = "";
			
			$this->load->view('header', $data);
			$this->load->view('blog_comments', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_post()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(4);
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['blog_id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['blog_id']);
			$this->db->order_by('id', 'asc');
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->limit(5,$limits['offset']);
			$this->db->order_by('id', 'desc');
			$data['blog_comments'] = $this->db->get('blog_comments');
			
			$this->db->where('blog_id', $data['blog_id']);
			$this->db->order_by('id', 'desc');
			$data['blog_comments_count'] = $this->db->get('blog_comments');
			
			$number_results = $data['blog_comments_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/post/'.$data['blog_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('blog_id', 'Blog Id', 'required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|prep_for_form');
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				redirect($_SERVER['HTTP_REFERER']);
				$data['alert_msg'] = '<p><strong>There were some errors with your blog:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'blog_id' => $this->input->post('blog_id'),
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description')
					);
				$this->db->insert('blog_comments', $item);
				
				$data['alert_msg'] = '<p><strong>Your blog was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('news_blogs', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function edit_post()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(4, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['id']);
			$this->db->limit(5,$limits['offset']);
			$data['blog_comments'] = $this->db->get('blog_comments');
			
			$this->db->where('blog_id', $data['id']);
			$data['blog_comments_count'] = $this->db->get('blog_comments');
			
			$number_results = $data['blog_comments_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/news_blogs/post/'.$data['id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->where('id', $data['id']);
			$this->db->order_by('id', 'desc');
			$data['blogs'] = $this->db->get('blogs');
			
			$this->db->limit(8);
			$data['news'] = $this->db->get('news');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|prep_for_form');
			
			//currently online
			$this->db->distinct('ip_address');
			$this->db->where('user_data !=', "");
			$data['online'] = $this->db->get('ci_sessions');
			//echo $this->db->last_query();
			
			//last 24 hours
			$date = date('Y-m-d H:i:s');
			$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
			$first_date = date ('Y-m-d H:i:s', $newdate );
			$second_date = date('Y-m-d H:i:s');
			$this->db->where('last_login >=', $first_date);
			$this->db->where('last_login <=', $second_date);
			$data['last_24'] = $this->db->get('users');
			//echo $this->db->last_query();
			
			//newest
			$this->db->order_by('created', 'desc');
			$this->db->limit(1);
			$data['newest'] = $this->db->get('users');
			//echo $this->db->last_query();
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				$this->load->view('header', $data);
				$this->load->view('blog_comments', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description')
					);
				$this->db->where('id', $data['id']);	
				$this->db->update('blog_comments', $item);
				
				$this->load->view('header', $data);
				$this->load->view('blog_comments', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
			
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function delete_post()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'news_blogs');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['blog_id'] = $this->uri->segment(3);
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);		
			$this->db->delete('blog_comments');
			
			redirect('news_blogs/post/'.$data['blog_id']);
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>