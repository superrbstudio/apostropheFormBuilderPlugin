<?php slot('body_class','a-form-builder edit') ?>

<?php slot('a-page-title', '<span>Form Builder :</span> Edit') ?>

<?php use_helper('jQuery') ?>

<?php include_partial('aForm/subnav') ?>

<?php if (!$sf_request->isXmlHttpRequest()): ?><div id="a-form-<?php echo $aForm->getId() ?>" ><?php endif ?>  

<h3 class="a-form-builder-name"><?php echo $aForm->getName() ?> 
<?php echo link_to_function('Form Settings', '$("#a-form-settings-'.$aForm->getId().'").slideToggle()', array('class' => 'a-settings-button', )) ?></h3>

<div id="a-form-settings-<?php echo $aForm->getId() ?>" class="a-form-builder a-form-settings" style="display:none;">
  <?php echo jq_form_remote_tag(array(
    'url' => 'aForm/editForm', 
    'update' => 'a-form-'.$aForm->getId(), 
    ), array('class' => 'a-form-settings-form')) ?>
  <?php include_partial('aForm/aFormForm', array('aFormForm' => $aFormForm)) ?>
  </form>
</div>

<div id="a-form-<?php echo $aForm->getId() ?>-fields" class="a-form-builder editing">
<?php echo include_partial('aForm/aFormLayouts', array('aForm' => $aForm)); ?>
</div>

<?php echo jq_sortable_element('#a-form-'.$aForm->getId().'-fields', array('url' => '@a_form_sortLayouts?id='.$aForm->getId())) ?>


<div id="add-layout-form-<?php echo $aForm->getId() ?>" class="a-form-builder adding" <?php if (!$aFormLayoutForm->hasErrors()): ?>style="display:none;"<?php endif ?>>
	<?php echo include_partial('aForm/aFormLayoutForm', array('aFormLayoutForm' => $aFormLayoutForm, 'aFormLayout' => $aFormLayout, 'aForm' => $aForm)); ?>
</div>

<?php if (!$aFormLayoutForm->hasErrors()): ?>
<?php echo jq_link_to_function('Add field<span></span>', "$('#add-layout-form-".$aForm->getId()."').show();$(this).hide();$('#a_form_layout_label').focus();", array('id' => 'add-layout-button-'.$aForm->getId(), 'class' => 'a-btn a-add-layout-button big icon a-add')) ?>
<?php endif ?>

<ul class="a-form-list">
  <li>
    <ul class="a-form-list-item">
	  	<li><?php echo link_to('Fill out this form', '@a_form_submission_sequence_new?form_id='. $aForm->getId(), array('class' => 'a-btn', )) ?></li>
      <li><?php echo link_to('See the data', '@a_form_submission_admin?form_id='. $aForm->getId(), array('class' => 'a-btn')) ?></li>
    </ul>
  </li>
</ul>

<?php if (!$sf_request->isXmlHttpRequest()): ?></div><?php endif ?>