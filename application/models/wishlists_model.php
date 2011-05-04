<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wishlists_model
 *
 * @author chadley
 */
class Wishlists_model extends CI_Model {
	//put your code here
	//
	
	function get_all()
	{
		$query = $this->db->get("users");
		return $query->result();
	}
	function get_wishlists_by_user($user) 
	{
		$this->db->where('owner', $user);
		$query = $this->db->get("wishlists");
		return $query->result_array();
		
	}
	function get_wishlist_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get("wishlists");
		
		if ($query->num_rows() > 0)
		{
			$row = array_pop($query->result_array());
			return $row;
		} else
		{
			return NULL;
		}
	}
	function get_link_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get("item_links");

		if ($query->num_rows() > 0)
		{
			$row = array_pop($query->result_array());
			$row['item'] = $this->get_item_by_id($row['item_id']);
			return $row;
		} else
		{
			return NULL;
		}
	}
	
	function get_image_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get("item_images");

		if ($query->num_rows() > 0)
		{
			$row = array_pop($query->result_array());
			$row['item'] = $this->get_item_by_id($row['item_id']);
			return $row;
		} else
		{
			return NULL;
		}
	}
	function get_item_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get("items");
		
		if ($query->num_rows() > 0)
		{
			$row = array_pop($query->result_array());
			$row['wishlist'] = $this->get_wishlist_by_id($row['wishlist_id']);
			return $row;
		} else
		{
			return NULL;
		}
	}
	
	function get_items_by_wishlist_id($id)
	{
		$this->db->where('wishlist_id', $id);
		$query = $this->db->get("items");
		return $query->result_array();
		
	}
	function get_images_for_item($id)
	{
		$this->db->where('item_id', $id);
		$query = $this->db->get("item_images");
		return $query->result_array();
		
	}
	function get_links_for_item($id)
	{
		$this->db->where('item_id', $id);
		$query = $this->db->get("item_links");
		return $query->result_array();
		
	}
	function add_item($data)
	{
		$insert = $this->db->insert('items', $data);
		
		if ($insert)
		{
			$id = $this->db->insert_id();
			$image_data = array( 'item_id' => $id, 'filename' => $data['image_info']);
			$this->add_image_to_item($image_data);
		}
		
	}
	function wishlist_owner($id)
	{
		$this->db->where('id', $id);
		$this->db->select('owner');
		$query = $this->db->get('wishlists');

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->owner;
		} else
		{
			return NULL;
		}
	}
	function item_owner($id)
	{
		$this->db->select('owner');
		$this->db->from('items');
		$this->db->join('wishlists', 'wishlists.id = items.wishlist_id');
		$this->db->where('items.id', $id);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->owner;
		} else
		{
			return NULL;
		}
	}
	function delete_item($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('items');
	}
	function delete_wishlist($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('wishlists');
	}
	function add_image_to_item($data)
	{
		if (isValidURL($data['filename']))
		{
			$newfile = basename($data['filename']);
			$newfile = APPPATH . '../images/' . $newfile;

			if (strpos(cURLdownload($data['filename'], $newfile), "SUCCESS") === 0)
			{
					
				$config = array(
					'source_image' => $newfile,
					'new_image' => APPPATH . '../images/thumbs',
					'maintain_ratio' => true,
					'width' => 150,
					'height' => 100
				);

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
				$data['filename'] = '/images/' . basename($data['filename']);
			};
		}
		return $this->db->insert('item_images',$data);
	}

	function add_link_to_item($data)
	{
		if (isValidURL($data['url']))
		{
//			$newfile = basename($data['url']);
//			$newfile = APPPATH . '../images/' . $newfile;
//
//			if (strpos(cURLdownload($data['filename'], $newfile), "SUCCESS") === 0)
//			{
//					
//				$config = array(
//					'source_image' => $newfile,
//					'new_image' => APPPATH . '../images/thumbs',
//					'maintain_ratio' => true,
//					'width' => 150,
//					'height' => 100
//				);
//
//				$this->load->library('image_lib', $config);
//				$this->image_lib->resize();
//				
//				$data['filename'] = '/images/' . basename($data['filename']);
//			};
			
		return $this->db->insert('item_links',$data);
		}
	}	
	
	function create_wishlist($title, $desc, $owner)
	{
		$data = array(
		    'title' => $title,
		    'desc' => $desc,
		    'owner' => $owner
		);
		
		return $this->db->insert('wishlists', $data);
		
	}
	function update_wishlist($id, $title, $desc)
	{
		$this->db->where('id', $id);		
		$data = array(
		    'title' => $title,
		    'desc' => $desc
		);
		return $this->db->update('wishlists', $data);
	}
	function update_item($data)
	{
		$this->db->where('id', $data['id']);
		return $this->db->update('items', $data);
	}
	
	function update_link($data)
	{
		$this->db->where('id', $data['id']);
		return $this->db->update('item_links', $data);
	}
	function update_image($data)
	{
		if (isValidURL($data['filename']))
		{
			$newfile = basename($data['filename']);
			$newfile = APPPATH . '../images/' . $newfile;

			if (strpos(cURLdownload($data['filename'], $newfile), "SUCCESS") === 0)
			{
					
				$config = array(
					'source_image' => $newfile,
					'new_image' => APPPATH . '../images/thumbs',
					'maintain_ratio' => true,
					'width' => 150,
					'height' => 100
				);

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
				$data['filename'] = '/images/' . basename($data['filename']);
			};
		}
		
		$this->db->where('id', $data['id']);
		return $this->db->update('item_images',$data);
	}
	function delete_image($id)
	{
		$this->db->where('id', $id);
		$this->db->delete("item_images");
	}
	function delete_link($id)
	{
		$this->db->where('id', $id);
		$this->db->delete("item_links");
	}
}

?>