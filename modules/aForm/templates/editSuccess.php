<?php use_helper('jQuery') ?>

<?php if (!$sf_request->isXmlHttpRequest()): ?><div id="a-form-<?php echo $aForm->getId() ?>" ><?php endif ?>  

<?php slot('a-page-title', '<span>Form Builder :</span> Edit') ?>

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
<?php echo jq_link_to_function('Add field<span></span>', "$('#add-layout-form-".$aForm->getId()."').show();$(this).hide()", array('id' => 'add-layout-button-'.$aForm->getId(), 'class' => 'a-btn')) ?>
<?php endif ?>

<?php if (!$sf_request->isXmlHttpRequest()): ?></div><?php endif ?>