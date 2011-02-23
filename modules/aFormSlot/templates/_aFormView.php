<?php use_helper('jQuery') ?>

<h3><?php echo $a_form->getName() ?></h3>

<?php if (isset($submitted)): ?>
<h2><?php echo ($a_form->getThankYou()) ? $a_form->getThankYou() : 'Thank You! Your submission has been received.' ?></h2>
<?php endif ?>

<?php $id = "a-form-builder-" . $a_form->getId() ?>
<form method="POST" action="<?php echo url_for('aFormSlot/submit') ?>" class="a-form-builder" id="<?php echo $id ?>" ?>
  <?php include_partial('aFormSubmission/aFormBody', array('form' => $form)) ?>
  <div class="a-form-row"><input type="submit" class="a-submit" value="Submit" /></div>
</form>

<?php a_js_call('apostrophe.formUpdates(?)', array('selector' => '#' . $id, 'updates' => '#a-form-' . $a_form->getId())) ?>
<?php echo jq_form_remote_tag(array(
  'url' => 'aForm/submit',
  'update' => 'a-form-'.$a_form->getId(), 
), array(
	'class' => 'a-form-builder',
	'id' => 'a-form-builder-'.$a_form->getId(), 
)) ?>

<script type="text/javascript" charset="utf-8">

	// this is a temporary fix for grabbing & formatting checkbox options
	// Tom: how temporary? This dates back to Trinity 1
	$(document).ready(function() {
		$('.a-form-row input[type="checkbox"]').parent().addClass('checkbox');
	});
	
</script>