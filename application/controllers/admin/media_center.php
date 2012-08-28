<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_center extends CI_Controller {

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
			redirect('/admin/media_center/media', 'refresh');
		}
	}
	
	public function media()
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
			$data['media'] = $this->db->get('media');
			
			$data['media_count'] = $this->db->get('media');
			
			$number_results = $data['media_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/media_center/media/'.$data['order'].'/';
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
			$this->load->view('admin/media_center', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function media_add()
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
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('media', 'Media', 'xss_clean');
			$this->form_validation->set_rules('video', 'Video', 'xss_clean');
			
			$config['upload_path'] = './uploads/media/';
			$config['allowed_types'] = 'gif|jpg|png|mp3';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$config['max_size'] = '10000';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
						
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				redirect('admin/media_center/media_add/');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/media_center_add', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "media";
				$this->upload->do_upload($field_name);
				$media_data = $this->upload->data();
				$media_data = $media_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'video' => $this->input->post('video'),
						'user_id' => $data['user_id'],
						'username' => $data['username']
					);
					
					$this->db->insert('media', $item);
					
					redirect('admin/media_center/media/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/media_center_add', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'video' => $this->input->post('video'),
						'user_id' => $data['user_id'],
						'username' => $data['username']
					);
					
					if(isset($media_data)) {
						if(strstr($media_data, '.mp3', true)) {
							$this->upload->do_upload();
							$item['audio'] = $media_data;
						}
						
						if((strstr($media_data, '.jpg', true))||(strstr($media_data, '.jpeg', true))||(strstr($media_data, '.png', true))||(strstr($media_data, '.gif', true))) {
							$this->upload->do_upload();
							$media_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
							$item['image'] = $media_data;
						}
					}
					
					$this->db->insert('media', $item);
					
					redirect('admin/media_center/media/');
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/media_center_add', $data);
					$this->load->view('admin/footer');
				}	
			}
		}
	}
	
	public function media_edit()
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
			$data['media'] = $this->db->get('media');
			
			$this->db->where('id', $data['id']);
			$data['media_edit'] = $this->db->get('media')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('media', 'Media', 'xss_clean');
			$this->form_validation->set_rules('video', 'Video', 'xss_clean');
			
			$config['upload_path'] = './uploads/media/';
			$config['allowed_types'] = 'gif|jpg|png|mp3';
			$config['min_width'] = '900';
			$config['min_height'] = '900';
			$config['max_width'] = '1500';
			$config['max_height'] = '1500';
			$config['max_size'] = '10000';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
						
			$data['alert_msg'] = "";
			
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				redirect('admin/media_center/media_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/media_center_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$field_name = "media";
				$this->upload->do_upload($field_name);
				$media_data = $this->upload->data();
				$media_data = $media_data['file_name'];
				//var_dump(is_dir('./uploads/slides/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'video' => $this->input->post('video'),
						'user_id' => $data['user_id'],
						'username' => $data['username']
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('media', $item);
					
					redirect('admin/media_center/media_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/media_center_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$this->db->where('id', $data['id']);
					$delete_media = $this->db->get('media')->row();
					
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'video' => $this->input->post('video'),
						'user_id' => $data['user_id'],
						'username' => $data['username']
					);
					
					if(isset($media_data)) {
						if(strstr($media_data, '.mp3', true)) {
							$DelFilePath2 = $_SERVER['DOCUMENT_ROOT'].'/uploads/media/'. $delete_media->audio;

							if (file_exists($DelFilePath2)) { unlink ($DelFilePath2); }
						
							$this->upload->do_upload();
							$item['audio'] = $media_data;
						}
						
						if((strstr($media_data, '.jpg', true))||(strstr($media_data, '.jpeg', true))||(strstr($media_data, '.png', true))||(strstr($media_data, '.gif', true))) {
							$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/media/'. $delete_media->image;
							
							if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
					
							$this->upload->do_upload();
							$media_data = rename_resize_and_crop($this->upload->data(), array('width' => '900', 'height' => '900'));
							$item['image'] = $media_data;
						}
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('media', $item);
					
					redirect('admin/media_center/media_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/media_center_edit', $data);
					$this->load->view('admin/footer');
				}	
			}
		}
	}
	
	public function media_delete()
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
			$delete_media = $this->db->get('media')->row();
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/media/'. $delete_media->image;
			$DelFilePath2 = $_SERVER['DOCUMENT_ROOT'].'/uploads/media/'. $delete_media->audio;

			# delete file if exists
			if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
			if (file_exists($DelFilePath2)) { unlink ($DelFilePath2); }
			
			$this->db->where('id', $data['id']);
			$this->db->delete('media');
					
			redirect('admin/media_center/media/', 'refresh');
		}
	}
	
}

?>