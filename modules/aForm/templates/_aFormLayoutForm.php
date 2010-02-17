<?php use_helper('jQuery') ?>

<?php echo jq_form_remote_tag(array(
  'url' => ($a_form_layout->isNew()) ? '@a_form_addLayout?id='.$a_form->getId() : 'aForm/updateLayout', 
  'update' => ($a_form_layout->isNew()) ? 'a-form-'.$a_form->getId() : 'a-form-layout-'.$a_form_layout->getId(),
  'script' => 'true', 
  ), array('class' => 'a-form-builder editing-field', )) ?>


<ul class="a-form-layout">
	<li class="drag"><?php echo jq_link_to_function('Drag','',array('class' => 'a-btn icon drag', )) ?></li>
	<?php foreach ($a_form_layout_form as $field): ?>
		<?php if (!$field->isHidden()): ?><li class="a-form-row <?php echo strtolower($field->renderLabelName()) ?>"><?php endif ?>
		<?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
		<?php echo $field ?>
		<?php echo $field->renderError() ?>
		<?php if (!$field->isHidden()): ?></li><?php endif ?>
	<?php endforeach ?>
</ul>

<ul class="a-form-row submit">
	<li><input type="submit" name="submit" value="Submit" class="a-submit"></li>
<?php if ($a_form_layout->isNew()): ?>
  <li class="cancel"> or <?php echo jq_link_to_function('cancel', "$('#add-layout-button-".$a_form->getId()."').show();$('#add-layout-form-".$a_form->getId()."').hide()", array('class' => 'b')) ?></li>
<?php else: ?>
  <li class="cancel"> or <?php echo jq_link_to_remote('cancel', array(
    'url' => 'aForm/showField?id='.$a_form_layout->getId(), 
    'update' => 'a-form-layout-'.$a_form_layout->getId(),
  ), array('class' => 'b')) ?></li>
<?php endif ?>
</ul>

</form>
