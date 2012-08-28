<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login Function
 * Summary: 	 Validates users details and then logs in the user.
 * Parameters: Username (String), Password (String)
 * Returns:		 notactive, banned, success, failed, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('auth_log_in'))
{
    function auth_log_in($user,$pass)
    {		
    		// Set up the CI instance so site instance can be called
    		$ci =& get_instance();
    		// Load the user model
				$ci->load->model('User_model', 'user_model');
				    
    		// If the user and password are there
        if(($user) && ($pass)) 
        {
        	// This will either be FALSE or the ID of the user
        	$login_id = $ci->user_model->does_user_exist($user,md5($pass));

        	if(!empty($login_id))
        	{ // Log in was succesful
        		$active = $ci->user_model->is_user_active($login_id);
        		$banned = $ci->user_model->is_user_banned($login_id);
        		
        		// If the user is active and is not banned
        		// stop with the login and return
        		if(empty($active)) return 'notactive';
        		if(!empty($banned)) return 'banned';
        		
        		// Get the details of the user from database
        		$user_details = $ci->user_model->get_user_details($login_id);
        		if($user_details)
        		{
	        		// Insert details into the session
	        		$user_data = array(
	                   'id'  => $user_details->id,
	                   'username'  => $user_details->username,
	                   'logged_in' => TRUE,
	                   'user_level' => $user_details->permissions_id,
	               );
					$ci->session->set_userdata($user_data);
	        		$ci->user_model->set_last_login($user_details->id);
	        		// Return if all OK
	        		return 'success';
	        		
	        	} else {
	        		// Return if user details are incorrect
	        		return 'failed';
	        	}
        	}
        } 
       
        // If everything failed, return false
        return FALSE;
    }   
}

/**
 * Log out Function
 * Summary: 	 Ends the logged in session.
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('auth_log_out'))
{
    function auth_log_out()
    {		
    	// Set up the CI instance so site instance can be called
    	$ci =& get_instance();
    	
    	// Clear the array and destroy the session
    	$array_items = array('id' => '', 'username' => '', 'logged_in' => '');
		return $ci->session->unset_userdata($array_items) ? false : true;		
    }
    
}

/**
 * Is Logged In Function
 * Summary: 	 Returns if someone is logged in.
 * Returns:		 TRUE, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('auth_is_logged_in'))
{
	function auth_is_logged_in()
	{		
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Return if logged in or not
		return $ci->session->userdata('logged_in');
	}    
}

/**
 * Admin Is Logged In Function
 * Summary: 	 Returns if someone is logged in and an admin.
 * Returns:		 TRUE, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('admin_is_logged_in'))
{
	function admin_is_logged_in()
	{		
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If there is a permissions ID and the user is logged in
		if((isset($permissions_id)) && ($logged_in == TRUE)) {
			
			// Get the actual level of the permission from the ID
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			// Return if the level is 10 or not
			return $permissions_level == 10 ? TRUE : FALSE;
		}
		// If not logged in, return false
		return FALSE;
	}    
}

/**
 * CMS Is Logged In Function
 * Summary: 	 Returns if someone is logged in and an admin.
 * Returns:		 TRUE, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('cms_is_logged_in'))
{
	function cms_is_logged_in()
	{		
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If there is a permissions ID and the user is logged in
		if((isset($permissions_id)) && ($logged_in == TRUE)) {
			
			// Get the actual level of the permission from the ID
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			// Return if the level is 5 or not
			return $permissions_level >= 2 ? TRUE : FALSE;
		}
		// If not logged in, return false
		return FALSE;
	}    
}

/**
 * CMS Show Log In Function
 * Summary: 	Displays the log in page for the CMS area.
 * Author: 		Max Novakovic
 *
 */
if ( ! function_exists('cms_show_login'))
{

	function cms_show_login()
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If a user is logged in and has permissions
		if(($logged_in) && (isset($permissions_id))) {
		
			// Get the permissions level
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			
			// If the permissions level is not 2
			if($permissions_level != 2) {

				// Redirect the user to the homepage
				redirect(base_url());
			}
			// If there are no permissions, or the user is an admin
			// Allow them to log in
			else {
				$header_data['css'] = css_asset_url('login.css', 'cms');
				$ci->load->view('cms/header.php',$header_data);
				$ci->load->view('cms/login.php');
				$ci->load->view('cms/footer.php');
			}
		}
		// If no one is logged in, display the log in
		else {
			$header_data['css'] = css_asset_url('login.css', 'cms');
			$ci->load->view('cms/header.php',$header_data);
			$ci->load->view('cms/login.php');
			$ci->load->view('cms/footer.php');
		}
	
	}

}

/**
 * Admin Show Log In Function
 * Summary: 	Displays the log in page for the admin area.
 * Author: 		Max Novakovic
 *
 */
if ( ! function_exists('admin_show_login'))
{

	function admin_show_login()
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If a user is logged in and has permissions
		if(($logged_in) && (isset($permissions_id))) {
		
			// Get the permissions level
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			
			// If the permissions level is not 10
			if($permissions_level != 10) {

				// Redirect the user to the homepage
				redirect(base_url());
			}
			// If there are no permissions, or the user is an admin
			// Allow them to log in
			else {
				$header_data['css'] = css_asset_url('style.css', 'admin');
				$ci->load->view('admin/header.php',$header_data);
				$ci->load->view('admin/login.php');
				$ci->load->view('admin/footer.php');
			}
		}
		// If no one is logged in, display the log in
		else {
			$header_data['css'] = css_asset_url('style.css', 'admin');
			$ci->load->view('admin/header.php',$header_data);
			$ci->load->view('admin/login.php');
			$ci->load->view('admin/footer.php');
		}
	
	}

}

/**
 * Moderator Is Logged In Function
 * Summary: 	 Returns if someone is logged in and a moderator.
 * Returns:		 TRUE, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('moderator_is_logged_in'))
{
	function moderator_is_logged_in()
	{		
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If there is a permissions ID and the user is logged in
		if((isset($permissions_id)) && ($logged_in == TRUE)) {
			
			// Get the actual level of the permission from the ID
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			// Return if the level is 3 or not
			return $permissions_level >= 3 ? TRUE : FALSE;
		}
		// If not logged in, return false
		return FALSE;
	}    
}

/**
 * Moderator Show Log In Function
 * Summary: 	Displays the log in page for the moderation area.
 * Author: 		Max Novakovic
 *
 */
if ( ! function_exists('moderator_show_login'))
{

	function moderator_show_login()
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If a user is logged in and has permissions
		if(($logged_in) && (isset($permissions_id))) {
		
			// Get the permissions level
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			
			// If the permissions level is not 3
			if($permissions_level < 3) {
				// Redirect the user to the homepage
				redirect(base_url());
			}
			// If there are no permissions, or the user is an admin
			// Allow them to log in
			else {
				$header_data['css'] = css_asset_url('style.css', 'admin');
				$ci->load->view('moderation/header.php',$header_data);
				$ci->load->view('moderation/login.php');
				$ci->load->view('moderation/footer.php');
			}
		}
		// If no one is logged in, display the log in
		else {
			$header_data['css'] = css_asset_url('style.css', 'admin');
			$ci->load->view('moderation/header.php',$header_data);
			$ci->load->view('moderation/login.php');
			$ci->load->view('moderation/footer.php');
		}
	
	}

}

/**
 * Staf Is Logged In Function
 * Summary: 	 Returns if someone is logged in and staff.
 * Returns:		 TRUE, FALSE
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('staff_is_logged_in'))
{
	function staff_is_logged_in()
	{		
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If there is a permissions ID and the user is logged in
		if((isset($permissions_id)) && ($logged_in == TRUE)) {
			
			// Get the actual level of the permission from the ID
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			// Return if the level is 4 or not
			return $permissions_level >= 4 ? TRUE : FALSE;
		}
		// If not logged in, return false
		return FALSE;
	}    
}

/**
 * Moderator Show Log In Function
 * Summary: 	Displays the log in page for the moderation area.
 * Author: 		Max Novakovic
 *
 */
if ( ! function_exists('staff_show_login'))
{

	function staff_show_login()
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		$ci->load->model('Parent_model');
		
		// Assign the permissions and logged in status
		$permissions_id = $ci->session->userdata('user_level');
		$logged_in = $ci->session->userdata('logged_in');
		
		// If a user is logged in and has permissions
		if(($logged_in) && (isset($permissions_id))) {
		
			// Get the permissions level
			$permissions_level = $ci->user_model->return_permission_level($permissions_id)->row()->level;
			
			// If the permissions level is not 3
			if($permissions_level < 4) {
				// Redirect the user to the homepage
				redirect(base_url());
			}
			// If there are no permissions, or the user is a staff/admin
			// Allow them to log in
			else {

			$data['groups'] = $ci->Parent_model->get_all('groups');
			
			$header_data['css'] = css_asset_url('style.css', 'admin');
			$ci->load->view('admin/header', $header_data);
			$ci->load->view('admin/staff_login', $data);
			$ci->load->view('admin/footer');
			}
		}
		// If no one is logged in, display the log in
		else {
			$header_data['css'] = css_asset_url('style.css', 'admin');
			$ci->load->view('admin/header.php',$header_data);
			$ci->load->view('admin/staff_login.php');
			$ci->load->view('admin/footer.php');
		}
	
	}

}

/**
 * Random Password Function
 * Summary: 	Generates a random password from a-z A-Z 0-9.
 * Author: 		Max Novakovic
 *
 */
if ( ! function_exists('random_password'))
{
	function random_password() {

  	$password = '';
		
		// Loop through 8 chars and generate a random one 
   	for ($x = 1; $x <= 8; $x++) {
    	switch ( rand(1, 3) ) {
	      case 1:
	      $password .= rand(0, 9);
	      break;
	      case 2:
	      $password .= chr( rand(65, 90) );
	      break;
	      case 3:
	      $password  .= chr( rand(97, 122) );
	      break;
      }
   	}
 		return $password;
	}
}


/**
 * Online Users Function
 * Summary: 	 Checks which users are online and how long they have 
 *						 been online for. Only gets users that have been logged 
 *						 on for less than 10 minutes for effiency.
 * Returns:		 Array( ID, Date of last login, First name, last name )
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('online_users'))
{

	function online_users()
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model and the date helper
		$ci->load->model('User_model', 'user_model');
		$ci->load->helper('date');
		
		// Get the session data from the database
		$online_details = $ci->user_model->get_online_details();
		
		// Set up some variables for looping
		$i = 0;
		if($online_details) {
		
			// Loop through the online details
			foreach($online_details as $row)
			{
				// Get the user data from the MySQL
				$user_data = $row->user_data;
				// If the user data exists, then the user is logged on
				// or the user has been logged in
				if($user_data)
				{
					
					// Get the logged in status out the serialized array
					$regex_logged_in = '/"logged_in";s:([0-9]+):"(.*?)";/i';
					// Match the data (returns false if nothing matched)
					$logged_in = preg_match($regex_logged_in, $user_data, $regs) ? $regs[2] : "FALSE"; 	
					
					// For every user that is logged in
					if($logged_in) {
						
						// get the username from the serialized array
						$regex_username = '/"username";s:([0-9]+):"(.*?)";/i';
						// Match the data (returns false if nothing matched)
						$username = preg_match($regex_username, $user_data, $regs) ? $regs[2] : "FALSE"; 	
						
						// From the username get the users account details
						$user_details = $ci->user_model->get_details_from_username($username);
						
						if($user_details) {
						
							// Calculate the time in seconds the user has been logged in
							$now = mktime(date('H'), date('i'), date('s'), date("m")  , date("d"), date("Y"));
							
							//echo date("Y m d H:i:s", mysql_to_unix($user_details->last_login)) . " ";
							
							$login = $now - mysql_to_unix($user_details->last_login);
							//echo $login;
							// If the user has been online for less than 1 hour, display them
							if($login < 3600) {
							
								// Get the users first and last name and add them to the array
								$profile_details = $ci->user_model->get_user_profile_details($user_details->id);
								
								//print_r($users);							
								$found = false;
								//echo count($users);
								//echo $profile_details->last_name;
								
								if(isset($users)) {
										foreach($users as $user)
										{
											if($user['last_name'] == $profile_details->last_name)
												$found = true;
											
										}	
								}						
								
								if (!$found) {
									// Assign the online users to the array
									$users[$i]['id'] = $user_details->id;
									$users[$i]['last_login'] = $login;
									
									$users[$i]['first_name'] = $profile_details->first_name;
									$users[$i]['last_name'] = $profile_details->last_name;
								}
							
							
							
							
							}
						}
						$i++;
					}
				}
			} // End the loop
		}
		
		// Return the array of online users that have been logged in
		// for less than 10 minus
		if(isset($users)) return $users;
		else return false;

	}

}

/**
 * Username Check Function
 * Summary: 	 Checks if a username is taken. This is used as a call back
 *						 function for form validation.
 * Returns:		 TRUE, FALSE
 * Parameters: $str (String)
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('username_check'))
{

	function username_check($str)
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Check if the username has been taken
		if ($ci->user_model->is_username_unique($str)) {
			return TRUE;
		}
		// If the user name is taken, send back error message for the form validation
		else {
			$ci->validation->set_message('alias_username_check', 'The Username you have specified is already in use.');
			return FALSE;
		}
	}
}

/**
 * Email Check Function
 * Summary: 	 Checks if a email is taken. This is used as a call back
 *						 function for form validation.
 * Returns:		 TRUE, FALSE
 * Parameters: $str (String)
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('email_check'))
{

	function email_check($str)
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user model
		$ci->load->model('User_model', 'user_model');
		
		// Check if the email address is already in use
		if ($ci->user_model->is_email_unique($str)) {
			return TRUE;
		}
		// If it is in use, send back an error message for the form 
		// validation
		else {
			$ci->validation->set_message('alias_email_check', 'The email you have specified is already in use by another user.');
			return FALSE;
		}
	}
}

/**
 * Permissions Check Function
 * Summary: 	 Checks if the permissions level being set for a user
 *						 exists or not
 * Returns:		 TRUE, FALSE
 * Parameters: $str (String)
 * Author: 		 Max Novakovic
 *
 */
if ( ! function_exists('permissions_check'))
{

	function permissions_check($str)
	{
		// Set up the CI instance so site instance can be called
		$ci =& get_instance();
		// Load the user name
		$ci->load->model('User_model', 'user_model');
		
		// Check if the permission is valid
		if ($ci->user_model->does_permission_exist($str)) {
			return TRUE;
		}
		// If it is not valid, send back an error message for the form 
		// validation
		else {
			$ci->validation->set_message('alias_permissions_check', 'The permission level that you have set for this user does not exist.');
			return FALSE;
		}
	}
}

/* End of file user_authentication_helper.php */
/* Location: ./system/application/helpers/user_authentication_helper.php */