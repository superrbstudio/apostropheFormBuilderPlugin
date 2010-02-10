<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="a-admin-form-container">
  <?php echo form_tag_for($form, '@a_form_submission_admin', array('id'=>'a-admin-form')) ?>
    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    <?php include_partial('aFormSubmission/aFormBody', array('form' => $form)) ?>

    <?php include_partial('aFormSubmission/form_actions', array('a_form_submission' => $a_form_submission, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
