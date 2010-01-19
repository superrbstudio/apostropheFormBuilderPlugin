<?php

class aFormBuilder extends sfForm
{
  protected
    $legends = array();
  
  public function configure()
  {
    if (!$this->getOption('a_form') instanceof aForm)
    {
      throw new Exception("aFormBuilder requires an instance of aForm in the 'a_form' option.");
    }

    $this->setWidget('form_id', new sfWidgetFormInputHidden());
    
    $this->setDefault('form_id', $this->getOption('a_form')->getId());
    
    $fieldWrapperForm = new sfForm();
    
    foreach ($this->getOption('a_form')->getAllFieldsByRank() as $field)
    {
      $this->legends[$field->getId()] = $field->getLabel();
      $fieldWrapperForm->embedForm($field->getId(), $field->getForm());
    }

    $this->embedForm('fields', $fieldWrapperForm);

    $this->widgetSchema->setNameFormat('form[%s]');
    
    $this->setValidator('form_id', new sfValidatorInteger(array('required' => true)));
  }
  
  public function getLegend($id)
  {
    return $this->legends[$id];
  }
  
  public function save()
  {
    $a_form_submission = new aFormSubmission();
    $a_form_submission->setFormId($this->getOption('a_form')->getId());
    $a_form_submission->setIpAddress($_SERVER['REMOTE_ADDR']);
    $a_form_submission->save();
    
    $values = $this->getValues();
    foreach ($values['fields'] as $field_id => $field_values)
    {
      $a_form_field = Doctrine::getTable('aFormField')->find($field_id);
      
      $a_form_field_form = $a_form_field->getForm($field_values, array('a_form_submission' => $a_form_submission, 'a_form_field' => $a_form_field));
      $a_form_field_form->save();
    }
    
    return $a_form_submission;
  }
}