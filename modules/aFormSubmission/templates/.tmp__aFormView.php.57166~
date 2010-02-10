<?php use_helper('jQuery') ?>

<h3><?php echo $a_form->getName() ?></h3>

<?php if (isset($submitted)): ?>
<h2><?php echo ($a_form->getThankYou()) ? $a_form->getThankYou() : 'Thank You! Your submission has been received.' ?></h2>
<?php endif ?>

<?php echo jq_form_remote_tag(array(
  'url' => 'aForm/submit',
  'update' => 'a-form-'.$a_form->getId(), 
), array(
	'class' => 'a-form-builder',
	'id' => 'a-form-builder-'.$a_form->getId(), 
)) ?>

<?php echo $form['form_id'] ?>

<?php echo $form->renderGlobalErrors() ?>
<ul>
<?php foreach ($form['fields'] as $id => $embedded_form): ?>
<li class="a-form-row">
  <?php if (count($embedded_form) > 1): ?>
  <fieldset>
    <legend><?php echo $form->getLegend($id) ?></legend>
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
<li><input type="submit" class="a-submit" value="Submit" /></li>
</ul>

</form>

<script type="text/javascript" charset="utf-8">

	// this is a temporary fix for grabbing & formatting checkbox options
	$(document).ready(function() {
		$('.a-form-row input[type="checkbox"]').parent().addClass('checkbox');
	});
	
</script>