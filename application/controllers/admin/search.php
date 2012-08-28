<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
			redirect('/admin/login/');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '3')){
			redirect('');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();	
	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('keyword', 'Search', 'required|xss_clean|alpha_numeric');
			
			if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/header', $data);
			$this->load->view('admin/search_bad');
			$this->load->view('admin/footer');
			}
			else 
			{
				
				$data['keyword'] = $this->input->post('keyword');
				$data['result_msg'] = "The list(s) below show all of the results for <strong style='font-size: 20px;'>'" . $this->input->post('keyword') . "'</strong> within each of the sites main sections";
				//media search
				$this->db->or_like('title', $data['keyword']);
				$this->db->or_like('description', $data['keyword']);
				$this->db->order_by('date', 'desc');
				$data['media'] = $this->db->get('media');
				
				//shp search
				$this->db->like('product_name', $data['keyword']);
				$this->db->or_like('product_description', $data['keyword']);
				$this->db->order_by('date', 'desc');
				$data['shop'] = $this->db->get('shop_products');
				
				//news search
				$this->db->like('title', $data['keyword']);
				$this->db->or_like('description', $data['keyword']);
				$this->db->order_by('date', 'desc');
				$data['news'] = $this->db->get('news');
				
				//blog search
				$this->db->like('title', $data['keyword']);
				$this->db->or_like('description', $data['keyword']);
				$this->db->order_by('date', 'desc');	
				$data['blogs'] = $this->db->get('blogs');
				
				//forum search
				$this->db->like('thread_name', $data['keyword']);
				$this->db->or_like('thread_description', $data['keyword']);		
				$this->db->order_by('date', 'desc');
				$data['forum'] = $this->db->get('forum_threads');
				
				$this->load->view('admin/header', $data);
				$this->load->view('admin/search', $data);
				$this->load->view('admin/footer');
			}
		}
    }

}

?>