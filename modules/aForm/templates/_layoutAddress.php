<li class="address"><label><?php echo $aFormLayout['label'] ?></label></li>
<li class="address1">
  <?php echo $form['street1']->renderLabel() ?>
  <?php echo $form['street1']->render(array('disabled' => $disabled)) ?>
</li>
<li class="address2">
  <?php echo $form['street1']->renderLabel() ?>
  <?php echo $form['street1']->render(array('disabled' => $disabled)) ?>
</li>
<li class="city">
  <?php echo $form['city']->renderLabel() ?>
  <?php echo $form['city']->render(array('disabled' => $disabled)) ?>
</li>
<li class="state">
  <?php echo $form['state']->renderLabel() ?>
  <?php echo $form['state']->render(array('disabled' => $disabled)) ?>
</li>
<li class="postal-code">
  <?php echo $form['postal_code']->renderLabel() ?>
  <?php echo $form['postal_code']->render(array('disabled' => $disabled)) ?>
</li>
<li class="country">
  <?php echo $form['country']->renderLabel() ?>
  <?php echo $form['country']->render(array('disabled' => $disabled)) ?>
</li>
