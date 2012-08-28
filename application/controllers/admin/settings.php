<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

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
			
			$data['id'] = '1';
			
			$this->db->where('id', $data['id']);
			$data['settings'] = $this->db->get('settings');
			
			$this->db->where('id', $data['id']);
			$data['settings_edit'] = $this->db->get('settings')->row();
			
			$this->db->where('id', '1');
			$data['terms_conditions_edit'] = $this->db->get('terms_conditions')->row();
			
			$this->load->library('form_validation');
			//tracking, metadata and business info
			$this->form_validation->set_rules('google_analytics', 'Google Analytics', 'htmlspecialchars_decode|prep_for_form');
			$this->form_validation->set_rules('keywords', 'Keywords (Meta)', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description (Meta)', 'required|xss_clean');
			$this->form_validation->set_rules('business_name', 'Business Name', 'required|xss_clean');
			$this->form_validation->set_rules('business_logo', 'Business Logo', 'xss_clean');
			$this->form_validation->set_rules('business_email', 'Business Email', 'required|xss_clean|valid_email');
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'xss_clean|valid_email');
			//styling and layout
			$this->form_validation->set_rules('layout_type', 'Layout Type', 'required|xss_clean|numeric');
			$this->form_validation->set_rules('background_image', 'Background Image', 'xss_clean');
			$this->form_validation->set_rules('background_repeat', 'Background Repeat', 'xss_clean');
			$this->form_validation->set_rules('background_position', 'Background Position', 'xss_clean');
			$this->form_validation->set_rules('container_image', 'Container Image', 'xss_clean');
			$this->form_validation->set_rules('container_repeat', 'Container Repeat', 'xss_clean');
			$this->form_validation->set_rules('container_position', 'Container Position', 'xss_clean');
			$this->form_validation->set_rules('container_color_1', 'Container Color 1', 'xss_clean');
			$this->form_validation->set_rules('container_color_2', 'Container Color 2', 'xss_clean');
			$this->form_validation->set_rules('container_color_3', 'Container Color 3', 'xss_clean');
			$this->form_validation->set_rules('color_1', 'Container Color 1', 'required|xss_clean');
			$this->form_validation->set_rules('color_2', 'Container Color 2', 'xss_clean');
			$this->form_validation->set_rules('color_3', 'Background Color 3', 'xss_clean');
			$this->form_validation->set_rules('all_text_color', 'All Text Color', 'xss_clean');
			$this->form_validation->set_rules('all_text_size', 'All Text Size', 'xss_clean|numeric|less_than[18]');
			$this->form_validation->set_rules('all_text_type', 'All Text Type', 'xss_clean');
			$this->form_validation->set_rules('header_color', 'Header Color', 'xss_clean');
			$this->form_validation->set_rules('header_size', 'Header Size', 'xss_clean|numeric|less_than[30]');
			$this->form_validation->set_rules('link_size', 'Link Size', 'xss_clean|numeric|less_than[18]');
			$this->form_validation->set_rules('link_normal_visited_color', 'Link (Normal, Visited) Color', 'xss_clean');
			$this->form_validation->set_rules('link_hover_active_color', 'Link (Hover, Active) Color', 'xss_clean');
			$this->form_validation->set_rules('border_color', 'Border Color', 'xss_clean');
			$this->form_validation->set_rules('border_style', 'Border Style', 'xss_clean');
			$this->form_validation->set_rules('border_size', 'Border Size', 'xss_clean|numeric|less_than[18]');
			$this->form_validation->set_rules('corner_radius', 'corner Radius', 'xss_clean|numeric|less_than[30]');
			$this->form_validation->set_rules('splash_overlay_image', 'Splash Overlay Image (Homepage)', 'xss_clean');
			//social networks
			$this->form_validation->set_rules('facebook', 'Facebook', 'required|xss_clean');
			$this->form_validation->set_rules('fb_color_scheme', 'Facebook Color Scheme', 'required|xss_clean');
			$this->form_validation->set_rules('twitter', 'Twitter', 'required|xss_clean');
			//terms and conditions
			$this->form_validation->set_rules('title2', 'Title (Terms & Conditions)', 'required|xss_clean');
			$this->form_validation->set_rules('description2', 'Description  (Terms & Conditions)', 'required|xss_clean');
			
			$this->load->library('upload');
			
			$data['alert_msg'] = "";
				
			if ($this->form_validation->run() == FALSE)
			{	
				if (validation_errors() != ""){
				//redirect('admin/settings');
				$data['alert_msg'] = "<div id='message-red'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
										<tr>
											<td class='red-left'>Error. ".validation_errors()."<a href='".$_SERVER['HTTP_REFERER']."'>Please try again.</a></td>
											<td class='red-right'><a class='close-red'><img src='".base_url()."assets/admin/images/table/icon_close_red.gif'   alt='' /></a></td>
										</tr>
										</table>
										</div>";
				}
				$this->load->view('admin/header', $data);
				$this->load->view('admin/settings', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$items = array(
					'google_analytics' => $this->input->post('google_analytics'),
					'keywords' => $this->input->post('keywords'),
					'description' => $this->input->post('description'),
					'business_name' => $this->input->post('business_name'),
					'business_email' => $this->input->post('business_email'),
					'paypal_email' => $this->input->post('paypal_email'),
					'layout_type' => $this->input->post('layout_type'),
					'background_repeat' => $this->input->post('background_repeat'),
					'background_position' => $this->input->post('background_position'),
					'container_repeat' => $this->input->post('container_repeat'),
					'container_position' => $this->input->post('container_position'),
					'container_color_1' => '#'.$this->input->post('container_color_1'),
					'container_color_2' => '#'.$this->input->post('container_color_2'),
					'container_color_3' => '#'.$this->input->post('container_color_3'),
					'color_1' => '#'.$this->input->post('color_1'),
					'color_2' => '#'.$this->input->post('color_2'),
					'color_3' => '#'.$this->input->post('color_3'),
					'all_text_color' => '#'.$this->input->post('all_text_color'),
					'all_text_size' => $this->input->post('all_text_size'),
					'all_text_type' => $this->input->post('all_text_type'),
					'header_color' => '#'.$this->input->post('header_color'),
					'header_size' => $this->input->post('header_size'),
					'link_size' => $this->input->post('link_size'),
					'link_normal_visited_color' => '#'.$this->input->post('link_normal_visited_color'),
					'link_hover_active_color' => '#'.$this->input->post('link_hover_active_color'),
					'border_color' => '#'.$this->input->post('border_color'),
					'border_style' => $this->input->post('border_style'),
					'border_size' => $this->input->post('border_size'),
					'corner_radius' => $this->input->post('corner_radius'),
					'facebook' => $this->input->post('facebook'),
					'fb_color_scheme' => $this->input->post('fb_color_scheme'),
					'twitter' => $this->input->post('twitter')
				);
				
					if(!empty($_FILES['business_logo']['name'])) 
					{
						$config['upload_path'] = './assets/images/';
						$config['allowed_types'] = 'png';
						$config['max_size'] = '10000';
						$config['max_width'] = '600';
						$config['max_height'] = '600';
						$config['file_name'] = 'logo.png';
						$config['overwrite'] = TRUE;
						$this->upload->initialize($config);
						//$this->load->library('upload', $config);
						
						$this->upload->do_upload('business_logo');
						$image_data = $this->upload->data();
						$image_data = $image_data['file_name'];
						$items['business_logo'] = $image_data;
						
					} 
					
					if(!empty($_FILES['background_image']['name'])) 
					{
						$config2['upload_path'] = './assets/images/';
						$config2['allowed_types'] = 'png';
						$config2['max_size'] = '10000';
						$config2['max_width'] = '1500';
						$config2['max_height'] = '1000';
						$config2['file_name'] = 'background.png';
						$config2['overwrite'] = TRUE;
						$this->upload->initialize($config2);
						//$this->load->library('upload', $config2);
						
						$this->upload->do_upload('background_image');
						$image_data2 = $this->upload->data();
						$image_data2 = $image_data2['file_name'];
						$items['background_image'] = $image_data2;
					} 
					
					if(!empty($_FILES['container_image']['name'])) 
					{
						$config3['upload_path'] = './assets/images/';
						$config3['allowed_types'] = 'png';
						$config3['max_size'] = '10000';
						$config3['max_width'] = '400';
						$config3['max_height'] = '100';
						$config3['file_name'] = 'content.png';
						$config3['overwrite'] = TRUE;
						$this->upload->initialize($config3);
						//$this->load->library('upload', $config3);
						
						$this->upload->do_upload('container_image');
						$image_data3 = $this->upload->data();
						$image_data3 = $image_data3['file_name'];
						$items['container_image'] = $image_data3;
					} 
					
					if(!empty($_FILES['splash_overlay_image']['name'])) 
					{
						$config4['upload_path'] = './assets/images/';
						$config4['allowed_types'] = 'png';
						$config4['max_size'] = '10000';
						$config4['min_width'] = '900';
						$config4['min_height'] = '390';
						$config4['max_width'] = '900';
						$config4['max_height'] = '390';
						$config4['file_name'] = 'nivo_shine.png';
						$config4['overwrite'] = TRUE;
						$this->upload->initialize($config4);
						//$this->load->library('upload', $config4);
						
						$this->upload->do_upload('splash_overlay_image');
						$image_data4 = $this->upload->data();
						$image_data4 = $image_data4['file_name'];
						$items['splash_overlay_image'] = $image_data4;
					} 
				
				$this->db->where('id', $data['id']);
				$this->db->update('settings', $items);
				
				
				$terms_conditions = array(
					'title' => $this->input->post('title2'),
					'description' => $this->input->post('description2')
				);
				
				$this->db->where('id', '1');
				$this->db->update('terms_conditions', $terms_conditions);
				
				
				redirect('admin/settings');
				$data['alert_msg'] = "<div id='message-green'><table border='0' width='100%' cellpadding='0' cellspacing='0'>
									<tr>
										<td class='green-left'>Editted successfully.</td>
										<td class='green-right'><a class='close-green'><img src='".base_url()."assets/admin/images/table/icon_close_green.gif'   alt='' /></a></td>
									</tr>
									</table>
									</div>";
				$this->load->view('admin/header', $data);
				$this->load->view('admin/settings', $data);
				$this->load->view('admin/footer');
			}
		}
	}
	
	public function delete_image()
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
			
			$data['image'] = $this->uri->segment(4);
			
			#complete serverpath must be given like 
			#example "/apache/htdocs/myfile.pdf" ( not "http:xyz.com/myfile.pdf" )
			$DelFilePath = $_SERVER['DOCUMENT_ROOT'].'/assets/images/'. $data['image'].'.png';

			# delete file if exists
			if (file_exists($DelFilePath)) { unlink ($DelFilePath); }
					
			redirect('admin/settings', 'refresh');
		}
	}
	
}

?>