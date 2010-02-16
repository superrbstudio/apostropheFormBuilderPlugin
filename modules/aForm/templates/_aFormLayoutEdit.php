<?php use_helper('jQuery') ?>

<li class="drag"><?php echo jq_link_to_function('Drag','',array('class' => 'a-btn icon drag', )) ?></li>
<li class="delete"><?php echo jq_link_to_remote('Delete', array(
  'url' => 'aForm/deleteField?id='.$a_form_layout->getId(),
  'confirm' => 'Are you sure you want to delete this field? If you do, you will no longer be able to retrieve the data from this column.',  
  'complete' => '$("#a-form-field-'.$a_form_layout->getId().'").hide()', 
), array('class' => 'a-btn icon delete', )) ?></li>
<li class="edit"><?php echo jq_link_to_remote('Edit<span></span>', array(
  'update' => 'a-form-field-'.$a_form_layout->getId(),
  'url' => 'aForm/editLayout?id='.$a_form_layout->getFormId().'&layout_id='.$a_form_layout->getId(),
  'script' => true, 
), array('class' => 'a-btn edit', )) ?></li>

<ul>
<?php include_partial('layout'.sfInflector::camelize($a_form_layout->getType()), 
  array('a_form_layout' => $a_form_layout, 'form' => $a_form_layout->getForm(), 'disabled' => true)) ?>
</ul>