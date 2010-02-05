<?php

class aFormBuilder extends BaseaFormSubmissionForm
{
  protected
    $legends = array();
  
  public function setup()
  {
    parent::setup();
    if (!$this->getOption('a_form') instanceof aForm)
    {
      if($this->isNew())
        throw new Exception("aFormBuilder requires an instance of aForm in the 'a_form' option.");
      else
        $this->setOption('a_form', $this->getObject()->aForm);
    }

    $this->setWidget('form_id', new sfWidgetFormInputHidden());
    $this->setDefault('form_id', $this->getOption('a_form')->getId());

    $fieldWrapperForm = new sfForm();
    
    $embeddedObjects = $this->getEmbeddedObjects();
    
    foreach ($this->getOption('a_form')->getAllFieldsByRank() as $field)
    {
      $this->legends[$field->getId()] = $field->getLabel();
      $fieldWrapperForm->embedForm($field->getId(), $field->getForm($embeddedObjects[$field['id']], array('a_form_field' => $field)));
    }

    $this->embedForm('fields', $fieldWrapperForm);

    $this->widgetSchema->setNameFormat('form[%s]');
    
    $this->setValidator('form_id', new sfValidatorInteger(array('required' => true)));
    
    $this->useFields(array(
      'form_id',
      'fields'
    ));
  }
  
  public function getEmbeddedObjects()
  {
    $embeddedObjects = array();
    foreach($this->getOption('a_form')->getAllFieldsByRank() as $field)
    {
      $embeddedObjects[$field['id']] = array();
    }
    foreach($this->getObject()->aFormFieldSubmissions as $fieldSubmission)
    {
      $embeddedObjects[$fieldSubmission['field_id']][] = $fieldSubmission;
    }
    return $embeddedObjects;
  }
  
  public function updateObjectEmbeddedForms($values, $forms = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $fieldForms)
    {
      $fieldForms->setOption('a_form_submission', $this->getObject());
      $fieldForms->doUpdateObjects($values['fields'][$name]);
      
    }
  }
  
  public function saveEmbeddedForms($con = null, $form = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $fieldForms)
    {
      $fieldForms->save();
    }
  }
  
  public function getLegend($id)
  {
    return $this->legends[$id];
  }
   
  public function doUpdateObject($values)
  {
    $this->getObject()->setFormId($this->getOption('a_form')->getId());
    $this->getObject()->setIpAddress($_SERVER['REMOTE_ADDR']);  
  }
  
}