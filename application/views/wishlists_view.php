
<?php if (isset($records)) : ?>
<?php foreach($records as $row) : ?>
<h2><?php echo anchor('wishlists/show/' . $row['id'] . '/' . url_title($row['title']), $row['title']); ?></h2>
<div><?php echo $row['desc']; ?></div>
<div id='links'><?php echo anchor('/wishlists/delete/' . $row['id'], "Delete"); ?></div>

<?php endforeach; ?>
<?php endif; ?>



<div id="add_wishlist_form">
	<?php echo form_open('wishlists/create/', 'class="cmxform"'); ?>
	<fieldset>
		<legend>Create Wishlist</legend>
		<ol>
		<li><label for="title">Title</label><?php echo form_input('title', "Title"); ?></li>		
		<li><label for="desc">Description</label><?php echo form_input('desc', "Description");  ?></li>
		<li><?php echo form_submit("submit", "Create Wishlist"); ?></li>
		</ol>
	</fieldset>	
	
	<?php echo form_close(); ?>
</div>
