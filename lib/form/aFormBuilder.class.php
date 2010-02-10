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

    $layoutWrapperForm = new sfForm();
    
    $embeddedObjects = $this->getEmbeddedObjects();
    
    foreach ($this->getOption('a_form')->getAllFieldsByRank() as $layout)
    {
      $this->legends[$layout->getId()] = $layout->getLabel();
      $layoutWrapperForm->embedForm($layout->getId(), $layout->getForm($embeddedObjects[$layout['id']], array('a_form_layout' => $layout)));
    }

    $this->embedForm('fields', $layoutWrapperForm);

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
    foreach($this->getOption('a_form')->getAllFieldsByRank() as $layout)
    {
      $embeddedObjects[$layout['id']] = array();
    }
    foreach($this->getObject()->aFormFieldSubmissions as $fieldSubmission)
    {
      $embeddedObjects[$fieldSubmission['layout_id']][] = $fieldSubmission;
    }
    return $embeddedObjects;
  }
  
  public function updateObjectEmbeddedForms($values, $forms = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $layoutForms)
    {
      $layoutForms->setOption('a_form_submission', $this->getObject());
      $layoutForms->doUpdateObjects($values['fields'][$name]);
    }
  }
  
  public function saveEmbeddedForms($con = null, $form = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $layoutForms)
    {
      $layoutForms->save();
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