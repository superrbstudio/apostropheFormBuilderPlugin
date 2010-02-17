<?php slot('a-subnav') ?>

<ul>
  <p><?php echo link_to('See all forms', 'a_form') ?></p>
  <p><?php echo link_to('Create a new form', 'a_form_new') ?></p>
  <p><?php echo link_to('Form submission data', 'a_form_submission_admin') ?></p>
</ul>

<?php end_slot() ?>