<th class="a-admin-text a-admin-list-th-field" colspan="4"></th>
<?php foreach($a_form->aFormLayouts as $aFormLayout): ?>
  <?php if(count($aFormLayout->aFormFields) > 1): ?>
	<?php $form = $aFormLayout->getForm() ?>
  <?php foreach($aFormLayout->aFormFields as $aFormField): ?>
	<th class="a-admin-text a-admin-list-th-field"><?php echo $form[$aFormField['name']]->renderLabel(); ?></th>
	<?php endforeach; ?>
  <?php else: ?>
	<th class="a-admin-text a-admin-list-th-field"><?php echo $aFormLayout['label']; ?></th>
	<?php endif ?>
<?php endforeach ?>
<th class="a-admin-text a-admin-list-th-field" colspan="1"></th>
