<div id="edit_image_form">
	<?php echo form_open('/wishlists/edit_image/' . $item_image['id'], 'class="cmxform"'); ?>
	<fieldset>
		<legend>Edit Image</legend>
		<ol>
		<li><label for="filename">Image Url</label><?php echo form_input('filename', $item_image['filename']); ?></li>		
		<li><?php echo form_submit("submit", "Edit Image"); ?></li>
		</ol>
	</fieldset>		
	<?php echo form_close(); ?>
</div>