<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

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
	
	$this->db->where('module_name', 'schedule');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			$data['user_id']	= "";
			$data['username']	= "";
			$data['role_id']	= "";
			
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$data['schedule'] = $this->db->get('jqcalendar');
			
			$this->load->view('header', $data);
			$this->load->view('schedule', $data);
			$this->load->view('footer');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$data['schedule'] = $this->db->get('jqcalendar');
			
			$this->load->view('header', $data);
			$this->load->view('schedule', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function day_time()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'schedule');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			$data['user_id']	= "";
			$data['username']	= "";
			$data['role_id']	= "";
			
			$data['date'] = $this->uri->segment(3);
			
			$this->db->order_by('StartTime', 'asc');
			$this->db->like('StartTime',$data['date']);
			$data['schedule_events'] = $this->db->get('jqcalendar');
			
			$this->load->view('header', $data);
			$this->load->view('schedule_day_time', $data);
			$this->load->view('footer');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['date'] = $this->uri->segment(3);
			
			$this->db->order_by('StartTime', 'asc');
			$this->db->like('StartTime',$data['date']);
			$data['schedule_events'] = $this->db->get('jqcalendar');
			//echo $this->db->last_query();
			
			$this->load->view('header', $data);
			$this->load->view('schedule_day_time', $data);
			$this->load->view('footer');
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
	public function event()
	{
	$this->db->where('module_name', 'home');
	$data['module_home'] = $this->db->get('modules')->row();
	
	if($data['module_home']->status != '0') {
	
	$this->db->where('module_name', 'schedule');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			$data['user_id']	= "";
			$data['username']	= "";
			$data['role_id']	= "";
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->where('id',$data['id']);
			$this->db->limit(1);
			$data['schedule_event'] = $this->db->get('jqcalendar');
			
			$this->load->view('schedule_event', $data);

		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['role_id']	= $this->tank_auth->get_role();
			
			$data['id'] = $this->uri->segment(3);
			
			$this->db->where('id',$data['id']);
			$this->db->limit(1);
			$data['schedule_event'] = $this->db->get('jqcalendar');
			
			$this->load->view('schedule_event', $data);
		}
	}else{redirect('');}
	}else{redirect('');}
	}
	
}

?>