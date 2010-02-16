<?php foreach ($aFormForm as $field): ?>
  <?php if (!$field->isHidden()): ?><div class="a-form-row"><?php endif ?>
  <?php echo $field->renderError() ?>
  <?php echo (!$field->isHidden()) ? $field->renderLabel() : '' ?>
  <?php echo $field ?>
  <?php if (!$field->isHidden()): ?></div><?php endif ?>
<?php endforeach ?>
<input type="submit" name="submit" value="Submit" class="a-submit">