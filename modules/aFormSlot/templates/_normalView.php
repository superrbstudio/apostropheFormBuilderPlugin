<?php use_stylesheet('/apostropheFormBuilderPlugin/css/aFormBuilder.css', 'last') ?>
<?php use_helper('jQuery') ?>

<?php if ($editable && $slot->isNew()): ?>
<?php echo link_to_function('Create a new form<span></span>', $showEditorJS, array('class' => 'a-btn b', )) ?>
<?php endif ?>

<div id="a-form-<?php echo $a_form->getId() ?>">
<?php if ($editable && !$slot->isNew()): ?>
<?php include_component('aForm', 'aFormEdit', array('a_form' => $a_form)) ?>
<?php endif ?>
<?php if (!$editable && !$slot->isNew()): ?>
<?php include_component('aForm', 'aFormView', array('a_form' => $a_form)) ?>
<?php endif ?>
</div>