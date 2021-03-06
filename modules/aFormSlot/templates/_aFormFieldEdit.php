<?php use_helper('jQuery') ?>

<li class="drag"><?php echo jq_link_to_function('Drag','',array('class' => 'a-btn icon a-drag nobg alt', )) ?></li>
<li class="delete"><?php echo jq_link_to_remote('Delete', array(
  'url' => 'aForm/deleteField?id='.$a_form_fieldset->getId(),
  'confirm' => 'Are you sure you want to delete this field? If you do, you will no longer be able to retrieve the data from this column.',  
  'complete' => '$("#a-form-field-'.$a_form_fieldset->getId().'").hide()', 
), array('class' => 'a-btn icon delete', )) ?></li>
<li class="edit"><?php echo jq_link_to_remote('Edit<span></span>', array(
  'update' => 'a-form-field-'.$a_form_fieldset->getId(),
  'url' => 'aForm/editField?id='.$a_form_fieldset->getId(),
  'script' => true, 
), array('class' => 'a-btn edit', )) ?></li>

<?php if ($a_form_fieldset->getType() != 'select_radio' && $a_form_fieldset->getType() != 'select_checkbox'): ?>
<?php foreach ($a_form_fieldset->getForm() as $field): ?>
<ul class="<?php echo $a_form_fieldset->getType() ?>">
	<li class="label"><?php echo $field->renderLabel() ?></li> 
  <li class="field"><?php echo $field->render(array('disabled' => 'true')) ?></li>
</ul>
<?php endforeach ?>
<?php else: ?>
<ul>
	<li class="label">
		<label><?php echo $a_form_fieldset->getLabel() ?></label>
	</li>
</ul>
<?php endif ?>


<?php if ($a_form_fieldset->usesOptions()): ?>
<?php include_component('aForm', 'aFormFieldsetOptions', array('a_form_fieldset' => $a_form_fieldset)); ?>
<?php endif ?>	