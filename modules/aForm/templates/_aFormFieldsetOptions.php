<?php use_helper('jQuery') ?>

<?php echo jq_form_remote_tag(array(
  'url' => 'aForm/updateFieldsetOption?id='.$a_form_fieldset['form_id'].'&fieldset_id='.$a_form_fieldset['id'],
  'update' => 'a-form-fieldset-'.$a_form_fieldset->getId(),
  'script' => 'true', 
  'complete' => '$("#a-form-field-options-'.$a_form_fieldset->getId().' .a-form-field-options input:last").focus()', 
  ), array('id' => 'a-form-field-options-'.$a_form_fieldset->getId())) ?>
  <?php echo $a_form_fieldset_options_form->renderGlobalErrors(); ?>
  <?php echo $a_form_fieldset_options_form->renderHiddenFields(); ?>
<li class="options">
	<div class="options-container">
    <ul>
    <?php $optionsForm = $a_form_fieldset_options_form->getEmbeddedForm('options') ?>
    <?php foreach($a_form_fieldset_options_form['options'] as $key => $field): ?>
      <li class="option">
        <?php echo $field['name']->render(); ?> <span><?php echo $field['value']->render(); ?></span>
        <?php echo jq_link_to_remote('Delete', array(
          'url' => 'aForm/updateFieldsetOption?id='.$a_form_fieldset['form_id'].'&fieldset_id='.$a_form_fieldset['id'].'&delete='.$a_form_fieldset_options_form->getEmbeddedForm('options')->getEmbeddedForm($key)->getObject()->getId(),
          'with' => "$('#a-form-field-options-".$a_form_fieldset->getId()."').serialize()",
          'update' => 'a-form-fieldset-'.$a_form_fieldset->getId(),
          ), array('class' => 'a-btn icon no-label a-delete')) ?>
      </li>
    <?php endforeach; ?>
      <li><?php echo jq_link_to_remote('Add', array(
          'url' => 'aForm/updateFieldsetOption?id='.$a_form_fieldset['form_id'].'&fieldset_id='.$a_form_fieldset['id'].'&add=1',
          'with' => "$('#a-form-field-options-".$a_form_fieldset->getId()."').serialize()",
          'update' => 'a-form-fieldset-'.$a_form_fieldset->getId(),
          ), array('class' => 'a-btn icon no-label a-add')) ?> </li>
      <li><input type="submit" value="Save" class="a-btn a-submit" /></li>
    </ul>
  </div>
</li>
</form>

  
