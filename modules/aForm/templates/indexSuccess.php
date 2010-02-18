<?php include_partial('aForm/subnav') ?>

<ul>
<?php foreach ($aForms as $aForm): ?>
  <ul>
  	<li class="title"><?php echo link_to($aForm->getName(), 'a_form_edit', $aForm) ?></li>
  	<li><?php echo link_to('Edit this form', 'a_form_edit', $aForm) ?></li>
  	<li><?php echo link_to('Fill out this form', 'a_form_submission_new', $aForm) ?></li>
  </ul>
<?php endforeach ?>	
</ul>