<li class="textarea">
  <?php echo $form['textarea']->renderLabel() ?>
  <?php echo $form['textarea']->render(array('disabled' => $disabled)) ?>
</li>

<?php if ($aFormFieldset->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
