<?php
class Feed extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model('wishlists_model');
		$this->load->helper('xml');
	}
    
	function items()
	{
		$id = $this->uri->segment(3);
		
		$data['encoding'] = 'utf-8';
		$data['page_language'] = 'en-ca';
		
		$data['wishlist'] = $this->wishlists_model->get_wishlist_by_id($id);
		$data['items'] = $this->wishlists_model->get_items_by_wishlist_id($id);
		
		header("Content-Type: application/rss+xml");
		$this->load->view('feed/items_feed', $data);
	}
	
	function add_links()
	{
		$id = $this->uri->segment(3);
		
		$data['encoding'] = 'utf-8';
		$data['page_language'] = 'en-ca';
		
		$data['wishlist'] = $this->wishlists_model->get_wishlist_by_id($id);
		$data['items'] = $this->wishlists_model->get_items_by_wishlist_id($id);
		
		header("Content-Type: application/rss+xml");
		$this->load->view('feed/add_links_feed', $data);
		
	}
}
?>