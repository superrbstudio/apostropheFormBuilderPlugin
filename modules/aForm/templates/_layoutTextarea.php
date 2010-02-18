<li class="textarea">
  <?php echo $form['textarea']->renderLabel() ?>
  <?php echo $form['textarea']->render(array('disabled' => $disabled)) ?>
</li>

<?php if ($aFormLayout->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
