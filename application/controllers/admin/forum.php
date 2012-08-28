<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {

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
		elseif(($this->tank_auth->is_logged_in())&&($role == '2')) {
			redirect('admin/forum/shoutbox');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role <= '1')) {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/forum', $data);
			$this->load->view('admin/footer');
		}
		
	}
	
	public function pm()
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
			$data['pm'] = $this->db->get('pm');
			
			$data['pm_count'] = $this->db->get('pm');
			
			$number_results = $data['pm_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/forum/pm/'.$data['order'].'/';
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
			$this->load->view('admin/forum_pm', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function pm_delete()
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
			$this->db->delete('pm');
					
			redirect('admin/forum/pm/', 'refresh');
		}
	}
	
	public function block()
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
			$data['block'] = $this->db->get('forum');
			
			$data['block_count'] = $this->db->get('forum');
			
			$number_results = $data['block_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/forum/block/'.$data['order'].'/';
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
			$this->load->view('admin/forum_block', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function block_add()
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
			$this->form_validation->set_rules('section_block', 'Block Order', 'required|xss_clean|numeric');
			$this->form_validation->set_rules('block_name', 'Block Name', 'required|xss_clean');
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/lists/groups_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/forum_block_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'section_block' => $this->input->post('section_block'),
					'block_name' => $this->input->post('block_name')
				);
				
				$this->db->insert('forum', $item);
				
				redirect('admin/forum/block');
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/forum_block_add', $data);
				$this->load->view('admin/footer');
			} 
		}
	}
	
	public function block_edit()
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
			$this->form_validation->set_rules('section_block', 'Block Order', 'required|xss_clean|numeric');
			$this->form_validation->set_rules('block_name', 'Block Name', 'required|xss_clean');
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$data['block'] = $this->db->get('forum');
			
			$this->db->where('id', $data['id']);
			$data['block_edit'] = $this->db->get('forum')->row();
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/lists/groups_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/forum_block_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'section_block' => $this->input->post('section_block'),
					'block_name' => $this->input->post('block_name')
				);
				
				$this->db->where('id', $data['id']);
				$this->db->update('forum', $item);
				
				//redirect('admin/forum/block/'.$data['id']);
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/forum_block_edit', $data);
				$this->load->view('admin/footer');
			} 
		}
	}
	
	public function block_delete()
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
			$this->db->delete('forum');
					
			redirect('admin/forum/block/', 'refresh');
		}
	}
	
	public function arcade()
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
			$data['arcade'] = $this->db->get('forum_arcade');
			
			$data['arcade_count'] = $this->db->get('forum_arcade');
			
			$number_results = $data['arcade_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/forum/arcade/'.$data['order'].'/';
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
			$this->load->view('admin/forum_arcade', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function arcade_add()
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
			$this->form_validation->set_rules('genre', 'Genre', 'required|xss_clean');
			$this->form_validation->set_rules('game', 'Game', 'xss_clean');
			
			$config['upload_path'] = './uploads/games/';
			$config['allowed_types'] = 'swf';
			$config['max_size'] = '10000';
			$config['overwrite'] = true;
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
				$this->load->view('admin/forum_arcade_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "game";
				$this->upload->do_upload($field_name);
				$game_data = $this->upload->data();
				$game_data = $game_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'genre' => $this->input->post('genre')
					);
					
					$this->db->insert('forum_arcade', $item);
					
					redirect('admin/forum/arcade/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/forum_arcade_add', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'genre' => $this->input->post('genre')
					);

					if(isset($game_data)) {
						$this->upload->do_upload();
						$item['game'] = $game_data;
					}
					
					$this->db->insert('forum_arcade', $item);
					
					redirect('admin/forum/arcade/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/forum_arcade_add', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function arcade_edit()
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
			$data['arcade'] = $this->db->get('forum_arcade');
			
			$this->db->where('id', $data['id']);
			$data['arcade_edit'] = $this->db->get('forum_arcade')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('genre', 'Genre', 'required|xss_clean');
			$this->form_validation->set_rules('game', 'Game', 'xss_clean');
			
			$config['upload_path'] = './uploads/games/';
			$config['allowed_types'] = 'swf';
			$config['max_size'] = '10000';
			$config['overwrite'] = true;
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
				$this->load->view('admin/forum_arcade_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "game";
				$this->upload->do_upload($field_name);
				$game_data = $this->upload->data();
				$game_data = $game_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'genre' => $this->input->post('genre')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('forum_arcade', $item);
					
					//redirect('admin/dashboard/splash_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/forum_arcade_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'genre' => $this->input->post('genre')
					);

					if(isset($game_data)) {
						$this->upload->do_upload();
						$item['game'] = $game_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('forum_arcade', $item);
					
					//redirect('admin/dashboard/splash_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/forum_arcade_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
	
	public function arcade_delete()
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
			
			#$this->db->where('id', $data['id']);
			#$delete_media = $this->db->get('forum_arcade')->row();
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			#$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/games/'. $delete_media->game;

			# delete file if exists
			#if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
			
			$this->db->where('id', $data['id']);
			$this->db->delete('forum_arcade');
					
			redirect('admin/forum/arcade/', 'refresh');
		}
	}
	
	public function shoutbox()
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
			$data['forum_shoutbox'] = $this->db->get('forum_shoutbox');
			
			$data['forum_shoutbox_count'] = $this->db->get('forum_shoutbox');
			
			$number_results = $data['forum_shoutbox_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/forum/shoutbox/'.$data['order'].'/';
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
			$this->load->view('admin/forum_shoutbox', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function shoutbox_delete()
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
			$this->db->delete('forum_shoutbox');
					
			redirect('admin/forum/shoutbox/', 'refresh');
		}
	}
}

?>