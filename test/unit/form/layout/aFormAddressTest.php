<?php

/**
 * aFormAddressTests tests.
 * 
 * @see aFormAddress.class.php
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(7);

sfForm::disableCSRFProtection();
$form = new aFormAddress(null, array('required' => 'true'));

$t->is($form->getValidator('street1')->getOption('max_length'), 255, 'Street 1 is look for a 255 char string.');
$t->is($form->getValidator('street2')->getOption('max_length'), 255, 'Street 2 is look for a 255 char string.');
$t->is($form->getValidator('city')->getOption('max_length'), 255, 'City is look for a 255 char string.');
$t->is($form->getValidator('state')->getOption('max_length'), 255, 'State is look for a 255 char string.');
$t->is($form->getValidator('postal_code')->getOption('max_length'), 255, 'Postal code is look for a 255 char string.');
$t->is($form->getValidator('country')->getOption('max_length'), 255, 'Country is look for a 255 char string.');

$form->disableLocalCSRFProtection();
$form->bind(aFormTestToolkit::getValidData('address'));
$t->ok($form->isValid(), 'Valid form is valid');
