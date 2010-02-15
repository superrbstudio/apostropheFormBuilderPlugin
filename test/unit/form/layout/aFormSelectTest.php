<?php

/**
 * aFormSelect tests.
 * 
 * @see aFormSelect.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(2);

$choices = array('S1' => 'Select 1', 'S2' => 'Select 2');

sfForm::disableCSRFProtection();
$form = new aFormSelect(null, array('choices' => $choices, 'required' => 'true'));

$t->is_deeply($form->getValidator('select')->getOption('choices'), array_keys(get_choices($choices)), 'Select is validating your choices.');

$form->disableLocalCSRFProtection();
$form->bind(aFormTestTools::getValidData('select'));
$t->ok($form->isValid(), 'Valid form is valid');

function get_choices($choices)
{
  $blank = array('' => 'Please select an option');

  $choices = array_merge($blank, $choices);
  
  return $choices;
}
