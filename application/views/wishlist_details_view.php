
<h2><?php echo $title ?></h2>
<p>Wishlist created by <?php echo $owner ?></p>
<p><?php echo anchor("feed/items/" . $this->uri->segment(3), "RSS"); ?></p>
<p><?php echo anchor("wishlists/edit/" . $this->uri->segment(3), "Edit"); ?></p>

<?php foreach($wishlist_items as $item) : ?>
	<div class="wishlist_item">
		<h2><?php echo anchor('wishlists/show_item/' . $item['id'] . '/' . url_title($item['title']), $item['title']) ?></h2>
		<div class="description"><?php echo $item['desc'] ?></div>
		<div class="links"><?php echo anchor('/wishlists/delete_item/' . $item['id'], "Delete Item"); ?></div>
	</div>
<?php endforeach; ?>

<div id="add_item_form">
	<?php echo form_open('wishlists/add_item/'. $this->uri->segment(3), 'class="cmxform"'); ?>
	<fieldset>
		<legend>Add New Item</legend>
		<ol>
			<li><label for="title">Title</label><?php echo form_input('title', "Item Title"); ?></li>
		
		
		<li><label for="short_desc">Short Description</label><?php echo form_input('short_desc', "Short Description");  ?></li>
		<li><label for="desc">Description</label><?php echo form_input('desc', "Description");  ?></li>
		<li><label for="request_qty">Request Quantity</label><?php echo form_input('request_qty', "1");  ?></li>
		<li><label for="image_info">Image Info</label><?php echo form_input('image_info', "Image Url");  ?></li>
		<li><label for="cost">Approximate Cost</label><?php echo form_input('cost');  ?></li>
		<li><label for="rank">Rank</label><?php echo form_input('rank');  ?></li>
		<li><?php echo form_submit("submit", "Add Item"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>