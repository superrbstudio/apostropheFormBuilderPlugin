<?php

class aFormBuilder extends BaseaFormSubmissionForm
{  
  public function configure()
  {
    if (!$this->getOption('a_form') instanceof aForm)
    {
      if($this->getObject()->isNew())
        throw new Exception("aFormBuilder requires an instance of aForm in the 'a_form' option.");
      else
        $this->setOption('a_form', $this->getObject()->aForm);
    }	
    $layoutWrapperForm = new sfForm();
 
    $embeddedObjects = $this->getEmbeddedObjects();
    
    foreach ($this->getOption('a_form')->aFormLayouts as $aFormLayout)
    {
      $layoutWrapperForm->embedForm($aFormLayout->getId(), $aFormLayout->getForm(
        $this->getObject()->getFieldSubmissionsForLayout($aFormLayout['id']), 
        array('a_form_layout' => $aFormLayout)
      ));
			$layoutWrapperForm[$aFormLayout->getId()]->getWidget()->setLabel($aFormLayout->getLabel());
    }
    $this->embedForm('fields', $layoutWrapperForm);
    $this->widgetSchema->setNameFormat('form[%s]');
		$this->useFields(array('fields'));
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
     
  public function doUpdateObject($values)
  {
    $this->getObject()->setFormId($this->getOption('a_form')->getId());
    $this->getObject()->setIpAddress($_SERVER['REMOTE_ADDR']);  
  }
  
}