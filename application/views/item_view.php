<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2><?php echo $item['title']; ?></h2>

<div id='item_desc'><?php echo $item['desc'] ; ?></div>
<div id='item_cost'>Approximate Cost: <?php echo $item['cost']; ?></div>
<p><a href="javascript:void(window.open('<?php echo site_url('wishlists/add_link') . '/' . $item['id']; ?>?url='+encodeURIComponent(document.location)+'&title='+encodeURIComponent(document.title)));">Add Link to <?php echo $item['title']; ?></a></p>
<div id='item_images'>
	<?php foreach ($item_images as $image): ?>
	<div id="item_image">
		<a href='<?php echo $image['filename']; ?>'><img src="<?php echo '/images/thumbs/' . basename($image['filename']); ?>" alt='<?php echo $item['title'] ?>' /></a>
		<?php echo anchor('/wishlists/delete_image/' . $image['id'], 'Delete Image') ?>
		<?php echo anchor('/wishlists/edit_image/' . $image['id'], 'Edit Image') ?>
	</div>
	<?php endforeach; ?>
	
</div>

<div id='item_links'>
	<?php foreach ($item_links as $link): ?>
	<p><?php echo anchor($link['url'], $link['title']); ?></p>
	
	<?php if ($username == $item['wishlist']['owner']) : ?>
		<p><?php echo anchor('/wishlists/edit_link/' . $link['id'], 'Edit Link') ?></p>
		<p><?php echo anchor('/wishlists/delete_link/' . $link['id'], 'Delete Link') ?></p>
	<?php endif; ?>
	<?php endforeach; ?>
	
</div>
<?php if ($username == $item['wishlist']['owner']) : ?>

<div id="add_image_form">
	<?php echo form_open('/wishlists/add_image/' . $this->uri->segment(3), 'class="cmxform"'); ?>
	<fieldset>
		<legend>Add Image</legend>
		<ol>
		<li><label for="image">Image Filename or Url</label><?php echo form_input('image', "Image Filename or Url"); ?></li>		
		<li><?php echo form_submit("submit", "Add Image"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>
<div id="add_link_form">
	<?php echo form_open('/wishlists/add_link/' . $this->uri->segment(3), 'class="cmxform"'); ?>
	<fieldset>
		<legend>Add Link</legend>
		<ol>
		<li><label for="title">Link Title</label><?php echo form_input('title', "Link Title"); ?></li>
		<li><label for="url">Link Url</label><?php echo form_input('url', "Link Url"); ?></li>		
		<li><?php echo form_submit("submit", "Add Link"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>
<?php $this->load->view("edit_item_form"); ?>
<?php endif; ?>
<?php echo anchor('wishlists/show/' . $item['wishlist_id'], 'Back to wishlist'); ?>