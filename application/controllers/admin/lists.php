<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends CI_Controller {

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
			redirect('admin/lists/groups', 'refresh');
		}
	}
	
	public function groups()
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
			$data['list_groups'] = $this->db->get('list_groups');
			
			$data['list_groups_count'] = $this->db->get('list_groups');
			
			$number_results = $data['list_groups_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/lists/groups/'.$data['order'].'/';
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
			$this->load->view('admin/lists', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function groups_add()
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
			$this->form_validation->set_rules('list_title', 'List Title', 'required|xss_clean');
			$this->form_validation->set_rules('option_1_header', 'Header 1', 'required|xss_clean');
			$this->form_validation->set_rules('option_2_header', 'Header 2', 'xss_clean');
			
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
				$this->load->view('admin/list_groups_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'list_title' => $this->input->post('list_title'),
					'option_1_header' => $this->input->post('option_1_header'),
					'option_2_header' => $this->input->post('option_2_header')
					
				);
				
				$this->db->insert('list_groups', $item);
				
				redirect('admin/lists');
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_groups_add', $data);
				$this->load->view('admin/footer');
			} 
		}
	}
	
	public function groups_edit()
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
			$this->form_validation->set_rules('list_title', 'List Title', 'required|xss_clean');
			$this->form_validation->set_rules('option_1_header', 'Header 1', 'required|xss_clean');
			$this->form_validation->set_rules('option_2_header', 'Header 2', 'xss_clean');
			
			$data['id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['id']);
			$data['list_groups'] = $this->db->get('list_groups');
			
			$this->db->where('id', $data['id']);
			$data['list_groups_edit'] = $this->db->get('list_groups')->row();
			
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
				$this->load->view('admin/list_groups_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'list_title' => $this->input->post('list_title'),
					'option_1_header' => $this->input->post('option_1_header'),
					'option_2_header' => $this->input->post('option_2_header')
					
				);
				
				$this->db->where('id', $data['id']);
				$this->db->update('list_groups', $item);
				
				redirect('admin/lists/groups_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_groups_edit', $data);
				$this->load->view('admin/footer');
			} 
		}
	}
	
	public function groups_delete()
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
			$this->db->delete('list_groups');
			
			$this->db->where('group_id', $data['id']);
			$this->db->delete('lists');
			
				
			redirect('admin/lists/groups/', 'refresh');
		}
	}
	
	public function items()
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
			$data['group_id'] = $this->uri->segment(6);
			
			if($data['order'] != ""){
				$this->db->order_by($data['order'], 'desc');
			}else{
				$data['order'] = 'id';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->where('id', $data['group_id']);
			$data['list_group_titles'] = $this->db->get('list_groups')->row();
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$this->db->where('group_id', $data['group_id']);
			$data['list_items'] = $this->db->get('list_items');
			
			$this->db->where('group_id', $data['group_id']);
			$this->db->join('list_groups', 'list_groups.id = list_items.group_id');
			$data['list_items_edit'] = $this->db->get('list_items')->row();
			
			$this->db->where('group_id', $data['group_id']);
			$data['list_items_count'] = $this->db->get('list_items');
			
			$number_results = $data['list_items_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/lists/items/'.$data['order'].'/';
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
			$this->load->view('admin/list_items', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function items_add()
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
			
			$data['group_id'] = $this->uri->segment(4);
			
			$this->db->where('id', $data['group_id']);
			$data['list_group_titles'] = $this->db->get('list_groups')->row();
			
			$this->db->where('id',$data['group_id']);
			$data['list_groups'] = $this->db->get('list_groups');
			foreach($data['list_groups']->result() as $row){
				$group_name = $row->list_title;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('option_1', 'option_1', 'required|xss_clean');	
			$this->form_validation->set_rules('option_2', 'Option 2', 'required');	
			$this->form_validation->set_rules('link', 'Link', 'xss_clean');	
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/lists/items_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_items_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'group_id' => $data['group_id'],
					'option_1' => $this->input->post('option_1'),
					'option_2' => $this->input->post('option_2'),
					'link' => $this->input->post('link')
				);					
				$this->db->insert('list_items', $item);
				
				redirect('admin/lists/items/id/0/'.$data['group_id']);
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_items_add', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	
	public function items_edit()
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
			$data['group_id'] = $this->uri->segment(5);
			
			$this->db->where('id', $data['group_id']);
			$data['list_group_titles'] = $this->db->get('list_groups')->row();
			
			$this->db->where('id',$data['group_id']);
			$data['list_groups_current'] = $this->db->get('list_groups');
			foreach($data['list_groups_current']->result() as $row){
				$group_name = $row->group;
			}
			
			$data['list_groups'] = $this->db->get('list_groups');
			
			$this->db->where('id', $data['id']);
			$data['list_items'] = $this->db->get('list_items');
			
			$this->db->where('id', $data['id']);
			$data['list_items_edit'] = $this->db->get('list_items')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('option_1', 'option_1', 'required|xss_clean');	
			$this->form_validation->set_rules('option_2', 'Option 2', 'required');	
			$this->form_validation->set_rules('link', 'Link', 'xss_clean');	
			
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/lists/items_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_items_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$item = array(
					'group_id' => $data['group_id'],
					'option_1' => $this->input->post('option_1'),
					'option_2' => $this->input->post('option_2'),
					'link' => $this->input->post('link')
				);
				
				$this->db->where('id', $data['id']);
				$this->db->update('list_items', $item);
				
				redirect('admin/lists/items/id/0/'.$data['group_id']);
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted sucessfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/list_items_edit', $data);
				$this->load->view('admin/footer');
			}
		}
	}

	public function items_delete()
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
			$this->db->delete('list_items');
			
			redirect('admin/lists/items/', 'refresh');
		}
	}
	
}

?>