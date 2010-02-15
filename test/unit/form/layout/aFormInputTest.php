<?php

/**
 * aFormInput tests.
 * 
 * @see aFormInput.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(2);

sfForm::disableCSRFProtection();
$form = new aFormInput(null, array('required' => 'true'));

$t->is($form->getValidator('input')->getOption('max_length'), 255, 'Input is looking for a 255 char string.');

$form->disableLocalCSRFProtection();
$form->bind(aFormTestTools::getValidData('input'));
$t->ok($form->isValid(), 'Valid form is valid');
