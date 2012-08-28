<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {

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
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			redirect('forum/main/');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function main()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['offset'] = 0;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$data['owner'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->limit(10);
			$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
			
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			$data['alert_msg'] = "";
			$data['shout_alert_msg'] = "";
			
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
			
			$this->load->view('header', $data);
			$this->load->view('forum', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function shoutbox()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {	
		$this->db->order_by('date', 'desc');
		$this->db->limit(10);
		$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
		
		$data['user_profiles'] = $this->db->get('user_profiles');
		
		$this->load->view('shoutbox', $data);
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_shout()
	{	
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['offset'] = 0;

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$data['owner'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->limit(10);
			$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
			
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('message', 'Shout Message', 'required|xss_clean');
			
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
				$data['shout_alert_msg'] = validation_errors();
				$data['alert_msg'] = "<p><strong>There were some errors with your section:</strong></p>".validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'message' => $this->input->post('message')
				);
				
				$this->db->insert('forum_shoutbox', $item);
				
				$data['shout_alert_msg'] = "";
				$data['alert_msg'] = "";
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
				redirect('forum');
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}

	public function add_section()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['offset'] = 0;

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$data['owner'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->limit(10);
			$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
			
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('owned_by', 'Owned By', 'required|xss_clean');
			$this->form_validation->set_rules('block', 'Associated Block', 'required|xss_clean');
			$this->form_validation->set_rules('section_name', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('section_description', 'Description', 'required|xss_clean');
			
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
				$data['shout_alert_msg'] = '';
				$data['alert_msg'] = '<p><strong>There were some errors with your section:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
			}else{
			
			$this->db->where('id',$this->input->post('owned_by'));
			$userid_username = $this->db->get('users');
			
			foreach ($userid_username->result() as $row)
			{
				$data['username'] =  $row->username;
			}
				$item = array(
						'owner_id' => $this->input->post('owned_by'),
						'owned_by' => $data['username'],
						'block' => $this->input->post('block'),
						'section_name' => $this->input->post('section_name'),
						'section_description' => $this->input->post('section_description')
					);
				
				$this->db->insert('forum_sections', $item);
				
				$data['shout_alert_msg'] = '';
				$data['alert_msg'] = '<p><strong>Your section was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
				redirect('forum');
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function edit_section()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['offset'] = 0;

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['section_id'] = $this->uri->segment(3);
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$data['owner'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->limit(10);
			$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
			
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('owned_by', 'Owned By', 'required|xss_clean');
			$this->form_validation->set_rules('block', 'Associated Block', 'required|xss_clean');
			$this->form_validation->set_rules('section_name', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('section_description', 'Description', 'required|xss_clean');
			
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
				$data['shout_alert_msg'] = '';
				$data['alert_msg'] = '<p><strong>There were some errors with your section:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
			}else{
			
			$this->db->where('id',$this->input->post('owned_by'));
			$userid_username = $this->db->get('users');
			
			foreach ($userid_username->result() as $row)
			{
				$data['username'] =  $row->username;
			}
				$item = array(
						'owner_id' => $this->input->post('owned_by'),
						'owned_by' => $data['username'],
						'block' => $this->input->post('block'),
						'section_name' => $this->input->post('section_name'),
						'section_description' => $this->input->post('section_description')
				);
				
				$this->db->where('id', $data['section_id']);
				$this->db->update('forum_sections', $item);
				
				$data['shout_alert_msg'] = '';
				$data['alert_msg'] = '<p><strong>Your section was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('forum', $data);
				$this->load->view('footer');
				redirect('forum');
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function delete_section()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['section_id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['section_id']);		
			$this->db->delete('forum_sections');
			
			$this->db->where('section_id', $data['section_id']);		
			$this->db->delete('forum_threads');
			
			$this->db->where('section_id', $data['section_id']);		
			$this->db->delete('forum_posts');
			redirect('forum');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function thread()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
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
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$this->db->limit(5,$limits['offset']);
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads_count'] = $this->db->get('forum_threads');
			
			$number_results = $data['forum_threads_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/thread/'.$data['sections_thread_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$array = array('section_id' => $data['sections_thread_id'], 'id' => $data['threads_post_id']);
			$this->db->where($array);
			$this->db->order_by('id', 'asc');
			$data['forum_posts'] = $this->db->get('forum_threads');
			
			$data['alert_msg'] = "";
			
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
			
			$this->load->view('header', $data);
			$this->load->view('forum_thread', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_thread()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
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
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$this->db->limit(5,$limits['offset']);
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads_count'] = $this->db->get('forum_threads');
			
			$number_results = $data['forum_threads_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/thread/'.$data['sections_thread_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$array = array('section_id' => $data['sections_thread_id'], 'id' => $data['threads_post_id']);
			$this->db->where($array);
			$this->db->order_by('id', 'asc');
			$data['forum_posts'] = $this->db->get('forum_threads');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('section_id', 'Section Id', 'required|xss_clean');
			$this->form_validation->set_rules('thread_name', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('thread_description', 'Description', 'required|prep_for_form');
			
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
				$data['alert_msg'] = '<p><strong>There were some errors with your thread:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum_thread', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'section_id' => $this->input->post('section_id'),
						'thread_name' => $this->input->post('thread_name'),
						'thread_description' => $this->input->post('thread_description')
					);
				$this->db->insert('forum_threads', $item);
				
				$data['alert_msg'] = '<p><strong>Your thread was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('forum_thread', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function edit_thread()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
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
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$this->db->limit(5,$limits['offset']);
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads_count'] = $this->db->get('forum_threads');
			
			$number_results = $data['forum_threads_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/thread/'.$data['sections_thread_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$array = array('section_id' => $data['sections_thread_id'], 'id' => $data['threads_post_id']);
			$this->db->where($array);
			$this->db->order_by('id', 'asc');
			$data['forum_posts'] = $this->db->get('forum_threads');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('section_id', 'Section Id', 'required|xss_clean');
			$this->form_validation->set_rules('thread_name', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('thread_description', 'Description', 'required|prep_for_form');
			
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
				$data['alert_msg'] = '<p><strong>There were some errors with your thread:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum_post', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'section_id' => $this->input->post('section_id'),
						'thread_name' => $this->input->post('thread_name'),
						'thread_description' => $this->input->post('thread_description')
					);
				$this->db->where('id', $data['threads_post_id']);		
				$this->db->update('forum_threads', $item);
				
				$this->load->view('header', $data);
				$this->load->view('forum_post', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function delete_thread()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['threads_post_id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['threads_post_id']);		
			$this->db->delete('forum_threads');
			
			$this->db->where('thread_id', $data['threads_post_id']);		
			$this->db->delete('forum_posts');
			redirect('forum');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function post()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$this->db->limit(5,$limits['offset']);
			$data['forum_posts'] = $this->db->get('forum_posts');
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$data['forum_posts_count'] = $this->db->get('forum_posts');
			
			$number_results = $data['forum_posts_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/post/'.$data['sections_thread_id'].'/'.$data['threads_post_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$data['alert_msg'] = "";
			
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
			
			$this->load->view('header', $data);
			$this->load->view('forum_post', $data);
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
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$this->db->limit(5,$limits['offset']);
			$data['forum_posts'] = $this->db->get('forum_posts');
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$data['forum_posts_count'] = $this->db->get('forum_posts');
			
			$number_results = $data['forum_posts_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/post/'.$data['sections_thread_id'].'/'.$data['threads_post_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('section_id', 'Section Id', 'required|xss_clean');
			$this->form_validation->set_rules('thread_id', 'Thread Id', 'required|xss_clean');
			$this->form_validation->set_rules('post_name', 'Title', 'xss_clean');
			$this->form_validation->set_rules('post_description', 'Description', 'required|prep_for_form');
			
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
				$data['alert_msg'] = '<p><strong>There were some errors with your post:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('forum_post', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'section_id' => $this->input->post('section_id'),
						'thread_id' => $this->input->post('thread_id'),
						'post_name' => $this->input->post('post_name'),
						'post_description' => $this->input->post('post_description')
					);
				$this->db->insert('forum_posts', $item);
				
				$data['alert_msg'] = '<p><strong>Your post was added successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('forum_post', $data);
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
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$data['forum'] = $this->db->get('forum');
			$this->db->order_by('id', 'asc');
			$data['forum_sections'] = $this->db->get('forum_sections');
			
			$data['sections_thread_id'] = $this->uri->segment(3);
			$data['threads_post_id'] = $this->uri->segment(4);
			$data['post_id'] = $this->uri->segment(5);
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$this->db->limit(5,$limits['offset']);
			$data['forum_posts'] = $this->db->get('forum_posts');
			
			$this->db->where('thread_id', $data['threads_post_id']);
			$data['forum_posts_count'] = $this->db->get('forum_posts');
			
			$number_results = $data['forum_posts_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/forum/post/'.$data['sections_thread_id'].'/'.$data['threads_post_id'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 5;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->db->where('section_id', $data['sections_thread_id']);
			$this->db->order_by('id', 'desc');
			$data['forum_threads'] = $this->db->get('forum_threads');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('section_id', 'Section Id', 'required|xss_clean');
			$this->form_validation->set_rules('thread_id', 'Thread Id', 'required|xss_clean');
			$this->form_validation->set_rules('post_name', 'Title', 'xss_clean');
			$this->form_validation->set_rules('post_description', 'Description', 'required|prep_for_form');
			
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
				$this->load->view('forum_post', $data);
				$this->load->view('footer');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'section_id' => $this->input->post('section_id'),
						'thread_id' => $this->input->post('thread_id'),
						'post_name' => $this->input->post('post_name'),
						'post_description' => $this->input->post('post_description')
					);
				$this->db->where('id', $data['post_id']);	
				$this->db->update('forum_posts', $item);
				
				$this->load->view('header', $data);
				$this->load->view('forum_post', $data);
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
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['post_id'] = $this->uri->segment(3);
			
			$this->db->where('id', $data['post_id']);		
			$this->db->delete('forum_posts');
			redirect($_SERVER['HTTP_REFERER']);
			
		}	
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function pm()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	$this->db->where('module_name', 'profile');
	$data['modules_2'] = $this->db->get('modules')->row();
	
	if(($data['modules']->status != '0')||($data['modules_2']->status != '0')) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->db->order_by('username', 'asc');
			$data['user'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->where('reciever_id',$data['user_id']);
			$data['inbox'] = $this->db->get('pm');
			
			$this->db->order_by('date', 'desc');
			$this->db->where('sender_id',$data['user_id']);
			$data['outbox'] = $this->db->get('pm');
			
			$data['alert_msg'] = '';
			
			$this->load->view('header', $data);
			$this->load->view('pm', $data);
			$this->load->view('footer');
		}	
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function pm_send()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	$this->db->where('module_name', 'profile');
	$data['modules_2'] = $this->db->get('modules')->row();
	
	if(($data['modules']->status != '0')||($data['modules_2']->status != '0')) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->db->order_by('username', 'asc');
			$data['user'] = $this->db->get('users');
			
			$this->db->order_by('date', 'desc');
			$this->db->where('reciever_id',$data['user_id']);
			$data['inbox'] = $this->db->get('pm');
			
			$this->db->order_by('date', 'desc');
			$this->db->where('sender_id',$data['user_id']);
			$data['outbox'] = $this->db->get('pm');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('sender_id', 'Sender Id', 'required|xss_clean');
			$this->form_validation->set_rules('sender', 'Sender', 'required|xss_clean');
			$this->form_validation->set_rules('reciever_id', 'Reciever Id', 'required|xss_clean');
			$this->form_validation->set_rules('title', 'Title', 'xss_clean');
			$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				$data['alert_msg'] = '<p><strong>There were some errors with your pm:</strong></p>'.validation_errors();
				$this->load->view('header', $data);
				$this->load->view('pm', $data);
				$this->load->view('footer');
			}else{
				$this->db->where('id',$this->input->post('reciever_id'));
				$userid_username = $this->db->get('users');
				
				foreach ($userid_username->result() as $row)
				{
					$data['reciever'] =  $row->username;
				}
				
				$item = array(
						'sender_id' => $this->input->post('sender_id'),
						'sender' => $this->input->post('sender'),
						'reciever_id' => $this->input->post('reciever_id'),
						'reciever' => $data['reciever'],
						'title' => $this->input->post('title'),
						'message' => $this->input->post('message')
					);
				$this->db->insert('pm', $item);
				
				$data['alert_msg'] = '<p><strong>Your pm was sent to <strong>'.$data['reciever'].'</strong> successfully</strong></p>';
				$this->load->view('header', $data);
				$this->load->view('pm', $data);
				$this->load->view('footer');
				redirect('forum/pm');
			}
		}	
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function pm_read()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	$this->db->where('module_name', 'profile');
	$data['modules_2'] = $this->db->get('modules')->row();
	
	if(($data['modules']->status != '0')||($data['modules_2']->status != '0')) {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['message_id'] = $this->uri->segment(3);
			
			$item = array(
				'reciever_id' => $data['user_id'], 
				'read' => '1'
			);
			
			$this->db->where('read', '0');
			$this->db->where('reciever_id', $data['user_id']);
			$this->db->where('id', $data['message_id']);
			$this->db->update('pm', $item);
			
			redirect('forum/pm/');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function members()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['alphabet'] = $this->uri->segment(3);
			
			$this->db->order_by('username', 'asc');
			$data['user'] = $this->db->get('users');
			
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
			
			$this->load->view('header', $data);
			$this->load->view('forum_members', $data);
			$this->load->view('footer');
		}	
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function arcade()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'forum');
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
			$data['game'] = $this->db->get('forum_arcade');
			
			$this->db->order_by('id', 'desc');
			$data['games_list'] = $this->db->get('forum_arcade');
			
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
			
			$this->load->view('header', $data);
			$this->load->view('forum_arcade', $data);
			$this->load->view('footer');
		}	
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>