<?php slot('body_class','a-form-builder list') ?>

<?php slot('a-page-title', '<span>Form Builder :</span> Home') ?>

<?php include_partial('aForm/subnav') ?>

<h4>All Forms</h4>

<ul class="a-form-list">
<?php foreach ($aForms as $aForm): ?>
	<li>
	  <ul class="a-form-list-item">
	  	<li class="title"><h5><?php echo link_to($aForm->getName(), 'a_form_edit', $aForm) ?></h5></li>
	  	<li><?php echo link_to('Edit this form', 'a_form_edit', $aForm, array('class' => 'a-btn icon icon-only a-edit', )) ?></li>
	  	<li><?php echo link_to('Fill out this form', '@a_form_submission_sequence_new?id='. $aForm->getId(), array('class' => 'a-btn', )) ?></li>
      <li><?php echo link_to('See the data', '@a_form_submission_admin?form_id='. $aForm->getId(), array('class' => 'a-btn')) ?></li>
	  </ul>
	</li>
<?php endforeach ?>	
</ul>