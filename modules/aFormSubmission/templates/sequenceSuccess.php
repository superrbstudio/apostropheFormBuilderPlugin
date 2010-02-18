<?php echo $pos ?> of <?php echo count($aForm->aFormLayouts) ?>
<br>
<?php echo form_tag('@a_form_submission_sequence_submit?id='.$aFormSubmission->getId().'&form_id='.$aForm->getId().'&layout_id='.($aFormLayout->getId())); ?>
<?php echo $form ?>
<input type="submit" ?>
