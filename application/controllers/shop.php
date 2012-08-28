<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

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
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->db->order_by('category', 'asc');
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$this->load->view('header', $data);
			$this->load->view('shop', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function category()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			
			$this->db->order_by('category', 'asc');
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$this->db->order_by('product_name', 'asc');
			$this->db->where('category_id', $data['category_id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$this->load->view('header', $data);
			$this->load->view('shop_category', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function product()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			$data['product_id'] = $this->uri->segment(4);
			
			$this->db->order_by('category', 'asc');
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$this->db->where('category_id', $data['category_id']);
			$this->db->where('id', $data['product_id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('product_id', $data['product_id']);
			$data['basket'] = $this->db->get('user_to_products');
			
			$this->load->view('header', $data);
			$this->load->view('shop_product', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_to_basket()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			$data['product_id'] = $this->uri->segment(4);
			
			$this->db->where('category_id', $data['category_id']);
			$this->db->where('id', $data['product_id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$data['basket'] = $this->db->get('user_to_products');
			
			$shop_products = $data['shop_products'];
			$basket = $data['basket'] ;
			
			foreach($shop_products->result() as $row){
			  $product_name = $row->product_name;
			}
			
			foreach($basket->result() as $item){
			}
			
			$date = date('Y-m-d H:i:s');
			
			$basket_id = array(
				'user_id' => $data['user_id'],
				'username' => $data['username'],
				'product_id' => $data['product_id'],
				'product_name' => $product_name,
				'transaction_type' => '1',
				'transaction_date' => $date
			); 
			
			$this->db->insert('user_to_products', $basket_id);  

			redirect('shop/product/'.$data['category_id'].'/'.$data['product_id']);
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function remove_from_basket()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			$data['product_id'] = $this->uri->segment(4);
			
			$this->db->where('category_id', $data['category_id']);
			$this->db->where('id', $data['product_id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$data['basket'] = $this->db->get('user_to_products');
			
			$shop_products = $data['shop_products'];
			$basket = $data['basket'] ;
			
			foreach($shop_products->result() as $row){
			  $product_name = $row->product_name;
			}
			
			foreach($basket->result() as $item){
			}
			
			$date = date('Y-m-d H:i:s');
			
			$basket_id = array(
				'user_id' => $data['user_id'],
				'username' => $data['username'],
				'product_id' => $data['product_id'],
				'product_name' => $product_name,
				'transaction_type' => '0',
				'transaction_date' => $date
			); 
			
			$this->db->where('user_id', $data['user_id']); 
			$this->db->where('product_id', $data['product_id']);
			$this->db->delete('user_to_products');  
			
			redirect('shop/basket');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function basket()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['shop_products'] = $this->db->get('shop_products');

			$data['basket'] = $this->db->get('user_to_products');
			
			$shop_products = $data['shop_products'];
			$basket = $data['basket'] ;
			
			foreach($shop_products->result() as $row){
				$data['product_id'] = $row->id;
			}
			
			foreach($basket->result() as $item){
			}
			
			$this->db->distinct();
			$this->db->where('user_to_products.transaction_type', '1');
			$this->db->join('user_to_products', 'user_to_products.product_id = shop_products.id');
			$data['basket_products'] = $this->db->get('shop_products');
			
			$this->load->view('header', $data);
			$this->load->view('shop_basket', $data);
			$this->load->view('footer');			 
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function success()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['shop_products'] = $this->db->get('shop_products');	
			
			$data['cancel'] = $this->db->get('user_to_products');
			
			$this->load->view('header', $data);
			$this->load->view('shop_success', $data);
			$this->load->view('footer');	
		}
	}else{redirect('');}
	}else{redirect('');}	
	}
	
	public function cancelled()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['shop_products'] = $this->db->get('shop_products');	
			
			$data['cancel'] = $this->db->get('user_to_products');
			
			$this->load->view('header', $data);
			$this->load->view('shop_cancelled', $data);
			$this->load->view('footer');	
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function comment()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			$data['product_id'] = $this->uri->segment(4);
			
			$data['shop_products'] = $this->db->get('shop_products');	
			$shop_products = $data['shop_products'];
			
			foreach($shop_products->result() as $row){
			  $product_name = $row->product_name;
			}
			
			$data['product_name'] = $product_name;
			
			$data['alert_msg'] = "";
			
			$this->db->where('product_id', $data['product_id']);
			$this->db->order_by('date', 'desc');
			$data['shop_review'] = $this->db->get('shop_review');
			
			$this->load->view('shop_comment', $data);	
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function add_comment()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'shop');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['category_id'] = $this->uri->segment(3);
			$data['product_id'] = $this->uri->segment(4);
			
			$data['shop_products'] = $this->db->get('shop_products');	
			$shop_products = $data['shop_products'];
			
			foreach($shop_products->result() as $row){
			  $product_name = $row->product_name;
			}
			
			$data['product_name'] = $product_name;
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User Id', 'required|xss_clean');
			$this->form_validation->set_rules('username', 'Username', 'required|xss_clean');
			$this->form_validation->set_rules('product_id', 'Product Id', 'required|xss_clean');
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|xss_clean');
			$this->form_validation->set_rules('review', 'Review', 'required|xss_clean');
			
			$this->db->where('product_id', $data['product_id']);
			$this->db->order_by('date', 'desc');
			$data['shop_review'] = $this->db->get('shop_review');
			
			// run validation
			if ($this->form_validation->run() == FALSE) {
				$data['alert_msg'] = '<p><strong>There were some errors with your section:</strong></p>'.validation_errors();
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$item = array(
						'category_id' => $this->input->post('category_id'),
						'user_id' => $this->input->post('user_id'),
						'username' => $this->input->post('username'),
						'product_id' => $this->input->post('product_id'),
						'product_name' => $this->input->post('product_name'),
						'review' => $this->input->post('review')
				);
				
				$this->db->insert('shop_review', $item);
				$data['alert_msg'] = '<p><strong>Your review of this product was added</strong></p>';
				redirect($_SERVER['HTTP_REFERER']);
			}	
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>