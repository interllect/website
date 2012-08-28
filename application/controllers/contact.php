<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

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
	
	$this->db->where('module_name', 'contact');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['users'] = $this->db->get('users');
			$data['contact'] = $this->db->get('contact');
			
			$data['alert_msg'] = "";
			$this->load->view('header', $data);
			$this->load->view('contact', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function send_message()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'contact');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['users'] = $this->db->get('users');
			$data['contact'] = $this->db->get('contact');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
			$this->form_validation->set_rules('enquiry_type', 'Enquiry Type', 'required|xss_clean');
			$this->form_validation->set_rules('enquiry', 'Enquiry', 'required|xss_clean');
			
			if ($this->form_validation->run() == FALSE) {
				$data['alert_msg'] = "<p><strong>There were some errors with your enquiry:</strong></p>".validation_errors();
				$this->load->view('header', $data);
				$this->load->view('contact', $data);
				$this->load->view('footer');
			}else{
				$item = array(
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'enquiry_type' => $this->input->post('enquiry_type'),
						'enquiry' => $this->input->post('enquiry')
				);
				
				$this->db->insert('contact', $item);
				
				$data['alert_msg'] = "";
				$this->load->view('header', $data);
				$this->load->view('contact', $data);
				$this->load->view('footer');
				redirect('contact');
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>