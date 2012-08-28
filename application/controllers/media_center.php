<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_center extends CI_Controller {

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
	
	$this->db->where('module_name', 'media_center');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			redirect('/media_center/media');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function media()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'media_center');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$number_rows_per_page = 8;
			$offset = $this->uri->segment(3, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->db->order_by('id', 'desc');
			$this->db->where('audio !=', '');
			$data['audio'] = $this->db->get('media');
			
			$this->db->limit(8,$limits['offset']);
			$this->db->order_by('id', 'desc');
			$this->db->where('image !=', '');
			$data['image'] = $this->db->get('media');
			
			$this->db->order_by('id', 'desc');
			$this->db->where('video !=', '');
			$data['video'] = $this->db->get('media');
			
			$this->db->order_by('id', 'desc');
			$this->db->where('image !=', '');
			$data['image_count'] = $this->db->get('media');
			
			$number_results = $data['image_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/media_center/media/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->load->view('header', $data);
			$this->load->view('media_center', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}	
	}
}

?>