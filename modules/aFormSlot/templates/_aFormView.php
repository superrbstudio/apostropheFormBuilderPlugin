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

<?php //include_partial('aFormSubmission/aFormBody', array('a_form', $a_form) ) ?>

</form>

<script type="text/javascript" charset="utf-8">

	// this is a temporary fix for grabbing & formatting checkbox options
	$(document).ready(function() {
		$('.a-form-row input[type="checkbox"]').parent().addClass('checkbox');
	});
	
</script>