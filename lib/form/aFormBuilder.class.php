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
		$this->setDefault('form_id', $this->getOption('a_form')->getId());
		$this->setWidget('form_id' , new sfWidgetFormInputHidden());
		
    $fieldsetWrapperForm = new sfForm();
    
    foreach ($this->getOption('a_form')->aFormFieldsets as $aFormFieldset)
    {
      $fieldsetWrapperForm->embedForm($aFormFieldset->getId(), $aFormFieldset->getForm(
        $this->getObject()->getFieldSubmissionsForFieldset($aFormFieldset['id']), 
        array('a_form_fieldset' => $aFormFieldset)
      ));
			$fieldsetWrapperForm[$aFormFieldset->getId()]->getWidget()->setLabel($aFormFieldset->getLabel());
    }
    $this->embedForm('fields', $fieldsetWrapperForm);
    $this->widgetSchema->setNameFormat('form[%s]');
		$this->useFields(array('form_id', 'fields'));
  }
	  
  public function updateObjectEmbeddedForms($values, $forms = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $fieldsetForms)
    {
      $fieldsetForms->setOption('a_form_submission', $this->getObject());
      $fieldsetForms->doUpdateObjects($values['fields'][$name]);
    }
  }
  
  public function saveEmbeddedForms($con = null, $form = null)
  {
    foreach($this->getEmbeddedForm('fields')->getEmbeddedForms() as $name => $fieldsetForms)
    {
      $fieldsetForms->save();
    }
  }
     
  public function doUpdateObject($values)
  {
    $this->getObject()->setFormId($this->getOption('a_form')->getId());
    $this->getObject()->setIpAddress($_SERVER['REMOTE_ADDR']);  
  }
  
}