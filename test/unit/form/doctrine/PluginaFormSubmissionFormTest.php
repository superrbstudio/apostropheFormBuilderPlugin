<?php

/**
 * aFormSubmissionForm tests.
 */
include dirname(__FILE__).'/../../../bootstrap/Doctrine.php';

$t = new lime_test(2);

$a_form = Doctrine::getTable('aForm')->createQuery()->fetchOne();

$form = new aFormBuilder(array(), array('a_form' => $a_form));

/*
 * Tests for form creation
 */
$t->is(count($form->getEmbeddedForm('fields')->getEmbeddedForms()), count($a_form->aFormFields), 'Correct number of field forms were embedded');

$bool = true;
foreach($a_form->aFormFields as $field)
{
  if(!$field->getType() == $form->getEmbeddedForm('fields')->getEmbeddedForm($field->getId()))
    $bool = false;
}

$t->ok($bool, "Each form is embedded with proper field type.");
