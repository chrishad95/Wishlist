<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Wishlists extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model('wishlists_model');
	}
	public function index() {
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['records']	= $this->wishlists_model->get_wishlists_by_user($data['username']);
			$data['main_content']	= 'wishlists_view';
			$this->load->view('includes/template', $data);
		}
	}
	public function show()
	{
		$wishlist_id = $this->uri->segment(3);
		$wishlist_info = $this->wishlists_model->get_wishlist_by_id($wishlist_id);
		$wishlist_items = $this->wishlists_model->get_items_by_wishlist_id($wishlist_id);
		
		$data['main_content'] = 'wishlist_details_view';
		$data['title'] = $wishlist_info['title'];
		$data['owner'] = $wishlist_info['owner'];
		
		$data['wishlist_info'] = $wishlist_info;
		$data['wishlist_items'] = $wishlist_items;
		
		$this->load->view('includes/template', $data);
		
	}
	public function add_item()
	{
		$this->load->library('form_validation');
		$this->load->helper('file');
		
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('request_qty', 'Request Quantity', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			redirect("/wishlists/show/" . $this->uri->segment(3));
		}		
		else
		{
			$data = array(
				'wishlist_id' => $this->uri->segment(3),
				'title' => $this->input->post('title'),
				'short_desc' => $this->input->post('short_desc'),
				'desc' => $this->input->post('desc'),
				'request_qty' => $this->input->post('request_qty'),
				'cost' => $this->input->post('cost'),
				'rank' => $this->input->post('rank'),
				'image_info' => $this->input->post('image_info')

			);

			
			$insert = $this->wishlists_model->add_item($data);			
			redirect("/wishlists/show/" . $this->uri->segment(3));
		}
		
	}
	public function show_item()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['username'] = $this->tank_auth->get_username();
			$data['item'] = $this->wishlists_model->get_item_by_id($this->uri->segment(3));
			$data['item']['wishlist'] = $this->wishlists_model->get_wishlist_by_id($data['item']['wishlist_id']);
			$data['item_images'] = $this->wishlists_model->get_images_for_item($this->uri->segment(3));
			$data['item_links'] = $this->wishlists_model->get_links_for_item($this->uri->segment(3));
			$data['main_content'] = "item_view";

			$this->load->view("includes/template", $data);
		}
	}
	public function delete()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$owner = $this->wishlists_model->wishlist_owner($id);			
			if ($this->tank_auth->get_username() == $owner)
			{
				$this->wishlists_model->delete_wishlist($id);
			}
			redirect('/wishlists');
		}		
	}
	public function delete_item($id)
	{
		$item_info = $this->wishlists_model->get_item_by_id($id);
		$this->wishlists_model->delete_item($id);
		redirect("/wishlists/show/" . $item_info['wishlist_id']);
	}
	public function add_image()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data = array (
			    'item_id' => $this->uri->segment(3),
			    'filename' => $this->input->post('image')
			);

			$this->wishlists_model->add_image_to_item($data);
			redirect("/wishlists/show_item/" . $this->uri->segment(3));
		}
	}
	
	public function add_link()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$owner = $this->wishlists_model->item_owner($id);
			
			if ($this->tank_auth->get_username() == $owner)
			{
				if ($this->input->get_post('title'))
				{
					$data = array (
					    'item_id' => $this->uri->segment(3),
					    'title' => $this->input->get_post('title'),
					    'url' => $this->input->get_post('url')
					);

					$this->wishlists_model->add_link_to_item($data);
				}
			}
			redirect("/wishlists/show_item/" . $this->uri->segment(3));
		}
	}
	public function create()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
						
			$this->load->library('form_validation');		

			// field name, error message, validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			if ($this->input->post('title'))
			{
				if($this->form_validation->run() == FALSE)
				{
					redirect("/wishlists");
				}		
				else
				{
					$insert = $this->wishlists_model->create_wishlist(
						$this->input->post('title'), 
						$this->input->post('desc'), 
						$this->tank_auth->get_username()
						);
					redirect("/wishlists");
				}
			}

		}
	}
	public function edit()
	{
		$redirect_url = "/wishlists/show/" . $this->uri->segment(3);
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$owner = $this->wishlists_model->wishlist_owner($id);
			
			if ($this->tank_auth->get_username() == $owner)
			{
				if ($this->input->post('title'))
				{
					//  this is a post from the form
					$this->load->library('form_validation');		

					// field name, error message, validation rules
					$this->form_validation->set_rules('title', 'Title', 'trim|required');
					if($this->form_validation->run() == FALSE)
					{
						redirect($redirect_url);
					}		
					else
					{
						$insert = $this->wishlists_model->update_wishlist(
							$id,
							$this->input->post('title'), 
							$this->input->post('desc')
							);
						redirect($redirect_url);
					}
				} else
				{
					// this is a get, so show the form
					$data['wishlist_info'] = $this->wishlists_model->get_wishlist_by_id($id);
					$data['main_content'] = 'edit_wishlist_form';
					$this->load->view('includes/template', $data);
					
				}
				
			} else
			{
						redirect($redirect_url);
			}

		}
	}

	public function edit_item()
	{
		$redirect_url = "/wishlists/show_item/" . $this->uri->segment(3);
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$owner = $this->wishlists_model->item_owner($id);
			
			if ($this->tank_auth->get_username() == $owner)
			{
				if ($this->input->post('title'))
				{
					//  this is a post from the form
					$this->load->library('form_validation');		

					// field name, error message, validation rules
					$this->form_validation->set_rules('title', 'Title', 'trim|required');
					$this->form_validation->set_rules('request_qty', 'Request Quantity', 'trim|required');
					if($this->form_validation->run() == FALSE)
					{
						redirect($redirect_url);
					}		
					else
					{
						$data = array(
							
							'id' => $id,
							'title' => $this->input->post('title'),
							'short_desc' => $this->input->post('short_desc'),
							'desc' => $this->input->post('desc'),
							'request_qty' => $this->input->post('request_qty'),
							'cost' => $this->input->post('cost'),
							'rank' => $this->input->post('rank')

						);

						$update = $this->wishlists_model->update_item($data);
						redirect($redirect_url);
					}
				} else
				{
					// this is a get, so show the form
					$data['item_info'] = $this->wishlists_model->get_item_by_id($id);
					$data['main_content'] = 'edit_item_form';
					$this->load->view('includes/template', $data);
					
				}
				
			} else
			{
						redirect($redirect_url);
			}

		}
	}


	public function delete_link()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$link_info = $this->wishlists_model->get_link_by_id($id);	
			$owner = $link_info['item']['wishlist']['owner'];
			
			if ($this->tank_auth->get_username() == $owner)
			{
				$this->wishlists_model->delete_link($id);
			}
			redirect("/wishlists/show_item/" . $link_info['item_id']);
		}
		
	}	
	public function delete_image()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$image_info = $this->wishlists_model->get_image_by_id($id);	
			$owner = $image_info['item']['wishlist']['owner'];
			
			if ($this->tank_auth->get_username() == $owner)
			{
				$this->wishlists_model->delete_image($id);
			}
			redirect("/wishlists/show_item/" . $image_info['item_id']);
		}
		
	}
	
	public function edit_link()
	{
	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$item_link = $this->wishlists_model->get_link_by_id($id);			
			$owner = $item_link['item']['wishlist']['owner'];
			$redirect_url = "/wishlists/show_item/" . $item_link['item_id'];
			
			if ($this->tank_auth->get_username() == $owner)
			{
				if ($this->input->post('title'))
				{
					//  this is a post from the form
					$this->load->library('form_validation');		

					// field name, error message, validation rules
					$this->form_validation->set_rules('title', 'Link Title', 'trim|required');
					$this->form_validation->set_rules('url', 'Link Url', 'trim|required');
					if($this->form_validation->run() == FALSE)
					{
						redirect($redirect_url);
					}		
					else
					{
						$data = array(
							
							'id' => $id,
							'title' => $this->input->post('title'),
							'url' => $this->input->post('url')
						);

						$update = $this->wishlists_model->update_link($data);
						redirect($redirect_url);
					}
				} else
				{
					// this is a get, so show the form
					$data['item_link'] = $this->wishlists_model->get_link_by_id($id);
					$data['main_content'] = 'edit_link_form';
					$this->load->view('includes/template', $data);
					
				}
				
			} else
			{
						redirect($redirect_url);
			}

		}
	}
	
	public function edit_image()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$id = $this->uri->segment(3);
			$item_image = $this->wishlists_model->get_image_by_id($id);			
			$owner = $item_image['item']['wishlist']['owner'];
			$redirect_url = "/wishlists/show_item/" . $item_image['item_id'];
			
			if ($this->tank_auth->get_username() == $owner)
			{
				if ($this->input->post('filename'))
				{
					//  this is a post from the form
					$this->load->library('form_validation');		

					// field name, error message, validation rules
					$this->form_validation->set_rules('filename', 'Image URL', 'trim|required');
					if($this->form_validation->run() == FALSE)
					{
						redirect($redirect_url);
					}		
					else
					{
						$data = array(
							
							'id' => $id,
							'filename' => $this->input->post('filename')
						);

						$update = $this->wishlists_model->update_image($data);
						redirect($redirect_url);
					}
				} else
				{
					// this is a get, so show the form
					$data['item_image'] = $item_image;
					$data['main_content'] = 'edit_image_form';
					$this->load->view('includes/template', $data);					
				}
				
			} else
			{
						redirect($redirect_url);
			}

		}	
	}
	
}
?>
