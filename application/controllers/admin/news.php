<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

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
			redirect('/admin/news/news_articles');
		}
		
	}
	
	public function news_articles()
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
			$data['news'] = $this->db->get('news');
			
			$data['news_count'] = $this->db->get('news');
			
			$number_results = $data['news_count']->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/news/news_articles/'.$data['order'].'/';
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
			$this->load->view('admin/news', $data);
			$this->load->view('admin/footer');
		}
	}
	
	public function news_edit()
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
			$data['news'] = $this->db->get('news');
			
			$this->db->where('id', $data['id']);
			$data['news_edit'] = $this->db->get('news')->row();
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'Title', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
			$this->form_validation->set_rules('video', 'Video', 'xss_clean');
			$this->form_validation->set_rules('image', 'Image', 'xss_clean');
			
			$config['upload_path'] = './uploads/news/';
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
				//redirect('admin/news/news_edit/'.$data['id']);
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/news_edit', $data);
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
						'video' => $this->input->post('video')
					);
					
					$this->db->where('id', $data['id']);
					$this->db->update('news', $item);
					
					redirect('admin/news/news_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted sucessfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/news_edit', $data);
					$this->load->view('admin/footer');
				} 
				else 
				{
					$item = array(
						'title' => $this->input->post('title'),
						'description' => $this->input->post('description'),
						'video' => $this->input->post('video')
					);

					if(isset($image_data)) {
						$this->upload->do_upload();
						$image_data = rename_resize_and_crop($this->upload->data(), array('width' => '480', 'height' => '360'));
						$item['image'] = $image_data;
					}
					
					$this->db->where('id', $data['id']);
					$this->db->update('news', $item);
					
					redirect('admin/news/news_edit/'.$data['id']);
					$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='green-left'>Editted successfully.</td>
											<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
					$this->load->view('admin/header', $data);
					$this->load->view('admin/news_edit', $data);
					$this->load->view('admin/footer');
				}
			}
		}
	}
}

?>