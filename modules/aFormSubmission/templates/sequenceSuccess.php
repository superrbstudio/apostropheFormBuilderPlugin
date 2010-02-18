<?php echo $pos ?> of <?php echo count($aForm->aFormLayouts) ?>
<br>
<?php echo form_tag('@a_form_submission_sequence?id='.$aFormSubmission->getId().'&form_id='.$aForm->getId().'&layout_rank='.($aFormLayout->getRank())); ?>
<?php echo $form ?>
<input type="submit" ?>
