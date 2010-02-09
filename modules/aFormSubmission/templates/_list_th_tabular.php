
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-text a-admin-list-th-id">
		  <?php if ('id' == $sort[0]): ?>
	    <?php echo link_to(__('Id', array(), 'messages'), 'aFormSubmission/index?sort=id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
	    <?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'a-admin'), 'title' => __($sort[1], array(), 'a-admin'))) ?>
	  <?php else: ?>
	    <?php echo link_to(__('Id', array(), 'messages'), 'aFormSubmission/index?sort=id&sort_type=asc') ?>
	  <?php endif; ?>
		</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>

	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-foreignkey a-admin-list-th-form_id">
		  <?php if ('form_id' == $sort[0]): ?>
	    <?php echo link_to(__('Form', array(), 'messages'), 'aFormSubmission/index?sort=form_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
	    <?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'a-admin'), 'title' => __($sort[1], array(), 'a-admin'))) ?>
	  <?php else: ?>
	    <?php echo link_to(__('Form', array(), 'messages'), 'aFormSubmission/index?sort=form_id&sort_type=asc') ?>
	  <?php endif; ?>
		</th>
	<?php end_slot(); ?>

<?php include_slot('a-admin.current-header') ?>

	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-text a-admin-list-th-ip_address">
		  <?php if ('ip_address' == $sort[0]): ?>
	    <?php echo link_to(__('Ip address', array(), 'messages'), 'aFormSubmission/index?sort=ip_address&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
	    <?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'a-admin'), 'title' => __($sort[1], array(), 'a-admin'))) ?>
	  <?php else: ?>
	    <?php echo link_to(__('Ip address', array(), 'messages'), 'aFormSubmission/index?sort=ip_address&sort_type=asc') ?>
	  <?php endif; ?>
		</th>
	<?php end_slot(); ?>


<?php include_slot('a-admin.current-header') ?>
	<?php slot('a-admin.current-header') ?>
	<th class="a-admin-foreignkey a-admin-list-th-user_id">
		  <?php if ('user_id' == $sort[0]): ?>
	    <?php echo link_to(__('User', array(), 'messages'), 'aFormSubmission/index?sort=user_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
	    <?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'a-admin'), 'title' => __($sort[1], array(), 'a-admin'))) ?>
	  <?php else: ?>
	    <?php echo link_to(__('User', array(), 'messages'), 'aFormSubmission/index?sort=user_id&sort_type=asc') ?>
	  <?php endif; ?>
		</th>
	<?php end_slot(); ?>

<?php foreach($a_form->aFormLayouts as $aField): ?>
<?php include_slot('a-admin.current-header') ?>
  
  <?php slot('a-admin.current-header') ?>
  <th class="a-admin-text a-admin-list-th-field" style="text-align:center;" colspan="<?php echo count($aField->getForm()->getObjects()); ?>">
    <?php echo $aField['label'] ?>
  </th>
  <?php end_slot(); ?>
  
<?php endforeach ?>

<?php include_slot('a-admin.current-header') ?>


