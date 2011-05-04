<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Site extends CI_Controller {
    
    public function index() 
    {
        
//        $records = $this->site_model->get_records();
//        $data['records'] = $records;
//        
//        $this->load->view("wishlists_view", $data);
	    
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else {
		$data['username'] = $this->tank_auth->get_username();
		$data['main_content'] = 'welcome';
		$this->load->view('includes/template.php', $data);
	}
	    
    }
}
?>
