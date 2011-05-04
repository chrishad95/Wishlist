<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Users extends CI_Controller {
    
    public function index() 
    {
       	$this->load->model('users_model') ;

        $records = $this->users_model->get_all();
	$data['main_content'] = "users_view";
        $data['records'] = $records;
        
        $this->load->view("includes/template", $data);
    }
    public function signup()
    {
	    if ($this->input->post('first_name')) {
		    $this->load->model('users_model');
		    $result = $this->users_model->create(
			    $this->input->post('username'),
			    $this->input->post('password'),
			    $this->input->post('email_address'),
			    $this->input->post('first_name'),
			    $this->input->post('last_name')			    
			    );
		    if ($result) {
			$this->index();
		    } else {	
			    $data['main_content'] = "create_user_form";
			    $this->load->view('includes/template', $data);
		    }
	    } else {
		    $data['main_content'] = "create_user_form";
		    $this->load->view('includes/template', $data);
	    }
    }
}


?>
