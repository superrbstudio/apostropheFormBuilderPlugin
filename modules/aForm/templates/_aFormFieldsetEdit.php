<?php use_helper('jQuery') ?>

<li class="drag"><?php echo jq_link_to_function('Drag', '', array('class' => 'a-btn icon no-label a-drag no-bg alt', 'title' => 'Drag to Order',  )) ?></li>
<li class="delete"><?php echo jq_link_to_remote('Delete', array(
  'url' => '@a_form_deleteFieldset?id='.$aForm->getId().'&fieldset_id='.$aFormFieldset->getId(),
  'confirm' => 'Are you sure you want to delete this field? If you do, you will no longer be able to retrieve the data from this column.',  
  'complete' => '$("#a-form-fieldset-'.$aFormFieldset->getId().'").hide()', 
  'method' => 'post', 
), array('class' => 'a-btn icon no-label a-delete', 'title' => 'Delete', )) ?></li>
<li class="edit"><?php echo jq_link_to_remote('Edit<span></span>', array(
  'update' => 'a-form-fieldset-'.$aFormFieldset->getId(),
  'url' => '@a_form_editFieldset?id='.$aFormFieldset->getFormId().'&fieldset_id='.$aFormFieldset->getId(),
  'script' => true,
	'complete' => 'aUI("#a-form-fieldset-'.$aFormFieldset->getId().'");', 
), array('class' => 'a-btn icon no-label a-edit', 'title' => 'Edit', )) ?></li>

<li>
	<ul class="a-form-field <?php echo $aFormFieldset->getType() ?>">
		<?php include_partial('fieldset'.sfInflector::camelize($aFormFieldset->getType()), array('aFormFieldset' => $aFormFieldset, 'form' => $aFormFieldset->getForm(), 'disabled' => true)) ?>
	</ul>
</li>