<?php

/**
 * aFormSelectCheckbox tests.
 * 
 * @see aFormSelectCheckbox.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$choices = array('CB1' => 'Checkbox 1', 'CB2' => 'Checkbox 2');

$t = new lime_test((count($choices) * 2) + 1);

$true_values = array('1');
$false_values = array('0', ' ', '');

sfForm::disableCSRFProtection();
$form = new aFormSelectCheckbox(null, array('choices' => $choices));

foreach ($choices as $key => $choice)
{
  $t->is_deeply($form->getValidator($key)->getOption('true_values'), $true_values, 'Checkbox is validating true_values on your fields.');
  $t->is_deeply($form->getValidator($key)->getOption('false_values'), $false_values, 'Checkbox is validating false_values on your fields.');
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
