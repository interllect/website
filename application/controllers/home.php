<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('email','session','tank_auth'));
		$this->load->helper(array('url','form', 'profile'));
	}
	
	public function index()
	{
		$this->db->where('module_name', 'home');
		$data['modules'] = $this->db->get('modules')->row();
	
		if($data['modules']->status != '0') {
	
			if (!$this->tank_auth->is_logged_in()) {
				$data['user_id']	= "";
				$data['username']	= "";
				$data['role_id']	= "";
				
				//splash
				$data['splash'] = $this->db->get('splash');
				
				//about
				$this->db->order_by('id','desc');
				$this->db->limit(1);
				$data['about'] = $this->db->get('about');
				
				//forum
				$this->db->order_by('id', 'desc');
				$this->db->limit(3);
				$data['forum_threads'] = $this->db->get('forum_threads');
				
				//media
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('audio !=', '');
				$data['audio'] = $this->db->get('media');
				
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('image !=', '');
				$data['image'] = $this->db->get('media');
				
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('video !=', '');
				$data['video'] = $this->db->get('media');
				
				//shop
				$this->db->limit(8);
				$this->db->order_by('id', 'desc');
				$data['shop_products'] = $this->db->get('shop_products');
				
				//news
				$this->db->limit(1);
				$data['news'] = $this->db->get('news');
				
				//blogs
				$this->db->order_by('id', 'desc');
				$this->db->limit(3);
				$data['blogs'] = $this->db->get('blogs');
				
				$this->load->view('header', $data);
				$this->load->view('index', $data);
				$this->load->view('footer');
			} else {
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();
				$data['role_id']	= $this->tank_auth->get_role();
				
				//splash
				$data['splash'] = $this->db->get('splash');
				
				//about
				$this->db->order_by('id','desc');
				$this->db->limit(1);
				$data['about'] = $this->db->get('about');
				
				//forum
				$this->db->order_by('id', 'desc');
				$this->db->limit(3);
				$data['forum_threads'] = $this->db->get('forum_threads');
				
				//media
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('audio !=', '');
				$data['audio'] = $this->db->get('media');
				
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('image !=', '');
				$data['image'] = $this->db->get('media');
				
				$this->db->limit(3);
				$this->db->order_by('id', 'desc');
				$this->db->where('video !=', '');
				$data['video'] = $this->db->get('media');
				
				//shop
				$this->db->limit(8);
				$this->db->order_by('id', 'desc');
				$data['shop_products'] = $this->db->get('shop_products');
				
				//news
				$this->db->limit(1);
				$data['news'] = $this->db->get('news');
				
				//blogs
				$this->db->order_by('id', 'desc');
				$this->db->limit(3);
				$data['blogs'] = $this->db->get('blogs');
				
				$this->load->view('header', $data);
				$this->load->view('index', $data);
				$this->load->view('footer');
			}
		}else{redirect('home/holding_page');}
	}
	
	public function holding_page()
	{
	$this->db->where('module_name', 'home');
	$data['modules'] = $this->db->get('modules')->row();
	
	if($data['modules']->status != '1') {	
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['role_id']	= $this->tank_auth->get_role();
		$this->load->view('holding_page', $data);
	}else{redirect('');}
	}
}
?>