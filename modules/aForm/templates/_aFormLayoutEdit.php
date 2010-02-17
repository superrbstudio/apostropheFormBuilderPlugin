<?php use_helper('jQuery') ?>

<li class="drag"><?php echo jq_link_to_function('Drag', '', array('class' => 'a-btn icon icon-only a-drag nobg alt', 'title' => 'Drag to Order',  )) ?></li>
<li class="delete"><?php echo jq_link_to_remote('Delete', array(
  'url' => '@a_form_deleteLayout?id='.$aForm->getId().'&layout_id='.$aFormLayout->getId(),
  'confirm' => 'Are you sure you want to delete this field? If you do, you will no longer be able to retrieve the data from this column.',  
  'complete' => '$("#a-form-layout-'.$aFormLayout->getId().'").hide()', 
  'method' => 'post', 
), array('class' => 'a-btn icon icon-only a-delete', 'title' => 'Delete', )) ?></li>
<li class="edit"><?php echo jq_link_to_remote('Edit<span></span>', array(
  'update' => 'a-form-layout-'.$aFormLayout->getId(),
  'url' => '@a_form_editLayout?id='.$aFormLayout->getFormId().'&layout_id='.$aFormLayout->getId(),
  'script' => true, 
), array('class' => 'a-btn icon icon-only a-edit', 'title' => 'Edit', )) ?></li>

<li class="a-form-field <?php echo $aFormLayout->getType() ?>">
	<ul>
		<?php include_partial('layout'.sfInflector::camelize($aFormLayout->getType()), array('aFormLayout' => $aFormLayout, 'form' => $aFormLayout->getForm(), 'disabled' => true)) ?>
	</ul>
</li>