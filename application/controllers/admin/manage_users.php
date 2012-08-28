<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_users extends CI_Controller {

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
			redirect('/admin/manage_users/user_list', 'refresh');
		}
	}
	
	public function user_list()
	{		
	$data['role']	= $this->tank_auth->get_role();
	$role = $data['role'];
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/admin/login/');
		}
		elseif(($this->tank_auth->is_logged_in())&&($role >= '2')){
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
				$data['order'] = 'user_id';
				$this->db->order_by($data['order'], 'desc');
			}
			
			$this->db->limit($number_rows_per_page,$limits['offset']);
			$this->db->join('user_profiles', 'user_profiles.user_id = users.id');
			$data['users'] = $this->db->get('users');
			
			$this->db->where('role_id', '0');
			$data['super_users'] = $this->db->get('users');
			
			$data['users_count'] = $this->db->get('users');
			
			$number_results = $data['users_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_users/user_list/'.$data['order'].'/';
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
			$this->load->view('admin/manage_users', $data);
			$this->load->view('admin/footer');
		}
		
	}
	
	public function user_edit()
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
			$data['users'] = $this->db->get('users');
			
			$this->db->where('user_id', $data['id']);
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$this->db->where('id', $data['id']);
			$data['users_edit'] = $this->db->get('users')->row();
			
			$this->db->where('user_id', $data['id']);
			$data['user_profiles_edit'] = $this->db->get('user_profiles')->row();
			
			if ($data['users_edit']->role_id >= $data['role_id']) {
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('role_id', 'Role', 'required|xss_clean');
				$this->form_validation->set_rules('username', 'Title', 'required|xss_clean');
				$this->form_validation->set_rules('email', 'Description', 'required|xss_clean|valid_email');
				$this->form_validation->set_rules('image', 'Image', 'xss_clean');
				$this->form_validation->set_rules('country', 'Country', 'xss_clean');
				$this->form_validation->set_rules('website', 'Website', 'xss_clean');
				$this->form_validation->set_rules('country', 'Country', 'xss_clean');
				$this->form_validation->set_rules('bio', 'Bio', 'xss_clean');
				$this->form_validation->set_rules('signature', 'Signature', 'xss_clean');
				$this->form_validation->set_rules('facebook', 'Facebook', 'xss_clean');
				$this->form_validation->set_rules('twitter', 'Twitter', 'xss_clean');
				
				$config['upload_path'] = './uploads/user_profiles/avatars/';
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
					redirect('admin/manage_users/user_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
											<tr>
												<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
												<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
											</tr>
											</table>
											</div>";
					}
					$this->load->view('admin/header', $data);
					$this->load->view('admin/manage_user_edit', $data);
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
						$user = array(
							'role_id' => $this->input->post('role_id'),
							'username' => $this->input->post('username'),
							'email' => $this->input->post('email')
						);
						
						$this->db->where('id', $data['id']);
						$this->db->update('users', $user);
						
						$profile = array(
							'country' => $this->input->post('country'),
							'website' => $this->input->post('website'),
							'bio' => $this->input->post('bio'),
							'signature' => $this->input->post('signature'),
							'facebook' => $this->input->post('facebook'),
							'twitter' => $this->input->post('twitter')
						);
						
						$this->db->where('user_id', $data['id']);
						$this->db->update('user_profiles', $profile);
						
						redirect('admin/manage_users/user_edit/'.$data['id']);
						$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
											<tr>
												<td class='green-left'>Editted sucessfully.</td>
												<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
											</tr>
											</table>
											</div>";
						$this->load->view('admin/header', $data);
						$this->load->view('admin/manage_user_edit', $data);
						$this->load->view('admin/footer');
					} 
					else 
					{
						$this->db->where('id', $data['id']);
						$delete_media = $this->db->get('user_profiles')->row();
						
						#complete serverpath must be given like 
						#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
						$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/user_profiles/avatars/'. $delete_media->image;

						# delete file if exists
						if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
					
						$user = array(
							'role_id' => $this->input->post('role_id'),
							'username' => $this->input->post('username'),
							'email' => $this->input->post('email')
						);
						
						$this->db->where('id', $data['id']);
						$this->db->update('users', $user);
						
						$profile = array(
							'country' => $this->input->post('country'),
							'website' => $this->input->post('website'),
							'bio' => $this->input->post('bio'),
							'signature' => $this->input->post('signature'),
							'facebook' => $this->input->post('facebook'),
							'twitter' => $this->input->post('twitter')
						);
						
						if(isset($image_data)) {
							$this->upload->do_upload();
							$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
							$profile['image'] = $image_data;
						}
						
						$this->db->where('user_id', $data['id']);
						$this->db->update('user_profiles', $profile);
						
						redirect('admin/manage_users/user_edit/'.$data['id']);
						$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
											<tr>
												<td class='green-left'>Editted successfully.</td>
												<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
											</tr>
											</table>
											</div>";
						$this->load->view('admin/header', $data);
						$this->load->view('admin/manage_user_edit', $data);
						$this->load->view('admin/footer');
					}
				}
			}else{redirect('admin/manage_users/user_list/', 'refresh');}
		}
	}
	
	public function user_delete()
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
			$data['users_edit'] = $this->db->get('users')->row();
		
			if ($data['users_edit']->role_id >= $data['role_id']) {
			
				$this->db->where('id', $data['id']);
				$delete_media = $this->db->get('user_profiles')->row();
				
				#complete serverpath must be given like 
				#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
				$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/user_profiles/avatars/'. $delete_media->image;

				# delete file if exists
				if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
				
				$this->db->where('id', $data['id']);
				$this->db->delete('users');
					
				$this->db->where('user_id', $data['id']);
				$this->db->delete('user_profiles');
			}		
			
			redirect('admin/manage_users/user_list/', 'refresh');
		}
	}
	
	public function user_toggle()
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
			$data['users'] = $this->db->get('users');
			
			foreach ($data['users']->result() as $row)
			{
				$activated =  $row->activated;
				$banned =  $row->banned;
			}
			
			if(($activated == "0")||($banned == "1")){
				$item = array(
						'activated' => "1",
						'banned' => "0"
				);
				$this->db->where('id', $data['id']);
				$this->db->update('users', $item);
			}elseif(($activated == "1")||($banned == "0")){
				$item = array(
						'activated' => "0",
						'banned' => "1"
				);
				$this->db->where('id', $data['id']);
				$this->db->update('users', $item);
			}
			
			redirect('/admin/manage_users/user_list/');
		}
	}
	
	public function email_all()
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
			
			$this->db->where('email !=', '');	
			$data['users'] = $this->db->get('users');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean');
			$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
		
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{
				if (validation_errors() != ""){
				//redirect('admin/manage_users/email_all/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/manage_user_email_all', $data);
				$this->load->view('admin/footer');	
			}
			else
			{
				$this->db->where('id', '1');
				$settings = $this->db->get('settings')->row();
	
				foreach($data['users']->result() as $row){
					$this->email->clear();
					$this->email->from($settings->business_email, $settings->business_name);
					$this->email->to($row->email);

					$this->email->subject($this->input->post('subject'));
					$this->email->message($this->input->post('message'));	

					$this->email->send();

					echo $this->email->print_debugger();
				}
				//redirect('admin/manage_users/email_all/');
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Message was sent successfully to all users.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/manage_user_email_all', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	
	public function session_clear()
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
			$this->db->truncate('ci_sessions'); 
			redirect('/admin/settings');
		}
	}
	
	public function autologin_clear()
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
			$this->db->truncate('user_autologin'); 
			redirect('/admin/settings');
		}
	}
}

?>