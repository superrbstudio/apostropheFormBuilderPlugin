<?php echo $pos ?> of <?php echo count($aForm->aFormLayouts) ?>

<?php echo form_tag('@a_form_submission_sequence?id='.$aFormSubmission->getId().'&form_id='.$aForm->getId().'&layout_rank='.($aFormLayout->getRank())); ?>

<ul class="a-form-field <?php echo $aFormLayout->getType() ?>">
<?php include_partial('aForm/layout'.sfInflector::camelize($aFormLayout->getType()), array('aFormLayout' => $aFormLayout, 'form' => $aFormLayout->getForm(), 'disabled' => false)) ?>
</ul>

<input type="submit" ?>
