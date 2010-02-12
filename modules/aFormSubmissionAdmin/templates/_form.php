<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="a-admin-form-container">
  <?php echo form_tag_for($form, '@a_form_submission_admin', array('id'=>'a-admin-form')) ?>
    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    <?php include_partial('aFormSubmission/aFormBody', array('form' => $form)) ?>
  </form>
</div>
