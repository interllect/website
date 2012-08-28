<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/dashboard', $data);
			$this->load->view('admin/footer');
		}
	}

	public function splash()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
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
			$data['splash'] = $this->db->get('splash');
			
			$data['splash_count'] = $this->db->get('splash');
			
			$number_results = $data['splash_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/dashboard/splash/'.$data['order'].'/';
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
			$this->load->view('admin/dash_splash', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function splash_add()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('link', 'Link', 'required|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/slides/';
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
				//redirect('admin/dashboard/splash_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/dash_splash_add', $data);
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
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'link' => $this->input->post('link')
					);
					
					$this->db->insert('splash', $item);
					
					redirect('admin/dashboard/splash/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_splash_add', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'link' => $this->input->post('link')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '390'));
						$item['image'] = $image_data;
					}
					
					$this->db->insert('splash', $item);
					
					redirect('admin/dashboard/splash/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_splash_add', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function splash_edit()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$data['splash'] = $this->db->get('splash');
			
			$this->db->where('id', $data['id']);
			$data['splash_edit'] = $this->db->get('splash')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('link', 'Link', 'required|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/slides/';
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
				//redirect('admin/dashboard/splash_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/dash_splash_edit', $data);
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
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'link' => $this->input->post('link')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('splash', $item);
					
					//redirect('admin/dashboard/splash_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_splash_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$this->db->where('id', $data['id']);
					$delete_media = $this->db->get('splash')->row();
					
					#complete serverpath must be given like 
					#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
					$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/slides/'. $delete_media->image;

					# delete file if exists
					if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
				
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'link' => $this->input->post('link')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '390'));
						$item['image'] = $image_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('splash', $item);
					
					//redirect('admin/dashboard/splash_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_splash_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function splash_delete()
	{	
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$delete_media = $this->db->get('splash')->row();
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/slides/'. $delete_media->image;

			# delete file if exists
			if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
			
			$this->db->where('id', $data['id']);
			$this->db->delete('splash');
					
			redirect('admin/dashboard/splash/', 'refresh');
		}
	}
	
	public function advert()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
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
			$data['advert'] = $this->db->get('advert');
			
			$data['advert_count'] = $this->db->get('advert');
			
			$number_results = $data['advert_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/dashboard/advert/'.$data['order'].'/';
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
			$this->load->view('admin/dash_advert', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function advert_edit()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$data['advert'] = $this->db->get('advert');
			
			$this->db->where('id', $data['id']);
			$data['advert_edit'] = $this->db->get('advert')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('advert_link', 'Link', 'required|xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/corner_advert/';
			$config['allowed_types'] = 'jpg';
			$config['max_size'] = '10000';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$config['file_name'] = 'large.jpg';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				redirect('admin/dashboard/advert_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/dash_advert_edit', $data);
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
						'advert_link' => $this->input->post('advert_link')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('advert', $item);
					
					redirect('admin/dashboard/advert_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_advert_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'advert_link' => $this->input->post('advert_link')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = resize_and_crop($this->upload->data(), array('width' => '500', 'height' => '500'));
						$item['image'] = $image_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('advert', $item);
					
					redirect('admin/dashboard/advert_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/dash_advert_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function modules()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '1')){
			redirect('', 'refresh');
		} 
		else {
			$number_rows_per_page = 20;
			$offset = $this->uri->segment(5, '0');
			$limits['limit'] = $number_rows_per_page;
			$limits['offset'] = $offset;
		
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['order'] = $this->uri->segment(4);
			
			if($data['order'] != ""){
				$this->db->order_by($data['order'], 'asc');
			}else{
				$data['order'] = 'id';
				$this->db->order_by($data['order'], 'asc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$data['modules'] = $this->db->get('modules');
			
			$data['modules_count'] = $this->db->get('modules');
			
			$number_results = $data['modules_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/dashboard/modules/'.$data['order'].'/';
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
			$this->load->view('admin/dash_modules', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function modules_toggle()
	{
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '1')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			$data['offset'] = $this->uri->segment(5);
			
			$this->db->where('id', $data['id']);
			$data['modules'] = $this->db->get('modules');
			
			foreach ($data['modules']->result() as $row)
			{
				$status =  $row->status;
			}
			
			if($status == "0"){
				$item = array(
						'status' => "1"
				);
				$this->db->where('id', $data['id']);
				$this->db->update('modules', $item);
			}elseif($status == "1"){
				$item = array(
						'status' => "0"
				);
				$this->db->where('id', $data['id']);
				$this->db->update('modules', $item);
			}
			
			redirect('/admin/dashboard/modules/');
		}
	}
	
	public function chat()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
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
			$data['chat'] = $this->db->get('chat');
			
			$data['chat_count'] = $this->db->get('chat');
			
			$number_results = $data['chat_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/dashboard/chat/'.$data['order'].'/';
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
			$this->load->view('admin/dash_chat', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function chat_delete()
	{	
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/', 'refresh');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
			redirect('', 'refresh');
		} 
		else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$this->db->delete('chat');
					
			redirect('admin/dashboard/chat/', 'refresh');
		}
	}
}

?>