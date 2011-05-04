<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Site_model extends CI_Model {
    public function get_records()
    {
        $query = $this->db->get("wishlists");
        return $query->result();
        
    }
}
?>
