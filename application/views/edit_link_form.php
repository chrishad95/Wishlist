
<div id="edit_item_form">
	<?php echo form_open('wishlists/edit_link/'. $item_link['id'], 'class="cmxform"'); ?>
	<fieldset>
		<legend>Edit Link</legend>
		<ol>
		<li><label for="title">Link Title</label><?php echo form_input('title', $item_link['title']); ?></li>		
		<li><label for="url">Link URL</label><?php echo form_input('url', $item_link['url']);  ?></li>
		<li><?php echo form_submit("submit", "Edit Link"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>