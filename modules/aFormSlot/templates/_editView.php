<?php use_stylesheet('/apostropheFormBuilderPlugin/css/aFormBuilder.css', 'last') ?>

<h4>Step 1: Please fill out the form name, the email address to receive the results, and a thank you message to be displayed after a user submits to your form.</h4>

<div class="a-form-builder">
  <?php foreach ($form as $field): ?>
  <?php if (!$field->isHidden()): ?><div class="a-form-row"><?php endif ?>
  <?php echo $field->renderError() ?>
  <?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
  <?php echo $field ?>
  <?php if (!$field->isHidden()): ?></div><?php endif ?>
  <?php endforeach ?>
</div>
