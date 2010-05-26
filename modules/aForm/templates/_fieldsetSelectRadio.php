<li class="options-label"><label><?php echo $aFormFieldset['label'] ?></label></li>

<?php include_partial('aForm/aFormFieldsetOptions', array('a_form_fieldset' => $aFormFieldset, 'a_form_fieldset_options_form' => $aFormFieldset->getOptionsForm())) ?>



<?php if ($aFormFieldset->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
