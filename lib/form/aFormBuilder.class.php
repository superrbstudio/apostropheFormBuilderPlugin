<?php

class aFormBuilder extends BaseaFormSubmissionForm
{
  protected
    $legends = array();
  
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
    	//TODO: Don't really need to use legends array here, templates should just get the embedded form label.
    	$this->legends[$aFormLayout['id']] = $aFormLayout->getLabel();
      $layoutWrapperForm->embedForm(
			  $aFormLayout->getId(),
		    $aFormLayout->getForm(
			    $this->getObject()->getFieldSubmissionsForLayout($aFormLayout['id']), 
					array('a_form_layout' => $aFormLayout)
		  ));
    }

    $this->embedForm('fields', $layoutWrapperForm);
    $this->widgetSchema->setNameFormat('form[%s]');
		
		$this->useFields(array('fields'));
  }
	
  protected function updateDefaultsFromObject()
  {
    $defaults = $this->getDefaults();

    // update defaults for the main object
    if ($this->isNew())
    {
      $defaults = $this->getDefaults() + $this->getObject()->toArray(false);
    }
    else
    {
      $defaults = $this->getObject()->toArray(false) + $this->getDefaults();
    }

    foreach ($this->embeddedForms as $name => $form)
    {
      if ($form instanceof sfFormDoctrine)
      {
        $form->updateDefaultsFromObject();
        $defaults[$name] = $form->getDefaults();
      }
    }

    $this->setDefaults($defaults);
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