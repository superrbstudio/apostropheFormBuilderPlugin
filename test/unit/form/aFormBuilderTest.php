<?php

/**
 * aFormSubmissionForm tests.
 * 
 * @see aFormBuilder.class.php
 */
include dirname(__FILE__).'/../../bootstrap/Doctrine.php';

$t = new lime_test(8);

$a_form = Doctrine::getTable('aForm')->createQuery()->fetchOne();

$form = new aFormBuilder(array(), array('a_form' => $a_form));

/*
 * An aFormBuilder object needs to correctly represent a corresponding aForm object.
 */
$t->comment('An aFormBuilder object needs to correctly represent a corresponding aForm object.');


$t->is(count($form->getEmbeddedForm('fields')->getEmbeddedForms()), count($a_form->aFormLayouts), 'Correct number of field forms were embedded');

$bool = true;
foreach($a_form->aFormLayouts as $field)
{
  if(!($field->getFormClass() == get_class($form->getEmbeddedForm('fields')->getEmbeddedForm($field->getId()))) )
    $bool = $bool && false;
}
$t->ok($bool, "Each form is embedded with proper field type.");

/*
 * Dynamic forms need to validate, bind and save correctly.
 */
$t->comment('Dynamic forms need to validate, bind and save correctly.');

/**
 * Bind and save a valid form.
 */
$valid = aFormTestToolkit::getValidData();
foreach($a_form->aFormLayouts as $field)
{
  $values['fields'][$field->getId()] = $valid[$field->getType()];
}
$values[$form->getCSRFFieldName()] = $form->getCSRFToken();
$values['form_id'] = $a_form->getId();
$form->bind($values);
$t->ok($form->isValid(), 'Form was bound with optional fields is valid.');
foreach($form as $field)
{
  echo $field->renderError();
}
$t->ok($form->save(), 'Form was saved.');

$a_form_submission = Doctrine::getTable('aFormSubmission')->findOneBy('id', $form->getObject()->getId());
$t->is($a_form_submission->getFormId(), $a_form->getId(), 'Submission was saved with proper form_id');

/**
 * Try and save a form with invalid data.
 */
$f = Doctrine::getTable('aForm')->findOneByName('Required fields');

$form = new aFormBuilder(array(), array('a_form' => Doctrine::getTable('aForm')->findOneByName('Required fields')));
$invalid = aFormTestToolkit::getInvalidData();
foreach($a_form->aFormLayouts as $field)
{
  $values['fields'][$field->getId()] = $invalid[$field->getType()];
}
$values[$form->getCSRFFieldName()] = $form->getCSRFToken();
$values['form_id'] = $a_form->getId();
$form->bind($values);
$t->is($form->isValid(), false, 'Form with required fields is not valid if fields are left empty.');

/**
 * Test form creation with existing submissions
 */
try
{ 
  new aFormBuilder();
}
catch(exception $e)
{
	$t->pass('A form can not be created without an aFormSubmission object or an aForm passed as an option');
}
new aFormBuilder($a_form_submission);
$t->pass('A form can be created with an instance of aFormSubmission without aForm passed as an option');
