<li><?php echo $a_form_layout['label'] ?></li>
<li class="address1">
  <span>
    <?php echo $form['street1']->renderLabel() ?>
    <?php echo $form['street1']->render(array('disabled' => $disabled)) ?>
  </span>
</li>
<li class="address2">
  <span>
    <?php echo $form['street1']->renderLabel() ?>
    <?php echo $form['street1']->render(array('disabled' => $disabled)) ?>
  </span>
</li>
<li class="city_state">
  <span>
    <?php echo $form['city']->renderLabel() ?>
    <?php echo $form['city']->render(array('disabled' => $disabled)) ?>
  </span>
	<span>
    <?php echo $form['state']->renderLabel() ?>
    <?php echo $form['state']->render(array('disabled' => $disabled)) ?>
  </span>
</li>
<li class="zip_country">
  <span>
    <?php echo $form['postal_code']->renderLabel() ?>
    <?php echo $form['postal_code']->render(array('disabled' => $disabled)) ?>
  </span>
  <span>
    <?php echo $form['country']->renderLabel() ?>
    <?php echo $form['country']->render(array('disabled' => $disabled)) ?>
  </span>
</li>
