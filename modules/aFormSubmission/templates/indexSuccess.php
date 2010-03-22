<ul>
<?php foreach ($aFormSubmissions as $aFormSubmission): ?>
  <li><?php echo link_to('Submission on '. $aFormSubmission->getCreatedAt(), 'a_form_submission_sequence', array(
    'id' => $aFormSubmission->getId(),
    'form_id' => $aFormSubmission->getFormId(),
    'fieldset_rank' => 1,   
    )) ?></li>
<?php endforeach ?>
</ul>