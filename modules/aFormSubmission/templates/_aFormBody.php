<?php use_helper('jQuery') ?>

<h3><?php //echo $a_form->getName() ?></h3>
<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>
<ul>
<?php foreach ($form['fields'] as $id => $embedded_form): ?>
<li class="a-form-row">
  <?php if (count($embedded_form) > 1): ?>
  <fieldset>
    <legend><?php echo $embedded_form->getWidget()->getLabel() ?></legend>
    <ul>
      <?php foreach ($embedded_form as $field): ?>
        <li>
          <?php echo $field->renderLabel() ?>
          <?php echo $field ?>
          <?php echo $field->renderError() ?>
        </li>
      <?php endforeach ?>
    </ul>
  </fieldset>
  <?php else: ?>
    <?php foreach ($embedded_form as $field): ?>
      <?php echo $field->renderLabel() ?>
      <?php echo $field ?>
      <?php echo $field->renderError() ?>
    <?php endforeach ?>
  <?php endif ?>
</li>
<?php endforeach ?>
</ul>



<script type="text/javascript" charset="utf-8">

	// this is a temporary fix for grabbing & formatting checkbox options
	$(document).ready(function() {
		$('.a-form-row input[type="checkbox"]').parent().addClass('checkbox');
	});
	
</script>