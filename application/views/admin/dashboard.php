<br/>
<h3><?php echo anchor('admin/dashboard/splash/','Manage Splash');?></h3>
<br/>
<h3><?php echo anchor('admin/dashboard/advert/','Manage Peeling Corner Advert');?></h3>
<?php if($role_id<='0'): ?>
<br/>
<h3><?php echo anchor('admin/dashboard/modules/','Manage Modules');?></h3>
<?php endif; ?>
<br/>
<h3><?php echo anchor('admin/dashboard/chat/','Manage Chat');?></h3>