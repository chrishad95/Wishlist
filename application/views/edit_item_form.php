
<div id="edit_item_form">
	<?php echo form_open('wishlists/edit_item/'. $item['id'], 'class="cmxform"'); ?>
	<fieldset>
		<legend>Edit Item</legend>
		<ol>
		<li><label for="title">Title</label><?php echo form_input('title', $item['title']); ?></li>		
		<li><label for="short_desc">Short Description</label><?php echo form_input('short_desc', $item['short_desc']);  ?></li>
		<li><label for="desc">Description</label><?php echo form_input('desc', $item['desc']);  ?></li>
		<li><label for="request_qty">Request Quantity</label><?php echo form_input('request_qty', $item['request_qty']);  ?></li>
		<li><label for="cost">Approximate Cost</label><?php echo form_input('cost', $item['cost']);  ?></li>
		<li><label for="rank">Rank</label><?php echo form_input('rank', $item['rank']);  ?></li>
		<li><?php echo form_submit("submit", "Edit Item"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>