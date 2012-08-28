<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_age_from_dob($dob) {		
	
    list($y,$m,$d) = explode('-', $dob);
   
    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }
   
    return date('Y') - $y;

}  

function arrange_dob($dob) {
	list($y,$m,$d) = explode('-', $dob);
	return $d . "-" . $m . "-" . $y;
}

function rarrange_dob($dob) {
	list($d,$m,$y) = explode('-', $dob);
	return $y . "-" . $m . "-" . $d;
}

function get_time_since_post($timestamp){
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	
	for($j = 0; $difference >= $lengths[$j]; $j++)
	   $difference /= $lengths[$j];
	   $difference = round($difference);
	
	if($difference != 1) $periods[$j].= "s";
		$text = "$difference $periods[$j] ago";
   
	return $text;
}


function get_last_active($date) {

	list($y,$m,$d) = explode('-', $date);
	$d = substr($d, 0, 2);
	$date1 = time();
	
	$date2 = mktime(0,0,0,$m,$d,$y);
	$dateDiff = $date1 - $date2;
	$fullDays = floor($dateDiff/(60*60*24));
	$fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));
	$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);

	return "$fullDays day(s), $fullHours hour(s) and $fullMinutes minute(s)"; 

}

function get_user_profile_pic($user_id) {
	// Set up the CI instance so site instance can be called
    $ci =& get_instance();

	$ci->load->model('Photo_model');
	$ci->load->model('User_model');

	$profile = $ci->User_model->get_user_profile_details($user_id);
	
	if(isset($profile->profile_pic_id)):
		
		if($profile->profile_pic_id != 0) $picture = $ci->Photo_model->get_photo_from_id($profile->profile_pic_id);
		if(isset($picture->filename)):
			return $picture->filename; 
		else:
			return '';
		endif;
	else:
		return '';
	endif;
	
}

function does_user_have_custom_theme($user_id) {
	// Set up the CI instance so site instance can be called
    $ci =& get_instance();

	$ci->db->where('user_id', $user_id);
	$query = $ci->db->get('users_profile_themes');
	
	if($query->num_rows() > 0):
		$row = $query->row();
		return $row->user_id;
	else:
		return 0;
	endif;	
}

function get_users_theme_id($user_id) {
	// Set up the CI instance so site instance can be called
    $ci =& get_instance();

	$ci->db->where('user_id', $user_id);
	$query = $ci->db->get('users_profiles');
	
	if($query->num_rows() > 0):
		$row = $query->row();
		return $row->profile_theme;
	else:
		return 0;
	endif;	
}

function string_limit_chars($string, $char_limit) {

	if (strlen($string) > $char_limit) {
		 $words = substr($string, 0, $char_limit) . "...";
		 return $words;
	}
	else { return $string; }
}

function get_profile_pic_from_id($id, $dimensions = array('width' => 300, 'height' => 300), $attributes = "") 
{

	$ci =& get_instance();
	
	$ci->load->model('Photo_model');
	$ci->load->model('User_model');

	$profile = $ci->User_model->get_user_profile_details($id);
	
	if(isset($profile->profile_pic_id)){
		
		if($profile->profile_pic_id != 0) $picture = $ci->Photo_model->get_photo_from_id($profile->profile_pic_id);
		
		if(isset($picture->filename)) {
		
			// Build the image
			$img_string  = '<img src="';
				$url_string = '/assets/thumb/phpThumb.php?src='; 
				$url_string .= $picture->filename; 
				$url_string .= '&amp;w='.$dimensions['width'].'&amp;h='.$dimensions['height'];
				$url_string .= '&amp;zc=1&amp;q=100';
			$img_string .= str_replace('index.php', '', base_url()) . $url_string;
			$img_string .= '" width="'.$dimensions['width'].'" height="'.$dimensions['height'].'"';
			$img_string .= ' title="';
			if(isset($profile->first_name)) $img_string .= ucfirst($profile->first_name);
			$img_string .= ' ';
			if(isset($profile->last_name)) $img_string .= ucfirst($profile->last_name);
			$img_string .= '"';
			if($attributes!="") $img_string .= " " . $attributes . " ";
			$img_string .= ' />';
		}
		else {
			// Build default profile picture
			$img_string = '<img src="/assets/thumb/phpThumb.php?src=/assets/images/presenter-no-pic.jpg';
			$img_string .= '&amp;w='.$dimensions['width'].'&amp;h='.$dimensions['height'];
			$img_string .= '&amp;zc=1" ';
			$img_string .= 'width="'.$dimensions['width'].'" height="'.$dimensions['height'].'"';
			$img_string .= ' title="';
			if(isset($profile->first_name)) $img_string .= ucfirst($profile->first_name);
			$img_string .= ' ';
			if(isset($profile->last_name)) $img_string .= ucfirst($profile->last_name);
			$img_string .= '"';
			if($attributes!="") $img_string .= " " . $attributes . " ";
			$img_string .= ' />';
		}
		
	}
	else {
		// Build default profile picture
		$img_string = '<img src="/assets/thumb/phpThumb.php?src=/assets/images/presenter-no-pic.jpg';
		$img_string .= '&amp;w='.$dimensions['width'].'&amp;h='.$dimensions['height'];
		$img_string .= '&amp;zc=1" ';
		$img_string .= 'width="'.$dimensions['width'].'" height="'.$dimensions['height'].'"';
		$img_string .= ' title="';
		if(isset($profile->first_name)) $img_string .= ucfirst($profile->first_name);
		$img_string .= ' ';
		if(isset($profile->last_name)) $img_string .= ucfirst($profile->last_name);
		$img_string .= '"';
		if($attributes!="") $img_string .= " " . $attributes . " ";
		$img_string .= ' />';
	}
	
	return $img_string;
}

function load_profile_friends($user_id)
{		
    $ci =& get_instance();
	$ci->load->model('User_model');
	$data['user_id'] = $user_id;
    $data['friends'] = $ci->User_model->get_users_friends($user_id,NULL,TRUE);

    $ci->load->view('widgets/profile_friends', $data);
}   

function load_profile_photos($user_id)
{		
    $ci =& get_instance();
	$ci->load->model('Photo_model');   	
	$data['user_id'] = $user_id;
    $data['photos'] = $ci->Photo_model->list_photos_by_user($user_id,TRUE);

    $ci->load->view('widgets/profile_photos', $data);
}


/* End of file user_authentication_helper.php */
/* Location: ./system/application/helpers/user_authentication_helper.php */