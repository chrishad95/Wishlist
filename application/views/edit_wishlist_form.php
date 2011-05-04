<div id="add_wishlist_form">
	<?php echo form_open('wishlists/edit/' . $wishlist_info['id'], 'class="cmxform"'); ?>
	<fieldset>
		<legend>Edit Wishlist</legend>
		<ol>
		<li><label for="title">Title</label><?php echo form_input('title', $wishlist_info['title']); ?></li>		
		<li><label for="desc">Description</label><?php echo form_input('desc', $wishlist_info['desc']);  ?></li>
		<li><?php echo form_submit("submit", "Edit Wishlist"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>

