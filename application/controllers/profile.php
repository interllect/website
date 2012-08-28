<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('email','session','tank_auth','form_validation'));
		$this->load->helper(array('url','form', 'profile'));
	}
	
	public function index()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'profile');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			redirect('profile/view/');
		}
	}else{redirect('');}
	}
	}
	
	public function view()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'profile');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['profile_id'] = $this->uri->segment(3);
			
			$this->db->where('id',$data['profile_id']);
			$data['users'] = $this->db->get('users');
			
			$this->db->where('user_id',$data['profile_id']);
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$this->db->where('user_id',$data['profile_id']);
			$data['profile'] = $this->db->get('user_profiles')->row();
			
			$data['alert_msg'] = "";
		
			$this->load->view('header', $data);
			$this->load->view('profile', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}
	}
	
	public function update_info()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'profile');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else 
		{
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['profile_id'] = $this->uri->segment(3);
			
			$this->db->where('id',$data['user_id']);
			$data['users'] = $this->db->get('users');
			
			$this->db->where('user_id',$data['user_id']);
			$data['user_profiles'] = $this->db->get('user_profiles');
			
			$this->db->where('user_id',$data['profile_id']);
			$data['profile'] = $this->db->get('user_profiles')->row();
			
			$this->form_validation->set_rules('image', 'Avatar', 'xss_clean');
			$this->form_validation->set_rules('country', 'Country', 'required|xss_clean');
			$this->form_validation->set_rules('website', 'Website', 'xss_clean');
			$this->form_validation->set_rules('bio', 'Bio', 'xss_clean');
			$this->form_validation->set_rules('signature', 'Signature', 'xss_clean');
			$this->form_validation->set_rules('facebook', 'Facebook', 'xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'xss_clean');
			
			$config['upload_path'] = './uploads/user_profiles/avatars/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '10000';
			$config['max_width'] = '900';
			$config['max_height'] = '900';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$data['alert_msg'] = "There was an error while changing your information:".validation_errors();
				$this->load->view('header', $data);
				$this->load->view('profile', $data);
				$this->load->view('footer');
			}
			else
			{
				$field_name = "image";
				$this->upload->do_upload($field_name);
				$image_data = $this->upload->data();
				$image_data = $image_data['file_name'];
				//var_dump(is_dir('./uploads/user_profiles/avatars/')); //test directory validity
				
				$errs = $this->upload->display_errors();
				if(!$this->upload->do_upload($field_name)) 
				{
					$item = array(
						'country' => $this->input->post('country'),
						'website' => $this->input->post('website'),
						'bio' => $this->input->post('bio'),
						'signature' => $this->input->post('signature'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter')
					);
					
					$this->db->where('user_id', $data['user_id']);
					$this->db->update('user_profiles', $item);
				
					$data['alert_msg'] = "Info has been changed successfully";
					$this->load->view('header', $data);
					$this->load->view('profile', $data);
					$this->load->view('footer');
					redirect('profile');
				} 
				else 
				{
					$item = array(
						'country' => $this->input->post('country'),
						'website' => $this->input->post('website'),
						'bio' => $this->input->post('bio'),
						'signature' => $this->input->post('signature'),
						'facebook' => $this->input->post('facebook'),
						'twitter' => $this->input->post('twitter')
					);

					if(isset($image_data)) {
						$item['image'] = $image_data;
					}
					
					$this->db->where('user_id', $data['user_id']);
					$this->db->update('user_profiles', $item);
				
					$data['alert_msg'] = "Info has been changed successfully";
					$this->load->view('header', $data);
					$this->load->view('profile', $data);
					$this->load->view('footer');
					redirect('profile');
				}
			}
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>