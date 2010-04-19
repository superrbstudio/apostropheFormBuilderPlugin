<?php use_helper('jQuery') ?>

<?php echo jq_form_remote_tag(array(
  'url' => ($aFormFieldset->isNew()) ? '@a_form_addFieldset?id='.$aForm->getId() : '@a_form_updateFieldset?id='.$aForm->getId().'&fieldset_id='.$aFormFieldset->getId(),
  'update' => ($aFormFieldset->isNew()) ? 'a-form-'.$aForm->getId() : 'a-form-fieldset-'.$aFormFieldset->getId(),
  'script' => 'true', 
), array('class' => 'a-form-builder editing-field', )) ?>

<ul class="a-form-fieldset">
<?php foreach ($aFormFieldsetForm as $field): ?>
	<?php if (!$field->isHidden()): ?><li class="a-form-field <?php echo strtolower($field->renderLabelName()) ?>"><?php endif ?>
	<?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
	<?php echo $field ?>
	<?php echo $field->renderError() ?>
	<?php if (!$field->isHidden()): ?></li><?php endif ?>
<?php endforeach ?>
<?php if(!$aFormFieldset->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif ?>
</ul>

<ul class="a-form-field submit">
	<li><input type="submit" name="submit" value="Save" class="a-submit"></li>
  <?php if ($aFormFieldset->isNew()): ?>
  <li class="cancel"><?php echo jq_link_to_function('cancel', "$('#add-fieldset-button-".$aForm->getId()."').show();$('#add-fieldset-form-".$aForm->getId()."').hide()", array('class' => 'a-btn no-label icon a-cancel')) ?></li>
  <?php else: ?>
  <li class="cancel"><?php echo jq_link_to_remote('cancel', array(
    'url' => '@a_form_showFieldset?id='.$aForm->getId().'&fieldset_id='.$aFormFieldset->getId(), 
    'update' => 'a-form-fieldset-'.$aFormFieldset->getId(),
    'method' => 'get',
		'complete' => 'aUI("#a-form-fieldset-'.$aFormFieldset->getId().'");', 
  ), array('class' => 'a-btn no-label icon a-cancel')) ?></li>
  <?php endif ?>
</ul>

</form>

<?php if ($aFormFieldset->isNew()): ?>
<script type="text/javascript" charset="utf-8">
	aInputSelfLabel('#a_form_fieldset_label','Field Name');
</script>	
<?php endif ?>
