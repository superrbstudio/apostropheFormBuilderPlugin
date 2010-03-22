<?php

/**
 * aFormSelectRadio tests.
 * 
 * @see aFormSelectRadio.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(2);

$choices = array('R1' => 'Radio 1', 'R2' => 'Radio 2');

sfForm::disableCSRFProtection();
$form = new aFormSelectRadio(null, array('choices' => $choices, 'required' => 'true'));

$t->is_deeply($form->getValidator('radio')->getOption('choices'), array_keys($choices), 'Select radio is validating your choices.');

$form->disableLocalCSRFProtection();
$form->bind(aFormTestToolkit::getValidData('select_radio'));
$t->ok($form->isValid(), 'Valid form is valid');