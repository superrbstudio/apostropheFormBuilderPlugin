<?php
  // Compatible with sf_escaping_strategy: true
  $editable = isset($editable) ? $sf_data->getRaw('editable') : null;
  $feed = isset($feed) ? $sf_data->getRaw('feed') : null;
  $invalid = isset($invalid) ? $sf_data->getRaw('invalid') : null;
  $name = isset($name) ? $sf_data->getRaw('name') : null;
  $pageid = isset($pageid) ? $sf_data->getRaw('pageid') : null;
  $permid = isset($permid) ? $sf_data->getRaw('permid') : null;
  $options = isset($options) ? $sf_data->getRaw('options') : null;
  $slot = isset($slot) ? $sf_data->getRaw('slot') : null;
  $url = isset($url) ? $sf_data->getRaw('url') : null;
?>
<?php use_helper('a') ?>
<?php // Does this work? ?>
<?php use_stylesheet('/apostropheFormBuilderPlugin/css/aFormBuilder.css', 'last') ?>
<?php if ($editable): ?>
  <?php include_partial('a/simpleEditWithVariants', array('name' => $name, 'permid' => $permid, 'pageid' => $pageid, 'slot' => $slot, 'label' => a_get_option($options, 'editLabel', a_('Edit')))) ?>
<?php endif ?>

<?php if (!$slot->isNew()): ?>
  <?php include_component('aFormSlot', 'aFormView', array('a_form' => $a_form, 'form' => $form)) ?>
<?php endif ?>
