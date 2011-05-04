<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_model extends CI_Model {
     function get_all()
    {
        $query = $this->db->get("users");
        return $query->result();
        
    }
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }
    
    function create($username, $password, $email_address, $first_name, $last_name) {
	 $user_data = array (	     
	     'username' => $username,
	     'password' => md5($password),
	     'email_address' => $email_address,
	     'first_name' => $first_name,
	     'last_name' => $last_name
	 )   ;
	 $insert = $this->db->insert('users', $user_data);
	 return $insert;
	 
    }
}

?>
