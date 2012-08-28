<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('email','session','tank_auth'));
		$this->load->helper(array('url','form', 'profile', 'image_upload_helper'));
	}
	
	public function index()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '3')){
			redirect('', 'refresh');
		} 
		else {
			redirect('/admin/contact/form', 'refresh');
		}
	}
	
	public function form()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '3')){
			redirect('');
		} 
		else {
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['order'] = $this->uri->segment(4);
			
			if($data['order'] != ""){
				$this->db->order_by($data['order'], 'desc');
			}else{
				$data['order'] = 'id';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$data['contact'] = $this->db->get('contact');
			
			$data['contact_count'] = $this->db->get('contact');
			
			$number_results = $data['contact_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/contact/form/'.$data['order'].'/';
			$config['total_rows'] = $number_results;
			$config['per_page'] = $number_rows_per_page;
			$config['uri_segment'] = 5;
			$config['cur_tag_open'] = '<div id="page-info"><strong>';
			$config['cur_tag_close'] = '</strong></div>';
			$config['num_tag_open'] = '<div id="page-info">';
			$config['num_tag_close'] = '</div>';
			$config['prev_link'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$config['prev_tag_open'] = '<div class="page-left">';
			$config['prev_tag_close'] = '</div>';
			$config['first_link'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$config['first_tag_open'] = '<div class="page-far-left">';
			$config['first_tag_close'] = '</div>';
			$config['last_link'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$config['last_tag_open'] = '<div class="page-far-right">';
			$config['last_tag_close'] = '</div>';
			$config['next_link'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$config['next_tag_open'] = '<div class="page-right">';
			$config['next_tag_close'] = '</div>';
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/contact', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function form_delete()
	{	
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '3')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$this->db->delete('contact');
					
			redirect('admin/contact/form/', 'refresh');
		}
	}
}
?>