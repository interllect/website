<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends CI_Controller {

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
	
	$this->db->where('module_name', 'lists');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			$data['user_id']	= "";
			$data['username']	= "";
			$data['role_id']	= "";
			
			$data['list_groups'] = $this->db->get('list_groups');
			
			$this->db->order_by('id','desc');
			$data['list_items'] = $this->db->get('list_items');
			
			$this->load->view('header', $data);
			$this->load->view('lists', $data);
			$this->load->view('footer');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['list_groups'] = $this->db->get('list_groups');

			$this->db->order_by('id','desc');
			$data['list_items'] = $this->db->get('list_items');
			
			$this->load->view('header', $data);
			$this->load->view('lists', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>