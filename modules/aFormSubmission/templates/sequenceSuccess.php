<?php slot('body_class','a-form-builder filling-out') ?>

<?php slot('a-page-title', '<span>Form Builder :</span> Filling Out Survey') ?>

<h4><span><em>Question <?php echo $pos ?> </em> of <?php echo count($aForm->aFormFieldsets) ?></span></h4>

<?php echo form_tag('@a_form_submission_sequence?id='.$aFormSubmission->getId().'&form_id='.$aForm->getId().'&fieldset_rank='.($aFormFieldset->getRank()+1), array(
  'class' => $aFormFieldset->getType(), 
)); ?>

<ul class="a-form-field <?php echo $aFormFieldset->getType() ?>">

<?php include_partial('aForm/fieldset'.sfInflector::camelize($aFormFieldset->getType()), array('aFormFieldset' => $aFormFieldset, 'form' => $form, 'disabled' => false)) ?>
<?php echo $form->renderHiddenFields() ?>
</ul>

<input type="submit" name="submit" class="a-submit" />

</form>