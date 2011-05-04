<?php if (isset($records)) : ?>
    <?php foreach($records as $row) : ?>
<h2><?php echo $row->username; ?></h2>
<div><?php echo $row->created_at; ?></div>
    <?php endforeach; ?>
<?php endif; ?>