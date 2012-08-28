<h3>All Categories</h3>
<p>
	<?php echo anchor('shop','All Categories');?>
</p>
<br/>
<p>Please select one of the provided "categories" listed below:</p>
<?php if($shop_categories->num_rows() > 0):?>
	<?php foreach($shop_categories->result() as $row): ?>
		<div style="margin: 5px 10px; width: 200px !important; overflow: hidden; display: inline-block;">
			<div style="margin: 0px;">
				<div style="max-height: 200px !important; max-width: 200px !important; height: 200px !important; width: 200px !important; text-align: center; display: table-cell; vertical-align: middle; background: silver;">
					<a href="<?php echo base_url(); ?>shop/category/<?php echo $row->id; ?>">
						<img src="<?php echo base_url(); ?>uploads/shop/categories/<?php echo $row->image; ?>" alt="<?php echo $row->category; ?>" style="width: auto; max-width: 200px; height:auto; max-height: 200px;" />
					</a>
				</div>
			</div>
			<strong><a href="<?php echo base_url(); ?>shop/category/<?php echo $row->id; ?>"><?php echo $row->category; ?></a></strong>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
</div>
<div class="content_plain">