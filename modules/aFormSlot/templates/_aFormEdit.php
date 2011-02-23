<?php use_helper('jQuery') ?>

<h3 class="a-form-builder-name"><?php echo $a_form->getName() ?> 
<?php echo link_to_function('Form Settings', '$("#a-form-settings-'.$a_form->getId().'").slideToggle()', array('class' => 'a-settings-button', )) ?></h3>

<div id="a-form-settings-<?php echo $a_form->getId() ?>" class="a-form-builder a-form-settings" style="display:none;">
  <?php echo jq_form_remote_tag(array(
    'url' => 'aForm/editForm', 
    'update' => 'a-form-'.$a_form->getId(), 
    ), array('class' => 'a-form-settings-form')) ?>
  <?php foreach ($a_form_form as $field): ?>
  <?php if (!$field->isHidden()): ?><div class="a-form-row"><?php endif ?>
  <?php echo $field->renderError() ?>
  <?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
  <?php echo $field ?>
  <?php if (!$field->isHidden()): ?></div><?php endif ?>
  <?php endforeach ?>
	<input type="submit" name="submit" value="Submit" class="a-submit">
  </form>
  <?php echo link_to(__('Download CSV', array(), 'apostrophe') . '<span class="icon"></span>', 'aForm/export?id='.$a_form->getId(), array('class' => 'a-btn b')) ?>
</div>

<div id="a-form-<?php echo $a_form->getId() ?>-fields" class="a-form-builder editing">
<?php echo include_partial('aForm/aFormFieldsets', array('aForm' => $a_form)); ?>
</div>

<?php echo jq_sortable_element('#a-form-'.$a_form->getId().'-fields', array('url' => 'aForm/sortFields')) ?>

<div id="add-field-form-<?php echo $a_form->getId() ?>" class="a-form-builder adding" <?php if (!$a_form_fieldset_form->hasErrors()): ?>style="display:none;"<?php endif ?>>
	<?php echo include_partial('aForm/aFormFieldsetForm', array('aFormFieldsetForm' => $a_form_fieldset_form, 'aFormFieldset' => $a_form_fieldset, 'aForm' => $a_form)); ?>
</div>

<?php echo jq_link_to_function(__('Add field', array(), 'apostrophe') . '<span class="icon"></span>', "$('#add-field-form-".$a_form->getId()."').show();$(this).hide()", array('id' => 'add-field-button-'.$a_form->getId(), 'class' => 'a-btn')) ?>