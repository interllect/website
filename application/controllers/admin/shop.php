<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

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
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/shop', $data);
			$this->load->view('admin/footer');
		}
		
	}
	
	public function categories()
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
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$data['shop_categories_count'] = $this->db->get('shop_categories');
			
			$number_results = $data['shop_categories_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/shop/categories/'.$data['order'].'/';
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
			$this->load->view('admin/shop_categories', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function categories_add()
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
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category', 'Category', 'required|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/shop/categories/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10000';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/shop/categories_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_categories_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "image";
				$this->upload->do_upload($field_name);
				$image_data = $this->upload->data();
				$image_data = $image_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'category' => $this->input->post('category')
					);
					
					$this->db->insert('shop_categories', $item);
					
					redirect('admin/shop/categories/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_categories_add', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'category' => $this->input->post('category')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
						$item['image'] = $image_data;
					}
					
					$this->db->insert('shop_categories', $item);
					
					redirect('admin/shop/categories/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_categories_add', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function categories_edit()
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
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$this->db->where('id', $data['id']);
			$data['shop_categories_edit'] = $this->db->get('shop_categories')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category', 'Category', 'required|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/shop/categories/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10000';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/shop/categories_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_categories_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "image";
				$this->upload->do_upload($field_name);
				$image_data = $this->upload->data();
				$image_data = $image_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'category' => $this->input->post('category')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('shop_categories', $item);
					
					redirect('admin/shop/categories_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_categories_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$this->db->where('id', $data['id']);
					$delete_media = $this->db->get('shop_categories')->row();
					
					#complete serverpath must be given like 
					#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
					$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/shop/categories/'. $delete_media->image;

					# delete file if exists
					if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
				
					$item = array(
						'category' => $this->input->post('category')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
						$item['image'] = $image_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('shop_categories', $item);
					
					redirect('admin/shop/categories_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_categories_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function categories_delete()
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
			$delete_media = $this->db->get('shop_categories')->row();
			
			$this->db->where('category_id', $data['id']);
			$delete_media2 = $this->db->get('shop_products')->row();
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/shop/categories/'. $delete_media->image;
			$DelFilePath2 = $_SERVER['DOCUMENT_ROOT'].'/uploads/shop/products/'. $delete_media2->image;

			# delete file if exists
			if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
			if (file_exists($DelFilePath2)) { unlink ($DelFilePath2); }
			
			$this->db->where('id', $data['id']);
			$this->db->delete('shop_categories');
			
			$this->db->where('category_id', $data['id']);
			$this->db->delete('shop_products');
			
			$this->db->where('category_id', $data['id']);
			$this->db->delete('shop_review');
				
			redirect('admin/shop/categories/', 'refresh');
		}
	}
	
	public function products()
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
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
			$data['offset'] = $limits['offset'];
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['order'] = $this->uri->segment(4);
			$data['catergory_id'] = $this->uri->segment(6);
			
			if($data['order'] != ""){
				$this->db->order_by($data['order'], 'desc');
			}else{
				$data['order'] = 'id';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$this->db->where('category_id', $data['catergory_id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$this->db->where('category_id', $data['catergory_id']);
			$this->db->join('shop_categories', 'shop_categories.id = shop_products.category_id');
			$data['shop_products_edit'] = $this->db->get('shop_products')->row();
			
			$this->db->where('category_id', $data['catergory_id']);
			$data['shop_products_count'] = $this->db->get('shop_products');
			
			$number_results = $data['shop_products_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/shop/products/'.$data['order'].'/';
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
			$this->load->view('admin/shop_products', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function products_add()
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
			
			$data['category_id'] = $this->uri->segment(4);
			
			$this->db->where('id',$data['category_id']);
			$data['shop_categories'] = $this->db->get('shop_categories');
			foreach($data['shop_categories']->result() as $row){
				$category_name = $row->category;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('product_name', 'Name', 'required|xss_clean');	
			$this->form_validation->set_rules('product_description', 'Description', 'required|xss_clean');	
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');	
			$this->form_validation->set_rules('sku_number', 'SKU Number', 'required|xss_clean');	
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|xss_clean|numeric');	
			$this->form_validation->set_rules('product_height', 'Product Height', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_width', 'Product Width', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_breadth', 'Product Breadth', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_weight', 'Product Weight', 'xss_clean|decimal');	
			$this->form_validation->set_rules('price', 'Price', 'required|xss_clean|decimal');	
			$this->form_validation->set_rules('discount_amount', 'Discount Amount', 'xss_clean|decimal');	
			$this->form_validation->set_rules('discount_rate', 'Discount Rate', 'xss_clean|numeric');	
			$this->form_validation->set_rules('shipping', 'Shipping', 'xss_clean|decimal');
			$this->form_validation->set_rules('availability', 'Availability', 'required|xss_clean|numeric');
			
			$config['upload_path'] = './uploads/shop/products/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10000';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/shop/products_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_products_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "image";
				$this->upload->do_upload($field_name);
				$image_data = $this->upload->data();
				$image_data = $image_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'category_id' => $data['category_id'],
						'category_name' => $category_name,
						'product_name' => $this->input->post('product_name'),	
						'product_description' => $this->input->post('product_description'),		
						'sku_number' => $this->input->post('sku_number'),	
						'quantity' => $this->input->post('quantity'),
						'product_height' => $this->input->post('product_height'),	
						'product_width' => $this->input->post('product_width'),
						'product_breadth' => $this->input->post('product_breadth'),
						'product_weight' => $this->input->post('product_weight'),	
						'price' => $this->input->post('price'),
						'discount_amount' => $this->input->post('discount_amount'),	
						'discount_rate' => $this->input->post('discount_rate'),
						'shipping' => $this->input->post('shipping'),
						'availability' => $this->input->post('availability')
					);
					
					$this->db->insert('shop_products', $item);
					
					redirect('admin/shop/products/id/0/'.$data['category_id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_products_add', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'category_id' => $data['category_id'],
						'category_name' => $category_name,
						'product_name' => $this->input->post('product_name'),	
						'product_description' => $this->input->post('product_description'),		
						'sku_number' => $this->input->post('sku_number'),	
						'quantity' => $this->input->post('quantity'),
						'product_height' => $this->input->post('product_height'),	
						'product_width' => $this->input->post('product_width'),
						'product_breadth' => $this->input->post('product_breadth'),
						'product_weight' => $this->input->post('product_weight'),	
						'price' => $this->input->post('price'),
						'discount_amount' => $this->input->post('discount_amount'),	
						'discount_rate' => $this->input->post('discount_rate'),
						'shipping' => $this->input->post('shipping'),
						'availability' => $this->input->post('availability')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
						$item['image'] = $image_data;
					}
					
					$this->db->insert('shop_products', $item);
					
					redirect('admin/shop/products/id/0/'.$data['category_id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_products_add', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function products_edit()
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
			$data['category_id'] = $this->uri->segment(5);
			
			$this->db->where('id',$data['category_id']);
			$data['shop_categories_current'] = $this->db->get('shop_categories');
			foreach($data['shop_categories_current']->result() as $row){
				$category_name = $row->category;
			}
			
			$data['shop_categories'] = $this->db->get('shop_categories');
			
			$this->db->where('id', $data['id']);
			$data['shop_products'] = $this->db->get('shop_products');
			
			$this->db->where('id', $data['id']);
			$data['shop_products_edit'] = $this->db->get('shop_products')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category_id', 'Category', 'required|xss_clean');
			$this->form_validation->set_rules('product_name', 'Name', 'required|xss_clean');	
			$this->form_validation->set_rules('product_description', 'Description', 'required|xss_clean');	
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');	
			$this->form_validation->set_rules('sku_number', 'SKU Number', 'required|xss_clean');	
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|xss_clean|numeric');	
			$this->form_validation->set_rules('product_height', 'Product Height', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_width', 'Product Width', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_breadth', 'Product Breadth', 'xss_clean|decimal');	
			$this->form_validation->set_rules('product_weight', 'Product Weight', 'xss_clean|decimal');		
			$this->form_validation->set_rules('price', 'Price', 'required|xss_clean|decimal');	
			$this->form_validation->set_rules('discount_amount', 'Discount Amount', 'xss_clean|decimal');	
			$this->form_validation->set_rules('discount_rate', 'Discount Rate', 'xss_clean|numeric');	
			$this->form_validation->set_rules('shipping', 'Shipping', 'xss_clean|decimal');
			$this->form_validation->set_rules('availability', 'Availability', 'required|xss_clean|numeric');
			
			$config['upload_path'] = './uploads/shop/products/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10000';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/shop/products_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_products_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "image";
				$this->upload->do_upload($field_name);
				$image_data = $this->upload->data();
				$image_data = $image_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'category_id' => $this->input->post('category_id'),
						'category_name' => $category_name,
						'product_name' => $this->input->post('product_name'),	
						'product_description' => $this->input->post('product_description'),		
						'sku_number' => $this->input->post('sku_number'),	
						'quantity' => $this->input->post('quantity'),
						'product_height' => $this->input->post('product_height'),	
						'product_width' => $this->input->post('product_width'),
						'product_breadth' => $this->input->post('product_breadth'),
						'product_weight' => $this->input->post('product_weight'),	
						'price' => $this->input->post('price'),
						'discount_amount' => $this->input->post('discount_amount'),	
						'discount_rate' => $this->input->post('discount_rate'),
						'shipping' => $this->input->post('shipping'),
						'availability' => $this->input->post('availability')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('shop_products', $item);
					
					redirect('admin/shop/products/id/0/'.$data['category_id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_products_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$this->db->where('id', $data['id']);
					$delete_media = $this->db->get('shop_products')->row();
					
					#complete serverpath must be given like 
					#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
					$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/shop/products/'. $delete_media->image;

					# delete file if exists
					if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
				
					$item = array(
						'category_id' => $this->input->post('category_id'),
						'product_name' => $category_name,	
						'product_description' => $this->input->post('product_description'),		
						'sku_number' => $this->input->post('sku_number'),	
						'quantity' => $this->input->post('quantity'),
						'product_height' => $this->input->post('product_height'),	
						'product_width' => $this->input->post('product_width'),
						'product_breadth' => $this->input->post('product_breadth'),
						'product_weight' => $this->input->post('product_weight'),	
						'price' => $this->input->post('price'),
						'discount_amount' => $this->input->post('discount_amount'),	
						'discount_rate' => $this->input->post('discount_rate'),
						'shipping' => $this->input->post('shipping'),
						'availability' => $this->input->post('availability')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
						$item['image'] = $image_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('shop_products', $item);
					
					redirect('admin/shop/products/id/0/'.$data['category_id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/shop_products_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}

	public function products_delete()
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
			$delete_media = $this->db->get('shop_products')->row();
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/shop/products/'. $delete_media->image;

			# delete file if exists
			if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
			
			$this->db->where('id', $data['id']);
			$this->db->delete('shop_products');
			
			$this->db->where('product_id', $data['id']);
			$this->db->delete('shop_review');
			
			redirect('admin/shop/products/', 'refresh');
		}
	}
	
	public function review()
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
			$number_rows_per_page = 5;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
			$data['offset'] = $limits['offset'];
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['order'] = $this->uri->segment(4);
			$data['id'] = $this->uri->segment(6);
			
			if($data['order'] != ""){
				$this->db->order_by($data['order'], 'desc');
			}else{
				$data['order'] = 'currency_name';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$this->db->where('product_id', $data['id']);
			$data['shop_review'] = $this->db->get('shop_review');
			
			$this->db->where('product_id', $data['id']);
			$data['shop_review_edit'] = $this->db->get('shop_review')->row();
			
			$data['shop_review_count'] = $this->db->get('shop_review');
			
			$number_results = $data['shop_review_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/shop/review/'.$data['order'].'/';
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
			$this->load->view('admin/shop_reviews', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function review_delete()
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
			$this->db->delete('shop_review');
					
			redirect('admin/shop/review/id/0/'.$data['id'], 'refresh');
		}
	}
	
	public function standards_formatting()
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
				$data['order'] = 'currency_name';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
			$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard');
			$data['shop_standards_formatting'] = $this->db->get('shop_standards_formatting');
			
			$data['shop_standards_formatting_id'] = $this->db->get('shop_standards_formatting');
			
			$data['shop_standards_formatting_count'] = $this->db->get('shop_standards_formatting');
			
			$number_results = $data['shop_standards_formatting_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/shop/standards_formatting/'.$data['order'].'/';
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
			$this->load->view('admin/shop_standards_formatting', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function standards_formatting_edit()
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
			
			$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
			$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard');
			$data['shop_standards_formatting'] = $this->db->get('shop_standards_formatting');
			$data['shop_measurement'] = $this->db->get('shop_measurement');
			$data['shop_currency'] = $this->db->get('shop_currency');
			
			$this->db->join('shop_currency', 'shop_currency.id = shop_standards_formatting.currency_standard');
			$this->db->join('shop_measurement', 'shop_measurement.id = shop_standards_formatting.measurement_standard');
			$data['shop_standards_formatting_edit'] = $this->db->get('shop_standards_formatting')->row();
			$data['shop_measurement_edit'] = $this->db->get('shop_measurement')->row();
			$data['shop_currency_edit'] = $this->db->get('shop_currency')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('currency_standard', 'Currency Standard', 'required|xss_clean');
			$this->form_validation->set_rules('measurement_standard', 'Measurement Standard', 'required|xss_clean');
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/shop/categories_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_standards_formatting_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'currency_standard' => $this->input->post('currency_standard'),
					'measurement_standard' => $this->input->post('measurement_standard')
				);
					
				$this->db->where('id', $data['id']);
				$this->db->update('shop_standards_formatting', $item);
					
				redirect('admin/shop/standards_formatting');
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/shop_standards_formatting_edit', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	
	public function transactions()
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
			$data['shop_transactions'] = $this->db->get('user_to_products');
			
			$data['shop_transactions_count'] = $this->db->get('user_to_products');
			
			$number_results = $data['shop_transactions_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/shop/transactions/'.$data['order'].'/';
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
			$this->load->view('admin/shop_transactions', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function transactions_delete()
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
			$this->db->delete('user_to_products');
					
			redirect('admin/shop/transactions/', 'refresh');
		}
	}
}

?>