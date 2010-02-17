<?php use_helper('jQuery') ?>

<?php echo jq_form_remote_tag(array(
  'url' => ($aFormLayout->isNew()) ? '@a_form_addLayout?id='.$aForm->getId() : '@a_form_updateLayout?id='.$aForm->getId().'&layout_id='.$aFormLayout->getId(),
  'update' => ($aFormLayout->isNew()) ? 'a-form-'.$aForm->getId() : 'a-form-layout-'.$aFormLayout->getId(),
  'script' => 'true', 
), array('class' => 'a-form-builder editing-field', )) ?>

<ul class="a-form-layout">
<?php foreach ($aFormLayoutForm as $field): ?>
	<?php if (!$field->isHidden()): ?><li class="a-form-row <?php echo strtolower($field->renderLabelName()) ?>"><?php endif ?>
	<?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
	<?php echo $field ?>
	<?php echo $field->renderError() ?>
	<?php if (!$field->isHidden()): ?></li><?php endif ?>
<?php endforeach ?>
<input type="hidden" name="sf_method" value="put" />
</ul>

<ul class="a-form-row submit">
	<li><input type="submit" name="submit" value="Submit" class="a-submit"></li>
  <?php if ($aFormLayout->isNew()): ?>
  <li class="cancel"> or <?php echo jq_link_to_function('cancel', "$('#add-layout-button-".$aForm->getId()."').show();$('#add-layout-form-".$aForm->getId()."').hide()", array('class' => 'b')) ?></li>
  <?php else: ?>
  <li class="cancel"> or <?php echo jq_link_to_remote('cancel', array(
    'url' => '@a_form_showLayout?id='.$aForm->getId().'&layout_id='.$aFormLayout->getId(), 
    'update' => 'a-form-layout-'.$aFormLayout->getId(),
    'method' => 'get', 
  ), array('class' => 'b')) ?></li>
  <?php endif ?>
</ul>

</form>

<?php if ($aFormLayout->isNew()): ?>
<script type="text/javascript" charset="utf-8">
	aSelfInputLabel('#a_form_layout_label','Label Name');
	alert('dong');
</script>	
<?php endif ?>
