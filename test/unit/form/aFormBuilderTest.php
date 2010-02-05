<?php

/**
 * aFormSubmissionForm tests.
 */
include dirname(__FILE__).'/../../bootstrap/Doctrine.php';

$t = new lime_test(5);

$a_form = Doctrine::getTable('aForm')->createQuery()->fetchOne();

$form = new aFormBuilder(array(), array('a_form' => $a_form));

/*
 * An aFormBuilder object needs to correctly represent a corresponding aForm object.
 */
$t->comment('An aFormBuilder object needs to correctly represent a corresponding aForm object.');

$t->is(count($form->getEmbeddedForm('fields')->getEmbeddedForms()), count($a_form->aFormFields), 'Correct number of field forms were embedded');

$bool = true;
foreach($a_form->aFormFields as $field)
{
  if(!($field->getFormClass() == get_class($form->getEmbeddedForm('fields')->getEmbeddedForm($field->getId()))) )
    $bool = $bool && false;
}
$t->ok($bool, "Each form is embedded with proper field type.");

/*
 * Testing the form submission process.
 */
$t->comment('Testing the form submission process.');
$testValues = array("Alex Gilbert", "alex@punkave.com", "June", "Vanilla");
$key = 0;
foreach($a_form->aFormFields as $field)
{
  foreach($field->getForm()->getObjects() as $subField => $object)
  {
     $values['fields'][$field->getId()][$subField] = $testValues[$key];
  }
  $key++;
}
$values[$form->getCSRFFieldName()] = $form->getCSRFToken();
$values['form_id'] = $a_form->getId();
$form->bind($values);

$t->ok($form->isValid(), 'Form was bound and is valid.');
$t->ok($form->save(), 'Form was saved.');

$a_form_submission = Doctrine::getTable('aFormSubmission')->findOneBy('id', $form->getObject()->getId());
$t->is($a_form_submission->getFormId(), $a_form->getId(), 'Submission was saved with proper form_id');
$bool = true;