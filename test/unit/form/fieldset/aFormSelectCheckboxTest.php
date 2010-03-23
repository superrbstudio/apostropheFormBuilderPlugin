<?php

/**
 * aFormSelectCheckbox tests.
 * 
 * @see aFormSelectCheckbox.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$choices = array('CB1' => 'Checkbox 1', 'CB2' => 'Checkbox 2');

$t = new lime_test(count($choices) + 1);

sfForm::disableCSRFProtection();
$form = new aFormSelectCheckbox(null, array('choices' => $choices));

foreach ($choices as $key => $choice)
{
  $t->is_deeply($form->getValidator($key)->getOption('choices'), array($key, ''), 'Checkbox is validating the choices.');
}

$form->disableLocalCSRFProtection();
$form->bind(aFormTestToolkit::getValidData('select_checkbox'));
$t->ok($form->isValid(), 'Valid form is valid');

function get_choices($choices)
{
  $blank = array('' => 'Please select an option');

  $choices = array_merge($blank, $choices);
  
  return $choices;
}
