<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advert extends CI_Controller {

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
	
	$this->db->where('module_name', 'advert');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '0') {
		if (!$this->tank_auth->is_logged_in()) {
			
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$data['advert'] = $this->db->get('advert');
			
			foreach($data['advert']->result() as $row){
				$advert_link = $row->advert_link;
			}
			redirect($advert_link);
		} else {
						
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$data['advert'] = $this->db->get('advert');
			
			foreach($data['advert']->result() as $row){
				$advert_link = $row->advert_link;
			}
			redirect($advert_link);
		}
	}else{redirect('');}
	}else{redirect('');}
	}
}

?>